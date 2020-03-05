<?php

session_start();
unset($_SESSION['username']);
unset($_SESSION['56-90-2332-uniquecode']);
unset($_SESSION['56-89-2333-uniquecode']);
$url = "../index.php";

if(isset($_GET['session_expired'])){
  $session_selector =$_GET['session_expired'];
  $url .= "?session_expired='".$session_selector."'";
  header("location:$url");
}

?>
