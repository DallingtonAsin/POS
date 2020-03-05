<?php

require '../php/authenticate.php';
require '../php/plus-content.inc.php';
require '../php/hostsys.inc.php';
require '../php/downloads.php';

if(empty($_SESSION['username'])){
  header("location:../index.php");
}

$obj = new RetrievalDbModule();

if(isset($_POST["importStockBtn"])) {
  echo $obj->importStock();
}

 $array = $obj->getExpenses();
 $list_of_expenses = $array['expenses'];
 $totalExpenses = $array['TotalExpenses'];



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
       $('#editable_table').Tabledit({
        url:'../php/updates.inc.php',
        data:{
          updateExpenses:1
        },
        buttons:{
          delete:{
            html: '<span class="glyphicon glyphicon-trash" id="delete"></span>',
            action:'deleteExpense'
          },
          edit:{
            html: '<span class="glyphicon glyphicon-pencil" id="edit"></span>',
            action:'editExpense'
          }
        },
        columns:{
          identifier:[0, "id"],
          editable:[[1,'ExpenseType'],[2,'Amount'],[3,'DateOfExpense']]
        },
          // $("edit").css('background','blue'),
          restoreButton:false,
          onSuccess:function(data, textStatus, jqXHR){
            if(data.action == 'delete'){
              $('#'+data.id).remove();
            }
          }
        });
    $('#editable_table').DataTable();
  } ); 
</script>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/gif/png" href="../img/skills.png">

<title>Manage Expenses</title>
<link href="../vendor/datatables/datatables-18/css/jquery.dataTables.min.css" rel="stylesheet">
<!-- Bootstrap core CSS -->
<link href="../css/bootstrap.min.css" rel="stylesheet">

<!-- External CSS -->
<link href="../css/style.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/jquery-ui.css" >

<!--fontawesome -->
<link rel="stylesheet" type="text/css" href="../fontawesome/css/all.css">


<script src="../js/jquery-tabledit/jquery.tabledit.min.js"></script>
<style type="text/css">
  .panel-heading{
    height: 50px !important;
  }
  #records-form{
    margin-left:50px !important;
  }
  #limit-ExpensesRecords{
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
                  <a href="stock.php?56-90-2332-logout='1'" id="logout" ><span class="glyphicon glyphicon-off"></span> Logout </a>
                <?php endif ?>
              </li>
            </ul>
          </a>
        </li>
      </ul>

      <!--   <?php require('../php/errors.php') ;?>  -->
    </div>
  </div>
</nav>

<header id="header">

  <div class="container">

    <div class="row">
      <div class="col-md-10">

        <h3><span class="glyphicon glyphicon-cog" aria-hidden="true"></span>Expenses <small id="manage">Manage expenses</small>
        </h3>
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

            <form method="POST" action="expenses.php" enctype="multipart/form-data">

              <div class="form-group">
               <input type="file" name="Expense-ExcelFile" id="excelfile">
             </div>

             <div class="form-group import-button-group">
              <center>
                <input type="submit" name="importExpensesBtn" id="import-first-time" 
                value="import" class="btn btn-imports">
                <!-- <input type="submit" name="importUpdateExpensesBtn" id="update-import" 
                value="update" class="btn btn-imports"> -->
              </center>
              </div>
              <?php
              if(isset($_POST['importExpensesBtn'])){
                $response_message  =  $obj->importExpenses();
                if($response_message == 1){
                  $array = $obj->getExpenses();
                  $list_of_expenses = $array['expenses'];
                  $totalExpenses = $array['TotalExpenses'];
                  echo "<span class='success'>Expenses imported successfully</span>";
                }
                else{
                 echo "<span class='error-info'>$response_message</span>";
               }

             }
           /*  if(isset($_POST['importUpdateExpensesBtn'])){
              $response_info  =  $obj->importAndUpdateExpenses();
              if($response_info == 1){
                $array = $obj->getExpenses();
                $list_of_expenses = $array['expenses'];
                $totalExpenses = $array['TotalExpenses'];
                echo "<span class='success'>Expenses updated successfully</span>";
              }
              else{
               echo "<span class='error-info'>$response_info</span>";
             }

           }*/

           ?>

         </form>

       </div>
     </div>
     <div class="col-md-9">
      <div class="panel panel-default">


        <div class="panel-heading">
          <div class="form-inline">
                <div class="form-group">
                  <span>Expenses</span>
                </div>
            
                
              <div class="form-group">
                  <a href="#" data-toggle="modal"  data-target="#addExpense" id="modal-links" class="margink">
                    <span class="glyphicon glyphicon-plus-sign"></span> add expense</a>
                  </div> 

              <div class="form-group">
              <a href="#" data-toggle="modal"  data-target="#addExpenseType" id="modal-links" class="margink">
                <span class="glyphicon glyphicon-plus-sign"></span> add type</a>
              </div>

             <div class="form-group">
                <div class="input-group">
                  <ul id="stocklabel">
                    <li >Current total expenses</li>
                  </ul>
                </div>
              </div>

              <div class="form-group" id="salescolored">
                <span name="totalsales" class="form-control" >
                  <?php
                  echo htmlspecialchars(number_format($totalExpenses));
                  ?></span>
                </div>

                 <div class="form-group btn-group pull-right">
                        <button type="button" class="btn btn-primary dropdown-toggle downloadfilebtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         Download <span class="caret"></span>
                       </button>
                       <ul class="dropdown-menu">
                       <!--  <li><a href="expenses.php?SaveExpenseBtn='1'">Export to Pdf</a></li> -->
                        <li><a href="expenses.php?SaveExpensesCsvFile='1'">Export to Excel / Csv</a></li> 
                      </ul>
                    </div>

          </div>
        </div>

        <div class="panel-body">
               
                <div class="table-responsive">
                  <table id="editable_table"  class="table table-striped table-hover">
                    <thead>
                      <tr id="fontfam" class="warning">
                        <th>No.</th>
                        <th>Expense Type</th>
                        <th>Amount</th>
                        <th>Date of expense</th>
                      </tr>
                    </thead>

                    <tbody>
                    <?php
                    foreach($list_of_expenses as $rows){
                      ?>
                      <tr>
                        <td><?php echo "".$rows['id']."";?></td>
                        <td><?php echo"".$rows['ExpenseType']."";?></td>
                        <td><?php echo"".number_format($rows["Amount"])."";?></td>
                        <td><?php echo"".$rows['DateOfExpense']."";?></td>
                       
                      <?php } ?>
                    </tr>
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



    <!--Add Expense -->
    <div class="modal fade" id="addExpense" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">

          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Add Expense</h4>
            </div>
            <div class="modal-body">

              <div class="form-group">
                <label>Expense Type</label>
                <select class="form-control" name="ExpenseType" Required autofocus>
                  <option selected>choose expense type</option>

                  <?php
                  $expense_types = $obj->getExpenseTypes();
                  foreach ($expense_types as $key => $row) {
                   echo "<option>".$row['ExpenseType']."</option>";
                 } ?>

               </select>
             </div>

             <div class="form-group">
              <label>Amount</label>
              <input type="number" class="form-control" name="Amount" 
              placeholder="enter expenditure" Required autofocus>

            </div>
            <div class="form-group">
              <label>Date of expenditure</label>
              <div class='input-group date' id='datetimepicker1'>
                <input type='date' name="DateOfExpense" placeholder="start date..." class="form-control"  />
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>

          </div>

          <div class="form-group">
            <button type="submit" class="btn"  name="AddExpenseBtn" class="login_btn">Add</button>
            <button type="reset" class="btn btn-danger">Clear</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
          <?php require('../php/errors.php') ;?>

        </div>

      </form>
    </div>
  </div>
</div>



<!--Add Expense -->
<div class="modal fade" id="addExpenseType" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Add ExpenseType</h4>
        </div>
        <div class="modal-body">

         <div class="form-group">
          <label>Expense Type</label>
          <input type="text" class="form-control" name="EType" 
          placeholder="enter expense type e.g rent,salary etc " Required autofocus>
        </div>

        <div class="form-group">
          <button type="submit" class="btn"  name="AddExpenseTypeBtn" id="login_btn">Add</button>
          <button type="reset" class="btn btn-danger">Clear</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        <?php require('../php/errors.php') ;?>

      </div>

    </form>
  </div>
</div>
</div>

</body>
</html>
