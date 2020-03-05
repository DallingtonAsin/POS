<?php
require '../php/authenticate.php';
require '../php/hostsys.inc.php';
require_once '../php/downloads.php';
if(empty($_SESSION['username'])){
  header("location:../index.php");
}
$obj = new RetrievalDbModule();
$value = null;
$sales_list = null;
$errors = array();
if(isset($_POST['Filter-Sales'])){
  if(isset($_POST['datey1']) && $_POST['datey1'] != "mm/dd/yyyy"){
    $datey1 = $_POST['datey1'];
  }
  if(empty($_POST['datey1'])){
    $datesetErr = "select start date";
    array_push($errors,$datesetErr);
  }
  if(isset($_POST['datey2']) && $_POST['datey2'] != "mm/dd/yyyy"){
    $datey2 = $_POST['datey2'];
  }
  if(empty($_POST['datey2'])){
    $datesetErr = "select end date";
    array_push($errors,$datesetErr);
  }
  if(count($errors) == 0){
    $array = $obj->CashierFiltersSales($datey1,$datey2);
    $sales_list = $array['filteredsales'];
    $title = $array['title'];
    $total_sales = $obj->getTotal4CashierFilteredSales($datey1,$datey2);
  }else{
    $array = $obj->fetchTodaysSales();
    $sales_list = $array['SalesToday'];
    $total_sales = $array['amount-of-sales'];
    $title = $array['title'];
    $datesetErr = "Please select start & end dates to filter sales";
  }
}
else{
  $array = $obj->fetchTodaysSales();
  $sales_list = $array['SalesToday'];
  $total_sales = $array['amount-of-sales'];
  $title = $array['title'];
}

if($total_sales > 0){
  $value = $total_sales;
}
else{
  $value = 0;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>

  <script src="../js/jquery-2.2.4.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../vendor/datatables/datatables-18/js/jquery.dataTables.min.js"></script>
  <script>
  $(document).ready( function () {
    $('#sales-table').DataTable();
  } );
  </script>

  <script src="../js/jquery-ui.min.js"></script>
  <script src="../js/jsMaster.js"></script>
  <script src="../js/dialog-master/dist/js/bootstrap-dialog.min.js"></script>
  <script src="../js/jquery-tabledit/jquery.tabledit.min.js"></script>
  <script src="../js/bootstrap3-typeahead.min.js"></script>




  <link rel="icon" type="image/gif/png" href="../img/skills.png">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">


  <title>Cashier | View Todays sales</title>
  <link href="../vendor/datatables/datatables-18/css/jquery.dataTables.min.css" rel="stylesheet">
  <!-- Bootstrap core CSS -->
  <link href="../css/bootstrap.min.css" rel="stylesheet">

  <!-- External CSS -->
  <link href="../css/style.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css" >
  <!--    -->

  <style type="text/css">
  #CSalesRecords-form{
    margin-left:180px !important;
  }
  #Climit-SalesRecords{
    width: 170px !important;
  }
  #footer{
    margin-top: 300px !important;
  }

  </style>

  <!--fontawesome -->
  <link rel="stylesheet" type="text/css" href="../fontawesome/css/all.css">



</head>

<body>

  <nav class="navbar navbar-default">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#"><span class="titlehd"><?php echo $obj->getCompanyName(); ?> </span></a>
      </div>
      <div id="navbar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <li><a href="dashboard.php">Dashboard</a></li>
          <li><a href="conductsale.php">shopping-cart</a></li>
          <li class="active"><a href="sales.php">Sales</a></li>
          <li><a href="stock.php">Stock</a></li>
          <li><a href="damages.php">Damages</a></li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a data-toggle="dropdown">
              <span class="user"><?php echo $_SESSION['username'];?></span>
              <span class="group"><?php echo $_SESSION['Group'];?></span>
              <span class="caret"></span>
              <ul class="dropdown-menu" role="menu" class="drop">
                <li>
                  <a class="settings"><span class="fas fa-cog"></span> Change password</a>
                </li>
                <li class="divider"></li>
                <li>
                  <?php if(isset($_SESSION['username'])):?>
                    <a href="sales.php?56-89-2333-logout='1'" id="logout" ><span class="glyphicon glyphicon-off"></span> Logout </a>
                  <?php endif ?>
                </li>
              </ul>
            </a>
          </li>
        </ul>


      </div><!--/.nav-collapse -->
    </div>
  </nav>

  <header id="header">

    <div class="container">

      <div class="form-inline">
        <div class="form-group">
          <h2>
            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>Sales
            <small id="manage">conducted sales</small>
          </h2>
        </div>

        <div class="nav navbar-nav navbar-right">
          <div class="form-group">
            <span class="clock">
              <?php include('../php/clock.php');?>
            </span>
          </div>

          <div class="form-group">
            <span class="clock">
              <?php
              date_default_timezone_set("Africa/Kampala");
              echo" ".date("d/m/y G:i A<br>", time())."";
              ?>
            </span>
          </div>
        </div>
      </div>
    </div>
  </header>


  <section id="main">
    <div class="container">
      <div class="row">


        <div class="col-md-15">
          <div class="panel panel-default">
            <div class="panel-heading">
              <form action="sales.php" method="POST">
                <div class="form-inline">
                  <div class="form-group">
                    <span>&nbsp;<?php echo $title;?> :</span> <span id="salescolored">
                      <?php echo htmlspecialchars(number_format($value)); ?>
                    </span>
                  </div>


                  <div class="form-group date-select" >
                    <div class='input-group date'>
                      <input type='date' name="datey1" placeholder="set date..." class="form-control"
                      id="datepicker"
                      value="<?php
                      if(isset($_POST['datey1']) && $_POST['datey1'] != "mm/dd/yyyy"){
                        echo htmlspecialchars($_POST['datey1']);
                      }else{
                        echo "set start date";
                      }
                      ?>"
                      />
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </div>
                  <div class='input-group date'>
                    <input type='date' name="datey2" placeholder="set date..." class="form-control"
                    id="datepicker"
                    value="<?php
                    if(isset($_POST['datey2']) && $_POST['datey2'] != "mm/dd/yyyy"){
                      echo htmlspecialchars($_POST['datey2']);
                    }else{
                      echo "set end date";
                    }
                    ?>"
                    />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                  </span>
                </div>
                <div class="form-group">
                  <span>
                    <?php
                    if(isset($datesetErr) && !(is_null($datesetErr))){
                      echo "<span class='faults'>$datesetErr</span>";
                    }

                    ?>
                  </span>
                </div>
              </div>


              <div class="form-group btn-group pull-right">
                <button type="button" class="btn btn-primary dropdown-toggle downloadfilebtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Action <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                  <li><input type="submit" name="Filter-Sales"  class="btn btn-filter-sales" value="Filter"></li>
                  <li><input type="submit" name="Download-Filtered-Sales" class="btn btn-filter-sales" value="Export to excel"></li>
                </ul>
              </div>
            </div>
          </form>


        </div>
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table  table-striped" id="sales-table">
              <thead>
                <tr id="fontfam" class="warning">
                  <th>TransactionID</th>
                  <th>ProductID</th>
                  <th>Product</th>
                  <th>Quantity</th>
                  <th>Price</th>
                  <th>Amount</th>
                  <th>Discount</th>
                  <th>Paid</th>
                  <th>Customer</th>
                  <th>Date</th>
                  <th>Cashier</th>
                </tr>
              </thead>
              <?php
              foreach($sales_list as $row) {
                $date = date('d-m-Y G:i A', strtotime($row["Date"]));
                ?>
                <tr>
                  <td><?php echo"" . $row["billno"]. " ";?></td>
                  <td><?php echo"" . $row["ProductID"]. " ";?></td>
                  <td><?php echo"" . $row["ProductName"]. " ";?></td>
                  <td><?php echo"" . $row["Quantity"]. " ";?></td>
                  <td><?php echo"" .number_format($row["Price"]). " ";?></td>
                  <td><?php echo"" .number_format($row["Amount"]). " ";?></td>
                  <td><?php echo"" . $row["Discount"]. " ";?></td>
                  <td id="changecolor"><?php echo"" .number_format($row["Cost"]). " ";?></td>
                  <td><?php echo"" . $row["Customer"]. " ";?></td>
                  <td><?php echo"" . $date. " ";?></td>
                  <td><?php echo"" . $row["CashierName"]. " ";?></td>
                </tr>
                <?php  }   ?>

            </table>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

</section>

<div class="dialog-class">
  <div id="dialog-container">
    <div id="dialog" title="Change password">
      <div>
        <form>
        <div class="form-group">
          <label>New Password:</label>
          <input type="password" name="pass1" id="password1" class="form-control dialog-inputs" Required autocomplete="false">
        </div>
        <div class="form-group">
          <label>Confirm Password:</label>
          <input type="password" name="pass2" id="password2" class="form-control dialog-inputs" Required autocomplete="false">
        </div>
        <div class="form-group">
          <input type="submit" name="submit" id="ChangePassword"
          class="btn btn-success form-control" value="Change" >
        </div>
      </form>
      </div>
    </div>
  </div>
</div>

<footer id="footer">
  <address>
    <strong>CST, Inc.</strong><br>
    1355 Sir.Apollo Kagwa Road, Suite 900<br>
    Kampala, CA 94103<br>
    <abbr title="Phone">P:</abbr> (+256) 774014727
  </address>
  <p><strong>Copyright&copy; Code Solution Tech 2019. All Rights Reserved.</strong></p>
</footer>

</body>
</html>
