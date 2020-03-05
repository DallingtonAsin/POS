<?php
require_once('dbController.inc.php');
require_once('../dompdf/autoload.inc.php');
require_once('hostsys.inc.php');
/*header("Content-disposition: attachment;filename=test.php");
header("Content-type:application/pdf");
readfile('test.php');*/


use Dompdf\Dompdf;

class classcontrol{

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




  function printReceipt($receiptContents){
    // print_r($receiptContents);
    $obj = new RetrievalDbModule();
    date_default_timezone_set('Africa/Kampala');
    $timenow = date('d/m/Y G:i A');
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

     foreach($receiptContents as $x){
      $receipt_contents .='
      <tr>
      <td> '.$x[0].'</td>
      <td> '.$x[1].'</td>
      <td> '.$x[2].'</td>
      <td> '.$x[3].'</td>
      <td> '.$x[4].'</td>
      <td> '.$x[5].'</td>
      </tr>
      ';
    }

    $receipt_contents .="

    <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>Total:</td>
    <td>shs.5000</td>
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
    classcontrol::getPdfInstance()->loadHtml($receipt_contents);

    classcontrol::getPdfInstance()->setPaper('A4','portrait');
    classcontrol::getPdfInstance()->render();
    classcontrol::getPdfInstance()->stream("receipt",array("Attachment"=>0));
  }catch(Exception $ex){
    echo $ex;
  }
    } // end of method downloadSales()

    } // end of class classcontrol

//if(isset($_REQUEST['Transact'])){
   //  $data = $_POST['ContentsArray'];
      //echo $class->printReceipt($data); 
 //}
  /* if(isset($_REQUEST['Transaction'])){
       $class = new classcontrol();
       $sold1 = array("sugar","10","3000","4500","5","7000");
       $sold2 = array("salt","11","4000","5500","6","8000");
       $sold3 = array("cheese","12","5000","6500","7","9000");
       $array = array($sold1,$sold2,$sold3);
       print_r($array) ;
      // echo $class->printReceipt($array);  
     }*/
     $class = new classcontrol();
     //if(isset($_REQUEST['Transaction'])){
    //require('../56-89-2333/conductsale.php');
     /* $tbody ="
      <table>
      <tbody>

      <tr>
      <td>salt</td>
      <td>5</td>
      <td>2000</td>
      <td>10000</td>
      <td>10</td>
      <td>9000</td>
      </tr>
      <tr>
      <td>rice</td>
      <td>2</td>
      <td>7000</td>
      <td>14000</td>
      <td>5</td>
      <td>10000</td>
      </tr>
      <tr>
      <td>cheese</td>
      <td>5000</td>
      <td>4</td>
      <td>20000</td>
      <td>8</td>
      <td>16000</td>
      </tr>
      <tr>
      <td>meat</td>
      <td>10</td>
      <td>10000</td>
      <td>100000</td>
      <td>5</td>
      <td>80000</td>
      </tr>

      </tbody>
      </table>
      ";*/
/*      $dom =  new domDocument;
      $dom->loadHtml($tbody);
      $rowArray = array();
      $dom->preserveWhiteSpace = false;
      $tables = $dom->getElementsByTagName('table');
      $rows = $tables->item(0)->getElementsByTagName('tr');
     // $rowCount = count($rows);
      
      foreach($rows as $row){  
        $cols = $row->getElementsByTagName('td');
        $product = $cols->item(0)->nodeValue;
        $qty = $cols->item(1)->nodeValue;
        $unit = $cols->item(2)->nodeValue;
        $total = $cols->item(3)->nodeValue;
        $discount = $cols->item(4)->nodeValue;
        $amount = $cols->item(5)->nodeValue;
        array_push($rowArray ,array($product,$qty,$unit,$total,$discount,$amount));
        

      }
    //print_r($rowArray);
      echo $class->printReceipt($rowArray); */

   // }



    // echo foo::bar(); if bar() is a static method
    ?>
