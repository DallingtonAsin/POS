<?php

require_once('dbController.inc.php');
require_once('../vendor/dompdf/autoload.inc.php');


use Dompdf\Dompdf;

class Downloads{


  private static $instance,$docInstance;

  public static function getDbInstance(){
    if(!self::$instance){
      self::$instance = new Database();
    }
    return self::$instance;
  }


  public static function getPdfInstance(){
    if(!self::$docInstance){
      self::$docInstance = new Dompdf();
    }
    return self::$docInstance;
  }



  function downloadSalesCSVfile(){
   header("Content-Type: application/csv;charset=utf-8");
   header("Content-Disposition: attachment; filename=sales.csv");
   $sql_query = "SELECT * FROM sales ORDER BY Date DESC";
   $sql_statement = Downloads::getDbInstance()->getConnection()->prepare($sql_query);
   $sql_statement->execute();
   $row = $sql_statement->fetchAll(PDO::FETCH_ASSOC);

   $output = fopen("php://output", "w");
   fputcsv($output, array('No','ItemID','Item','Quantity','Buying Price','Selling Price',
    'Total Cost','Discount offered','Sold At','Customer','Date','Cashier'
  ));

   foreach($row as $table_data){
    fputcsv($output, $table_data);
  }
  fclose($output);
  exit();
}

function downloadPeriodicSalesCSVfile($date1, $date2){
 header("Content-Type: application/csv;charset=utf-8");
 header("Content-Disposition: attachment; filename=filteredsales.csv");
 $sql_query = "SELECT * FROM sales WHERE (Date BETWEEN '".$date1."' AND '".$date2."') ORDER BY Date DESC";
 $sql_statement = Downloads::getDbInstance()->getConnection()->prepare($sql_query);
 $sql_statement->execute();
 $row = $sql_statement->fetchAll(PDO::FETCH_ASSOC);

 $output = fopen("php://output", "w");
 fputcsv($output, array('No','ItemID','Item','Quantity','Buying Price','Selling Price',
  'Total Cost','Discount offered','Sold At','Customer','Date','Cashier'
));

 foreach($row as $table_data){
  fputcsv($output, $table_data);
}
fclose($output);
exit();
}





function downloadSales(){
 date_default_timezone_set('Africa/Kampala');
 $timenow = date('d/m/Y G:i A');
 $sales = Downloads::getDbInstance()->getConnection()->prepare("SELECT * FROM sales");
 $sales->execute();
 $sales_generated= "
 <link href='../css/bootstrap.min.css' rel='stylesheet'>
 <link href='../css/style.css' rel='stylesheet'>
 <span id='time'>$timenow</span>
 <h4 class='title'>SALES GENERATED SINCE THE START OF THE BUSINESS</h4>
 <table class='table table-striped table-hover'>
 <tr id='fontfam' class='warning'>
 <th>Bill no</th>
 <th>Product</th>
 <th>Qty</th>
 <th>Cost</th>
 <th>Discount</th>
 <th>Customer</th>
 <th>Date</th>
 <th>Cashier</th>
 </tr>
 ";

 if($sales->rowCount()>0){
   while ($row = $sales->fetch()) {
    $date = date('d-m-y', strtotime($row["Date"]));
    $sales_generated .='
    <tr>
    <td> '.$row["billno"].'</td>
    <td> '.$row["ProductName"].'</td>
    <td> '.$row["Quantity"].'</td>
    <td> '.$row["Price"].'</td>
    <td> '.$row["Discount"].'</td>
    <td> '.$row["Customer"].'</td>
    <td>'.$date.'</td>
    <td>'.$row["CashierName"].'</td>
    </tr>
    ';
  }
}

$sales_generated .='</table';
Downloads::getPdfInstance()->loadHtml($sales_generated);

Downloads::getPdfInstance()->setPaper('A4','landscape');
Downloads::getPdfInstance()->render();
Downloads::getPdfInstance()->stream("sales",array("Attachment"=>0));
    } // end of method downloadSales()

    function downloadInventory(){
      date_default_timezone_set('Africa/Kampala');
      $timenow = date('d/m/Y G:i A');
      $products = Downloads::getDbInstance()->getConnection()->prepare("SELECT ProductName,Category,QuantityAvailable,Supplier FROM products");
      $products->execute();
      $stock_available = "
      <link href='../css/bootstrap.min.css' rel='stylesheet'>
      <link href='../css/style.css' rel='stylesheet'>
      <span id='time'>$timenow</span>
      <h5 class='title'>PRODUCTS AVAILABLE IN STOCK [INVENTORY REPORT] </h5>
      <table class='table table-striped table-hover'>
      <tr id='fontfam' class='warning'>
      <th>Product</th>
      <th>Category</th>
      <th>Quantity</th>
      <th>Supplier</th>
      </tr>
      ";
      if($products->rowCount() > 0){
       while ($row = $products->fetch()) {
        $stock_available .='
        <tr>
        <td> '.$row["ProductName"].'</td>
        <td> '.$row["Category"].'</td>
        <td> '.$row["QuantityAvailable"].'</td>
        <td>'.$row["Supplier"].'</td>
        </tr>
        ';

      }
    }

    $stock_available .='</table';
    Downloads::getPdfInstance()->loadHtml($stock_available);
    Downloads::getPdfInstance()->setPaper('A4','landscape');
    Downloads::getPdfInstance()->render();
    Downloads::getPdfInstance()->stream("stock",array("Attachment"=>0));
} // end of method downloadInventory()

function downloadListOfExpenses(){
  date_default_timezone_set('Africa/Kampala');
  $timenow = date('d/m/Y G:i A');
  $count = 1;
  $sql = "SELECT ExpenseType,Amount,DateOfExpense FROM Expenses";
  $expenses = Downloads::getDbInstance()->getConnection()->prepare($sql);
  $expenses->execute();
  $ExpensesRecorded = "
  <link href='../css/bootstrap.min.css' rel='stylesheet'>
  <link href='../css/style.css' rel='stylesheet'>
  <span id='time'>$timenow</span>
  <h5 class='title'>RECORDED EXPENSES [EXPENSE REPORT] </h5>
  <table class='table table-striped table-hover'>
  <tr id='fontfam' class='warning'>
  <th>No</th>
  <th>ExpenseType</th>
  <th>Amount</th>
  <th>Date of Expense</th>
  </tr>
  ";
  if($expenses->rowCount() > 0){
   while ($row = $expenses->fetch()) {
    $ExpensesRecorded .='
    <tr>
    <td> '.$count++.'</td>
    <td> '.$row["ExpenseType"].'</td>
    <td> '.$row["Amount"].'</td>
    <td>'.$row["DateOfExpense"].'</td>
    </tr>
    ';

  }
}

$ExpensesRecorded .='</table';
Downloads::getPdfInstance()->loadHtml($ExpensesRecorded);
Downloads::getPdfInstance()->setPaper('A4','landscape');
Downloads::getPdfInstance()->render();
Downloads::getPdfInstance()->stream("expenses",array("Attachment"=>0));
} // end of method downloadListOfExpenses()


function downloadExpensesCSVfile(){
 header("Content-Type: application/csv;charset=utf-8");
 header("Content-Disposition: attachment; filename=expenses.csv");
 $sql_query = "SELECT * FROM expenses ORDER BY DateOfExpense DESC";
 $sql_statement = Downloads::getDbInstance()->getConnection()->prepare($sql_query);
 $sql_statement->execute();
 $row = $sql_statement->fetchAll(PDO::FETCH_ASSOC);

 $output = fopen("php://output", "w");
 fputcsv($output, array('No','Expense Type','Amout spent','Date of Expenditure'));

 foreach($row as $table_data){
  fputcsv($output, $table_data);
}
fclose($output);
exit();
}

function DownloadStockCsvfile(){
  header("Content-Type: application/csv;charset=utf-8");
  header("Content-Disposition: attachment; filename=stock.csv");
  $sql_query = "SELECT * FROM products ORDER BY id ASC";
  $sql_statement = Downloads::getDbInstance()->getConnection()->prepare($sql_query);
  $sql_statement->execute();
  $row = $sql_statement->fetchAll(PDO::FETCH_ASSOC);

  $output = fopen("php://output", "w");
  fputcsv($output, array('id','ItemID','Item','Category','Quantity',
    'Quantity Last Added','Buying Price','Selling Price','Profit per Unit',
    'Total CostPrice per Item','Total profit per item','Supplier','DateofEntry','ExpiryDate'));

  foreach($row as $table_data){
    fputcsv($output, $table_data);
  }
  fclose($output);
  exit();

}

function DownloadCashiersCsvfile(){
  header("Content-Type: application/csv;charset=utf-8");
  header("Content-Disposition: attachment; filename=cashiers.csv");
  $sql_query = "SELECT id,CashierName,MobileNo,Address,Email FROM cashiers ORDER BY id ASC";
  $sql_statement = Downloads::getDbInstance()->getConnection()->prepare($sql_query);
  $sql_statement->execute();
  $row = $sql_statement->fetchAll(PDO::FETCH_ASSOC);

  $output = fopen("php://output", "w");
  fputcsv($output, array('No','Cashier Name','Contact','Adress','Email'));

  foreach($row as $table_data){
    fputcsv($output, $table_data);
  }
  fclose($output);
  exit();
  

}


function downloadCashiers(){
  $count=1;
  date_default_timezone_set('Africa/Kampala');
  $timenow = date('d/m/Y G:i A');
  $cashiers = Downloads::getDbInstance()->getConnection()->prepare("SELECT CashierName,MobileNo,Address,Email FROM cashiers");
  $cashiers->execute();
  $registered_cashiers = "
  <link href='../css/bootstrap.min.css' rel='stylesheet'>
  <link href='../css/style.css' rel='stylesheet'>
  <span id='time'>$timenow</span>
  <h4 class='title'>COMPANY REGISTERED CASHIERS</h4>
  <table class='table table-striped table-hover'>
  <tr id='fontfam' class='warning'>
  <th>No.</th>
  <th>Cashier</th>
  <th>Contact</th>
  <th>Address</th>
  <th>Email</th>
  </tr>
  ";

  if($cashiers->rowCount()>0){
   while ($row = $cashiers->fetch()) {
                //$date = date('d-m-y h:m', strtotime($row["ExpiryDate"]));

     $registered_cashiers .='
     <tr>
     <td> '.$count++.'</td>
     <td> '.$row["CashierName"].'</td>
     <td> '.$row["MobileNo"].'</td>
     <td> '.$row["Address"].'</td>
     <td> '.$row["Email"].'</td>
     </tr>
     ';


   }
 }

 $registered_cashiers .='</table';
 Downloads::getPdfInstance()->loadHtml($registered_cashiers);

 Downloads::getPdfInstance()->setPaper('A4','landscape');
 Downloads::getPdfInstance()->render();
 Downloads::getPdfInstance()->stream("RegisteredCashiers",array("Attachment"=>0)); 
} //end of method downloadCashiers()

function downloadSuppliers(){
 $count=1;
 date_default_timezone_set('Africa/Kampala');
 $timenow = date('d/m/Y G:i A');
 $suppliers= Downloads::getDbInstance()->getConnection()->prepare("SELECT SupplierName,Address,Contact,DR,CR FROM suppliers");
 $suppliers->execute();
 $registered_suppliers = "
 <link href='../css/bootstrap.min.css' rel='stylesheet'>
 <link href='../css/style.css' rel='stylesheet'>
 <span id='time'>$timenow</span>
 <h4 class='title'>LIST OF SUPPLIERS</h4>
 <table class='table table-striped table-hover'>
 <tr id='fontfam' class='warning'>
 <th>No.</th>
 <th>Supplier</th>
 <th>Address</th>
 <th>Contact</th>
 <th>Debt</th>
 <th>Credit</th>
 </tr>
 ";
 if($suppliers->rowCount() > 0){
   while ($row = $suppliers->fetch()) {
     $registered_suppliers .='
     <tr>
     <td> '.$count++.'</td>
     <td> '.$row["SupplierName"].'</td>
     <td> '.$row["Address"].'</td>
     <td> '.$row["Contact"].'</td>
     <td> '.$row["DR"].'</td>
     <td> '.$row["CR"].'</td>
     </tr>
     ';
   }
 }

 $registered_suppliers .='</table';
 Downloads::getPdfInstance()->loadHtml($registered_suppliers);

 Downloads::getPdfInstance()->setPaper('A4','landscape');
 Downloads::getPdfInstance()->render();
 Downloads::getPdfInstance()->stream("Suppliers",array("Attachment"=>0));
} //end of method downloadSuppliers()

function downloadSuppliersCSVfile(){
  header("Content-Type: application/csv;charset=utf-8");
  header("Content-Disposition: attachment; filename=suppliers.csv");
  $sql_query = "SELECT * FROM suppliers ORDER BY id ASC";
  $sql_statement = Downloads::getDbInstance()->getConnection()->prepare($sql_query);
  $sql_statement->execute();
  $row = $sql_statement->fetchAll(PDO::FETCH_ASSOC);

  $output = fopen("php://output", "w");
  fputcsv($output, array('No','Supplier','Address',
    'Contact','Email','Debt Amount','Credit Amount'));

  foreach($row as $table_data){
    fputcsv($output, $table_data);
  }
  fclose($output);
  exit();
}

function downloadDamages(){
 $count=1;
 date_default_timezone_set('Africa/Kampala');
 $timenow = date('d/m/Y G:i A');
 $damages_exe = Downloads::getDbInstance()->getConnection()->prepare("SELECT ItemID,ProductName,Category,Quantity FROM Damages");
 $damages_exe->execute();
 $recorded_damages = "
 <link href='../css/bootstrap.min.css' rel='stylesheet'>
 <link href='../css/style.css' rel='stylesheet'>
 <span id='time'>$timenow</span>
 <h4 class='title'>RECORDED DAMAGES</h4>
 <table class='table table-striped table-hover'>
 <tr id='fontfam' class='warning'>
 <th>No.</th>
 <th>ItemID</th>
 <th>Item</th>
 <th>Category</th>
 <th>Quantity</th>

 </tr>
 ";
 $count_damages_num = 1;
 if($damages_exe->rowCount()>0){
   while ($row = $damages_exe->fetch()) {
     $recorded_damages .='
     <tr>
     <td> '.$count++.'</td>
     <td> '.$row["ItemID"].'</td>
     <td> '.$row["ProductName"].'</td>
     <td> '.$row["Category"].'</td>
     <td> '.$row["Quantity"].'</td>
     </tr>
     ';


   }
 }

 $recorded_damages .='</table';
 Downloads::getPdfInstance()->loadHtml($recorded_damages);

 Downloads::getPdfInstance()->setPaper('A4','landscape');
 Downloads::getPdfInstance()->render();
 Downloads::getPdfInstance()->stream("RecordedDamages",array("Attachment"=>0));
} //end of method downloadDamages()


function downloadDamagesCSVfile(){
  header("Content-Type: application/csv;charset=utf-8");
  header("Content-Disposition: attachment; filename=damages.csv");
  $sql_query = "SELECT * FROM damages ORDER BY id ASC";
  $sql_statement = Downloads::getDbInstance()->getConnection()->prepare($sql_query);
  $sql_statement->execute();
  $row = $sql_statement->fetchAll(PDO::FETCH_ASSOC);

  $output = fopen("php://output", "w");
  fputcsv($output, array('No','ItemID','Damaged Item','Category','Quantity'));

  foreach($row as $table_data){
    fputcsv($output, $table_data);
  }
  fclose($output);
  exit();
}

function downloadCustomers(){
 $count=1;
 date_default_timezone_set('Africa/Kampala');
 $timenow = date('d/m/Y G:i A');
 $customers_exe = Downloads::getDbInstance()->getConnection()->prepare("SELECT CustomerName,Phone,DR,CR FROM customers");
 $customers_exe->execute();
 $registered_customers = "
 <link href='../css/bootstrap.min.css' rel='stylesheet'>
 <link href='../css/style.css' rel='stylesheet'>
 <span id='time'>$timenow</span>
 <h4 class='title'>LIST OF REGISTERED CUSTOMERS</h4>
 <table class='table table-striped table-hover'>
 <tr id='fontfam' class='warning'>
 <th>No.</th>
 <th>Customer</th>
 <th>Mobile No</th>
 <th>Debt</th>
 <th>Credit</th>
 </tr>
 ";

 if($customers_exe->rowCount()>0){
   while ($row = $customers_exe->fetch()) {
     $registered_customers .='
     <tr>
     <td> '.$count++.'</td>
     <td> '.$row["CustomerName"].'</td>
     <td> '.$row["Phone"].'</td>
     <td> '.$row["DR"].'</td>
     <td> '.$row["CR"].'</td>
     </tr>
     ';
   }
 }

 $registered_customers .='</table';
 Downloads::getPdfInstance()->loadHtml($registered_customers);

 Downloads::getPdfInstance()->setPaper('A4','landscape');
 Downloads::getPdfInstance()->render();
 Downloads::getPdfInstance()->stream("RegisteredCustomers",array("Attachment"=>0));
} //end of method downloadCustomers()


function downloadCustomersCSVfile(){
  header("Content-Type: application/csv;charset=utf-8");
  header("Content-Disposition: attachment; filename=customers.csv");
  $sql_query = "SELECT * FROM customers ORDER BY id ASC";
  $sql_statement = Downloads::getDbInstance()->getConnection()->prepare($sql_query);
  $sql_statement->execute();
  $row = $sql_statement->fetchAll(PDO::FETCH_ASSOC);

  $output = fopen("php://output", "w");
  fputcsv($output, array('No','Customer',
    'Contact','Debt Amount','Credit Amount'));

  foreach($row as $table_data){
    fputcsv($output, $table_data);
  }
  fclose($output);
  exit();
}

function downloadStockCategories(){
  $count=1;
  date_default_timezone_set('Africa/Kampala');
  $timenow = date('d/m/Y G:i A');
  $category_exe = Downloads::getDbInstance()->getConnection()->prepare("SELECT Category FROM category");
  $category_exe->execute();
  $registered_categories_of_stock = "
  <link href='../css/bootstrap.min.css' rel='stylesheet'>
  <link href='../css/style.css' rel='stylesheet'>
  <span id='time'>$timenow</span>
  <h4 class='title'>LIST OF CATEGORIES OF STOCK</h4>
  <table class='table table-striped table-hover'>
  <tr id='fontfam' class='warning'>
  <th>No.</th>
  <th>Category</th>
  </tr>
  ";

  if($category_exe->rowCount()>0){
   while ($row = $category_exe->fetch()) {
     $registered_categories_of_stock .='
     <tr>
     <td> '.$count++.'</td>
     <td> '.$row["Category"].'</td>
     </tr>
     ';
   } //end of method downloadStockCategories()


 } 

 $registered_categories_of_stock .='</table';
 Downloads::getPdfInstance()->loadHtml($registered_categories_of_stock);

 Downloads::getPdfInstance()->setPaper('A4','landscape');
 Downloads::getPdfInstance()->render();
 Downloads::getPdfInstance()->stream("StockCategories",array("Attachment"=>0));
}

function downloadCategoriesCSVfile(){
  header("Content-Type: application/csv;charset=utf-8");
  header("Content-Disposition: attachment; filename=stock-categories.csv");
  $sql_query = "SELECT * FROM category ORDER BY id ASC";
  $sql_statement = Downloads::getDbInstance()->getConnection()->prepare($sql_query);
  $sql_statement->execute();
  $row = $sql_statement->fetchAll(PDO::FETCH_ASSOC);

  $output = fopen("php://output", "w");
  fputcsv($output, array('No','Category'));

  foreach($row as $table_data){
    fputcsv($output, $table_data);
  }
  fclose($output);
  exit();
}


function downloadSalesCSVfileFilteredByCashier(){
  
  $errors = array();
  if(isset($_POST['datey1']) && $_POST['datey1'] != "mm/dd/yyyy"){
    $date1 = $_POST['datey1'];
    $the_date1 = date('Y-m-d', strtotime($date1));
  }
  if(empty($_POST['datey1'])){
    $datesetErr = "select start date";
    array_push($errors,$datesetErr);
  }
  if(isset($_POST['datey2']) && $_POST['datey2'] != "mm/dd/yyyy"){
    $date2 = $_POST['datey2'];
    $the_date2 = date('Y-m-d', strtotime($date2));
  } 
  if(empty($_POST['datey2'])){
    $datesetErr = "select end date";
    array_push($errors,$datesetErr);
  }
  if(count($errors) == 0){
    header("Content-Type: application/csv;charset=utf-8");
    header("Content-Disposition: attachment; filename=filteredsales.csv");
    $sql = "SELECT * FROM  sales WHERE (Date BETWEEN '".$the_date1."' AND '".$the_date2."')";
    $sql_statement = Downloads::getDbInstance()->getConnection()->prepare($sql);
    $sql_statement->execute();
    $row = $sql_statement->fetchAll(PDO::FETCH_ASSOC);

    $output = fopen("php://output", "w");
    fputcsv($output, array('No','ItemID','Item','Quantity','Buying Price','Selling Price',
      'Total Cost','Discount offered','Sold At','Customer','Date','Cashier'
    ));

    foreach($row as $table_data){
      fputcsv($output, $table_data);
    }
    fclose($output);
    exit();
  }
  else{
    $datesetErr = "Please select both start & end dates to download";
  }

}

}


$obj = new Downloads();

switch (true) {
  case (isset($_GET['SaveSalesBtn'])):
  echo $obj->downloadSales();
  break;
  case (isset($_GET['SaveSalesCsvBtn'])):
  echo $obj->downloadSalesCSVfile();
  break;
  case (isset($_GET['exportStockPdf'])):
  echo $obj->downloadInventory();
  break;
  case (isset($_GET['exportStockCsv'])):
  echo $obj->DownloadStockCsvfile();
  break;
  case (isset($_GET['SaveCashiersPdf'])):
  echo $obj->downloadCashiers();
  break;
  case (isset($_GET['SaveCashiersCsvFile'])):
  echo $obj->DownloadCashiersCsvfile();
  break;
  case (isset($_GET['SaveSuppliersBtn'])):
  echo $obj->downloadSuppliers();
  break;
  case (isset($_GET['SaveSuppliersCSVfile'])):
  echo $obj->downloadSuppliersCSVfile();
  break;
  case (isset($_GET['SaveDamagesBtn'])):
  echo $obj->downloadDamages();
  break;
  case (isset($_GET['SaveDamagesCSVfile'])):
  echo $obj->downloadDamagesCSVfile();
  break;
  case (isset($_GET['SaveCustomersBtn'])):
  echo $obj->downloadCustomers();
  break;
  case (isset($_GET['SaveCustomersCSVfile'])):
  echo $obj->downloadCustomersCSVfile();
  break;
  case (isset($_GET['SaveCategorysBtn'])):
  echo $obj->downloadStockCategories();
  break;
  case (isset($_GET['SaveCategoriesCSVfile'])):
  echo $obj->downloadCategoriesCSVfile();
  break;
  case (isset($_GET['SaveExpenseBtn'])):
  echo $obj->downloadListOfExpenses();
  break;
  case (isset($_GET['SaveExpensesCsvFile'])):
  echo $obj->downloadExpensesCSVfile();
  break;
  case (isset($_POST['Download-Filtered-Sales'])):
  echo $obj->downloadSalesCSVfileFilteredByCashier();
  break;

} //end of switch

?>