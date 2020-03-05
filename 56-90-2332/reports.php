<?php
require '../php/plus-content.inc.php';
require '../php/hostsys.inc.php';
require '../php/authenticate.php';
require '../php/downloads.php';
if(empty($_SESSION['username'])){
  header("location:../index.php");
}
$obj = new RetrievalDbModule();
$array = $obj->total_periodic_sales();
$heading = $array['title'];
$total_generated = $array['total'];
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
 

 <script type="text/javascript" src="../js/Chart.min.js"></script>
<script type="text/javascript" src="../js/chartjs-plugin-colorschemes.js"></script>
 <script>
  $(document).ready( function () {
    $('table').DataTable();

  } ); 
</script>
<script src="../js/jsconf.inc.js"></script>

<link rel="icon" type="image/gif/png" href="../img/skills.png">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style type="text/css">
 #chart-container {
  width: 100%;
  height: auto;
}
</style>

<title>Manager | View Reports</title>
<link href="../vendor/datatables/datatables-18/css/jquery.dataTables.min.css" rel="stylesheet">
<!-- Bootstrap core CSS -->
<link href="../css/bootstrap.min.css" rel="stylesheet">

<!-- External CSS -->
<link href="../css/style.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/jquery-ui.css" >

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
          </span></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="main.php">Dashboard</a></li>
            <li><a href="sales.php">Sales</a></li>
            <li><a href="stock.php">Stock</a></li>
            <li class="active"><a href="reports.php">Reports</a></li>
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
                  <a href="reports.php?56-90-2332-logout='1'" id="logout" ><span class="glyphicon glyphicon-off"></span> Logout </a>
                <?php endif ?>
              </li>
            </ul>
          </a>
        </li>
      </ul>


    </div>
  </div>
</nav>
<header id="header">
 <div class="container">
   <div class="row">
    <div class="col-md-10">
      <h2><span class="glyphicon glyphicon-cog" aria-hidden="true"></span>Reports <small id="manage">View Reports</small>

    </h2>
  </div>
</div>
</div>
</header>

<section id="main">
 <div class="container">
   <div class="row">
     <div class="col-md-3">
       <div class="list-group">
        <a href="main.php" class="list-group-item active main-color-bg">
          <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>Dashboard
        </a>
        <a href="reports.php?sales='1'"  class="list-group-item" role="button"> <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> General Sales</a>
        <a href="reports.php?inventory='1'"   class="list-group-item" role="button" name="inventory"><span class="glyphicon glyphicon-book" aria-hidden="true">
        </span> Stock Report</a>
        <a href="reports.php?lowrunningstock='1'"  id="lowinventory" class="list-group-item" role="button" name="lowstock"><span class="glyphicon glyphicon-alert" aria-hidden="true">
        </span> Low Running stock</a>
        <a href="reports.php?monthlysales='1'" class="list-group-item" role="button"  class="btn" name="monthlysales"> <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> Monthly sales</a>
        <a href="reports.php?bestselling='1'" id="bestselling" class="list-group-item" role="button" name="bselling">
         <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> Best selling products</a>
         <a href="reports.php?toptencustomers='1'" class="list-group-item" role="button" name="topcustomers"><span class="glyphicon glyphicon-user" aria-hidden="true">
         </span> Top 10 customers</a>

         <a id="barchart" class="list-group-item" role="button">
          <span class="fa fa-signal" aria-hidden="true"></span> Barchart 4 sales</a>
          <a id="piedrawing" class="list-group-item" role="button">
            <span class="fa fa-chart-pie" aria-hidden="true"></span> piechart 4 sales</a>
            <a id="linegraph" class="list-group-item" role="button">
              <span class="fa fa-chart-line" aria-hidden="true"></span> Linegraph 4 sales</a>


            </div>



            <div class="dropup create" style="margin-left: 20% !important" id="Reports">
             <button class="btn  dropdown-toggle more-reports"
             type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
             <span>More Reports</span>
             <span class="caret"></span>
           </button>
           <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">

            <a href="reports.php?cashiersperformance='1'"  class="list-group-item" role="button"> <span class="glyphicon glyphicon-list-alt" aria-hidden="true">
            </span> cashiers' evaluation</a>

            <a href="reports.php?lastweek='1'" class="list-group-item" role="button">
             <span class="fa fa-stream">
             </span> Last week sales</a>
             <a href="reports.php?currentweek='1'" class="list-group-item" role="button">
              <span class="fa fa-arrow-alt-circle-down">
              </span> Current week sales</a>
              <a href="reports.php?last7days='1'" class="list-group-item" role="button">
               <span class="fa fa-arrow-circle-left">
               </span> Last 7 days sales</a>
               <a href="reports.php?last30days='1'" class="list-group-item" role="button">
                <span class="fa  fa-arrow-alt-circle-left">
                </span> Last 30 day's sales</a>
                <a href="reports.php?currentmonth='1'" class="list-group-item" role="button">
                 <span class="fa fa-arrow-alt-circle-down">
                 </span> Current month sales</a>
                 <a href="reports.php?lastmonth='1'" class="list-group-item" role="button">
                  <span class="fa fa-arrow-alt-circle-up">
                  </span> Last month sales</a>
                  <a href="reports.php?suppliers='1'"  class="list-group-item" role="button"> <span class="fa fa-user" aria-hidden="true">
                  </span> Suppliers</a>
                  <a href="reports.php?companycashiers='1'"  class="list-group-item" role="button"> <span class="glyphicon glyphicon-user">
                  </span> Company cashiers</a>

                </ul>
              </div>


            </div>

            <div class="col-md-9">
             <div class="panel panel-success report-panel">
              <div class="panel-heading report-title text-center text-primary">
                <?php
                if(isset($heading) && isset($total_generated)){
                  if(is_numeric($total_generated)){
                   $total_generated = number_format($total_generated);
                 }
                 echo "<span>".$heading."  <span><span id='salescolored'> ".$total_generated."<span>";
               }
               else{
                echo "".$obj->getCompanyName()." Reports";
              }

              ?>


            </div>
            <div class="panel-body">


              <?php
              require '../php/report-chart.min.php';
              ?>

            </div>
          </div>
          <canvas id="graphCanvas"></canvas>



        </div>
      </div>

    </div>
  </div>



</section>


<div class="dialog-class">
  <div id="dialog-container">
    <div id="dialog" title="Change password">
      <form>
      <div>
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
      </div> 
      </form>   
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
