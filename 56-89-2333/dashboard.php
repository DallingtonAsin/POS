<?php
require '../php/hostsys.inc.php';
require '../php/shopping-cart.php';
require '../php/authenticate.php';
require '../php/errors.php';
if(empty($_SESSION['username'])){
  header("location:../index.php");
}
$obj = new RetrievalDbModule();
$objectClass = new CartClass();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <script src="../js/jquery-2.2.4.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/jquery-ui.min.js"></script>
  <script src="../js/jsMaster.js"></script>
  <script src="../js/dialog-master/dist/js/bootstrap-dialog.min.js"></script>

  <link rel="icon" type="../image/gif/png" href="../img/skills.png">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">


  <title>Cashier | Dashboard</title>



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
          </span></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="dashboard.php" >Dashboard</a></li>
            <li><a href="conductsale.php">shopping-cart</a></li>
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
                      <a href="dashboard.php?56-89-2333-logout='1'" id="logout" ><span class="glyphicon glyphicon-off"></span> Logout </a>
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
            <h3><span class="glyphicon glyphicon-cog" aria-hidden="true"></span>Sales-point
              <small id="manage">Dashboard</small>
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
      </div><!-- /.container -->



    </header>

    <section id="breadcrumb">
      <div class="container">
        <ol class="breadcrumb">
          <li><a href="dashboard.php" class="active">Dashboard</a></li>


        </ol>

      </div>

    </section>


    <section id="main">
      <div class="container">
        <div class="row">
          <div class="col-md-3">
            <div class="list-group">
              <a href="dashboard.php" class="list-group-item active main-color-bg">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>Dashboard
              </a>
              <a href="conductsale.php" class="list-group-item"> <span class="fa fa-shopping-cart" aria-hidden="true">
              </span> shopping-cart<span class="badge">
                <?php echo $objectClass->getNumberofCartItems();?>
              </span></a>
              <a href="sales.php" class="list-group-item"> <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"> </span> Today's Sales<span class="badge">
                <?php echo $obj->getNumberOfTodaysSales();?>
              </span></a>
              <a href="stock.php" class="list-group-item"><span class="glyphicon glyphicon-pencil" aria-hidden="true">
              </span> Stock<span class="badge"><?php echo $obj->getNumberofProducts();?></span></a>
              <a href="damages.php" class="list-group-item"><span class="fa fa-trash-alt" aria-hidden="true">
              </span> Damages<span class="badge"><?php echo $obj->getNumberofDamages();?></span></a>

            </div>
            <div class="well" id="wellsale">
              <center>
                <h4 class="titlehd">
                  <?php echo $obj->getCompanyName(); ?>
                </h4>
              </center>

            </div>

          </div>

          <div class="container" id="dashboard">


            <div class="col-md-9">
              <div class="panel panel-default">
                <div class="panel-heading main-color-bg" >
                  <h3 class="panel-title">Dashboard</h3>
                </div>
                <div class="panel-body">

                  <div class="col-md-3">
                    <a href="conductsale.php"> <div class="well dash-box" class="boxes">
                      <h2><span class="fa fa-shopping-cart" aria-hidden="true"></span></h2>
                      <h4>Cart</h4>
                    </div></a>
                  </div>

                  <div class="col-md-3">
                    <a href="sales.php"><div class="well dash-box" class="boxes">
                      <h2><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span></h2>
                      <h4>Sales</h4>
                    </div></a>
                  </div>



                  <div class="col-md-3">
                    <a href="stock.php"><div class="well dash-box" class="boxes">
                      <h2><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></h2>
                      <h4>Stock</h4>
                    </div></a>
                  </div>

                  <div class="col-md-3">
                    <a href="damages.php"><div class="well dash-box" class="boxes">
                      <h2><span class="fa fa-trash-alt" aria-hidden="true"></span></h2>
                      <h4>Damages</h4>
                    </div></a>
                  </div>
                </div>
              </div>



              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title"><span>
                    <center>
                      <h6><center>This is the property of Code Solution Tech.You have just a license
                        to use this software</center></h6>
                      </center>
                    </span></h4>
                  </div>
                  <!--<div class="panel-body">
                  <h6><center>This is the property of codesolutiontech.You have just a license
                  to use this software</center></h6>
                </div>-->
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
