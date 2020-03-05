<?php

require '../php/authenticate.php';
require '../php/hostsys.inc.php';
require '../php/plus-content.inc.php';
require '../php/downloads.php';

if(empty($_SESSION['username'])){
  header("location:../index.php");
}

$obj = new RetrievalDbModule();


$array = $obj->getStock();
$stocklist = $array['products'];
$value_of_stock = $array['StockValue'];

$SuppliersArray = $obj->getSuppliers();
$suppliers_list = $SuppliersArray['suppliers'];

$cat = $obj->getPdtCategories();


?>
<!DOCTYPE html>
<html lang="en">
<head>
 <script src="../js/jquery-2.2.4.min.js"></script>
 <!-- <script src="../js/ExportTable2Excel/js/FileSaver/FileSaver.js"></script> -->
 <script src="../js/TableExports/src/jquery.table2excel.js"></script>

 <script src="../js/bootstrap.min.js"></script>
 <script src="../vendor/datatables/datatables-18/js/jquery.dataTables.min.js"></script>
 <script src="../js/jquery-ui.min.js"></script>
 <script src="../js/jsMaster.js"></script>
 <script src="../js/dialog-master/dist/js/bootstrap-dialog.min.js"></script>
 <script src="../js/jquery-tabledit/jquery.tabledit.min.js"></script>
 <script src="../js/bootstrap3-typeahead.min.js"></script>

 <!-- <link href="../js/ExportTable2Excel/css/tableexport.css" rel="stylesheet"> -->
 

 <script>
  $(document).ready( function () {
    $('#editable_table').Tabledit({
      url:'../php/updates.inc.php',
      data:{
        updateStock:1
      },
      buttons:{
        delete:{
          html: '<span class="glyphicon glyphicon-trash" id="delete"></span>',
          action:'deleteStock'
        },
        edit:{
          html: '<span class="glyphicon glyphicon-pencil" id="edit"></span>',
          action:'editStock'
        }
      },
      columns:{
        identifier:[0, "id"],
        editable:[[1,'ProductName'],[2,'Category'],[3,'QuantityAvailable'],
        [4,'BuyingPrice'],[5,'SellingPrice'],[6,'Supplier'],[7,'ExpiryDate']]
      },
          // $("edit").css('background','blue'),
          restoreButton:false,
          onSuccess:function(data, textStatus, jqXHR){
            if(data.action == 'delete'){
              $('#'+data.id).remove();
            }
          }
        });

    $("#PrintPdf").click(function(){
     $("#editable_table").table2excel({
        //exclude: ".noExl",
        name: "Worksheet Name",
        filename: "Stock", //do not include extension
        fileext: ".xlxs" // file extension
      });
   });


    $('#editable_table').DataTable();



  } ); 
</script>


<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/gif/png" href="../img/skills.png">

<title>Manage Stock</title>
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
    height: 50px !important;
  }
  #records-form{
    margin-left:200px !important;
  }
  #limit-records{
    width: 160px;
  }
  .margink{
    margin-left: 60px;
  }
  #save-stock{
    margin-left: 50px;
    color: #006400;
  }
  #submit{
    color: #ffffff !important;
    background: 	color: #ffffff !important;
    background: #25383C !important;
    border-color: #25383C !important;
    border-radius: 3px;
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
          </span><!--| Stock--></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="main.php">Dashboard</a></li>
            <li><a href="sales.php">Sales</a></li>
            <li class="active"><a href="stock.php">Stock</a></li>
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
                  <a href="stock.php?56-90-2332-logout='1'" id="logout" ><span class="glyphicon glyphicon-off"></span> Logout </a>
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

        <h2><span class="glyphicon glyphicon-cog" aria-hidden="true"></span>Stock <small id="manage">Manage Stock</small>
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
           <form method="POST" action="stock.php" enctype="multipart/form-data">

            <div class="form-group">
             <input type="file" name="excelfile" id="excelfile">
           </div>

           <div class="form-group import-button-group">
            <center><input type="submit" name="importStockBtn" id="import-first-time" 
              value="import" class="btn btn-imports">
              <!-- <input type="submit" name="importUpdateStockBtn" id="update-import" 
                value="update" class="btn btn-imports"> -->
              </center>
            </div>
            <?php
            if(isset($_POST['importStockBtn'])){
              $response  =  $obj->importStock();
              if($response == 1){
                $array = $obj->getStock();
                $stocklist = $array['products'];
                $value_of_stock = $array['StockValue'];
                echo "<span class='success'>stock imported successfully</span>";
              }
              else{
               echo "<span class='error-info'>$response</span>";
             }

           }
           if(isset($_POST['importUpdateStockBtn'])){
            $response  =  $obj->importAndUpdateStock();
            if($response == 1){
              $array = $obj->getStock();
              $stocklist = $array['products'];
              $value_of_stock = $array['StockValue'];
              echo "<span class='success'>stock updated successfully</span>";
            }
            else{
             echo "<span class='error-info'>$response</span>";
           }

         }

         ?>

       </form>

     </div>
   </div>
   <div class="col-md-9">
    <div class="panel panel-default">


      <div class="panel-heading">
        <div class="form-inline">
          <div class="form-group">
            <span>Stock</span>
          </div>

          <div class="form-group">
            <a href="#" data-toggle="modal"  data-target="#addStock" id="modal-links" class="margink">
              <span class="glyphicon glyphicon-plus-sign"></span> add stock</a>
            </div>

            <div class="form-group">
              <div class="input-group">
                <ul id="stocklabel">
                  <li >Current stock value</li>
                </ul>
              </div>
            </div>



            <div class="form-group" id="salescolored">
              <span name="totalsales" class="form-control" >
                <?php
                echo htmlspecialchars(number_format($value_of_stock));
                ?>
              </span>
            </div>

            

            <div class="form-group pull-right">
              <form action="downloads.php" method="POST">
                <div class="form-group btn-group pull-right">
                  <button type="button" class="btn btn-primary dropdown-toggle downloadfilebtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                   Download <span class="caret"></span>
                 </button>

                 <ul class="dropdown-menu dropdown-menu-right">
                  <!-- <li><a href="stock.php?exportStockPdf='1'">Export to Pdf</a></li> -->
                  <li><a href="stock.php?exportStockCsv='1'" ><i class="fa fa-save" ></i> Save to excel</a></li>
                  <li><a id="PrintPdf"><i class="btn fa fa-print"></i> Print pdf</a></li>
                  <!--  <button onClick="print();" class="btn btn-primary no-print"><i class="fa fa-print"></i> Print info on this page</button> -->
                  
                </ul>

              </div>
            </form>
          </div>


        </div>
      </div>

      <div class="panel-body">
        <?php require('../php/errors.php') ;?>
        
        <div class="table-responsive">
          <table id="editable_table"  class="table table-striped table-hover">

            <thead>
              <tr id="fontfam" class="warning">
                <th>No.</i></th>
                <th>Product</th>
                <th>Category</th>
                <th>Qty</th>
                <th>B.Price</span></th>
                <th>S.Price</th>
                <th>Supplier</th>
                <th>Expiry</th>  
              </tr>
            </thead>

            <tbody>

              <?php
              foreach($stocklist as $rows){
                ?>

                <tr>
                  <td><?php echo "".$rows["id"]."";?></td>
                  <td><?php echo "".$rows["ProductName"]."";?></td>
                  <td><?php echo "".$rows["Category"]."";?></td>
                  <td><?php echo "".$rows['QuantityAvailable']."";?></td>
                  <td name="price_to_edit" class="colorgreen">
                    <?php echo "".number_format($rows["BuyingPrice"])."";?></td>
                    <td class="colorgreen"><?php echo "".number_format($rows["SellingPrice"])."";?></td>
                    <td><?php echo "".$rows["Supplier"]."";?></td>
                    <td><?php echo "".$rows["ExpiryDate"]."";?></td>    
                  </tr>
                <?php } ?>
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



  <!--Add Stock -->
  <div class="modal fade" id="addStock" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="AddStock">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Add Product</h4>
          </div>
          <div class="modal-body">

            <div class="form-group">
              <label>Product ID</label>
              <input type="text" class="form-control" name="id_of_product" placeholder="Scan Barcode" Required autofocus>

            </div>

            <div class="form-group">
              <label>Product Name</label>
              <input type="text" class="form-control" name="ProductName" placeholder="Enter Product Name" Required autofocus>

            </div>

            <div class="form-group">
              <label>Category</label>
              <select class="form-control" name="category" Required autofocus>
                <option selected>choose category</option>

                <?php
                foreach ($cat as $key => $row) {
                 echo "<option>".$row['Category']."</option>";
               }
               ?>


             </select>
           </div>

           <div class="form-group">
            <label>Supplier</label>
            <select class="form-control" name="supplier" Required autofocus>
              <option selected>select supplier</option>

              <?php
              foreach ($suppliers_list as $key => $row) {
               echo "<option>".$row['SupplierName']."</option>";
             }

             ?>


           </select>
         </div>


         <div class="form-group">
          <label>Quantity</label>
          <input type="text" class="form-control" name="Quantity" placeholder="Enter Quantity" Required autofocus>

        </div>

        <div class="form-inline">
          <div class="form-group">
            <label>BuyingPrice</label>
            <input type="text" class="form-control" name="originalprice" placeholder="Enter original price" Required autofocus>

            <label>SellingPrice</label>
            <input type="text" class="form-control" name="sellingprice" placeholder="Enter selling price" Required autofocus>

          </div></div>

          <br>
          <div class="form-inline">
            <div class="form-group">
              <label>Expiry Date</label>

              <div class='input-group date' id='datetimepicker1'>
                <input type='date' name="expirydate" placeholder="start date..." class="form-control"  />
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
          </div>
        </div>
        <br>
        <div class="form-group">
          <button type="submit" class="btn"  name="AddProductBtn" id="login_btn">Add</button>
          <button type="reset" class="btn btn-danger">Clear</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>


      </div>

    </form>
  </div>
</div>
</div>

<!-- Bootstrap core JavaScript -->
<!-- <script>
  $(document).ready(function(){
    $('#editable_table').DataTable();
  });

</script> -->



<script>
  $(document).ready(function(){

    $('#id_of_product').focus();


   /* $("#frmCSVImport").on("submit", function (){

      $("#response-message").attr("class", "");
      $("#response-message").html("");
      var fileType = ".csv";
      var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + fileType + ")$");
      if (!regex.test($("#file").val().toLowerCase())) {
        $("#response-message").addClass("errors-messo");
        $("#response-message").html("file Upload error:  import only <b>" + fileType + "</b>.");
        return false;
      }
      return true;
    });*/  

    $("#limit-records").change(function(){
          // alert(this.value);
          $('#records-form').submit();
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
