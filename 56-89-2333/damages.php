<?php
require '../php/hostsys.inc.php';
require '../php/shopping-cart.php';
require '../php/plus-content.inc.php';
require '../php/authenticate.php';
if(empty($_SESSION['username'])){
  header("location:../index.php");
}
$obj = new RetrievalDbModule();
$objectClass = new CartClass();
$damages_list = null;
$array = null;
$cost_of_damages = null;

if(isset($_POST['FilterDamages'])){
  $array = $obj->filterDamages();
  $damages_list = $array['damages'];
}else{
  $array = $obj->getDamages();
  $damages_list = $array['damages'];
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
        $('#damages-table').Tabledit({
     url:'../php/updates.inc.php',
     buttons:{
      /* delete:{
        html: '<span class="glyphicon glyphicon-trash" id="delete"></span>',
        action:'DeleteDamagedItem',
      },*/
      edit:{
        html: '<span class="glyphicon glyphicon-pencil" id="edit"></span>',
        action:'EditDamagedItem',
      },
    },
    columns:{
      identifier:[0, "id"],
      editable:[[1,'ItemID'],[2,'ProductName'],[4,'Quantity']]
    },
          deleteButton:false,
          restoreButton:false,
         /* onSuccess:function(data, textStatus, jqXHR){
            if(data.action == 'delete'){
              $('#'+data.id).remove();
            }
          }*/
        });

      $('#damages-table').DataTable();

       var damagedItem = $("#search-damage-label").val();
    $("#search-damage-label").typeahead({
      source:function(query,result){
        $.ajax({
          url:'../php/hostsys.inc.php',
          method:'POST',
          data:{
            searchDamage:1,
            query:damagedItem,
          },
          dataType:'json',
          success: function(data){
            result($.map(data, function(item){
              return item;
            }));
          },
          error:function(data){
        //alert("Failed to return data: "+data+"");
      },
    });
      }
    });

        $("#damaged_item").focus(function(){
      var damage = $("#damaged_item").val();
      if(damage.length>=2){
        $.ajax({
          url:'../php/hostsys.inc.php',
          method:'POST',
          data: {
            searchCategoryOfDamage: 1,
            d:damage

          },
          success: function(data) {
            $("#CategoryOfDamage").attr("value",data);
          },
          dataType: 'text'

        });
      }
    });
  var damagedItem = $("#damaged_item").val();
    $("#damaged_item").typeahead({
      source:function(query,result){
        $.ajax({
          url:'../php/hostsys.inc.php',
          method:'POST',
          data:{
            searchDamage:1,
            query:damagedItem,
          },
          dataType:'json',
          success: function(data){
            result($.map(data, function(item){
              return item;
            }));
          },
          error:function(data){
        //alert("Failed to return data: "+data+"");
      },
    });
      }
    });

    } ); 
  </script>
  
  
  


  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/gif/png" href="../img/skills.png">

  <title>Cashier | Manage Damages</title>
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
        <a class="navbar-brand" href="#"><span class="titlehd"><?php echo $obj->getCompanyName(); ?></span></a>
      </div>
      <div id="navbar" class="collapse navbar-collapse">

        <ul class="nav navbar-nav">
          <li><a href="dashboard.php">Dashboard</a></li>
          <li><a href="conductsale.php">shopping-cart</a></li>
          <li><a href="sales.php">Sales</a></li>
          <li><a href="stock.php">Stock</a></li>
          <li class="active"><a href="damages.php">Damages</a></li>

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
                <a href="damages.php?56-89-2333-logout='1'" id="logout" ><span class="glyphicon glyphicon-off"></span> Logout </a>
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
    <div class="form-inline">
      <div class="form-group">
        <h3><span class="glyphicon glyphicon-cog" aria-hidden="true"></span>Damages
          <small id="manage">Recorded damages</small>
        </h3>
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
        <div class="col-md-3">
          <div class="list-group">
            <a href="dashboard.php" class="list-group-item active main-color-bg">
              <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>Dashboard
            </a>
            <a href="conductsale.php" class="list-group-item" class="success"> <span class="fa fa-shopping-cart" aria-hidden="true">
            </span> shopping-cart<span class="badge">
              <?php echo $objectClass->getNumberofCartItems();?>  
            </span></a>
            <a href="sales.php" class="list-group-item"> <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"> </span>Today's Sales<span class="badge"><?php echo $obj->getNumberOfTodaysSales();?></span></a>
            <a href="stock.php" class="list-group-item"><span class="fa fa-wrench" aria-hidden="true">
            </span> Stock<span class="badge"><?php echo $obj->getNumberofProducts();?></span></a>
            <a href="#" class="list-group-item"><span class="fa fa-trash-alt" aria-hidden="true">
            </span> Damages<span class="badge"><?php echo $obj->getNumberofDamages();?></span></a>

          </div>

          <div class="well well-lg text-center">

            <a href="#" data-toggle="modal" data-target="#addDamage" id="modal-links" class="btn main-color-bg margink">
              <span class="glyphicon glyphicon-plus-sign" ></span> add damage</a>
            </div>
          </div>


          <div class="col-md-9">
            <div class="panel panel-default">
              <div class="panel-heading">
                <center><b>List of damaged items from stock</b></center>
                  <?php require('../php/errors.php') ;?>
             
            </div>

            <div class="panel-body">
              <div class="table-responsive">
              <table class="table table-striped table-hover" id="damages-table">

                <thead>
                  <tr id="fontfam" class="warning">
                    <th>No.</th>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Quantity</th>    
                  </tr>
                </thead>

                <tbody>
                <?php
                foreach($damages_list as $rows){
                  ?>
                  <tr>

                    <td><?php echo "".$rows['id']."";?></td>
                    <td><?php echo"".$rows['ItemID']."";?></td>
                    <td><?php echo"".$rows['ProductName']."";?></td>
                    <td><?php echo"".$rows['Quantity']."";?></td>
                  <?php } ?>
                </tr>
              </tbody>

              </table>
            </div>
            </div>


          </div>
        </div>
      </div>
    </div>
  </section>


  <footer id="footer">
    <address>
      <strong>CST, Inc.</strong><br>
      1355 Sir.Apollo Kagwa Road, Suite 900<br>
      Kampala, CA 94103<br>
      <abbr title="Phone">P:</abbr> (+256) 774014727
    </address>
    <p><strong>Copyright&copy; Code Solution Tech 2019. All Rights Reserved.</strong></p>
  </footer>

  <!--Add Damage -->
  <div class="modal fade" id="addDamage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="addDamage">
          <?php require ('../php/errors.php');   ?>
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Add Damage</h4>
          </div>
          <div class="modal-body">

            <div class="form-group">
              <label>Damaged Item</label>
              <input type="text" class="form-control" name="DamagedProduct" id="damaged_item" placeholder="Product Name " autocomplete="off" Required>
            </div>

            <div class="form-group">
              <label>Product ID</label>
              <input type="text" class="form-control" name="DamageID"  
              placeholder="Product ID (optional)">
            </div>

            <div class="form-group">
              <label>Category</label>
              <input type="text" class="form-control" name="CategoryOfDamage" id="CategoryOfDamage"   placeholder="Category" style="color: green" Required>
            </div>


            <div class="form-group">
              <label>Quantity</label>
              <input type="text" class="form-control" name="QuantityDamaged" placeholder="Quantity" Required>

            </div>

            <div class="form-group">
              <button type="submit" class="btn"  name="RecordDamage" id="login_btn">Add</button>
              <button type="reset" class="btn btn-danger">Clear</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

          </div>
        </form>
      </div>
    </div>
  </div>

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

</body>
</html>
