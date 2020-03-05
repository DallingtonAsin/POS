<?php

require('dbController.inc.php');

class Updater{
  

  public static $_instance;
  
  public static function getDbInstance(){
    if(!self::$_instance){
      self::$_instance = new Database();
    }
    return self::$_instance;
  }

//method to update cashier details
	function UpdateCashierDetails(){
		header('Content-Type: application/json');
		$input = filter_input_array(INPUT_POST);
		$cashiername = $input["CashierName"];
		$mobile = $input["MobileNo"];
		$address = $input["Address"];
		$email = $input["Email"];

		if($input["action"] === 'EditCashierDetails'){
			$update_query = "UPDATE Cashiers SET
			CashierName='".$cashiername."',MobileNo='".$mobile."',
			Address='".$address."',Email='".$email."' WHERE id='".$input["id"]."'
			";
			$update_sql = Updater::getDbInstance()->getConnection()->prepare($update_query);
			$up = $update_sql->execute();
		}

		if($input["action"]==='DeleteCashier'){
			$delete_query = "DELETE FROM Cashiers WHERE
			id='".$input["id"]."'";
			$delete_sql = Updater::getDbInstance()->getConnection()->prepare($delete_query);
			$delete_sql->execute();

		}

		echo json_encode($input);
	} // end of method UpdateCashierDetails()



//method UpdateDamages to set updates on recorded damages
	function UpdateDamages(){
		header('Content-Type: application/json'); 	
		$input = filter_input_array(INPUT_POST);
		$itemid = $input["ItemID"];
		$item =   $input["ProductName"];
		//$qty = $input["Quantity"];

		if($input["action"] === 'EditDamagedItem'){
			$update_query = "UPDATE damages SET
			ItemID='".$itemid."',ProductName='".$item."'
			WHERE id='".$input["id"]."'
			";
			$update_sql = Updater::getDbInstance()->getConnection()->prepare($update_query);
			$update_sql->execute();        
		}

		if($input["action"] === 'DeleteDamagedItem'){
			$delete_query = "DELETE FROM damages WHERE
			id='".$input["id"]."'
			";
			$delete_sql = Updater::getDbInstance()->getConnection()->prepare($delete_query);
			$delete_sql->execute();          
		}

		echo json_encode($input);
	} // end of method UpdateDamages()



//method UpdateStockCategories() to set updates on product categories
	function UpdateStockCategories(){
		header('Content-Type: application/json'); 	
		$input = filter_input_array(INPUT_POST);

		$category = $input["Category"];

		if($input["action"] === 'editCategory'){
			$update_query = "UPDATE Category SET
			Category='".$category."' WHERE id='".$input["id"]."'
			";
			$update_sql = Updater::getDbInstance()->getConnection()->prepare($update_query);
			$update_sql->execute();         
		}

		if($input["action"] === 'deleteCategory'){
			$delete_query = "DELETE FROM Category WHERE
			id='".$input["id"]."'
			";
			$delete_sql = Updater::getDbInstance()->getConnection()->prepare($delete_query);
			$delete_sql->execute();

		}

		echo json_encode($input);
	} // end of method UpdateStockCategories()




//method UpdateSupplierDetails() to set updates on supplier details
	function UpdateSupplierDetails(){
		header('Content-Type: application/json'); 	
		$input = filter_input_array(INPUT_POST);
		$suppliername = $input["SupplierName"];
		$address =  $input["Address"];
		$contact =  $input["Contact"];
		$email = $input["Email"];
		$debt = floatval(preg_replace('/[^\d.]/', '', $input["DR"]));
		$credit = floatval(preg_replace('/[^\d.]/', '', $input["CR"]));

		if($input["action"] === 'EditSupplierDetails'){
			try{
			$update_query = "UPDATE suppliers SET
			SupplierName='".$suppliername."',Address='".$address."',
			Contact='".$contact."',Email='".$email."',DR='".$debt."',CR='".$credit."' 
			WHERE id='".$input["id"]."'
			";
			$update_sql = Updater::getDbInstance()->getConnection()->prepare($update_query);
			$update_sql->execute(); 
			}catch(Exception $ex){
				echo "Problems at".$ex->getMessage();
			}      
		}

		if($input["action"] === 'DeleteSupplierDetails'){
			$delete_query = "DELETE FROM suppliers WHERE
			id='".$input["id"]."'
			";
			$delete_sql = Updater::getDbInstance()->getConnection()->prepare($delete_query);
			$delete_sql->execute();         
		}

		echo json_encode($input);
	} // end of method UpdateSupplierDetails()



	//method UpdateCustomerDetails() to set updates on customer details
	function UpdateCustomerDetails(){
		header('Content-Type: application/json'); 	
		$input = filter_input_array(INPUT_POST);
		$customername = $input["CustomerName"];
		$phone = $input["Phone"];
       /* $debt =  $input["DR"]);
		$credit =  $input["CR"]);*/

		$debt = floatval(preg_replace('/[^\d.]/', '', $input["DR"]));
		$credit = floatval(preg_replace('/[^\d.]/', '', $input["CR"]));

		if($input["action"] === 'EditCustomerDetails'){
			$update_query = "UPDATE customers SET
			CustomerName='".$customername."',Phone='".$phone."',
			DR='".$debt."',CR='".$credit."' 
			WHERE id='".$input["id"]."'
			";
			$update_sql = Updater::getDbInstance()->getConnection()->prepare($update_query);
			$update_sql->execute();         
		}

		if($input["action"] === 'DeleteCustomer'){
			$delete_query = "DELETE FROM customers WHERE
			id='".$input["id"]."'
			";
			$delete_sql = Updater::getDbInstance()->getConnection()->prepare($delete_query);
			$delete_sql->execute();             
		}
		echo json_encode($input);
	} // end of method UpdateCustomerDetails()


	//method UpdateStock() to set updates on stock details
	function UpdateStock(){
		header('Content-Type: application/json'); 	
		$input = filter_input_array(INPUT_POST);

		$productname = $input["ProductName"];
		$category = $input["Category"];
		$qty =      $input["QuantityAvailable"];
		$original_price = floatval(preg_replace('/[^\d.]/', '', $input["BuyingPrice"]));
		$selling_price = floatval(preg_replace('/[^\d.]/', '',$input["SellingPrice"]));
		$supplier =    $input["Supplier"];
		$dateofexpiry = $input["ExpiryDate"];

		if($input["action"] === 'editStock'){
			$update_query = "UPDATE products SET
			ProductName='".$productname."',Category='".$category."',
			QuantityAvailable='".$qty."',BuyingPrice='".$original_price."',
			SellingPrice='".$selling_price."',Supplier='".$supplier."',
			ExpiryDate='".$dateofexpiry."' WHERE id='".$input["id"]."'
			";
			$update_sql = Updater::getDbInstance()->getConnection()->prepare($update_query);
			$update_sql->execute();                
		}

		if($input["action"]==='deleteStock'){
			$delete_query = "DELETE FROM products WHERE
			id='".$input["id"]."'";
			$delete_sql = Updater::getDbInstance()->getConnection()->prepare($delete_query);
			$delete_sql->execute();           
		}
		echo json_encode($input);

	} // end of method UpdateStock()

	//method UpdateExpenses() to set updates on stock details
	function UpdateExpenses(){
		header('Content-Type: application/json'); 	
		$input = filter_input_array(INPUT_POST);

		$expense_type = $input["ExpenseType"];
		$expense_amt = floatval(preg_replace('/[^\d.]/', '', $input["Amount"]));
		$date_of_expense =      $input["DateOfExpense"];
		

		if($input["action"] === 'editExpense'){
			$update_query = "UPDATE Expenses SET
			ExpenseType='".$expense_type."',Amount='".$expense_amt."',
			DateOfExpense='".$date_of_expense."' WHERE id='".$input["id"]."'
			";
			$update_sql = Updater::getDbInstance()->getConnection()->prepare($update_query);
			$update_sql->execute();                
		}

		if($input["action"]==='deleteExpense'){
			$delete_query = "DELETE FROM Expenses WHERE
			id='".$input["id"]."'";
			$delete_sql = Updater::getDbInstance()->getConnection()->prepare($delete_query);
			$delete_sql->execute();           
		}
		echo json_encode($input);

	} // end of method UpdateExpenses()
 
}  //end of the class Updater()


$the_obj = new Updater();

echo $the_obj->UpdateSupplierDetails();
echo $the_obj->UpdateDamages();
echo $the_obj->UpdateCashierDetails();
echo $the_obj->UpdateCustomerDetails();
echo $the_obj->UpdateStock();
echo $the_obj->UpdateStockCategories();
echo $the_obj->UpdateExpenses();





?>