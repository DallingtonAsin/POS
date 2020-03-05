<?php

require_once('dbController.inc.php');

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
require_once ('Spout/Autoloader/autoload.php');

$ImportmessageErr = $ImportmessageSuccess = "";

class RetrievalDbModule{
	public $company ="Savers Hardware";
	private static $_instance;


	public static function getDbInstance(){
		if(!self::$_instance){
			self::$_instance = new Database();
		}
		return self::$_instance;
	}

//method that sets company name
	function getCompanyName(){
		return $this->company;
	}

//method getStock() to fetch the available products from stock
	function getStock(){
		$obj = new RetrievalDbModule();
		$products =  RetrievalDbModule::getDbInstance()->getConnection()->prepare("SELECT *,DATE_FORMAT(DateofEntry, '%d/%m/%Y') AS Date_of_Entry,DATE_FORMAT(ExpiryDate, '%d/%m/%Y') AS Date_of_Expiry
			FROM products");
		$products->execute();
		if($obj->getStockValue() > 0){
			$v = $obj->getStockValue();
		}else{
			$v = 0;
		}
		return array("products" => $products->fetchAll(),"StockValue" => $v);
		
} //end of method getStock()

//method getExpenses() to fetch the expenses
function getExpenses(){
	$obj = new RetrievalDbModule();
	$sql = "SELECT *,DATE_FORMAT(DateOfExpense, '%d/%m/%Y') AS DateofExpense
	FROM expenses";
	$expenses =  RetrievalDbModule::getDbInstance()->getConnection()->prepare($sql
	);
	$expenses->execute();
	if($obj->getValueOfExpenses() > 0){
		$sum_of_expenses = $obj->getValueOfExpenses();
	}else{
		$sum_of_expenses = 0;
	} 

	return array('expenses' => $expenses->fetchAll(), 'TotalExpenses' =>$sum_of_expenses);

} //end of method getExpenses()


//method CountExpenses() to count the expenses
function CountExpenses(){
	$sql = "SELECT COUNT(id) AS result FROM expenses ";
	$expenses =  RetrievalDbModule::getDbInstance()->getConnection()->prepare($sql);
	$expenses->execute();
	$row = $expenses->fetch();
	$value = $row['result'];
	return $value;		
} //end of method CountExpenses()



function getCashiers(){
	$cashiers = RetrievalDbModule::getDbInstance()->getConnection()->prepare("SELECT id,CashierName, MobileNo,Address,Email
		FROM cashiers");
	$cashiers->execute();
	return $cashiers->fetchAll();
}


function getSuppliers(){
	$debts = $credits = null;
	$obj = new RetrievalDbModule();
	
	$suppliers = RetrievalDbModule::getDbInstance()->getConnection()->prepare("SELECT * FROM suppliers");
	$suppliers->execute();
	$v = 'Suppliers';

	if($obj->getTotalDebt($v) > 0){
		$debts = $obj->getTotalDebt($v);
	}else{
		$debts = 0;
	}

	if($obj->getTotalCredit($v) > 0){
		$credits = $obj->getTotalCredit($v);
	}else{
		$credits = 0;
	}
	return array("suppliers" => $suppliers->fetchAll(),"debts" =>$debts,
		"credits" => $credits);


}



function getCustomers(){
	$obj = new RetrievalDbModule();
	$customers =  RetrievalDbModule::getDbInstance()->getConnection()->prepare("SELECT * FROM customers");
	$customers->execute();
	$val = 'Customers';

	if($obj->getTotalDebt($val) > 0){
		$debts = $obj->getTotalDebt($val);
	}else{
		$debts = 0;
	}

	if($obj->getTotalCredit($val) > 0){
		$credits = $obj->getTotalCredit($val);
	}else{
		$credits = 0;
	}
	return array("customers" => $customers->fetchAll(),"debts" =>$debts,
		"credits" => $credits);

}

function getFilteredCredit($who,$label){

	switch(true){
		case (strtolower($who)==strtolower('suppliers')):
		try{
			$sql = RetrievalDbModule::getDbInstance()->getConnection()->prepare("SELECT *,SUM(CR) as Scredits  From suppliers WHERE (SupplierName LIKE '".$label."%') OR (SupplierName LIKE '%".$label."%') OR (SupplierName LIKE '%".$label."')");
			$sql->execute();
			$rows = $sql->fetch(PDO::FETCH_ASSOC);
			$debtValue = $rows['Scredits'];
			return $debtValue;
		}catch(PDOException $e){
			echo $e->getMessage();
		}
		break;
		case (strtolower($who)==strtolower('customers')):
		try{
			$sql = RetrievalDbModule::getDbInstance()->getConnection()->prepare("SELECT *,SUM(CR) AS Ccredits  From customers WHERE (CustomerName LIKE '".$label."%') OR (CustomerName LIKE '%".$label."%') OR (CustomerName LIKE '%".$label."')");
			$sql->execute();
			$row = $sql->fetch(PDO::FETCH_ASSOC);
			$debtValue = $row['Ccredits'];
			return $debtValue;
		}catch(PDOException $e){
			echo $e->getMessage();
		}
		break;
	}
}


function getFilteredDebt($who,$label){

	switch(true){
		case (strtolower($who)==strtolower('suppliers')):
		try{
			$sql = RetrievalDbModule::getDbInstance()->getConnection()->prepare("SELECT *,SUM(DR) as Debts  From suppliers WHERE (SupplierName LIKE '".$label."%') OR (SupplierName LIKE '%".$label."%') OR (SupplierName LIKE '%".$label."')");
			$sql->execute();
			$row = $sql->fetch();
			$debtValue = $row['Debts'];
			return $debtValue;
		}catch(PDOException $e){
			echo $e->getMessage();
		}
		break;
		case (strtolower($who)==strtolower('customers')):
		try{
			$sql = RetrievalDbModule::getDbInstance()->getConnection()->prepare("SELECT *,SUM(DR) as Cdebts  From customers WHERE (CustomerName LIKE '".$label."%') OR (CustomerName LIKE '%".$label."%') OR (CustomerName LIKE '%".$label."')");
			$sql->execute();
			$rows = $sql->fetch();
			$debtValue = $rows['Cdebts'];
			return $debtValue;
		}catch(PDOException $e){
			echo $e->getMessage();
		}
		break;
	}
}

function filterCustomers(){
	$val = 'customers';
	$errors = array();
	$obj = new RetrievalDbModule();
	$customerlabel = $_POST['customerlabel'];
	$customers = RetrievalDbModule::getDbInstance()->getConnection()->prepare("SELECT * FROM customers WHERE (CustomerName LIKE '".$customerlabel."%') OR (CustomerName LIKE '%".$customerlabel."%') OR (CustomerName LIKE '%".$customerlabel."')
		");

	$customers->execute();
	
	if($obj->getFilteredDebt($val,$customerlabel) > 0){
		$debtValue = $obj->getFilteredDebt($val,$customerlabel);
	}else{
		$debtValue = 0;
	}

	if($obj->getFilteredCredit($val,$customerlabel) > 0){
		$creditValue = $obj->getFilteredCredit($val,$customerlabel);
	}else{
		$creditValue = 0;
	}
	return array("customers" => $customers->fetchAll(),"debts" => $debtValue,
		"credits" => $creditValue);
	
}


function getDamages(){
	$obj = new RetrievalDbModule();
	$sql = "SELECT * FROM damages";
	$damages = RetrievalDbModule::getDbInstance()->getConnection()->prepare($sql);
	$damages->execute();
	if($obj->getCostOfDamages() > 0){
		$costs = $obj->getCostOfDamages();
	}else{
		$costs = 0;
	}
	return array("damages" => $damages->fetchAll(),"costs-of-damages" => $costs);

}

function filterDamages(){
	$errors = array();
	if(isset($_POST['damagelabel'])){
		$damage_label = $_POST['damagelabel'];
		$sql = "SELECT * FROM damages WHERE
		(ProductName LIKE '".$damage_label."%') OR  (ProductName LIKE '%".$damage_label."')
		OR  (ProductName LIKE '%".$damage_label."%') ";
		$damages = RetrievalDbModule::getDbInstance()->getConnection()->prepare($sql);
		$exe = $damages->execute();
		$damagesList = $damages->fetchAll();
		$cost = 0;
		if($exe){
			foreach ($damagesList as $key => $rows) {

				$query = "SELECT BuyingPrice,ProductName FROM products WHERE
				(ProductName LIKE '".$damage_label."%') OR  (ProductName LIKE '%".$damage_label."') OR  (ProductName LIKE '%".$damage_label."%') ";
				$dam = RetrievalDbModule::getDbInstance()->getConnection()->prepare($query);
				$dam_exe = $dam->execute();
				$row = $dam->fetch();
				$price =$row['BuyingPrice'];
				$qty = $rows['Quantity'];

				$cost += ($price * $qty);

			}
		} 

		$sql_q = "SELECT *, SUM(id) as No FROM damages WHERE
		(ProductName LIKE '".$damage_label."%') OR  (ProductName LIKE '%".$damage_label."')
		OR  (ProductName LIKE '%".$damage_label."%') ";
		$d = RetrievalDbModule::getDbInstance()->getConnection()->prepare($sql_q);
		$d->execute();
		$row = $d->fetch();


		return array("damages" => $damagesList ,"costs-of-damages" => $cost);

	}else{
		array_push($errors, "enter damage label in search bar");
	}	
}

function getVolumeOfSales(){
	$query= "SELECT SUM(Cost) as amount FROM sales";
	$sql = RetrievalDbModule::getDbInstance()->getConnection()->prepare($query);
	$sql->execute();
	$row = $sql->fetch();
	$sales_made = $row['amount'];
	return $sales_made;
}
function getInitialValueofSoldPdts(){
	$query= "SELECT SUM(Quantity*OriginalPrice) as initialValue FROM sales";
	$sql = RetrievalDbModule::getDbInstance()->getConnection()->prepare($query);
	$sql->execute();
	$row = $sql->fetch();
	$t = $row['initialValue'];
	return $t;
}
function computeNetworth(){
	$obj = new RetrievalDbModule();
	$array1 = $obj->getDamages();
	$array2 = $obj->getExpenses();

	$cost_of_damages = $array1['costs-of-damages'];
	$totalExpenses = $array2['TotalExpenses'];
	$net_worth = ($obj->getVolumeOfSales())-($obj->getInitialValueofSoldPdts())-($cost_of_damages)-($totalExpenses); 
	return $net_worth;
}



function getPdtCategories(){
	$sql = "SELECT * FROM category ORDER BY id";
	$product_categories = RetrievalDbModule::getDbInstance()->getConnection()->prepare($sql);
	$product_categories->execute();
	return $product_categories->fetchAll();
}



function getConductedSales(){
	$class_obj = new RetrievalDbModule();
	$sales = RetrievalDbModule::getDbInstance()->getConnection()->prepare("SELECT *,DATE_FORMAT(Date, '%Y/%m/%d') AS
		Date FROM sales");
	$sales->execute();
	return array("all-sales" => $sales->fetchAll(),
		"sales-volume" =>$class_obj->getVolumeOfSales());
}


function filterConductedSales($date1,$date2){

	$datex1 = date('Y-m-d', strtotime($date1));
	$datex2 = date('Y-m-d', strtotime($date2));
	$sales = RetrievalDbModule::getDbInstance()->getConnection()->prepare("SELECT *,DATE_FORMAT(Date, '%d/%m/%Y') AS Date FROM sales WHERE (Date BETWEEN '".$datex1."' AND '".$datex2."') ");
	$sales->execute();

	$sql = RetrievalDbModule::getDbInstance()->getConnection()->prepare("SELECT SUM(Cost) as SalesValue FROM sales WHERE (Date BETWEEN '".$datex1."' AND '".$datex2."') ");
	$sql->execute();
	$row = $sql->fetch();
	$result = $row['SalesValue'];
	
	return array('sales' => $sales->fetchAll(PDO::FETCH_ASSOC),'valueofsales' => $result);

}




function fetchTodaysSales(){
	$todayzsales = RetrievalDbModule::getDbInstance()->getConnection()->prepare("SELECT *,DATE_FORMAT(Date, 
		'%Y-%m-%d') FROM sales WHERE DATE(Date) = CURDATE()");
	$todayzsales->execute();

	$sql = "SELECT SUM(Cost) as TodaySales FROM sales WHERE DATE(Date) = CURDATE()";
	$today = RetrievalDbModule::getDbInstance()->getConnection()->prepare($sql);
	$today->execute();
	$row = $today->fetch();
	$sales_of_today = $row['TodaySales'];


	return array("SalesToday" => $todayzsales->fetchAll(),
		         "amount-of-sales" => $sales_of_today,
		         "title" => "Today's sales (in total)"

		     );
}

			//method importStock() to get stock data from file to database

function importStock(){
	$errors = array();
	$stock = array();
	$class_object = new RetrievalDbModule();
	$h = $class_object->getStock();
	$k = $h['products'];
	foreach($k as $item){
		array_push($stock, $item['ProductName']);
	}
	//print_r($stock);
	if(!empty($_FILES['excelfile']['name'])){
    // Get File extension eg. 'xlsx' to check file is excel sheet
		$pathinfo = pathinfo($_FILES['excelfile']['name']);

    // check file has extension xlsx, xls and also check
    // file is not empty
		if (($pathinfo['extension'] == 'xlsx' || $pathinfo['extension'] == 'xls')
			&& $_FILES['excelfile']['size'] > 0 ){
			$file = $_FILES['excelfile']['tmp_name'];

        // Read excel file by using ReadFactory object.
		$reader = ReaderFactory::create(Type::XLSX);

        // Open file
		$reader->open($file);
		$count = 0;
		$errors = array();

        // Number of sheet in excel file
		foreach ($reader->getSheetIterator() as $sheet){

            // Number of Rows in Excel sheet
			foreach ($sheet->getRowIterator() as $row){
                // It reads data after header. In the my excel sheet,
                // header is in the first row.
				if ($count > 0) {
                    // Data of excel sheet
/*
User End::: Row 1 (A is No), Row 2(B is Item Name), Row 3(C is CostPrice)
Row 4 ( D is SellingPrice), Row 5(E is qty), Row 6(F is supplier)

Prograaming:::: pdt:row[1] bprice:row[2] sprice:row[3]
                qty:row[4] and supplier:row[5]

*/

                if(isset($row[1])){
                	$pdt = str_replace(array('\'', '"'), '', $row[1]); 
                }
                if(isset($row[1]) && is_numeric($row[1])){
                	array_push($errors, "Product can be a value,check your columns");
                }
                if(empty($row[1])){
                	continue;
                }
               // echo $pdt;
                
                if(isset($row[2])){
                	$costprice = floatval(preg_replace('/[^\d.]/','',$row[2]));
                }
                if(empty($row[2])){
                	$costprice = 0;
                }

                if(isset($row[3])){
                	$sellingprice = floatval(preg_replace('/[^\d.]/','',$row[3]));
                }
                if(empty($row[3])){
                	$sellingprice = 0;
                }
               
                if(isset($row[4])){
                	$qty = $row[4];
                }
                if(empty($row[4])){
                   $quantity = 0;
                }
                
                if(isset($row[5])){
                	$supplier = $row[5];
                }
                if(empty($row[5]) || is_null($row[5])){
                	$supplier = "";
                }



                if ( filter_var($qty, FILTER_VALIDATE_INT) === false ) {
                	$qty = 0;
                }
                if(is_null($qty) || $qty == ""){
                	$qty = 0;
                }


                if(count($errors) == 0){
                	if(in_array($pdt, $stock)){
                      $newQty = $qty + $class_object->getQuantityAvailable4Pdt($pdt);
								$qry = "UPDATE products SET QuantityAvailable= ?
								WHERE ProductName = ? ";
								$result = RetrievalDbModule::getDbInstance()->getConnection()->prepare($qry);
								$res_exe = $result->execute(array($newQty, $pdt));
								if($res_exe){
									$ImportmessageErr = 1;
								}
								else{
									$ImportmessageErr = "Stock Update Failed";
								}
                	}else{
                		$qry = "INSERT INTO products(ProductName,QuantityAvailable,BuyingPrice,SellingPrice,Supplier)
                		VALUES(:r1,:r2,:r3,:r4,:r5)";
                		$result = RetrievalDbModule::getDbInstance()->getConnection()->prepare($qry);
                		$res_exe = $result->execute(
                			array("r1" => $pdt, "r2" => $qty, "r3" => $costprice,
                				"r4" => $sellingprice, "r5" => $supplier)
                		);
                		if($res_exe){
                			$ImportmessageErr = 1;	
                		}
                		else{
                			$ImportmessageErr = "Stock Upload Failed";
                		}
                	}
                	
                }
                else{
                	$ImportmessageErr = "Product field cannot be numeric<br>check your arrangement of columns in excel file";
                	require 'errors.php';
                }


            }
            $count++;
        }
    }

        // Close excel file
    $reader->close();
}
else{
	$ImportmessageErr = "Please choose only excel file(.xls/.xlsx)";
}
}
else{
	$ImportmessageErr = "Please choose an excel file to upload";
	array_push($errors, $ImportmessageErr);
}

return $ImportmessageErr;

		} // end of importStock()



	/*	function importAndUpdateStock(){
			$class_object = new RetrievalDbModule();
			if(!empty($_FILES['excelfile']['name'])){
    // Get File extension eg. 'xlsx' to check file is excel sheet
				$pathinfo = pathinfo($_FILES['excelfile']['name']);

    // check file has extension xlsx, xls and also check
    // file is not empty
				if (($pathinfo['extension'] == 'xlsx' || $pathinfo['extension'] == 'xls')
					&& $_FILES['excelfile']['size'] > 0 ){
					$file = $_FILES['excelfile']['tmp_name'];

        // Read excel file by using ReadFactory object.
				$reader = ReaderFactory::create(Type::XLSX);

        // Open file
				$reader->open($file);
				$count = 0;
				$errors = array();

        // Number of sheet in excel file
				foreach ($reader->getSheetIterator() as $sheet){

            // Number of Rows in Excel sheet
					foreach ($sheet->getRowIterator() as $row){
                // It reads data after header. In the my excel sheet,
                // header is in the first row.
						if ($count > 0) {
                    // Data of excel sheet


							if(isset($row[1])){
								$product = str_replace(array('\'', '"'), '', $row[1]); 
							}
							if(isset($row[1]) && is_numeric($row[1])){
								array($errors,"product column contains numeric values");
							}
							if(isset($row[4])){
								$qty = intval(preg_replace('/[^\d.]/','',$row[4]));
							}
							if(empty($row[4])){
								$qty = 0;
							}
							if(isset($row[4]) && !(is_numeric($row[4]))){
								array_push($errors, "Quantity column must have numeric values");
							}

							if(count($errors) == 0){
								$newQty = $qty + $class_object->getQuantityAvailable4Pdt($product);
								$qry = "UPDATE products SET QuantityAvailable= ?
								WHERE ProductName = ? ";
								$result = RetrievalDbModule::getDbInstance()->getConnection()->prepare($qry);
								$res_exe = $result->execute(array($newQty, $product));
								if($res_exe){
									$ImportmessageErr = 1;
								}
								else{
									$ImportmessageErr = "Stock Update Failed";
								}	
							}else{
								$ImportmessageErr = "Either product column or Quantity column
								contains incorrect data,check your column arrangement in excel file";
							}
							


						}
						$count++;
					}
				}
				

				
        // Close excel file
				$reader->close();
			}
			else{
				$ImportmessageErr = "Please choose only excel file(.xls/.xlsx)";
			}
		}
		else{
			$ImportmessageErr = "Please choose an excel file to upload";
		}

		return $ImportmessageErr;

		} // end of importAndUpdateStock()*/


		function getQuantityAvailable4Pdt($item){
			$qry = "SELECT QuantityAvailable, ProductName FROM products
			WHERE ProductName = ? ";
			$result = RetrievalDbModule::getDbInstance()->getConnection()->prepare($qry);
			$result->bindValue(1, $item, PDO::PARAM_STR);
			$res = $result->execute();
			if($res){
				$row = $result->fetch(PDO::FETCH_ASSOC);
				$quantity = $row['QuantityAvailable'];
				return $quantity;
			}
			
		}





			//method importExpenses() to get stock data from file to database
		function importExpenses(){
			$class_object = new RetrievalDbModule();
			$data = $class_object->getExpenses();
			$errors = array();
			$expenses_data = array();
			$i = $data['expenses'];
			foreach($i as $row){
				array_push($expenses_data, $row[1]);
			}
			//print_r($expenses_data);
			if(!empty($_FILES['Expense-ExcelFile']['name'])){
    // Get File extension eg. 'xlsx' to check file is excel sheet
				$pathinfo = pathinfo($_FILES['Expense-ExcelFile']['name']);

    // check file has extension xlsx, xls and also check
    // file is not empty
				if (($pathinfo['extension'] == 'xlsx' || $pathinfo['extension'] == 'xls')
					&& $_FILES['Expense-ExcelFile']['size'] > 0 ){
					$file = $_FILES['Expense-ExcelFile']['tmp_name'];

        // Read excel file by using ReadFactory object.
				$reader = ReaderFactory::create(Type::XLSX);

        // Open file
				$reader->open($file);
				$count = 0;

        // Number of sheet in excel file
				foreach ($reader->getSheetIterator() as $sheet){

            // Number of Rows in Excel sheet
					foreach ($sheet->getRowIterator() as $row){
                // It reads data after header. In the my excel sheet,
                // header is in the first row.
						if ($count > 0) {
                    // Data of excel sheet
/*
User End:::: Row 1 (A is No), Row 2(B is ExpenseType) and Row 3(C is Amount)
Programming $expenseType: $row[1] and $amount: $row[2]

*/

if(isset($row[1])){
	$expense_type = $row[1];
}
if(isset($row[1]) && is_numeric($row[1])){
	array_push($errors,"Expense Type must not be a number");
}
if(empty($row[1])) {
	$expense_type = "";
}
if(isset($row[2])){
	$amount = floatval(preg_replace('/[^\d.]/','',$row[2]));
}
if(isset($row[2]) && !(is_numeric($row[2]))){
	array_push($errors,"Amount on expense must be a number");
}
if(empty($row[2])){
	$amount = 0;
}
if(count($errors)==0){
	$newAmount = floatval($amount) + $class_object->getAmount4ExpenseType($expense_type);
	if(in_array($expense_type, $expenses_data)){
		$qry = "UPDATE expenses SET Amount= ?
		WHERE ExpenseType = ? ";
		$result = RetrievalDbModule::getDbInstance()->getConnection()->prepare($qry);
		$res_exe = $result->execute(array($newAmount, $expense_type));
		if($res_exe){
			$feedback = 1;
		}
		else{
			$feedback = "Expenses Update Failed";
		}
	}
	else{
		$qry = "INSERT INTO expenses(ExpenseType,Amount)
		VALUES ('$expense_type','$amount')";
		$result = RetrievalDbModule::getDbInstance()->getConnection()->prepare($qry);
		$res_exe = $result->execute();	
		if($res_exe){
			$feedback = 1;	
		}
		else{
			$feedback = "Upload of Expenses Failed";
		}
	}

}
else{
	$feedback = "Check your column arrangement in excel file must be up to defined 
	standard";
}
}
$count++;
}
}


        // Close excel file
$reader->close();
}
else{
	$feedback = "Please choose only excel file(.xls/.xlsx)";
}
}
else{
	$feedback = "Please choose an excel file to upload";

}

return $feedback;

		} // end of importExpenses()


		/*function importAndUpdateExpenses(){
			$class_object = new RetrievalDbModule();
			if(!empty($_FILES['Expense-ExcelFile']['name'])){
				$pathinfo = pathinfo($_FILES['Expense-ExcelFile']['name']);
				if (($pathinfo['extension'] == 'xlsx' || $pathinfo['extension'] == 'xls')
					&& $_FILES['Expense-ExcelFile']['size'] > 0 ){
					$file = $_FILES['Expense-ExcelFile']['tmp_name'];
				$reader = ReaderFactory::create(Type::XLSX);
				$reader->open($file);
				$count = 0;
				foreach ($reader->getSheetIterator() as $sheet){
					foreach ($sheet->getRowIterator() as $row){
						if ($count > 0) {
							if(isset($row[1])){
								$expense_type = $row[1];
							}
							if(empty($row[1])) {
								$expense_type = "";
							}
							if(isset($row[2])){
								$amount = floatval(preg_replace('/[^\d.]/','',$row[2]));
							}
							if(empty($row[2])){
								$amount = 0;
							}

							$newAmount = floatval($amount) + $class_object->getAmount4ExpenseType($expense_type);
							
							$qry = "UPDATE expenses SET Amount= ?
							WHERE ExpenseType = ? ";
							$result = RetrievalDbModule::getDbInstance()->getConnection()->prepare($qry);
							$res_exe = $result->execute(array($newAmount, $expense_type));
							if($res_exe){
								$message = 1;
							}
							else{
								$message = "Expenses Update Failed";
							}
						}
						$count++;
					}
				}
				
				$reader->close();
			}
			else{
				$message = "Please choose only excel file(.xls/.xlsx)";
			}
		}
		else{
			$message = "Please choose an excel file to upload";
		}

		return $message;

	} // end of importAndUpdateExpenses()*/


	function getAmount4ExpenseType($expense){
		$qry = "SELECT ExpenseType,Amount FROM expenses
		WHERE ExpenseType= ? ";
		$result = RetrievalDbModule::getDbInstance()->getConnection()->prepare($qry);
		$result->bindValue(1, $expense, PDO::PARAM_STR);
		$res = $result->execute();
		if($res){
			$row = $result->fetch(PDO::FETCH_ASSOC);
			$moneys_expended = $row['Amount'];
			return floatval($moneys_expended);
		}

	}


	function getStockValue(){
		$myquery = "SELECT SUM(QuantityAvailable*BuyingPrice) AS Cost FROM products";
		$query= RetrievalDbModule::getDbInstance()->getConnection()->prepare($myquery);
		$query->execute();
		$rows = $query->fetch(PDO::FETCH_ASSOC);
		$value_of_stock = $rows['Cost'];
		return $value_of_stock;
	}

	function getExpenseTypes(){
		$myquery = "SELECT * FROM expensetypes";
		$query= RetrievalDbModule::getDbInstance()->getConnection()->prepare($myquery);
		$query->execute();
		return $query->fetchAll();
	}


	function getValueOfExpenses(){
		$myquery = "SELECT SUM(Amount) AS TotalExpenses FROM expenses";
		$query= RetrievalDbModule::getDbInstance()->getConnection()->prepare($myquery);
		$query->execute();
		$rows = $query->fetch(PDO::FETCH_ASSOC);
		$total_expenses = $rows['TotalExpenses'];
		return $total_expenses;
	}


	function getNumberofCategories(){
		$avail_categories = RetrievalDbModule::getDbInstance()->getConnection()->query("SELECT * FROM category");
		$num_of_categories = $avail_categories->rowCount();
		return $num_of_categories;
	}
	function getNumberofCustomers(){
		$query_customers =  RetrievalDbModule::getDbInstance()->getConnection()->query("SELECT * FROM customers");
		$num_of_customers  = $query_customers->rowCount();
		return $num_of_customers;
	}
	function getNumberofSuppliers(){
		$suppliers_sql =  RetrievalDbModule::getDbInstance()->getConnection()->query("SELECT * FROM suppliers");
		$num_of_suppliers  = $suppliers_sql->rowCount();
		return $num_of_suppliers;
	}
	function getNumberofSales(){
		$db = new Database();
		$sales_sql_query = RetrievalDbModule::getDbInstance()->getConnection()->query("SELECT * FROM sales");
		$sales_in_num = $sales_sql_query->rowCount();
		return $sales_in_num;
	}
	function getNumberofCashiers(){
		$db = new Database();
		$cashiers_sql =  RetrievalDbModule::getDbInstance()->getConnection()->query("SELECT * FROM cashiers");
		$num_of_cashiers = $cashiers_sql->rowCount();
		return $num_of_cashiers;
	}
	function getNumberofDamages(){
		$pdt_damages =  RetrievalDbModule::getDbInstance()->getConnection()->query("SELECT * FROM damages");
		$num_of_damages  = $pdt_damages->rowCount();
		$value_cost_of_damages = 0;
		return $num_of_damages;
	}
	function getNumberofProducts(){
		$products_query = RetrievalDbModule::getDbInstance()->getConnection()->query("SELECT * FROM products");
		$num_of_products = $products_query->rowCount();
		return $num_of_products;
	}
	function getNumberOfTodaysSales(){	
		$result_sales= RetrievalDbModule::getDbInstance()->getConnection()->query("SELECT * From sales 
			WHERE DATE(Date) = CURDATE()");
		return $result_sales->rowCount();

	}

	function Sale(){
		$product_id  = $quantity = $customer = $success = "";
		$errors = array();
		$product_code  =  $_POST["barcode"];
		$quantity = $_POST["Quantity"];
		$customer = $_POST["Customer"];
		if(empty($_POST["barcode"])){
			array_push($errors, "please scan barcode");

		}
		if(empty($_POST["Quantity"])){
			array_push($errors, "Product quantity required");

		}
		if (empty( $_POST["Customer"])) {
			array_push($errors,"Customer name Required");
		}
		if(count($errors)==0){
			$product_Details = RetrievalDbModule::getDbInstance()->getConnection()->query("select * products where ProductID='$product_code'");
			$product_Details->execute();

			if($product_Details->rowCount() > 0){

				$list = $product_Details->fetchAll();

				foreach($list as $rows){
					$product = $rows['ProductName'];
					$price = $rows['Price'];
				}
				$result = RetrievalDbModule::getDbInstance()->getConnection()->query("INSERT INTO sales(billno,ProductID,ProductName,Quantity,Price,
					Discount,Customer,Date,CashierName)
					VALUES('2900','$product_code','$product','$quantity','$price','0','$customer','1/2/1996','Henry')");
				$result->execute();

				if($result){
					$success = "sale transaction of ".$product_name." conducted successfully";
				}
				else{
					array_push($errors, "opps transaction failed because ".mysqli_error($con)."");
				}

			}
			else{
				array_push($errors, "product doesn't exit in the database");
			}
		}
	}


	function searchItem(){
		$request = $_POST['query'];
		$query = "SELECT DISTINCT ProductName FROM products WHERE ProductName LIKE '%".$request."%' ";
		$result_of_query = RetrievalDbModule::getDbInstance()->getConnection()->query($query);
		$result_of_query->execute();

		$num = $result_of_query->rowCount();
		$list = $result_of_query->fetchAll(PDO::FETCH_ASSOC);
		$data = array();
		if($num > 0){
			foreach($list as $row){
				$data[] = $row['ProductName'];
			}
			echo json_encode($data);
		}else{
			echo "no item found";
		}
	}

	function searchCashier(){
		$request = $_POST['CashierQuery'];
		$query = "SELECT CashierName FROM cashiers WHERE CashierName LIKE '%".$request."%' ";
		$result_of_query = RetrievalDbModule::getDbInstance()->getConnection()->query($query);
		$result_of_query->execute();

		$num = $result_of_query->rowCount();
		$list = $result_of_query->fetchAll(PDO::FETCH_ASSOC);
		$data = array();
		if($num > 0){
			foreach($list as $row){
				$data[] = $row['CashierName'];
			}
			echo json_encode($data);
		}else{
			echo "no cashier found";
		}
	}

	function searchInDamages(){
		$request = $_POST['DamageLabel'];
		$query = "SELECT DISTINCT ProductName FROM damages WHERE ProductName LIKE '%".$request."%' ";
		$result_of_query = RetrievalDbModule::getDbInstance()->getConnection()->query($query);
		$result_of_query->execute();

		$num = $result_of_query->rowCount();
		$list = $result_of_query->fetchAll(PDO::FETCH_ASSOC);
		$data = array();
		if($num > 0){
			foreach($list as $row){
				$data[] = $row['ProductName'];
			}
			echo json_encode($data);
		}else{
			echo "no damage found";
		}
	}

	function searchCustomer(){
		$request = $_POST['CustomerLabel'];
		$query = "SELECT CustomerName FROM customers WHERE CustomerName LIKE '%".$request."%' ";
		$result_of_query = RetrievalDbModule::getDbInstance()->getConnection()->query($query);
		$result_of_query->execute();

		$num = $result_of_query->rowCount();
		$list = $result_of_query->fetchAll(PDO::FETCH_ASSOC);
		$data = array();
		if($num > 0){
			foreach($list as $row){
				$data[] = $row['CustomerName'];
			}
			echo json_encode($data);
		}else{
			echo "no customer found";
		}
	}


	function searchCategory(){
		$request = $_POST['CatLabel'];
		$query = "SELECT Category FROM category WHERE Category LIKE '%".$request."%' ";
		$result_of_query = RetrievalDbModule::getDbInstance()->getConnection()->query($query);
		$result_of_query->execute();

		$num = $result_of_query->rowCount();
		$list = $result_of_query->fetchAll(PDO::FETCH_ASSOC);
		$data = array();
		if($num > 0){
			foreach($list as $row){
				$data[] = $row['Category'];
			}
			echo json_encode($data);
		}else{
			echo "no category found";
		}
	}

	function searchinExpenses(){
		$request = $_POST['ExpenseLabel'];
		$query = "SELECT DISTINCT ExpenseType FROM expenses WHERE ExpenseType LIKE '%".$request."%' ";
		$result_of_query = RetrievalDbModule::getDbInstance()->getConnection()->query($query);
		$result_of_query->execute();

		$num = $result_of_query->rowCount();
		$list = $result_of_query->fetchAll(PDO::FETCH_ASSOC);
		$data = array();
		if($num > 0){
			foreach($list as $row){
				$data[] = $row['ExpenseType'];
			}
			echo json_encode($data);
		}else{
			echo "no expense type found";
		}
	}

	function searchInSupplier(){
		$request = $_POST['SupplierLabel'];
		$query = "SELECT SupplierName FROM suppliers 
		WHERE SupplierName LIKE '%".$request."%' ";
		$result_of_query = RetrievalDbModule::getDbInstance()->getConnection()->query($query);
		$result_of_query->execute();

		$num = $result_of_query->rowCount();
		$list = $result_of_query->fetchAll(PDO::FETCH_ASSOC);
		$data = array();
		if($num > 0){
			foreach($list as $row){
				$data[] = $row['SupplierName'];
			}
			echo json_encode($data);
		}else{
			echo "no supplier found";
		}
	}


	function searchPricefromStock(){
		$q =  $_POST['q'];
		$sql = "SELECT * FROM products WHERE  (ProductName LIKE '".$q."%') OR  (ProductID LIKE '".$q."%') ";

		$result = RetrievalDbModule::getDbInstance()->getConnection()->query($sql);
		$num = $result->rowCount();
		$k = $result->fetch(PDO::FETCH_ASSOC);
		if($num > 0){
			$rows = $k;
			$response = $rows['SellingPrice'];
			echo $response;


		}
		else{
			$response = "No data found!";
		}
	}

	function searchPdtCategoryfromStock(){
		$d =  $_POST['d'];
		$sql = "SELECT Category FROM products WHERE  (ProductName LIKE '".$d."%') OR  (ProductID LIKE '".$d."%') ";

		$result = RetrievalDbModule::getDbInstance()->getConnection()->query($sql);
		$num = $result->rowCount();
		$k = $result->fetch(PDO::FETCH_ASSOC);
		if($num > 0){
			$rows = $k;
			$response = $rows['Category'];
			echo $response;
		}
		else{
			$response = "No data found!";
		}
	}

	function getTotalCredit($who){
		$creditValue = 0;
		switch(true){
			case (strtolower($who)==strtolower('suppliers')):
			try{
				$sql = RetrievalDbModule::getDbInstance()->getConnection()->prepare("SELECT CR  From suppliers ");
				$sql->execute();
				$row_list = $sql->fetchAll();
				foreach($row_list as $row){
					$creditValue += $row['CR']; 
				}
				return $creditValue;
			}catch(PDOException $e){
				echo $e->getMessage();
			}
			break;
			case (strtolower($who) == strtolower('customers')):
			try{
				$sql = RetrievalDbModule::getDbInstance()->getConnection()->prepare("SELECT CR  From customers ");
				$sql->execute();
				$row_list = $sql->fetchAll();
				foreach($row_list as $row){
					$creditValue += $row['CR']; 
				}
				return $creditValue;
			}catch(PDOException $e){
				echo $e->getMessage();
			}
			break;
		}

	}



	function getTotalDebt($who){
		$debtValue = 0;
		switch(true){
			case (strtolower($who)==strtolower('suppliers')):
			try{
				$sql = RetrievalDbModule::getDbInstance()->getConnection()->prepare("SELECT DR  From suppliers ");
				$sql->execute();
				$row_list = $sql->fetchAll();
				foreach($row_list as $row){
					$debtValue += $row['DR']; 
				}
				return $debtValue;
			}catch(PDOException $e){
				echo $e->getMessage();
			}
			break;
			case (strtolower($who)==strtolower('customers')):
			try{
				$sql = RetrievalDbModule::getDbInstance()->getConnection()->prepare("SELECT DR  From customers ");
				$sql->execute();
				$row_list = $sql->fetchAll();
				foreach($row_list as $row){
					$debtValue += $row['DR']; 
				}
				return $debtValue;
			}catch(PDOException $e){
				echo $e->getMessage();
			}
			break;
		}
	}


	function getCostOfDamagedItem($damage){
		try{
			$query = "SELECT BuyingPrice AS CostOfDamage From products WHERE
			ProductName='$damage'";
			$sql = RetrievalDbModule::getDbInstance()->getConnection()->prepare($query);
			$sql->execute();
			$row = $sql->fetch(PDO::FETCH_ASSOC);
			$cost_of_damage = $row['CostOfDamage']; 
			return $cost_of_damage;
		}catch(PDOException $e){
			echo $e->getMessage();
		}

	}
	function getCostOfDamages(){
		$k = new RetrievalDbModule();
		$total_cost_of_damages = 0;
		try{
			$sql_query = "SELECT ProductName,Quantity From damages";
			$sql = RetrievalDbModule::getDbInstance()->getConnection()->prepare($sql_query);
			$sql->execute();
			$row_list = $sql->fetchAll();
			foreach($row_list as $row){
				$damagedItem = $row['ProductName']; 
				$qty = $row['Quantity'];
				$cost = $k->getCostOfDamagedItem($damagedItem);
				$total_cost_per_item = ($qty * $cost);
				$total_cost_of_damages += $total_cost_per_item;

			}
			return $total_cost_of_damages;
		}catch(PDOException $e){
			echo $e->getMessage();
		}
	}




		//method ModifyPassword that changes password
	public function ModifyPassword(){     
		$data = $_REQUEST['dataArray'];
		$password1 = $data[0];
		$password2 = $data[1];
		$user = $data[2];
		$group = $data[3];
		if($password1 == $password2){
			$password = password_hash($password1, PASSWORD_DEFAULT);
		}
		if($password1 != $password2){
			echo "passwords donot match";
		}
		switch (true) {
			case ($group=='Manager'):
			try{
				$sql = "UPDATE administrators SET Password='$password' WHERE Username='".$user."'";
				$modify_query =  RetrievalDbModule::getDbInstance()->getConnection()->prepare($sql);
				$exe =  $modify_query->execute();
				if($exe){
					echo "Your password has been changed successfully"; 
				}else{
					echo "Failed to change your password";
				}
			}catch(PDOException $ex){
				echo "Failed to change your password because of ".$ex->getMessage();
			}
			break;
			case ($group=='Cashier'):
			try{
				$sql = "UPDATE cashiers SET Password='$password' WHERE CashierName='".$user."'";
				$modify_query =  RetrievalDbModule::getDbInstance()->getConnection()->prepare($sql);
				$exe =  $modify_query->execute();
				if($exe){
					echo "Your password has been changed successfully"; 
				}else{
					echo "Failed to change your password";
				}
			}catch(PDOException $ex){
				echo "Failed to change your password because of ".$ex->getMessage();
			}
			break;

		}


      } // end of method ModifyPassword()   

      function ReportData(){
      	try{
      		$sqlQuery = "SELECT monthly_date, month_name, sales_made FROM monthlysales ORDER BY monthly_date";
      		$result =  RetrievalDbModule::getDbInstance()->getConnection()->query($sqlQuery);
      		$data = array();
      		foreach ($result as $row) {
      			$data[] = $row;

      		}
// print_r($data);
      		echo json_encode($data);
      	}catch(PDOException $ex){
      		echo $ex;
      	}
      }

      function CashierFiltersSales($date1,$date2){ 
      	$the_date1 = date('Y-m-d', strtotime($date1));  
      	$the_date2 = date('Y-m-d', strtotime($date2)); 
      	$sql = "SELECT * FROM  sales
      	WHERE (Date BETWEEN '".$the_date1."' AND '".$the_date2."')";
      	$sales = RetrievalDbModule::getDbInstance()->getConnection()->prepare($sql);
      	$sales->execute();
      	$row = $sales->fetchAll();
      	return array("filteredsales" => $row,
                    "title" => "Total sales made");
      }
      function getTotal4CashierFilteredSales($date1,$date2){ 
      	$the_date1 = date('Y-m-d', strtotime($date1));  
      	$the_date2 = date('Y-m-d', strtotime($date2));    
      	$sql = "SELECT SUM(cost) as total FROM  sales
      	WHERE (Date BETWEEN '".$the_date1."' AND '".$the_date2."')";
      	$sales = RetrievalDbModule::getDbInstance()->getConnection()->prepare($sql);
      	$sales->execute();
      	$row = $sales->fetch();
      	$total = $row['total'];
      	return $total;
      }


      function total_periodic_sales(){
      	$title = "";
      	$k = new RetrievalDbModule();
      	$companyName = $k->getCompanyName();
      	if(isset($_GET['currentweek'])){
      		$title = "Total sales in this week so far:";
      		$sql = "SELECT SUM(cost) as salesnum FROM  sales
      		WHERE YEARWEEK(Date) = YEARWEEK(NOW())";
      		$sales = RetrievalDbModule::getDbInstance()->getConnection()->prepare($sql);
      		$sales->execute();
      		$row = $sales->fetch();
      		$total = $row['salesnum'];
      		return array("title" => $title, "total" => $total);

      	}
      	if(isset($_GET['lastweek'])){
      		$title = "Total sales generated last week:";
      		$sql = "SELECT SUM(cost) as salesnum FROM  sales
      		WHERE YEARWEEK(Date)=YEARWEEK(CURDATE()-INTERVAL 1 WEEK)";
      		$sales = RetrievalDbModule::getDbInstance()->getConnection()->prepare($sql);
      		$sales->execute();
      		$row = $sales->fetch();
      		$total = $row['salesnum'];
      		return array("title" => $title, "total" => $total);

      	}
      	if(isset($_GET['last7days'])){
      		$title = "Total sales in last 7 days:";
      		$sql = "SELECT SUM(cost) as salesnum FROM  sales
      		WHERE Date >= (DATE(NOW()) - INTERVAL 7 DAY)
      		";
      		$sales = RetrievalDbModule::getDbInstance()->getConnection()->prepare($sql);
      		$sales->execute();
      		$row = $sales->fetch();
      		$total = $row['salesnum'];
      		return array("title" => $title, "total" => $total);
      	}
      	if(isset($_GET['last30days'])){
      		$title = "Total sales in last 30 days:";
      		$sql = "SELECT SUM(cost) as salesnum FROM  sales
      		WHERE DATEDIFF(NOW(), DATE) <= 30";
      		$sales = RetrievalDbModule::getDbInstance()->getConnection()->prepare($sql);
      		$sales->execute();
      		$row = $sales->fetch();
      		$total = $row['salesnum'];
      		return array("title" => $title, "total" => $total);
      	}
      	if(isset($_GET['currentmonth'])){
      		$array = getdate();
      		$current_month = $array['month'];
      		$title = "Total sales in this month (".$current_month."):";
      		$sql = "SELECT SUM(cost) as salesnum FROM  sales
      		WHERE MONTH(Date) = MONTH(CURRENT_DATE()) AND
      		YEAR(Date) = YEAR(CURRENT_DATE()) 
      		";
      		$sales = RetrievalDbModule::getDbInstance()->getConnection()->prepare($sql);
      		$sales->execute();
      		$row = $sales->fetch();
      		$total = $row['salesnum'];
      		return array("title" => $title, "total" => $total);
      	}
      	if(isset($_GET['lastmonth'])){
      		$title = "Total sales generated last month:";
      		$sql = "SELECT SUM(cost) as salesnum FROM  sales
      		WHERE MONTH(Date) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH) AND
      		YEAR(Date) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) 
      		";
      		$sales = RetrievalDbModule::getDbInstance()->getConnection()->prepare($sql);
      		$sales->execute();
      		$row = $sales->fetch();
      		$total = $row['salesnum'];
      		return array("title" => $title, "total" => $total);
      	}
      	if(isset($_GET['sales'])){
      		$title = "Total sales generated since startup:";
      		$sql = "SELECT SUM(cost) as salesnum FROM  sales";
      		$sales = RetrievalDbModule::getDbInstance()->getConnection()->prepare($sql);
      		$sales->execute();
      		$row = $sales->fetch();
      		$total = $row['salesnum'];
      		return array("title" => $title, "total" => $total);
      	}
      	if(isset($_GET['lowrunningstock'])){
      		$title = "List of products running out of stock";
      		$total = "";
      		return array("title" => $title, "total" => $total);
      	}
      	if(isset($_GET['inventory'])){
      		$title = "List of recorded items or products in stock";
      		$total = "";
      		return array("title" => $title, "total" => $total);
      	}
      	if(isset($_GET['monthlysales'])){
      		$title = "Total Sales generated per month";
      		$total = "";
      		return array("title" => $title, "total" => $total);
      	}
      	if(isset($_GET['toptencustomers'])){
      		$title = " ".$companyName." Best 10 customers";
      		$total = "";
      		return array("title" => $title, "total" => $total);
      	}
      	if(isset($_GET['bestselling'])){
      		$title = "Best selling products in ".$companyName."";
      		$total = "";
      		return array("title" => $title, "total" => $total);
      	}
      	if(isset($_GET['suppliers'])){
      		$title = "List of ".$companyName." registered suppliers";
      		$total = "";
      		return array("title" => $title, "total" => $total);
      	}
      	if(isset($_GET['companycashiers'])){
      		$title = "List of ".$companyName." registered cashiers";
      		$total = "";
      		return array("title" => $title, "total" => $total);
      	}
      	if(isset($_GET['cashiersperformance'])){
      		$title = "Report showing cashier's performance";
      		$total = "";
      		return array("title" => $title, "total" => $total);
      	}

      }



} // end of class RetrievalDbModule()

$obj = new RetrievalDbModule();


if(isset($_POST['getReportData'])){
	$obj->ReportData();
}

switch (true) {
	case (isset($_POST['SaleProductBtn'])):
	echo $obj->Sale();
	break;
	case (isset($_POST['searchPrice'])):
	echo $obj->searchPricefromStock();
	break;
	case (isset($_POST['SearchItem'])):
	echo $obj->searchItem();
	break;
	case (isset($_POST['SearchStock'])):
	echo $obj->searchItem();
	break;
	case (isset($_POST['searchDamage'])):
	echo $obj->searchItem();
	break;
	case (isset($_POST['changepassword'])):
	echo $obj->ModifyPassword();
	break;
	case(isset($_POST['searchCategoryOfDamage'])):
	echo $obj->searchPdtCategoryfromStock();
	break;
	case(isset($_POST['SearchCashier'])):
	echo $obj->searchCashier();
	break;
	case(isset($_POST['SearchSupplier'])):
	echo $obj->searchInSupplier();
	break;
	case(isset($_POST['SearchInDamages'])):
	echo $obj->searchInDamages();
	break;
	case(isset($_POST['SearchInCustomers'])):
	echo $obj->searchCustomer();
	break;
	case(isset($_POST['SearchInExpenses'])):
	echo $obj->searchinExpenses();
	break;
	case(isset($_POST['SearchInCategories'])):
	echo $obj->searchCategory();
	break;

}
?>
