<?php
require '../php/plus-content.inc.php';
require '../php/hostsys.inc.php';
require '../php/authenticate.php';
if(empty($_SESSION['username'])){
  header("location:../index.php");
}
$obj = new RetrievalDbModule();
//if(isset($type_error)){
if(isset($error_message) && $error_message!="") {
  echo '<span class="error-message">'.$error_message.'</span>';
}
            //}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <script src="../js/jquery-2.2.4.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/jquery-ui.min.js"></script>
  <script src="../js/jsMaster.js"></script>
  <script src="../js/dialog-master/dist/js/bootstrap-dialog.min.js"></script>

  <link rel="icon" type="image/gif/png" href="../img/skills.png">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">


  <title>Register Cashier</title>

  <!-- Bootstrap core CSS -->
  <link href="../css/bootstrap.min.css" rel="stylesheet">

  <!-- External CSS -->
  <link href="../css/style.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css" >
  <!--fontawesome -->
  <link rel="stylesheet" type="text/css" href="../fontawesome/css/all.css">
  <style type="text/css">
   .star{
    color: red;
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
        </span>
      | Cashiers</a>
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
              <a href="RegisterCashier.php?56-90-2332-logout='1'" id="logout" ><span class="glyphicon glyphicon-off"></span> Logout </a>
            <?php endif ?>
          </li>
        </ul>
      </a>
    </li>
  </ul>

  
</div><!--/.nav-collapse -->
</div>
</nav>


<br>
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
          <div class="well text-center">
          <span id="title">
            <?php echo $obj->getCompanyName(); ?> 
            
          </span>
          </div>
        </div>
        <div class="col-md-7">
         <div class="panel panel-success">
          <div class="panel-heading" >
            <h5 class="panel-title">Register cashier</h5>

          </div>
          <div class="panel-body">

           <form action="RegisterCashier.php" method="POST" class="registration-form">
            <table class="table borderless">
              <tbody>
                <tr>
                  <td>
                   <div class="form-inline">
                    <span>First Name <span class="star">*</span></span>
                    <div class="input-group fname">
                      <span class="input-group-addon" id="basic-addon1">
                         <span class="fa fa-user"></span>
                      </span>
                      <input type="text" class="form-control " name="firstname"
                      placeholder="Cashier firstname " aria-describedby="basic-addon1" required autofocus>
                    </div>
                  </div>
                </td>
              </tr>

              <tr>
                <td>
                 <div class="form-inline">
                   <span>Last Name <span class="star">*</span></span>
                   <div class="input-group lname">
                    <span class="input-group-addon" id="basic-addon2">@</span>
                    <input type="text" class="form-control " name="lastname"
                    placeholder="Cashier lastname" required autofocus aria-describedBy='basic-addon2'>   
                  </div>    
                </div>
              </td>
            </tr>

            <tr>
              <td>
               <div class="form-inline">
                 <span>Mobile No <span class="star">*</span></span> 
                 <div class="input-group mobile">
                  <span class="input-group-addon " id="basic-addon3">
                     <span class="fa fa-phone"></span>
                  </span>
                  <input type="text" class="form-control " name="Mobile_No" placeholder="phone number" required autofocus aria-describedBy="basic-addon3">
                </div>        
              </div>
            </td>
          </tr>

          <tr>
            <td>
              <div class="form-inline">
                <span>Address <span class="star">*</span></span> 
                <div class="input-group address">
                  <span class="input-group-addon " id="basic-addon8">
                     <span class="fa fa-address-book"></span>
                  </span>
                  <input type="text" class="form-control " name="Address" placeholder="home address" required autofocus aria-describedBy="basic-addon8">
                </div>   
              </div>
            </td>
          </tr>

          <tr>
            <td>
             <div class="form-inline">
               <span>Email</span>
               <div class="input-group email">
                <span class="input-group-addon " id="basic-addon4">
                   <span class="fa fa-envelope"></span>
                </span>
                <input type="email" class="form-control " name="Email" placeholder="email (optional)" aria-describedBy="basic-addon4">
              </div>
            </div>
          </td>
        </tr>

        <tr>
          <td>
           <div class="form-inline">
             <span>Password <span class="star">*</span></span>
             <div class="input-group password1">
              <span class="input-group-addon " id="basic-addon5">
                <span class="fa fa-lock"></span>
              </span>
              <input type="password" class="form-control" name="Cashier_Password1" placeholder="enter password" required autofocus aria-describedBy="basic-addon5">
            </div>
          </div>
          
        </td>
      </tr>

      <tr>
        <td>
         <div class="form-inline">
          <span>Confirm Password <span class="star">*</span></span>
          <div class="input-group">
            <span class="input-group-addon" id="basic-addon6">
               <span class="fa fa-lock"></span>
            </span>
            <input type="password" class="form-control" name="Cashier_Password2" placeholder="confirm password" required autofocus aria-describedBy="basic-addon6">
          </div>
        </div>
      </td>
    </tr>
    <tr>
      <td>
        <div class="form-inline">
          <div class="btngroup">
         <input type="submit" class="btn btn-success main-color-bg mybtns" name="AddCashierBtn" 
         value="Register">
         <input type="reset" class="btn btn-default mybtns" value="Cancel"   >    
       </div>  
     </div>
     </td>
   </tr>
 </tbody>
</table>


<?php
$h = new ClassMaster();
if(isset($_POST['AddCashierBtn'])){
  $carray =  $h->AddCashier();
  $status = $carray['status'];
  $cashiernames = $carray['cashier'];
  if($status==true){
   echo "<span class='success'>".$cashiernames." has been registered as a cashier successfully</span>";
 }
 else{
  require('../php/errors.php');
}

}  

?> 

</form>
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



</body>
</html>
