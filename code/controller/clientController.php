<?php
require_once "services/mySQLDB.php";
class ClientController{
  
  protected $db;
  public function __construct(){
    $this->db = new MySQLDB();
  }

  //dipanggil dari method POST, return TRUE kalau berhasil masukin data ke db.
  public function createNewUser(){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    //data cleaning:
    $name = $this->db->escapeString($name);
    $email = $this->db->escapeString($email);
    $password = $this->db->escapeString($password);
    //ambil nama depan dan nama belakang.
    $array_of_names = explode(' ', $name, 2);
    $first_name = $array_of_names[0];
    $last_name = $array_of_names[1];
    //jalanin query
    $query = 'INSERT INTO client(first_name, last_name, email, password)
              VALUES("' . $first_name . '", "' . $last_name . '", "' . $email . '", PASSWORD("' . $password . '"))';
    $query_result = $this->db->executeNonSelectQuery($query);
    
    return $query_result;
  }

  //==LOGIN POST==
  public function loginUser(){
    $email = $this->db->escapeString($_POST['email']);
    $password = $this->db->escapeString($_POST['password']);

    $result = 'SELECT first_name, last_name
    FROM client
    WHERE email="'.$email.'" AND password=PASSWORD("'.$password.'")';
    $query_result = $this->db->executeSelectQuery($result);
    if(sizeof($query_result) > 0) {
      //pasang session
      session_start();
      $_SESSION["first-name"] = $query_result[0]['first_name'];
      $_SESSION["last-name"] = $query_result[0]['last_name'];
      return true;
    }
    else return false;
  }
}

?>