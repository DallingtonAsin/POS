<?php

require_once('dbController.inc.php');

class DataMaster{

  public function AuthenticateUsers(){
    global $errors;
    session_start();
define('login_session_duration',3000); // 50 minutes
$username = $password =  $who = "";
$errors = array();

$dbConn = new Database();

if($_SERVER['REQUEST_METHOD']=="POST"){
  if(isset($_POST['submit'])){

    $who = $_POST["who"];

    if(isset($_POST['username'])){
      $username = $_POST['username'];
    }
    if(isset($_POST['password'])){
      $password =$_POST['password'];
    }
    
    if(empty($username)){
      array_push($errors, "username is required");
    }

    if(empty($password)){
      array_push($errors, "password is required");
    }

    if(count($errors)==0){

      //Authenticate Managers    
      if($who=="Manager"){
        $query = "SELECT * FROM administrators WHERE Username = :username LIMIT 1";
        $stmt = $dbConn->getConnection()->prepare($query);
        $stmt->execute(
          array("username" => $username)
        );
        $count = $stmt->rowCount();

        if($count > 0){
         $rows =$stmt->fetch();
         if(password_verify($password, $rows['Password'])){
          $name = $rows['Username'];
          $_SESSION['56-90-2332-uniquecode'] = uniqid();
          $_SESSION['username'] = $name;
          $_SESSION['Group'] = 'Manager';
          $_SESSION['manager_loggedin_time'] = time();
          header("location:../savers-hardware.net/56-90-2332/main.php");
        }
        else{
          array_push($errors, "Invalid username or password,please try again!");
        }
      }
   } // end of an if block for the manager

  // Authenticate Cashiers
   elseif($who=="Cashier"){
    $query = "SELECT CashierName,Password FROM cashiers WHERE CashierName= :username LIMIT 1";
    $stmt = $dbConn->getConnection()->prepare($query);
    $stmt->execute(
      array('username' => $username)
    );
    $count = $stmt->rowCount();

    if($count > 0){
     $row = $stmt->fetch();
     if(password_verify($password, $row['Password'])){
      $name = $row['CashierName'];
      $_SESSION['username'] = $name;
      $_SESSION['Group'] = 'Cashier';
      $_SESSION['56-89-2333-uniquecode'] = uniqid();
      $_SESSION['cashier_loggedin_time'] = time();
      header("location:../savers-hardware.net/56-89-2333/dashboard.php");
    }
    else{
      array_push($errors, "Invalid username or password,please try again!");
    }
  }

      }// end of an elseif block  for the cashier


    } // end of an if block for count(($errors)==0)

    else{
      require('errors.php');
    }

  } // end of if block for action on submit button

} // end of an if block for the POST check method

  } // end of function AuthenticateUsers()


//method that checks whether the session for users is expired or not
  function isLoginSessionExpired(){
    $h = new DataMaster();
    if (isset($_SESSION['56-90-2332-uniquecode'])) {
      if($h->isManagerLoginSessionExpired()){
        header("location:../php/logout.php?session_expired='1'");
      }
    }

    if (isset($_SESSION['56-89-2333-uniquecode'])) {
      if($h->isCashierLoginSessionExpired()){
        header("location:../php/logout.php?session_expired='1'");
      }
    }
  }



//function isManagerLoginSessionExpired() checks manager's session timeout
  function isManagerLoginSessionExpired(){
    $current_time = time();
    if(isset($_SESSION['manager_loggedin_time']) && isset($_SESSION['56-90-2332-uniquecode'])){
      if($current_time - $_SESSION['manager_loggedin_time'] > 3000 ){
        return true;
      }else{
        return false;
      }
    }
  }

//function isCashierLoginSessionExpired() checks cashier's session timeout
  function isCashierLoginSessionExpired(){
    $current_time = time();
    if(isset($_SESSION['cashier_loggedin_time']) && isset($_SESSION['56-89-2333-uniquecode'])){
      if($current_time - $_SESSION['cashier_loggedin_time'] > 3000 ){
        return true;
      }else{
        return false;
      }
    }
  }
} // end of class DataMaster


$obj = new DataMaster();
echo $obj->AuthenticateUsers();
echo $obj->isLoginSessionExpired();

//Action taken if logout button is clicked by the manager
if(isset($_GET['56-90-2332-logout'])){
  session_destroy();
  unset($_SESSION['username']);
  unset($_SESSION['56-90-2332-uniquecode']);
  header("location:../index.php");
}


//Action taken if logout button is clicked by the cashier
if(isset($_GET['56-89-2333-logout'])){
  session_destroy();
  unset($_SESSION['56-89-2333-uniquecode']);
  unset($_SESSION['username']);
  header("location:../index.php");
}
?>