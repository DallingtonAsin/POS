<?php
require_once('dbController.inc.php');

class CartClass{

	private static $_instance;

	public static function getDbInstance(){
		if(!self::$_instance){
			self::$_instance = new Database();
		}
		return self::$_instance;
	}


//method AddToCart()
	function AddToCart(){
		$errors_mass = $errors = array();
		$obj = new CartClass();
		$product = $quantity = $price = $discount = "";
		if(isset($_POST['Product'])){
			$product = $_POST['Product'];
		}
		if(empty($_POST['Product'])){
			array_push($errors_mass, "product can't be empty");
		}
		if(isset($_POST['Price'])){
			$price = $_POST['Price'];
		}
		if(empty($_POST['Price'])){
			array_push($errors_mass, "price can't be empty");
		}
		if(isset($_POST['Discount'])){
			$discount = $_POST['Discount'];
		}
		if(empty($_POST['Discount'])){
			$discount = 0;
		}
		if(isset($_POST['Quantity']) && $_POST['Quantity'] < $obj->AvailableStockQuantity($product)){
			$quantity = $_POST['Quantity'];
		}
		if(isset($_POST['Quantity']) && $_POST['Quantity'] > $obj->AvailableStockQuantity($product)){
			$qty = $obj->AvailableStockQuantity($product);
			array_push($errors_mass, "".$product." is not enough in stock,Qty available is ".$qty." ");
		}
		if(empty($_POST['Quantity']) || $_POST['Quantity'] == ""){
			$quantity = 1;
		}	
		
		if(count($errors_mass) == 0){
			//$quantity = $_POST['Quantity'];
			/*echo gettype($quantity);
			echo gettype($price);
			echo gettype($product);
			echo gettype($discount);*/

			$total = $quantity*$price;

			if($discount == 0){
				$amt = $total;
			}
			if(strlen($discount) < 3){
				$amt = $total * ((100-$discount)/100);
			}
			if(strlen($discount) >= 3){
				$amt = $quantity*($price - $discount);
			}   
			try{
				$query = "INSERT INTO Cart(ItemId,Item,Quantity,Price,Total,Discount,Amount)
				VALUES(null,'$product','$quantity','$price','$total','$discount','$amt')";

				$sql = CartClass::getDbInstance()->getConnection()->prepare($query);	

				$sql->execute();

			}catch(Exception $e){
				var_dump($e->getMessage());
				print_r(CartClass::getDbInstance()->getConnection()->errorInfo());
			}
		}
		else{
			
			array_push($errors, implode(", ", $errors_mass));
			require('../php/errors.php');
			
		}
		
	} //end of function AddToCart()

//method that checks available quantity

	function AvailableStockQuantity($product){
		$query = "SELECT ProductName, QuantityAvailable FROM products
		WHERE ProductName='".$product."'
		";
		$sql = CartClass::getDbInstance()->getConnection()->prepare($query);
		$sql->execute();
		$row = $sql->fetch();
		return $row['QuantityAvailable'];

	}

	//method getCartItems to get items in the cart

	function getCartItems(){
		$query = "SELECT * FROM Cart";
		$sql = CartClass::getDbInstance()->getConnection()->prepare($query);

		$sql->execute();
		return array(
			"cartItems" => $sql->fetchAll()
		);

	}
	function getNumberofCartItems(){
		$query = "SELECT COUNT(*) FROM Cart";
		$sql = CartClass::getDbInstance()->getConnection()->prepare($query);
		$sql->execute();
		return $sql->fetchColumn();
	}

	function getPaymentFromCart(){
		$payment_sql = "SELECT SUM(Amount) AS payment From Cart";
		$payment_query = CartClass::getDbInstance()->getConnection()->prepare($payment_sql);
		$payment_query->execute();
		$row = $payment_query->fetch(PDO::FETCH_ASSOC);
		$payment = $row['payment'];
		return $payment;  
	}

	function ClearCart(){
		$sql = CartClass::getDbInstance()->getConnection()->prepare(
			"TRUNCATE TABLE Cart")->execute();
	}

	function RemovePdtFromCart($id){
		$query = "DELETE FROM Cart WHERE ItemId='$id'"; 
		$sql = CartClass::getDbInstance()->getConnection()->prepare($query)->execute();
	}



  // method ConductSale()
	public function ConductSale(){
		$errors = array();
		$CartMaster = new CartClass();
		$product_sold = $qty_sold = $price = $amount = $discount = $cost = "";

		$data = $CartMaster->getCartItems();
		$products = array();
		$dataArray = $data['cartItems'];
		//print_r($dataArray);
		
/*'$product_sold','$qty_sold','$bprice','$price','$amount','$discount','$cost',
'GoodCustomer','$datestamp','$cashier'*/
/**/
	$sql = "INSERT INTO sales(ProductName,Quantity,OriginalPrice,
	Price,Amount,Discount,Cost,Customer,Date,CashierName)
	VALUES(:f1, :f2 , :f3, :f4, :f5, :f6, :f7, :f8, :f9, :f10)";
	$stmt = CartClass::getDbInstance()->getConnection()->prepare($sql);	

if(is_array($dataArray)){
foreach($dataArray as $h) {
	$product_sold = $h[1];
	$qty_sold = $h[2];
	$price = $h[3];
	$amount = $h[4];
	$discount = $h[5];
	$cost = $h[6];
	$bprice = $CartMaster->getBuyingPrice($product_sold);
	date_default_timezone_set("Africa/Kampala");
	$datestamp = date("Y-m-d G:i:s", time());
	$cashier = $_SESSION['username'];
	$customer = "GoodCustomer";

	/*print("product: ".$product_sold." qty:".$qty_sold." price ".$price." amount ".$amount." dicount ".$discount." cost ".$cost."<br>");*/

	$stmtExe = $stmt->execute(
		array('f1' => $product_sold, 'f2' => $qty_sold, 'f3' => $bprice, 'f4' => $price,
			'f5' => $amount, 'f6' => $discount, 'f7' => $cost, 'f8' =>$customer,
			'f9' => $datestamp, 'f10' => $cashier)
	);

	if(!$stmtExe){
		echo "problems!".CartClass::getDbInstance()->errorCode();
	}
	else{
		$qty_before = $CartMaster->getQtyBeforeSale($product_sold);
		$new_quantity = ($qty_before - $qty_sold);
		echo $CartMaster->ReduceStockLevels($product_sold, $new_quantity);  
	}
}
}
      } // end of method ConductSale()
      function getBuyingPrice($product){
      	$sql = "SELECT DISTINCT ProductName,BuyingPrice FROM products 
      	WHERE ProductName ='$product'";
      	$stmt = CartClass::getDbInstance()->getConnection()->prepare($sql);
      	$stmt->execute();
      	$row = $stmt->fetch();
      	$buying_price = $row['BuyingPrice'];
      	return $buying_price;
      }  

      function getQtyBeforeSale($product){
      	$sql = "SELECT ProductName,QuantityAvailable FROM products 
      	WHERE ProductName='".$product."'";
      	$stmt = CartClass::getDbInstance()->getConnection()->prepare($sql);
      	$stmt->execute();
      	$row = $stmt->fetch();
      	$qty = $row['QuantityAvailable'];
      	return $qty;
      }    

      //method ReduceStockLevels()
      public  function ReduceStockLevels($item, $new_qty){

      	try{
      		$reduce_stock = "UPDATE products SET QuantityAvailable='$new_qty' WHERE ProductName='$item'";
      		$deduct_stock_levels = CartClass::getDbInstance()->getConnection()->prepare($reduce_stock);
      		$deduct_stock_exe = $deduct_stock_levels->execute();
          //echo "stock levels updated";
      	}catch(PDOException $ex){
      		echo "failed to reduce stock levels: ".$ex."";
      	}

      } // end of method ReduceStockLevels()



} // end of class Cart()

$errors = array();
$total = $amt = "";



?>
