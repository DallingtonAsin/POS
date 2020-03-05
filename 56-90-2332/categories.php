<?php
require '../php/authenticate.php';
require '../php/plus-content.inc.php';
require '../php/hostsys.inc.php';
require '../php/downloads.php';
if(empty($_SESSION['username'])){
  header("location:../index.php");
}

$obj = new RetrievalDbModule();
$obj_list = $obj->getPdtCategories();


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
       $('#categories_table').Tabledit({
   url:'../php/updates.inc.php',
   buttons:{
     delete:{
      html: '<span class="glyphicon glyphicon-trash" id="delete"></span>',
      action:'deleteCategory'
    },
    edit:{
      html: '<span class="glyphicon glyphicon-pencil" id="edit"></span>',
      action:'editCategory'
    }
  },
  columns:{
    identifier:[0, "id"],
    editable:[[1,'Category']]
  },
        // $("edit").css('background','blue'),
        restoreButton:false,
        onSuccess:function(data, textStatus, jqXHR){
          if(data.action == 'delete'){
            $('#'+data.id).remove();
          }
        }
      });
      $('#categories_table').DataTable();
    } ); 
  </script>


  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/gif/png" href="../img/skills.png">

  <title>Manage Categories</title>
  <link href="../vendor/datatables/datatables-18/css/jquery.dataTables.min.css" rel="stylesheet">
  <!-- Bootstrap core CSS -->
  <link href="../css/bootstrap.min.css" rel="stylesheet">

  <!-- External CSS -->
  <link href="../css/style.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css" >

  <!--fontawesome -->
  <link rel="stylesheet" type="text/css" href="../fontawesome/css/all.css">

  <style type="text/css">
   .panel-heading{
    height: 48px !important;
  }
  .btn-group{
    top:-4px !important;
  }
  #CategoriesRecords-form{
    margin-left: 110px;
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
                  <a href="categories.php?56-90-2332-logout='1'" id="logout" ><span class="glyphicon glyphicon-off"></span> Logout </a>
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

      <h2><span class="glyphicon glyphicon-cog" aria-hidden="true"></span>Categories <small id="manage">Manage Categories</small>
   </h2>
 </div>
</div>
</div>



</header>

<!--<section id="breadcrumb">
  <div class="container">
    <ol class="breadcrumb">
      <li><a href="main.php">Dashboard</a></li>
      <li>/</li>
      <li class="active">Categories</li>
    </ol>
  </div>
</section>-->


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
               <a href="#" data-toggle="modal"  data-target="#addCategory" id="modal-links">
                <span class="glyphicon glyphicon-plus-sign"></span> add category</a>
              </div>
            </center>
          </div>
        </div>
        <div class="col-md-9">
         <div class="panel panel-default">

           <div class="panel-heading">
            <div class="form-inline">
              <div class="form-group">
                <span><b>Product categories</b></span>
              </div>

              <div class="form-group btn-group pull-right">
              <button type="button" class="btn btn-primary dropdown-toggle downloadfilebtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               Download <span class="caret"></span>
             </button>
             <ul class="dropdown-menu">
              <!-- <li><a href="categories.php?SaveCategorysBtn='1'">Export to Pdf</a></li> -->
              <li><a href="categories.php?SaveCategoriesCSVfile='1'">Export to Excel / Csv</a></li> 
            </ul>
          </div>


        </div>

      </div>


      <div class="panel-body">
        <?php require('../php/errors.php') ;?>

       <div class="table-responsive">
        <table id="categories_table" class="table table-striped table-hover">

          <thead>
            <tr id="fontfam" class="warning">
              <th>No.</th>
              <th>Category</th>
            </tr>
          </thead>


          <tbody>
          <?php
          foreach($obj_list as $rows){
            ?>
            <?php
            echo'
            <tr>
            <td>'.$rows['id'].'</td>
            <td>'.$rows['Category'].'</td>
            </tr>
            ';
            ?>
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
  <p><strong>Copyright Code Solution Tech&copy;2019</strong></p>
</footer>


<!--Add Category -->
<div class="modal fade" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="AddStock">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Add Category</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Category</label>
            <input type="text" class="form-control" name="product_category" placeholder="product category" Required>

          </div>

          <br>
          <div class="form-group">
            <button type="submit" class="btn"  name="AddCategoryBtn" id="login_btn">Add</button>
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

  $("#limit-CategoriesRecords").change(function(){
      //alert(this.value);
      $('#CategoriesRecords-form').submit();
    });

  var cat_label = $('#cat-search-label').val();
  $("#cat-search-label").typeahead({
    source:function(query,result){
      $.ajax({
        url:'../php/hostsys.inc.php',
        method:'POST',
        data:{
          SearchInCategories:1,
          CatLabel:cat_label
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
