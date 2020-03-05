<?php
require_once('dbController.inc.php');
require_once('../dompdf/autoload.inc.php');
require_once('hostsys.inc.php');
require_once '../php/shopping-cart.php';


use Dompdf\Dompdf;


class PrintingModule{

  private static $_instance;
  private static $docInstance;

  public static function getDbInstance(){
    if(!self::$_instance){
      self::$_instance = new Database();
    }
    return self::$_instance;
  }

  public static function getPdfInstance(){
    if(!self::$docInstance){
      self::$docInstance = new Dompdf();
    }
    return self::$docInstance;
  }

 function printReceipt($paidAmount, $Balance){
  
  $obj = new RetrievalDbModule();
  $object = new PrintingModule();

  date_default_timezone_set('Africa/Kampala');
  $timenow = date('d/m/Y g:i A');

  try{
   $receipt_contents= "
   <link href='../css/bootstrap.min.css' rel='stylesheet'>
   <link href='../css/style.css' rel='stylesheet'>
   <span>Time:  <span id='time'>$timenow</span></span>
   <h2 id='receipt-title text-center'>ESTHER LTD</h2>
   <h4 class='rec text-center'>RECEIPT</h4>
   <hr class='dotted'></hr>
   <table class='table table-hover ReceiptTable'>
   <tr id='fontfam' class='warning'>
   <th>Item</th>
   <th>Quantity</th>
   <th>UnitPrice</th>
   <th>Total</th> 
   <th>Discount</th>
   <th>Actual cost</th> 
   </tr>
   <tbody class='receiptBody'>
   ";


   $class_obj = new CartClass();
   $the_array = $class_obj->getCartItems();
   $receiptContents = $the_array['cartItems'];
   $payment = $class_obj->getPaymentFromCart();

   foreach($receiptContents as $x){
    $receipt_contents .='
    <tr>
    <td> '.$x[1].'</td>
    <td> '.$x[2].'</td>
    <td> '.$x[3].'</td>
    <td> '.$x[4].'</td>
    <td> '.$x[5].'</td>
    <td> '.$x[6].'</td>
    </tr>
    ';
  }

  $receipt_contents .="

  <tr>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td>
      <span class='total'>Total:</span>
  shs.<span class='amount'>".$payment."</span><br>
      <span class='total'>Paid:</span>
  shs.<span class='total'>".$paidAmount."</span><br>
      <span class='total'>Balance:</span>
  shs.<span class='total'>".$Balance."</span>
  </td>

  </tr>
  </tbody>
  </table>
  <hr class='dotted'></hr>
  <div class='form-inline'>
  <span class='bottom'>Thank you</span>
  <div class='pull-right'>
  <span class='terms'>TERMS AND CONDITIONS</span><br>
  <span>Items once bought are not returnable<span>
  <div>
  <div>
  ";

  PrintingModule::getPdfInstance()->loadHtml($receipt_contents);
  PrintingModule::getPdfInstance()->setPaper('A4','portrait');
  PrintingModule::getPdfInstance()->render();
  PrintingModule::getPdfInstance()->stream("receipt",array("Attachment"=>false));

}catch(Exception $ex){
  echo $ex;
}

    } // end of method printReceipt()



    } // end of class PrintingModule




    ?>
