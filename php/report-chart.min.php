<?php

require_once('dbController.inc.php');

class ReportMaster{

  private static $_instance;


  public static function getDbInstance(){
    if(!self::$_instance){
      self::$_instance = new Database();
    }
    return self::$_instance;
  }


  function monthlySales(){

   $title = "Sales made per month";
   $monthlysales = ReportMaster::getDbInstance()->getConnection()->query("SELECT * FROM monthlysales");
   
   if($monthlysales->rowCount() >0 ){
    echo "<div class='table-responsive'>";
    echo "<table class='table table-striped table-hover' id='sales'>";
    echo  "<thead><tr id='fontfam' class='warning'>";
    echo "<th>Year</th>";
    echo "<th>Month</th>";
    echo "<th>Sales</th>";
    echo "</tr></thead>";
    while($row = $monthlysales->fetch()){
     echo "<tr>";
     echo "<td>".$row["year"]."</td>";
     echo  "<td>".$row["month_name"]."</td>";
     echo "<td id='changecolor'>".number_format($row["sales_made"])."</td>";
     echo  "</tr>";
   }
   echo "</table></div>";
 }else{
  echo "No matching records";
}

} // end of method monthlysales()

function getInventory(){

  $products = ReportMaster::getDbInstance()->getConnection()->query("SELECT * FROM products");
  if($products->rowCount() > 0){
    echo "<div class='table-responsive'>";
    echo "<table class='table table-striped table-hover'>";
    echo "<thead><tr id='fontfam' class='warning'>";
    echo "<th>Product</th>";
    echo "<th>Category</th>";
    echo "<th>Qty</th>";
    echo "<th>Last Add</th>";
    echo "<th>C.price</th>";
    echo "<th>S.price</th>";
    echo "<th>Supplier</th>";
    echo "<th>Expiry Date</th>";
    echo "</tr></thead>";

    while ($row = $products->fetch()) {
      $expiry_date = date('d-m-Y', strtotime($row["ExpiryDate"]));
      echo "<tr>";
      echo "<td>".$row["ProductName"]. "</td>";
      echo "<td>".$row["Category"]."</td>";
      echo "<td>".$row["QuantityAvailable"]."</td>";
      echo "<td>".number_format($row["QuantityLastAdded"])."</td>";
      echo "<td>".number_format($row["BuyingPrice"])."</td>";
      echo "<td id='changecolor'>".number_format($row["SellingPrice"]). "</td>";
      echo "<td>". $row["Supplier"]. "</td>";
      echo "<td>".$expiry_date."</td>";
      echo "</tr>";
    }
    echo "</table></div>";
  }

} //end of method getInventory()
function getLowInventory(){

  $products = ReportMaster::getDbInstance()->getConnection()->query("SELECT * FROM products WHERE QuantityAvailable < 6");

  if($products->rowCount() > 0){
    echo "<div class='table-responsive'>";
    echo "<table class='table table-striped table-hover'>";
    echo "<thead><tr id='fontfam' class='warning'>";
    echo "<th>Product</th>";
    echo "<th>Qty</th>";
    echo "<th>O.Price</th>";
    echo "<th>S.Price</th>";
    echo "<th>Supplier</th>";
    echo "<th>ExpiryDate</th>";
    echo "</tr></thead>";

    while ($row = $products->fetch()) {
      $expiry_date = date('d-m-Y', strtotime($row["ExpiryDate"]));
      echo "<tr>";
      echo "<td>".$row["ProductName"]. "</td>";
      echo "<td id='changecolor'>".$row["QuantityAvailable"]."</td>";
      echo "<td>".number_format($row["BuyingPrice"])."</td>";
      echo "<td >".number_format($row["SellingPrice"]). "</td>";
      echo "<td>". $row["Supplier"]. "</td>";
      echo "<td>".$expiry_date."</td>";
      echo "</tr>";
    }
    echo "</table></div>";
  }

} //end of method getLowInventory()

function getBestCustomers(){

  $toptencustomers = ReportMaster::getDbInstance()->getConnection()->query("SELECT * FROM bestcustomers");
  $count = 1;

  if($toptencustomers->rowCount() > 0){
    echo "<div class='table-responsive'>";
    echo "<table class='table table-striped table-hover'>";
    echo "<thead><tr id='fontfam' class='warning'>";
    echo "<th>No</th>";
    echo "<th>Customer Name</th>";
    echo "<th>Worth</th>";
    echo "<th>% (of Total sales)</th>";
    echo "</tr>";

    while($row = $toptencustomers->fetch()){
     echo "<tr>";
     echo "<td>".$count++. "</td>";
     echo "<td>".$row["Customer"]."</td>";
     echo "<td>".number_format($row["VolumeofSales"])."</td>";
     echo "<td id='changecolor'>" . $row["percent"]."</td>";
     echo "</tr></thead>";
   }
   echo "</table></div>";
 }
}//end of method getBestCustomers()

function getBestSellingProducts(){

  $bestsellingproducts = ReportMaster::getDbInstance()->getConnection()->query("SELECT * FROM mostsellingproducts");
  $num = 1;

  $bestselling = ReportMaster::getDbInstance()->getConnection()->query("SELECT SUM(Cost) AS TotalSales FROM sales");
  $row = $bestselling->fetch();
  $volume_of_sales =  $row['TotalSales'];
  
  if($bestselling->rowCount() > 0){
    echo "<div class='table-responsive'>";
    echo"<table class='table table-striped table-hover'>";
    echo"<thead><tr id='fontfam' class='warning'>";
    echo"<th>No</th>";
    echo"<th>Product</th>";
    echo"<th>Qty</th>";
    echo"<th>Amount of Sales</th>";
    echo"<th>% (of Total sales)</th>";
    echo"</tr></thead>";

    while($row = $bestsellingproducts->fetch()) {
      $salesmade = $row["TotalSales"];
      $percent = ($salesmade/$volume_of_sales)*100;

      echo"<tr>";
      echo"<td>" .$num++. "</td>";
      echo"<td>" . $row["ProductName"]. "</td>";
      echo"<td>".$row['Qty']."</td>";
      echo"<td>".number_format($salesmade)."</td>";
      echo"<td id='changecolor'>".round($percent,2)."</td>";
      echo"</tr>";
    }
    echo "</table></div>";
  }
} //end of method bestSellingProducts()

function getSales(){

  $sales = ReportMaster::getDbInstance()->getConnection()->prepare("SELECT * FROM sales");
  $sales->execute();
  $title = "General Sales";

  if($sales->rowCount()>0){
   echo "<div class='table-responsive'>";
   echo" <table class='table table-striped table-hover'>";
   echo"<thead> <tr id='fontfam' class='warning'>";
   echo" <th>Bill no</th>";
   echo" <th>Product</th>";
   echo"<th>Qty</th>";
   echo" <th>Cost</th>";
   echo"<th>Discount</th>";
   echo" <th>Customer</th>";
   echo"<th>Date</th>";
   echo"<th>Cashier</th>";
   echo" </tr></thead>";

   while($row = $sales->fetch()) {
    $date = date('d-m-Y h:m', strtotime($row["Date"]));

    echo"<tr>";
    echo"<td>" . $row["billno"]. "</td>";
    echo"<td>".$row["ProductName"]."</td>";
    echo"<td>".$row["Quantity"]."</td>";
    echo"<td id='changecolor'>".number_format($row["Cost"])."</td>";
    echo"<td>" . $row["Discount"]. "</td>";
    echo"<td>".$row["Customer"]."</td>";
    echo"<td>".$date."</td>";
    echo"<td>".$row["CashierName"]."</td>";
    echo"</tr>";
  }
  echo "</table></div>";
}
} //end of method getSales();

function getSuppliers(){

  $title = "Registered suppliers";
  $suppliers = ReportMaster::getDbInstance()->getConnection()->query("SELECT * FROM suppliers");
  $num = 1;
  if($suppliers->rowCount()>0){
    echo "<div class='table-responsive'>";
    echo "<table class='table table-striped table-hover'>";
    echo " <thead> <tr id='fontfam' class='warning'>";
    echo "  <th>No</th>";
    echo "  <th>Supplier</th>";
    echo "  <th>Address</th>";
    echo "  <th>Contact</th>";
    echo " <th>Debt</th>";
    echo " <th>Credit</th>";
    echo " </tr>";

    while ($row = $suppliers->fetch()) {
      echo "<tr>";
      echo " <td>" .$num++. "</td>";
      echo " <td>" . $row["SupplierName"]. "</td>";
      echo " <td>".$row["Address"]."</td>";
      echo "  <td>".$row["Contact"]."</td>";
      echo " <td id='changecolor'>".number_format($row["DR"])."</td>";
      echo " <td id='stocklabel'>".number_format($row["CR"])."</td>";
      echo "</tr></thead>";
    }
    echo "</table></div>";
  }

} //end of getSuppliers()

function getCashiers(){

  $title ="Registered Company Cashiers";
  $cashiers = ReportMaster::getDbInstance()->getConnection()->query("SELECT * FROM cashiers");
  $num = 1;
  if($cashiers->rowCount() > 0){
    echo "<div class='table-responsive'>";
    echo "<table class='table table-striped table-hover'>";
    echo "<thead> <tr id='fontfam' class='warning'>";
    echo "   <th>No</th>";
    echo "  <th>Cashier Name</th>";
    echo "  <th>Contact</th>";
    echo "  <th>Address</th>";
    echo " <th>Email</th>";
    echo " </tr>";

    while ($row = $cashiers->fetch()) {
      echo "<tr>";
      echo " <td>" .$num++. "</td>";
      echo " <td>" . $row["CashierName"]. "</td>";
      echo "<td>".$row["MobileNo"]."</td>";
      echo "<td>".$row["Address"]."</td>";
      echo " <td>".$row["Email"]."</td>";
      echo " </tr></thead>";
    }
    echo "</table></div>";
  }
} // end of method getCashiers()

function getCashiersPerformance(){

  $title = "Cashiers' performance";
  $cashiers_review = ReportMaster::getDbInstance()->getConnection()->query("SELECT * FROM cashiersperformance");
  $num = 1;
  if($cashiers_review->rowCount()){
    echo "<div class='table-responsive'>";
    echo "<table class='table table-striped table-hover'>";
    echo " <thead><tr id='fontfam' class='warning'>";
    echo " <th>No</th>";
    echo " <th>Cashier Name</th>";
    echo " <th>Amount of conducted sales</th>";
    echo " <th>% (of total conducted sales)</th>";
    echo " </tr></thead>";
    
    while ($row =$cashiers_review->fetch()) {
      $volume = $row["VolumeofConductedSales"];
      $percentage = $row["percent"];
      echo"<tr>";
      echo "<td>" .$num++. "</td>";
      echo "<td>" . $row["Cashier"]. "</td>";
      echo "<td>".number_format($row["VolumeofConductedSales"])."</td>";
      echo "<td id='changecolor'>".$percentage."</td>";
      echo "</tr></thead>";
    }
    echo "</table></div>";
  }
} //end of method getCashiersPerformance()

function Sales_in_7_days(){

  $day = date('Y-m-d');
  $title = "Sales made in the last 7 days";

  $last7daysales_query = "SELECT *, (DATE(NOW()) - INTERVAL 7 DAY) AS diff FROM sales
  WHERE Date >= (DATE(NOW()) - INTERVAL 7 DAY) ORDER BY Date DESC";

  $last7daysales = ReportMaster::getDbInstance()->getConnection()->query($last7daysales_query);
  if($last7daysales->rowCount()>0){
    echo "<div class='table-responsive'>";
    echo " <table class='table table-striped table-hover'>";
    echo  " <thead><tr id='fontfam' class='warning'>";
    echo "  <th>Bill no</th>";
    echo " <th>Product</th>";
    echo " <th>Quantity sold</th>";
    echo " <th>Cost</th>";
    echo " <th>Discount</th>";
    echo "<th>Customer</th>";
    echo " <th>Date of Sale</th>";
    echo " <th>Cashier</th></thead>";

    while ($row = $last7daysales->fetch()) {
      $date = date('d-m-Y h:m', strtotime($row["Date"]));
      echo "<tr>";
      echo "<td>" . $row["billno"]. "</td>";
      echo "<td>".$row["ProductName"]."</td>";
      echo "<td>".$row["Quantity"]."</td>";
      echo "<td id='changecolor'>".number_format($row["Cost"])."</td>";
      echo "<td>" . $row["Discount"]. "</td>";
      echo "<td>".$row["Customer"]."</td>";
      echo "<td>".$date."</td>";
      echo "<td>".$row["CashierName"]."</td>";
      echo "</tr>";

    }
    echo "</table></div>";
  }
  else{
    echo "<h5 style='color:red'>No sales conducted in last 7 days</h5>";
  }
} //end of method Sales_in_7_days()

function Sales_in_30_days(){

  $day = date('Y-m-d');
  $title = "Sales made in the last 30 days";

  $last30daysales_query = "SELECT *,  (DATEDIFF(NOW(), DATE)) AS diff FROM sales
  WHERE DATEDIFF(NOW(), DATE) <= 30 ORDER BY Date DESC";

  $last30daysales = ReportMaster::getDbInstance()->getConnection()->query($last30daysales_query);
  if($last30daysales->rowCount()>0){
    echo "<div class='table-responsive'>";
    echo " <table class='table table-striped table-hover'>";
    echo  "<thead> <tr id='fontfam' class='warning'>";
    echo "  <th>Bill no</th>";
    echo " <th>Product</th>";
    echo " <th>Quantity sold</th>";
    echo " <th>Cost</th>";
    echo " <th>Discount</th>";
    echo "<th>Customer</th>";
    echo " <th>Date of Sale</th>";
    echo " <th>Cashier</th>";
    echo "</tr></thead>";

    while ($row = $last30daysales->fetch()) {
      $date = date('d-m-Y h:m', strtotime($row["Date"]));
      echo "<tr>";
      echo "<td>" . $row["billno"]. "</td>";
      echo "<td>".$row["ProductName"]."</td>";
      echo "<td>".$row["Quantity"]."</td>";
      echo "<td id='changecolor'>".number_format($row["Cost"])."</td>";
      echo "<td>" . $row["Discount"]. "</td>";
      echo "<td>".$row["Customer"]."</td>";
      echo "<td>".$date."</td>";
      echo "<td>".$row["CashierName"]."</td>";
      echo "</tr>";

    }
    echo "</table></div>";
  }
  else{
    echo "<h5 style='color:red'>No sales conducted in last 30 days</h5>";
  }
} //end of method Sales_in_30_days()

function sales_for_current_month(){

  $currentmonthsales_query = "SELECT * FROM sales
  WHERE MONTH(Date) = MONTH(CURRENT_DATE()) AND
  YEAR(Date) = YEAR(CURRENT_DATE())  ORDER BY Date DESC";
  $currentmonthsales = ReportMaster::getDbInstance()->getConnection()->query($currentmonthsales_query);
  $title = "Sales made this month:".date('M')."";
  
  if($currentmonthsales->rowCount() > 0){
    echo "<div class='table-responsive'>";
    echo "<table class='table table-striped table-hover'>";
    echo "<thead><tr id='fontfam' class='warning'>";
    echo "<th>Bill no</th>";
    echo "<th>Product</th>";
    echo "<th>Quantity sold</th>";
    echo "<th>Cost</th>";
    echo "<th>Discount</th>";
    echo "<th>Customer</th>";
    echo "<th>Date of Sale</th>";
    echo "<th>Cashier</th>";
    echo "</tr></thead>";
    while ($row = $currentmonthsales->fetch()) {
    // $total_in_last_30days= $row['Cost'];
     $date = date('d-m-y h:m', strtotime($row["Date"]));

     echo "<tr>";
     echo "<td>" . $row["billno"]. "</td>";
     echo "<td>".$row["ProductName"]."</td>";
     echo "<td>".$row["Quantity"]."</td>";
     echo "<td id='changecolor'>".number_format($row["Cost"])."</td>";
     echo "<td>" . $row["Discount"]. "</td>";
     echo "<td>".$row["Customer"]."</td>";
     echo "<td>".$date."</td>";
     echo "<td id='stocklabel'>".$row["CashierName"]."</td>";
     echo "</tr>";
   }
   echo "</table></div>";

 } else{
  echo "<h5 style='color:red'>No sales for current month Available</h5>";
}
       } //end of method sales_for_current_month()

       function sales_for_last_month(){

        $lastmonthsales_query = "SELECT * FROM sales
        WHERE MONTH(Date) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH) AND
        YEAR(Date) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)  ORDER BY Date DESC";
        $lastmonthsales = ReportMaster::getDbInstance()->getConnection()->query($lastmonthsales_query);

        if($lastmonthsales->rowCount() > 0){
          echo "<div class='table-responsive'>";
          echo "<table class='table table-striped table-hover'>";
          echo "<thead><tr id='fontfam' class='warning'>";
          echo "<th>Bill no</th>";
          echo "<th>Product</th>";
          echo "<th>Quantity sold</th>";
          echo "<th>Cost</th>";
          echo "<th>Discount</th>";
          echo "<th>Customer</th>";
          echo "<th>Date of Sale</th>";
          echo "<th>Cashier</th>";
          echo "</tr></thead>";
          while ($row = $lastmonthsales->fetch()) {

           $date = date('d-m-y h:m', strtotime($row["Date"]));

           echo "<tr>";
           echo "<td>" . $row["billno"]. "</td>";
           echo "<td>".$row["ProductName"]."</td>";
           echo "<td>".$row["Quantity"]."</td>";
           echo "<td id='changecolor'>".number_format($row["Cost"])."</td>";
           echo "<td>" . $row["Discount"]. "</td>";
           echo "<td>".$row["Customer"]."</td>";
           echo "<td>".$date."</td>";
           echo "<td>".$row["CashierName"]."</td>";
           echo "</tr>";
         }
         echo "</table></div>";

       } else {
        echo "<h5 style='color:red'>No sales for last month Available</h5>";
      }
       } //end of method sales_for_last_month()

       function get_sales_for_current_week(){

         $title = "Sales made this week so far";
         $currentweeksales_query = "SELECT * FROM  sales WHERE 
         YEARWEEK(Date, 1) = YEARWEEK(CURDATE(), 1)  order by DATE DESC";
         $currentweeksales = ReportMaster::getDbInstance()->getConnection()->query($currentweeksales_query);
        // and Date <= curdate()
         if($currentweeksales->rowCount() > 0){
          echo "<div class='table-responsive'>";
          echo "<table class='table table-striped table-hover'>";
          echo "<thead><tr id='fontfam' class='warning'>";
          echo "<th>Bill no</th>";
          echo "<th>Product</th>";
          echo "<th>Quantity sold</th>";
          echo "<th>Cost</th>";
          echo "<th>Discount</th>";
          echo "<th>Customer</th>";
          echo " <th>Date of Sale</th>";
          echo "<th>Cashier</th>";
          echo "</tr></thead>";

          while ($row = $currentweeksales->fetch()) {
            $date = date('d-m-y h:m', strtotime($row["Date"]));

            echo " <tr>";
            echo " <td>" .$row["billno"]. "</td>";
            echo " <td>".$row["ProductName"]."</td>";
            echo "<td>".$row["Quantity"]."</td>";
            echo "<td id='changecolor'>".number_format($row["Cost"])."</td>";
            echo "<td>". $row["Discount"]. "</td>";
            echo "<td>".$row["Customer"]."</td>";
            echo "<td>".$date."</td>";
            echo " <td>".$row["CashierName"]."</td>";
            echo "</tr>";   
          }
          echo "</table></div>";
        }
        else if ($currentweeksales->rowCount() == 0){
          echo "<h5 style='color:red'>No sales for current week Available</h5>";
        }
    } //end of  get_sales_for_current_week()

    function get_sales_for_last_week(){
      
     $title = "Sales made this week so far";
     $lastweeksales_query = "SELECT * FROM  sales
     WHERE YEARWEEK(Date)=YEARWEEK(CURDATE()-INTERVAL 1 WEEK) ORDER BY DATE DESC";
     $lastweeksales = ReportMaster::getDbInstance()->getConnection()->query($lastweeksales_query);
     if($lastweeksales->rowCount() > 0){
       echo "<div class='table-responsive'>";
       echo "<table class='table table-striped table-hover'>";
       echo "<thead><tr id='fontfam' class='warning'>";
       echo "<th>Bill no</th>";
       echo "<th>Product</th>";
       echo "<th>Quantity sold</th>";
       echo "<th>Cost</th>";
       echo "<th>Discount</th>";
       echo "<th>Customer</th>";
       echo " <th>Date of Sale</th>";
       echo "<th>Cashier</th>";
       echo "</tr></thead>";

       while ($row = $lastweeksales->fetch()) {
        $date = date('d-m-y h:m', strtotime($row["Date"]));
        echo " <tr>";
        echo " <td>" . $row["billno"]. "</td>";
        echo " <td>".$row["ProductName"]."</td>";
        echo "<td>".$row["Quantity"]."</td>";
        echo "<td id='changecolor'>".number_format($row["Cost"])."</td>";
        echo "<td>" . $row["Discount"]. "</td>";
        echo "<td>".$row["Customer"]."</td>";
        echo "<td>".$date."</td>";
        echo " <td>".$row["CashierName"]."</td>";
        echo "</tr>";   
      }
      echo "</table></div>";
    }
    else{
      echo "<h5 style='color:red'>No sales for last week Available</h5>";
    }
    } //end of  get_sales_for_last_week()
    

  } // end of class ReportMaster()

  $obj = new ReportMaster();

  switch (true) {
    case (isset($_GET['monthlysales'])):
    echo $obj->monthlySales();
    break;
    case (isset($_GET['inventory'])):
    echo $obj->getInventory();
    break;
    case (isset($_GET['lowrunningstock'])):
    echo $obj->getLowInventory();
    break;
    case (isset($_GET['toptencustomers'])):
    echo $obj->getBestCustomers();
    break;
    case (isset($_GET['bestselling'])):
    echo $obj->getBestSellingProducts();
    break;
    case (isset($_GET['suppliers'])):
    echo $obj->getSuppliers();
    break;
    case (isset($_GET['companycashiers'])):
    echo $obj->getCashiers();
    break;
    case (isset($_GET['cashiersperformance'])):
    echo $obj->getCashiersPerformance();
    break;
    case (isset($_GET['last7days'])):
    echo $obj->Sales_in_7_days();
    break;
    case (isset($_GET['last30days'])):
    echo $obj->Sales_in_30_days();
    break;
    case (isset($_GET['currentmonth'])):
    echo $obj->sales_for_current_month();
    break;
    case (isset($_GET['lastmonth'])):
    echo $obj->sales_for_last_month();
    break;
    case (isset($_GET['currentweek'])):
    echo $obj->get_sales_for_current_week();
    break;
    case (isset($_GET['lastweek'])):
    echo $obj->get_sales_for_last_week();
    break;
    default:
    echo $obj->getSales();
    break;


  }




  ?>

















