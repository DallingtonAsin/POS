<?php
require '../php/hostsys.inc.php';
require '../php/authenticate.php';
if(empty($_SESSION['username'])){
  header("location:../index.php");
}
$stocklist = null;
$obj = new RetrievalDbModule();
$array = $obj->getStock();
$stocklist = $array['products'];


?>
<!DOCTYPE html>
<html lang="en">
<head>


  <script src="../js/jquery-2.2.4.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../vendor/datatables/datatables-18/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready( function () {
      $('#stock-table').DataTable();
    } ); 
  </script>
  
  <script src="../js/jquery-ui.min.js"></script>
  <script src="../js/jsMaster.js"></script>
  <script src="../js/dialog-master/dist/js/bootstrap-dialog.min.js"></script>
  <script src="../js/jquery-tabledit/jquery.tabledit.min.js"></script>
  <script src="../js/bootstrap3-typeahead.min.js"></script>
 

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/gif/png" href="../img/skills.png">

    <title>Cashier | View Stock</title>
  
  <link href="../vendor/datatables/datatables-18/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- External CSS -->
    <link href="../css/style.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css" >

    <!--fontawesome -->
    <link rel="stylesheet" type="text/css" href="../fontawesome/css/all.css">
    <style type="text/css">
      .keeptime{
        margin-left:70% !important;
      }
      #Records-form{
        margin-left: 180px;
      }

    </style>


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
          <a class="navbar-brand" href="#"><span class="titlehd"><?php echo $obj->getCompanyName(); ?></span></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="conductsale.php">shopping-cart</a></li>
            <li><a href="sales.php">Sales</a></li>
            <li class="active"><a href="stock.php">Stock</a></li>
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
                  <a href="stock.php?56-89-2333-logout='1'" id="logout" ><span class="glyphicon glyphicon-off"></span> Logout </a>
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

  <div  class="form-inline">

    <div class="form-group" class="keeptime">
      <h2><span class="glyphicon glyphicon-cog" aria-hidden="true"></span>Stock <small id="manage">Available stock</small>
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

  <!--<section id="breadcrumb">
    <div class="container">
      <ol class="breadcrumb">
        <li><a href="dashboard.php">Dashboard</a></li>
        <li>/</li>
        <li class="active">Stock</li>
      </ol>
    </div>
  </section>-->


  <section id="main">
   <div class="container">
     <div class="row">
       <div class="col-md-3">

      </div>
      <div class="col-md-15">
       <div class="panel panel-default">
        <div class="panel-heading">
        <center><b>List of products or items in stock</b></center>

   
  </div>

  <div class="panel-body">
    <?php require('../php/errors.php') ;?>

    <div class="table-responsive">
    <table class="table table-striped table-hover" id="stock-table">

      <thead>
      <tr id="fontfam" class="warning">
        <th>No</th>
        <th>Item ID</th>
        <th>Product Name</th>
        <th>Category</th>
        <th>Stock Available</th>
        <th>Selling Price</th>
      </tr>
    </thead>

      <tbody>
      <?php
      foreach($stocklist as $rows){
        ?>
      
        <tr>
          <td><?php echo "".$rows['id']."" ;?></td>
          <td><?php echo"".$rows['ProductID']."";?></td>
          <td><?php echo"".$rows['ProductName']."";?></td>
          <td><?php echo"".$rows['Category']."";?></td>
          <td><?php echo"".$rows['QuantityAvailable']."";?></td>
          <td class="colorgreen"><?php echo"".number_format($rows['SellingPrice'])."";?></td>
        </tr>
   

        <?php } ?>
      </tbody>
     

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
<script>
  $(document).ready(function(){
   $("#limit-records").change(function(){
      //alert(this.value);
      $('#Records-form').submit();
    });

   var search = $('#stock-search-label').val();
   $("#stock-search-label").typeahead({
    source:function(query,result){
      $.ajax({
        url:'../php/hostsys.inc.php',
        method:'POST',
        data:{
          SearchStock:1,
          query:search
        },
        dataType:'json',
        success: function(data){
          result($.map(data, function(item){
            return item;
          }));
        },
        error:function(data){
          console.log(data);
        },
      });
    }
  });

 });

</script>
</body>
</html>
