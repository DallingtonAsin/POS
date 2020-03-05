<?php
/*
require_once('../dompdf/autoload.inc.php');
require_once('dbh.inc.php');
use Dompdf\Dompdf;

$document = new Dompdf();

if(isset($_GET['PrintReceipt'])){

 $sales = mysqli_query($con,"SELECT * FROM sales");        
 $sales_generated= "
 <link href='../css/bootstrap.min.css' rel='stylesheet'>
 <link href='../css/style.css' rel='stylesheet'>
 <link href='../css/custom_downloads.css' rel='stylesheet'>
 <h3 class='title'>".CompanyName."</h3>
 <h4 id='subsequent'>
 <span style='font-size:300%;color:yellow;'>&#9733;</span>
<span style='font-size:500%;color:red;'>&#9733;</span>
<span style='font-size:500%;color:blue;'>&#9733;</span>

 Receipt</h4>
 <table class='table table-striped table-hover'>
 <tr id='fontfam' class='warning'>

 <th>Product</th>
 <th>Quantity</th>
 <th>price</th>
 <th>Discount</th>
 <th>cost</th>

 </tr>
 ";

 if(mysqli_num_rows($sales)>0){
   while ($row = mysqli_fetch_array($sales)) {
    $date = date('d-m-y', strtotime($row["Date"]));

    $sales_generated .='
    <tr>
  
    <td> '.$row["ProductName"].'</td>
    <td> '.$row["Quantity"].'</td>
    <td> '.$row["Price"].'</td>
    <td> '.$row["Discount"].'</td>
    <td> '.$row["Customer"].'</td>
    
    </tr>

    ';


  }
  $sales_generated .='
        <hr class="style6"><br>
        <span id="bigthanks">Thank you and come again!</span>

                       ';
}

$sales_generated .='</table';
$document->loadHtml($sales_generated);

$document->setPaper('A6','landscape');
$document->render(); 
$document->stream("sales",array("Attachment"=>0));
}
*/


?>