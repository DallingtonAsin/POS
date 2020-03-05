<?php

class Database{
  // specify your own database credentials
  public $host = "localhost";
  public $db_name = "savershw";
  public $username = "Esther";
  public $password = "Jennifer12";
  public $con;

  // get the database connection

  public function getConnection(){
    $this->con = null;

    try{

      $this->con = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);

      $this->con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

      // $this->con->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);

    }catch(PDOException $exception){

      echo "Connection error: " . $exception->getMessage();

    }
    return $this->con;
  }
}
?>