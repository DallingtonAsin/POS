<?php
require '../php/plus-content.inc.php';
require '../php/hostsys.inc.php';
require '../php/authenticate.php';
require '../php/downloads.php';

if(empty($_SESSION['username'])){
  header("location:../index.php");
}
$obj = new RetrievalDbModule();
$download = new Downloads();

$sales_list = null;

if(isset($_POST['FilterSales'])){
  if((isset($_POST['startdate']) && isset($_POST['enddate'])) &&
   ($_POST['startdate']!="mm/dd/yyyy") && ($_POST['enddate']!="mm/dd/yyyy")){
    $start_date = $_POST['startdate'];
  $end_date = $_POST['enddate'];
  $array = $obj->filterConductedSales($start_date,$end_date);
  $sales_list = $array['sales'];
  $volume_of_sales = $array['valueofsales'];
}  
}

else if(isset($_POST['DownloadFilteredSales'])){
  if((isset($_POST['startdate']) && isset($_POST['enddate'])) &&
   ($_POST['startdate']!="mm/dd/yyyy") && ($_POST['enddate']!="mm/dd/yyyy")){
    $start_date = $_POST['startdate'];
  $end_date = $_POST['enddate'];
  $array = $download->downloadPeriodicSalesCSVfile($start_date,$end_date);
} 
}


else{
  $array = $obj->getConductedSales();
  $sales_list = $array['all-sales'];
  $volume_of_sales = $array['sales-volume'];
 }

?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="../js/jquery-2.2.4.min.js"></script>
 <script src="../js/bootstrap.min.js"></script>
 <script src="../vendor/datatables/datatables-18/js/jquery.dataTables.min.js"></script>
 <script src="../js/jquery-ui.min.js"></script>
 <script src="../js/jsMaster.js"></script>
 <script src="../js/dialog-master/dist/js/bootstrap-dialog.min.js"></script>
 <script src="../js/jquery-tabledit/jquery.tabledit.min.js"></script>
 <script src="../js/bootstrap3-typeahead.min.js"></script>

 <script>
  $(document).ready( function () {
    $('#sales-table').DataTable();
  } ); 
</script>

  <link rel="icon" type="image/gif/png" href="../img/skills.png">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">


  <title>Generated Sales</title>

  
<link href="../vendor/datatables/datatables-18/css/jquery.dataTables.min.css" rel="stylesheet">
  <!-- Bootstrap core CSS -->
  <link href="../css/bootstrap.min.css" rel="stylesheet">

  <!-- External CSS -->
  <link href="../css/style.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css" >
  <!--    -->

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
        <a class="navbar-brand" href="#">
          <span class="titlehd">
           <?php echo $obj->getCompanyName(); ?>
         </span><!--| Sales--></a>
       </div>
       <div id="navbar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <li><a href="main.php">Dashboard</a></li>
          <li class="active"><a href="sales.php">Sales</a></li>
          <li><a href="stock.php">Stock</a></li>
          <li><a href="reports.php">Reports</a></li>
          <li><a href="cashiers.php">Cashiers</a></li>
          <li><a href="suppliers.php">Suppliers</a></li>
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
                <a href="sales.php?56-90-2332-logout='1'" id="logout" ><span class="glyphicon glyphicon-off"></span> Logout </a>
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

    <div class="row">
      <div class="col-md-10">

        <h2><span class="glyphicon glyphicon-cog" aria-hidden="true"></span>Sales <small id="manage">Manage Sales</small>
        </h2>
      </div>


    </div>

  </div><!-- /.container -->



</header>

<section id="main">
  <div class="container">
    <div class="row">
      <div class="col-md-3">
       <div class="list-group">
        <a href="main.php" class="list-group-item active main-color-bg">
          <span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Dashboard
        </a>
        <a href="sales.php" class="list-group-item">
          <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true">
          </span> Sales<span class="badge"><?php echo $obj->getNumberOfSales();?></span></a>
          <a href="stock.php" class="list-group-item"><span class="glyphicon glyphicon-pencil" aria-hidden="true">
          </span> Stock<span class="badge"><?php echo $obj->getNumberofProducts();?></span></a>
          <a href="reports.php" class="list-group-item"> <span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Reports<span class="badge">19</span></a>
          <a href="cashiers.php" class="list-group-item"><span class="glyphicon glyphicon-user" aria-hidden="true">
          </span> Cashiers<span class="badge"><?php echo $obj->getNumberofCashiers();?></span></a>
          <a href="suppliers.php" class="list-group-item"> <span class="fa fa-user" aria-hidden="true"></span> Suppliers<span class="badge"><?php echo $obj->getNumberofSuppliers();?></span></a>
          <a href="expenses.php" class="list-group-item"> <span class="fab fa-cc-amazon-pay" aria-hidden="true"></span> Expenses<span class="badge">
            <?php echo $obj->CountExpenses();?></span></a>
            <a href="customers.php" class="list-group-item"> <span class="fa fa-user" aria-hidden="true"></span> Customers<span class="badge">
              <?php echo $obj->getNumberofCustomers();?>
              
            </span></a>
            <a href="damages.php" class="list-group-item"> <span class="fa fa-trash-alt" aria-hidden="true"></span> Damages<span class="badge">
              <?php echo $obj->getNumberofDamages();?>   
            </span></a>
          </div>
          <div class="well well-sm">
            <!-- <center><a  id="save"  href="sales.php?SaveSalesBtn='1'" class="glyphicon glyphicon-save">SaveSales</a></center> -->
            <center><div class="form-group btn-group">
              <button type="button" class="btn btn-primary dropdown-toggle downloadfilebtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               Download <span class="caret"></span>
             </button>
             <ul class="dropdown-menu">
             <!--  <li><a href="sales.php?SaveSalesBtn='1'">Export to Pdf</a></li> -->
              <li><a href="sales.php?SaveSalesCsvBtn='1'">Export to Excel / Csv</a></li>
              
            </ul>
          </div></center>

        </div>
      </div>
      <div class="col-md-9">
        <div class="panel panel-default">
          <div class="panel-heading">
            <form action="sales.php" method="POST">
            <div class="form-inline">
              <div class="form-group">
                <span class="knowhowmuch">
                  <b>Sales made:</b>
                  <span id="stocklabel">
                    <?php
                    echo htmlentities(number_format($volume_of_sales));
                    ?>
                    
                  </span>
                </span>
              </div>

              <div class="form-group">
                <?php  
                $Amt = $obj->computeNetworth(); 
                if($Amt > 0){
                  echo "<span class='worth'>Profit:</span> <span  id='profit'>
                  ".number_format($Amt)."</span>";
                }else{
                  echo "<span class='worth'>Loss:</span> <span id='loss'>".number_format(abs($Amt))."</span>";
                }
                ?> 
              </div>

                <div class="form-group">
                <div class='input-group date' id='datetimepicker1'>
                  <input type='date' name="startdate" placeholder="start date..." class="form-control"  
                  value="<?php
                  if(isset($_POST['startdate']) && $_POST['startdate'] != 'mm/dd/yyyy'){
                    echo htmlspecialchars($_POST['startdate']);
                    }else{
                      echo "".date('d/m/Y')."";
                    }
                    ?>" 
                    />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                  </span>
                </div>
              </div>


                <div class="form-group">
                <div class='input-group date' id='datetimepicker2'>
                  <input type='date' name="enddate"  class="form-control" placeholder="end date..."  value="<?php
                  if(!empty($_POST['enddate']) && $_POST['enddate']!='mm/dd/yyyy'){
                    echo htmlspecialchars($_POST['enddate']);
                    }else{
                      echo "set end date";
                    }
                    ?>"
                    />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                  </span>
                </div>
              </div>

               <div class="form-group btn-group pull-right">
                <button type="button" class="btn btn-primary dropdown-toggle downloadfilebtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 Action <span class="caret"></span>
               </button>
               <ul class="dropdown-menu">
                <li><input type="submit" name="FilterSales"  class="btn btn-filter-sales" value="Filter"></li>
                <li><input type="submit" name="DownloadFilteredSales" class="btn btn-filter-sales" value="Export to excel"></li>
              </ul>
            </div>

          </div>
        </form>


        </div>

        <div class="panel-body">

     <div class="table-responsive">
      <table class="table table-striped table-hover" id="sales-table">

        <thead>
        <tr id="fontfam" class="warning">
          <th>No</th>
          <th>ProductID</th>
          <th>Product</th>
          <th>Quantity</th>
          <th>O.Price</th>
          <th>S.Price</th>
          <th>Cost</th>
          <th>Customer</th>
          <th>Date</th>
          <th>Cashier</th>
        </tr>
      </thead>


       <tbody>
        <?php
        foreach($sales_list as $key => $row) {
          ?>
          <tr>
            <td><?php echo"" . $row["billno"]. " ";?></td>
            <td><?php echo"" . $row["ProductID"]. " ";?></td>
            <td><?php echo"" . $row["ProductName"]. " ";?></td>
            <td><?php echo"" . $row["Quantity"]. " ";?></td>
            <td><?php echo"" .number_format($row["OriginalPrice"]). " ";?></td>
            <td><?php echo"".number_format($row["Price"])." ";?></td>
            <td id="changecolor"><?php echo"" .number_format($row["Cost"]). " ";?></td>
            <td><?php echo"" . $row["Customer"]. " ";?></td>
            <td><?php echo"" . $row["Date"]. " ";?></td>
            <td><?php echo"" . $row["CashierName"]. " ";?></td>
          </tr>

          <?php
        }
        ?>
      </tbody>

      </table>
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





<script>
  $(document).ready(function(){
    $("#limit-SalesRecords").change(function(){
      $("#SalesRecords-form").submit();
       // alert(this.value);
     });
  });
</script>








</body>
</html>
