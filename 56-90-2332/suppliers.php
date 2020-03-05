<?php
require '../php/plus-content.inc.php';
require '../php/hostsys.inc.php';
require '../php/authenticate.php';
require '../php/downloads.php';
if(empty($_SESSION['username'])){
  header("location:../index.php");
}
$obj = new RetrievalDbModule();
$val = 'suppliers';

 $array = $obj->getSuppliers(); 
 $suppliers_list = $array['suppliers'];
 $sum_of_debts =  $array['debts'];
 $sum_of_credits = $array['credits'];

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
      $('#suppliers_table').Tabledit({
   url:'../php/updates.inc.php',
   buttons:{
     delete:{
      html: '<span class="glyphicon glyphicon-trash" id="delete"></span>',
      action:'DeleteSupplierDetails',

    },
    edit:{
      html: '<span class="glyphicon glyphicon-pencil" id="edit"></span>',
      action:'EditSupplierDetails',
    }
  },
  columns:{
    identifier:[0, "id"],
    editable:[[1,'SupplierName'],[2,'Address'],[3,'Contact'],[4,'Email'],
    [5,'DR'],[6,'CR']]
  },
  restoreButton:false,
  onSuccess:function(data, textStatus, jqXHR){
    if(data.action == 'delete'){
      $('#'+data.id).remove();
    }
  }
});
    $('#suppliers_table').DataTable();
  } ); 
</script>



<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/gif/png" href="../img/skills.png">

<title>Manage Suppliers</title>
<link href="../vendor/datatables/datatables-18/css/jquery.dataTables.min.css" rel="stylesheet">
<!-- Bootstrap core CSS -->
<link href="../css/bootstrap.min.css" rel="stylesheet">

<!-- External CSS -->
<link href="../css/style.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/jquery-ui.css" >

<style type="text/css">
 .panel-heading{
  height: 50px !important;
}
#SupplierRecords-form{
  margin-left:145px !important;
}
#limit-SupplierRecords{
  width: 160px;
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
        <a class="navbar-brand" href="#"><span class="titlehd">
         <?php echo $obj->getCompanyName(); ?>      
       </span></a>
     </div>
     <div id="navbar" class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li><a href="main.php">Dashboard</a></li>
        <li><a href="sales.php">Sales</a></li>
        <li ><a href="stock.php">Stock</a></li>
        <li><a href="reports.php">Reports</a></li>
        <li><a href="cashiers.php">Cashiers</a></li>
        <li class="active"><a href="suppliers.php">Suppliers</a></li>
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
              <a href="suppliers.php?56-90-2332-logout='1'" id="logout" ><span class="glyphicon glyphicon-off"></span> Logout </a>
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

      <h2><span class="glyphicon glyphicon-cog" aria-hidden="true"></span>Suppliers <small id="manage">Manage Suppliers</small>
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
            <center>
             <div class="form-group">
              <a class="btn btn-primary main-color-bg" href="#" data-toggle="modal"  data-target="#addSupplier" id="modal-links"><span class="glyphicon glyphicon-plus-sign"></span> add supplier</a>
            </div>
            
          </center>
        </div>

      </div>
      <div class="col-md-9">
       <div class="panel panel-success">

        <div class="panel-heading">
          <div class="form-inline">
            <div class="form-group">
             <span>Registered Suppliers</span>
           </div>

           

           <div class="form-group">
            <div class="input-group">
              <ul id="stocklabel">
                <li >DR</li>
              </ul>
            </div>
          </div>

          <div class="form-group" id="salescolored" >
            <span name="totalsales" class="form-control" >
             <?php 
             echo htmlspecialchars(number_format($sum_of_debts));
             ?>
           </span>
         </div>

         <div class="form-group">
          <div class="input-group">
            <ul id="stocklabel">
              <li >CR</li>
            </ul>
          </div>
        </div>



        <div class="form-group" id="salescolored">
          <span name="totalsales" class="form-control" >
            <?php
            echo htmlspecialchars(number_format($sum_of_credits));
            ?>
          </span>
        </div>


        <div class="form-group btn-group pull-right">
          <button type="button" class="btn btn-primary dropdown-toggle downloadfilebtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           Download <span class="caret"></span>
         </button>
         <ul class="dropdown-menu">
          <!-- <li><a href="suppliers.php?SaveSuppliersBtn='1'">Export to Pdf</a></li> -->
          <li><a href="suppliers.php?SaveSuppliersCSVfile='1'">Export to Excel / Csv</a></li> 
        </ul>
      </div>
      

    </div>
  </div>


  <div class="panel-body">
   <div class="table-responsive"> 
   <table id="suppliers_table" class="table table-striped table-hover">
    <thead>
      <tr id="fontfam" class="warning">
        <th>No.</th>
        <th>SupplierName</th>
        <th>Address</th>
        <th>Contact</th>
        <th>Email</th>
        <th>Debt</th>
        <th>Credit</th>
      </tr>
    </thead>

    <tbody>
    <?php
    foreach($suppliers_list as $rows){
      ?>

      <?php
      echo'
      <tr>
      <td>'.$rows['id'].'</td>
      <td>'.$rows['SupplierName'].'</td>
      <td>'.$rows['Address'].'</td>
      <td class="colorgreen">'.$rows['Contact'].'</td>
      <td>'.$rows['Email'].'</td>
      <td>'.number_format($rows['DR']).'</td>
      <td>'.number_format($rows['CR']).'</td>

      </tr>

      ';
      ?>
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

<!--Add Supplier -->
<div class="modal fade" id="addSupplier" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="AddSupplier">
        <?php require ('../php/errors.php');   ?>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Add Supplier</h4>
        </div>
        <div class="modal-body">

          <div class="form-group">
            <label>Supplier Name <span class="star">*</span></label>
            <input type="text" class="form-control" name="supplier_name" placeholder="Supplier Name " Required>

          </div>
          <div class="form-group">
            <label>Address</label> <span class="star">*</span>
            <input type="text" class="form-control" name="supplier_address" placeholder="Supplier's Address" Required>

          </div>


          <div class="form-group">
            <label>Contact</label> <span class="star">*</span>
            <input type="text" class="form-control" name="supplier_contact" placeholder="Contact" Required>
          </div>

          <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" name="supplierEmail" placeholder="Email">
          </div>

          <div class="form-group">
            <button type="submit" class="btn"  name="addSupplierBtn" id="login_btn">Add</button>
            <button type="reset" class="btn btn-danger">Clear</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>

        </div>

      </form>
    </div>
  </div>
</div>

<script>
 $(document).ready(function(){

  $("#limit-SupplierRecords").change(function(){
    $('#SupplierRecords-form').submit();
  });

  var supplier_label = $('#supplier-search-label').val();
  $("#supplier-search-label").typeahead({
    source:function(query,result){
      $.ajax({
        url:'../php/hostsys.inc.php',
        method:'POST',
        data:{
          SearchSupplier:1,
          SupplierLabel:supplier_label
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
