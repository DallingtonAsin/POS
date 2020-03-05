<?php
require_once('dbController.inc.php');

class ClassMaster{

	private static $_instance;


	public static function getDbInstance(){
		if(!self::$_instance){
			self::$_instance = new Database();
		}
		return self::$_instance;
	}


//method AddSupplier() to register supplier
	public function AddSupplier(){
		$supplier = $address = $contact = $email = "";
		$errors = $success  = array();

		$supplier  =  $_POST["supplier_name"];
		$address = $_POST["supplier_address"];
		$contact = $_POST["supplier_contact"];
		$email = $_POST['supplierEmail'];
		$debt = 0.0;
		$credit = 0.0;
		if(empty($supplier)){
			array_push($errors,  "Supplier's Name Required");
		}
		if(empty($address)){
			array_push($errors,"Address Required");
		}
		if (empty($contact)) {
			array_push($errors, "Contact Required");
		}
		
		if(empty($email)){
			$email = null;
		}
		if(count($errors)==0){
			$query = "INSERT INTO suppliers(id,SupplierName,Address,Contact,Email,DR,CR)
			VALUES(null,'$supplier','$address','$contact','$email','$debt','$credit')";
			$sql = ClassMaster::getDbInstance()->getConnection()->prepare($query);
			$sql_exe = $sql->execute();
			if($sql_exe){
				array_push($success,"".$supplier." has been registered as a supplier successfully");
			}
			else{
			echo "problems in registering supplier";
			}
		}
	} //end of function AddSupplier()



// method AddCustomer() to register customer
	public function AddCustomer(){
		$errors = $success  = array();
		$customer = $contact = $DR = $CR = "";
		$customer  =  $_POST["CustomerName"];
		$contact = $_POST["PHONE"];
		$DR = $_POST["DEBT"];
		$CR = $_POST["CREDIT"];;
		if(empty($customer)){
			array_push($errors,  "Customer's Name Required");
		}
		if(empty($DR)){
			$DR = 0.0;
		}
		if (empty($CR)) {
			$CR = 0.0;
		}
		if(count($errors)==0){
			$query = "INSERT INTO customers(id,CustomerName,Phone,DR,CR)
			VALUES(null,'$customer','$contact','$DR','$CR')";
			$sql = ClassMaster::getDbInstance()->getConnection()->prepare($query);
			$sql_exe = $sql->execute();
			if($sql_exe){
				array_push($success,"".$customer." has been registered as a supplier successfully");
			}
			else{
				echo "problems in registering customer";
			}
		}
	} // end of method AddCustomer()


//method AddStock to add new stock to the database
	public function AddStock(){
		$errors = $success  = array();
		$product_id  = $product_name = $quantity = $buyingprice =  $Quantity_Last_Added =
		$sellingprice = $category= $expirydate1 = $expirydate
		= $success_string = $product_category = "";
		$product_id  =  $_POST["id_of_product"];
		$product_name = $_POST["ProductName"];
		$quantity = $_POST["Quantity"];
		$Quantity_Last_Added = $quantity;
		$buyingprice = $_POST["originalprice"];
		$sellingprice = $_POST["sellingprice"];
		$supplier = $_POST["supplier"];
		$category = $_POST['category'];
		$expirydate1 = $_POST['expirydate'];

		$expirydate = date('Y-m-d', strtotime($expirydate1));

		if(empty($_POST["id_of_product"])){
			array_push($errors, "ProductID Required");
		}
		if(empty($_POST["ProductName"])){
			array_push($errors, "ProductName Required");
		}
		if (empty( $_POST["Quantity"])) {
			array_push($errors,"Quantity Required");
		}
		if (empty( $_POST["category"]) || $category=="choose category"){
			$category = "";
		}
		if (empty($_POST["originalprice"])) {
			array_push($errors, "Original Price Required");
		}
		if (empty($_POST["sellingprice"])) {
			array_push($errors, "Original Price Required");
		}
		if (empty($_POST["supplier"]) || $supplier=="select supplier") {
			$supplier = "";
		}
		if (empty($_POST["expirydate"])) {
			$expirydate = "";
		}

		if(count($errors)==0){
			$result = ClassMaster::getDbInstance()->getConnection()->prepare("INSERT INTO products(id,ProductID,ProductName,Category,
				QuantityAvailable,QuantityLastAdded,BuyingPrice,SellingPrice,Supplier,DateofEntry,ExpiryDate)
				VALUES(null,'$product_id','$product_name','$category','$quantity',
				'$Quantity_Last_Added','$buyingprice','$sellingprice','$supplier',null,'$expirydate')");
			$result_exe = $result->execute();
			if($result_exe){
				$success_string = "".$product_name." added successfully";
			}
			else{
				echo mysqli_error($con);
			}
		}

	} // end of method AddStock()


//method AddCategory to add new product category
	public function AddCategory(){
		$errors = $success  = array();
		$product_category = $_POST['product_category'];
		if(empty($_POST['product_category'])){
			array_push($errors, "Enter product category");
		}
		if(count($errors)==0){
			$addcat_query = ClassMaster::getDbInstance()->getConnection()->prepare("INSERT INTO category(id,Category)
				VALUES(null,'$product_category')");
			$addcat_query_exe = $addcat_query->execute();
			if(!$addcat_query_exe){
				echo "failed to add category";
			}
			else{
				// do nothing
			}
		}
	} // end of method AddCategory()

//method AddCashier() to register new cashier
	public function AddCashier(){
		$errors = $success  = array();
		$firstname = $lastname = $cashiernames = $mobile_no = $address = $email =
		$password1 = $password2 = $password  = "";
		$firstname  =  $_POST["firstname"];
		$lastname  =  $_POST["lastname"];
		$mobile_no  = $_POST["Mobile_No"];
		$address = $_POST["Address"];
		$email = $_POST["Email"];
		$password1 = $_POST["Cashier_Password1"];
		$password2 = $_POST["Cashier_Password2"];

		if(empty($firstname)){
			array_push($errors,  "Cashier's First Name Required");
		}

		if(empty($lastname)){
			array_push($errors,  "Cashier's Last Name Required");
		}
		if(isset($firstname) && isset($lastname)){
			$cashiernames = "".$firstname." ".$lastname."";
		}

		if(empty($mobile_no)){
			array_push($errors,"mobile number Required");
		}
		if (empty($address)) {
			array_push($errors,"Address Required");
		}
		if(empty($email)){
			$email = null;
		}
		if(isset($email)){
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$type_error = "errors";
				$error_message = "Invalid email format";
				array_push($errors, "Invalid email format");

			}
		}

		if (empty($password1)) {
			array_push($errors,"Password Required");
		}
		if (empty($password2)) {
			array_push($errors,"Please Confirm your Password");
		}
		if(isset($password1) && isset($password1)){
			if($password1==$password2){
              $password = password_hash($password1, PASSWORD_DEFAULT); // Or use md5()
          }
          else if($password1!=$password2){
          	$type_error = "errors";
          	$error_message = "Your passwords don't match,please enter matching passwords";
          	array_push($errors, $error_message);
          }

      }

      if(count($errors)==0){
      	$query = "INSERT INTO cashiers(id,CashierName,MobileNo,Address,Email,Password,Image)
      	VALUES(null,'$cashiernames','$mobile_no','$address','$email','$password',null)";
      	$sql = ClassMaster::getDbInstance()->getConnection()->prepare($query);
      	$sql_exe = $sql->execute();
      	if(!$sql_exe){
      		echo "failed to add cashier";
      	}
      	else{
      		return array("status" => true,"cashier" =>$cashiernames);
      	}
      }
      else{
      	  require('errors.php');
      }
} // end of method AddCashier()


//method AddDamage() to record new Damage
public function AddDamage(){
	$errors = $success  = array();
	$damageid = $damaged_product = $quantity_damaged = $category_of_damage = "";
	
	if(empty($_POST['DamageID'])){
		$damageid = $damaged_product;       //array_push($errors, "Damaged id missing");
	}
	
	if(empty($_POST['DamagedProduct'])){
		array_push($errors, "Damaged product name missing");
	}
	if(empty($_POST['CategoryOfDamage'])){
		$category_of_damage = "";
	}
	if(isset($_POST['DamageID'])){
		$damageid = $_POST['DamageID'];
	}
	if(isset($_POST['CategoryOfDamage'])){
		$category_of_damage = $_POST['CategoryOfDamage'];
	}
	if(empty($_POST['QuantityDamaged'])){
		array_push($errors, "Quantity of damaged item missing");
	}
	if(count($errors)==0){
		$damaged_product = $_POST['DamagedProduct'];
		$quantity_damaged = $_POST['QuantityDamaged'];
		$inventory = array();
		$pdts = ClassMaster::getDbInstance()->getConnection()->prepare("SELECT ProductName FROM products");
		$pdts->execute();
		$list =$pdts->fetchAll();
		foreach($list as $row){
			array_push($inventory,$row['ProductName']);
		}
		
		if(in_array($damaged_product,$inventory)){
			$add_damage = "INSERT INTO damages(id,ItemID,ProductName,Category,Quantity)
			VALUES(null,'$damageid','$damaged_product','$category_of_damage','$quantity_damaged')";
			$execute_sql = ClassMaster::getDbInstance()->getConnection()->prepare($add_damage);
			$execute_sql_exe = $execute_sql->execute();

			if(!$execute_sql_exe){
				array_push($errors, "Can't execute record damage query");
			}
			else{
				$get_stockqty_exe = ClassMaster::getDbInstance()->getConnection()->prepare("SELECT * FROM products WHERE ProductName='".$damaged_product."'");
				$get_stockqty_exe->execute();

				if($get_stockqty_exe){
					$qty_row = $get_stockqty_exe->fetch();
					$qty_avail = $qty_row['QuantityAvailable'];
					$newqty = ($qty_avail - $quantity_damaged);
					$update_stock_query = "UPDATE products SET QuantityAvailable='".$newqty."'
					WHERE ProductName = '".$damaged_product."'
					";
					$update_stock_sql = ClassMaster::getDbInstance()->getConnection()->prepare($update_stock_query);
					$update_stock_sql_exe = $update_stock_sql->execute();

					if(!$update_stock_sql_exe){
						$type_error = "errors";
						$error_message = "Couldn't update stock levels";
					}
					else{
						//do nothing
					}
				}
			}

		}else{
			$type_error = "errors";
			$error_message = "Damaged product is not among those in stock";
		}

	}
} // end of method AddDamage

//method AddExpense to record new expenditures
function AddExpense(){
	$errors = array();
	if(empty($_POST['ExpenseType']) || strtolower($_POST['ExpenseType'])
		==strtolower('choose expense type')){
		array_push($errors, "please select expense type");
	}
	if(empty($_POST['Amount'])){
		array_push($errors, "please enter expenditure amount");
	}
	if(empty($_POST['DateOfExpense']) || $_POST['DateOfExpense']=="mm/dd/yyyy"){
		array_push($errors, "please enter date of expenditure");
	}
	if(count($errors) == 0){
		$expenseType = $_POST['ExpenseType'];
		$amt = $_POST['Amount'];
		$date_of_expense = $_POST['DateOfExpense'];
		$query = "INSERT INTO expenses(ExpenseType,Amount,DateOfExpense) VALUES
		('$expenseType','$amt','$date_of_expense')";
		$sql = ClassMaster::getDbInstance()->getConnection()->prepare($query);
	    $s = $sql->execute();
	    if(!$s){
	    	echo "problems recording expense";
	    }

	}
}

function AddExpenseType(){
	$errors = array();
	
	if(empty($_POST['EType'])){
		array_push($errors, "please enter expense type");
	}
	
	if(count($errors) == 0){
		$expenseType = $_POST['EType'];
		$query = "INSERT INTO expensetypes(ExpenseType) VALUES
		('$expenseType')";
		$sql = ClassMaster::getDbInstance()->getConnection()->prepare($query);
	    $s = $sql->execute();
	    if(!$s){
	    	echo "problems recording expense";
	    }

	}
}

} // end of class ClassMaster()

$obj = new ClassMaster();

if($_SERVER['REQUEST_METHOD']=="POST"){
	switch(true){
		case (isset($_POST['addSupplierBtn'])):
		 echo $obj->AddSupplier();
		 break;
		 case (isset($_POST['addCustomerBtn'])):
		 echo $obj->AddCustomer();
		 break;
		 case (isset($_POST['AddProductBtn'])):
		 echo $obj->AddStock();
		 break;
		 case (isset($_POST['AddCategoryBtn'])):
		 echo $obj->AddCategory();
		 break;
		 case (isset($_POST["RecordDamage"])):
		 echo $obj->AddDamage();
		 break;
		 case (isset($_POST["AddExpenseBtn"])):
		 echo $obj->AddExpense();
		 break;
		 case (isset($_POST["AddExpenseTypeBtn"])):
		 echo $obj->AddExpenseType();
		 break;


	}

} // end of if statement isset($_SERVER['REQUEST_METHOD']=='POST')


?>
