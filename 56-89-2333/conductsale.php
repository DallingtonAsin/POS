<?php
require_once '../php/authenticate.php';
require_once '../php/hostsys.inc.php';
require_once '../php/shopping-cart.php';

$casher = null;
if(empty($_SESSION['username'])){
  header("location:../index.php");
}
$obj = new RetrievalDbModule();
$class_obj = new CartClass();
//$class = new PrintingModule();
$errors = array();

$mount = null;
$tenderErr = null;
$EmptyCartmessageErr = "";
$ConfirmMessage_forSales = "";
$array = $class_obj->getCartItems();
$cartItems = $array['cartItems'];

if($class_obj->getPaymentFromCart() > 0){
 $amount = $class_obj->getPaymentFromCart();
}else{
  $amount = 0;
}

if(isset($_POST['save-sales'])){
  if($class_obj->getNumberofCartItems() == 0){
    $EmptyCartmessageErr = "The cart is empty,please sell at least 1 item";
  }
  else{
    $class_obj->ConductSale();
    $ConfirmMessage_forSales = "Sales saved successfully";
    $class_obj->ClearCart();
    $amount  = 0;
    $array = $class_obj->getCartItems();
    $cartItems = $array['cartItems'];
}


}

if(isset($_GET['clear-cart'])){
  $class_obj->ClearCart();
  $amount  = 0;
  $array = $class_obj->getCartItems();
  $cartItems = $array['cartItems'];
}
if(isset($_GET['action'])){
  if(isset($_GET['action']) == 'remove'){
    $item_id = $_GET['id'];
    $class_obj->RemovePdtFromCart($item_id);
    $amount = $class_obj->getPaymentFromCart();
    $array = $class_obj->getCartItems();
    $cartItems = $array['cartItems'];
  }
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
       $('#shoppingcart-table').DataTable();

      });
    </script>


 <meta charset="utf-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="icon" type="image/gif/png" href="../img/skills.png">

 <title>Shopping Cart</title>
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
  .navbar{
    height: 35px !important;
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
            <li><a href="dashboard.php">Dashboard</a></li>
            <li class="active"><a href="conductsale.php">shopping-cart</a></li>
            <li><a href="sales.php">Sales</a></li>
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
                  <a href="conductsale.php?56-89-2333-logout='1'" id="logout" ><span class="glyphicon glyphicon-off"></span> Logout </a>
                <?php endif ?>
              </li>
            </ul>
          </a>
        </li>
      </ul>


    </div><!--/.nav-collapse -->
  </div>
</nav>



<section id="main">
  <div class="container">
    <br>

        <!-- <div class="panel panel-default">
          <div class="panel-body"> -->

            <div class="row">

             <div class="col-md-4 " >
              <div id="enterproductname">

                <div class="well entrytable" style="background-color: #fff">

                  <form action="conductsale.php" method="POST" id="add_details">

                    <div class="form-group">
                      <label>Item</label>
                      <input class="form-control" type="text"  autocomplete="off" name="Product" id="item" placeholder="Search item name">
                    </div>

                    <div class="form-group">
                      <label>Quantity</label>
                      <input class="form-control" type="number"  name="Quantity" id="quantity" placeholder="1" autocomplete="off">
                    </div>

                    <div class="form-group">
                      <label>Price</label>
                      <input class="form-control" type="number"  id="price" name="Price" placeholder="0.0" >
                    </div>

                    <div class="form-group">
                      <label>Discount</label>
                      <input class="form-control" type="number"  name="Discount" id="discount" placeholder="0" autocomplete="off">
                    </div>

                    <div class="form-group">
                      <input type="submit" class="btn main-color-bg add-row recBtn" value="Add to cart" name="addToCart">
                      <input type="submit" name="save-sales" class="btn btn-info recBtn" 
                      id="PrintTheReceipt" value="Save sales" >
                    </div>

                    <?php
                    //formtarget="_blank"
                    if(isset($_POST['addToCart'])){
                      echo $class_obj->AddToCart(); 
                      $array = $class_obj->getCartItems();
                      $cartItems = $array['cartItems'];
                      if($class_obj->getPaymentFromCart() > 0){
                       $amount = $class_obj->getPaymentFromCart();
                     }else{
                      $amount = 0;
                    }
                  }

                  if(isset($ConfirmMessage_forSales) && $ConfirmMessage_forSales != ""){
                    echo "<span class='success'>$ConfirmMessage_forSales</span>";
                  }
                  if(isset($EmptyCartmessageErr) && $EmptyCartmessageErr != ""){
                    echo "<span class='error'>$EmptyCartmessageErr</span>";
                  }



                  ?>


                </div>
              </div>
            </div>


            <div class="col-md-8">
              <div class="panel panel-default">

                <div class="panel-heading main-color-bg" >
                  <h3 class="panel-title">Shopping cart</h3>
                </div>

                <div class="panel-body">
                     
                  <div class="col-lg-2">
                    <label>Pay:</label>
                    <span id="changecolor">shs.</span>
                  </div>

                  <div class="col-lg-2">
                    <div class="form-group" id="salescolored">
                      <span class="form-control" >
                        <span id='payment'><?php echo htmlspecialchars($amount);?></span>
                      </span>
                    </div>
                  </div>

                  <div class="col-lg-3">
                    <div class="form-group">
                      <input type="text" class="form-control" name="tendered" id="tendered" placeholder="Tendered" style="text-align: center";
                      value="<?php
                      if(isset($_POST['tendered'])){
                        echo htmlspecialchars($_POST['tendered']);
                      }
                      ?>"
                      >
                    </div>
                  </div>

                  <div class="col-lg-3">
                    <div class="form-group" id="salescolored">
                     <input type="text" class="form-control" name="balance" id="balance" placeholder="Balance" style="text-align: center;" 
                     value="<?php
                     if(isset($_POST['balance'])){
                      echo htmlspecialchars($_POST['balance']);
                    }
                    ?>"

                    >
                  </div>
                </div>


                <div >
                  <a  type="button" class="delete-row" href="conductsale.php?clear-cart='1'"><span class="fa fa-trash" id="changecolor"> clear cart</span></a>
                </div>

              </form>
               
              <table class="table table-striped table-hover" id="shoppingcart-table">
                <thead id="fontfam" class="warning">
                  <th>Action</th>
                  <th>Item Name</th>
                  <th>Qty</th>
                  <th>Unit Price</th>
                  <th>Total</th>
                  <th>Discount (% / shs)</th>
                  <th>Cost</th>
                </thead>
                

                <?php
                foreach($cartItems as $item){

                 $tbody = "
                 <tbody id='table_data'>
                 <tr>
                 <td>
                 <a href='conductsale.php?action=remove&id=".$item["ItemId"]."'>
                 <span class='glyphicon glyphicon-trash'></span>
                 </a>
                 </td>
                 <td>".$item[1]."</td>
                 <td>".$item[2]."</td>
                 <td>".number_format($item[3])."</td>
                 <td>".number_format($item[4])."</td> 
                 <td>".$item[5]."</td>
                 <td>".number_format($item[6])."</td>
                 </tr>
                 </tbody>
                 ";
                 echo $tbody;

               }

                   ?>

                 </table>


               </div>
             </div>
           </div>
         </div>



       </div>


     </section>

    

    <script type="text/javascript">
      $(document).ready(function(){

        $('#item_barcode').focus();
        var cash,index;

        get_balance();
        ComputeBalance();

        $("#price").css("color","#c0392b");

        $(".add-row").click(function(){
          getTotal();
          ComputeBalance();
          get_balance();
        });

        $(".delete-row").click(function(){
          $("table tbody").find('input[name="record"]').each(function(){
            if($(this).is(":checked")){
              $(this).parents("tr").remove();
              getTotal();
              get_balance();
              ComputeBalance();
            }
          });
        });

        $("#PrintTheReceipt").click(function(){
          var tendered,balance;
          var myarray = [];
          tendered = $("#tendered").val();
          balance = $("#balance").val();
          myarray.push(tendered);
          myarray.push(balance);

          $.ajax({
            url:"../php/PrintingHandler.php",
            method:'POST',
            data:{
              getMoreCartDetails:1,
              dataItems: myarray,
            },
            success:function(data){
              console.log(data);
            },
            error:function(data){
              console.log("Can't send the data because "+data+"");
            }

          });
        });




        $("#item").focus(function(){
          var mydata;
          var query = $("#item").val();

          if(query.length>=2){
    //console.log(query);
    $.ajax({
      url:'../php/hostsys.inc.php',
      method:'POST',
      data: {
        searchPrice: 1,
        q:query

      },
      success: function(data) {
       if (typeof data === 'string' || data instanceof String){
        mydata =parseInt(data);
      }else{
        mydata = data;
      }
      $("#price").val(parseInt(mydata));
    },
    dataType: 'text'

  });
  }
});

        $("#item").typeahead({
          source:function(query,result){
            $.ajax({
              url:'../php/hostsys.inc.php',
              method:'POST',
              data:{
                SearchItem:1,
                query:query
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

//Computation of how much the customer must pay
function getTotal(){
  cash = 0;
  var table = document.getElementById('table_data');
  for(index=0;index<table.rows.length;index++){
    cash += parseInt(table.rows[index].cells[6].innerHTML);
  }
  $("#payment").text((parseInt(cash)));
}



function get_balance(){
  $("#tendered").keyup(function(){
    var payment = $("#payment").text();
    var tendered_money = $("#tendered").val();

    if(tendered_money.length>0){
      var bal = (parseInt(payment) - parseInt(tendered_money));
      $('#balance').val(bal);
    }
   /* else if(tendered_money==payment || tendered_money==null){
      var bal = 0;
      $('#balance').text(bal);
    }*/
  });
}


function ComputeBalance(){
  var payment = $("#payment").text();
  var tenderedmoney = $("#tendered").val();

  if(tenderedmoney == null){
    tenderedmoney = 0;
  }
  if(tenderedmoney.length != 0){
    var bal = (parseInt(payment) - parseInt(tenderedmoney));
    $('#balance').val(bal);
  }
 /* else if(tenderedmoney==payment || tenderedmoney==null){
    var bal = 0;
    $('#balance').text(bal);
  }*/
}
});

</script>

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
