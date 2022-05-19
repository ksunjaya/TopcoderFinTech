<?php
require_once "services/mySQLDB.php";
require_once "services/QueryBuilder/Builder.php";
class ClientController{
  
  protected $db, $builder;
  protected $h, $client;
  public function __construct(){
    $this->db = new MySQLDB();

    $connection = new PDO('mysql:host=localhost;dbname=fintech;charset=utf8', 'root', '');
    $this->h = new \ClanCats\Hydrahon\Builder('mysql', function($query, $queryString, $queryParameters) use($connection)
    {
        $statement = $connection->prepare($queryString);
        $statement->execute($queryParameters);

        // when the query is fetchable return all results and let hydrahon do the rest
        // (there's no results to be fetched for an update-query for example)
        if ($query instanceof \ClanCats\Hydrahon\Query\Sql\FetchableInterface)
        {
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        }
        // when the query is a instance of a insert return the last inserted id  
        elseif($query instanceof \ClanCats\Hydrahon\Query\Sql\Insert)
        {
            return $connection->lastInsertId();
        }
        // when the query is not a instance of insert or fetchable then
        // return the number os rows affected
        else 
        {
            return $statement->rowCount();
        }	
    });

    $this->client = $this->h->table('client');
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
    $password = password_hash($password, PASSWORD_DEFAULT); //encrypt 
    
    //cek dulu apakah email nya sudah terdaftar atau belum
    if($this->isEmailRegistered($email)) return false;

    //ambil nama depan dan nama belakang.
    $array_of_names = explode(' ', $name, 2);
    $first_name = $array_of_names[0];
    $last_name = $array_of_names[1];
    //jalanin query
    $this->client->insert([
                  'first_name' => $first_name,
                  'last_name' => $last_name,
                  'email' => $email,
                  'password' => $password
                  ])->execute();

    return true;
  }

  /**
   * Cek apakah email nya sudah ada di database atau belum
   * @param email $email yang bakal di cek
   * 
   * @return true kalau email sudah terdaftar, false otherwise
   */
  private function isEmailRegistered($email){
    $query_result = $this->client->select()
            ->where('email', $email)
            ->get();

    if(sizeof($query_result) == 0) return false;
    else return true;
  }

  //==LOGIN POST==
  public function loginUser(){
    $email = $this->db->escapeString($_POST['email']);
    $password = $this->db->escapeString($_POST['password']);

    $query_result = $this->client->select()
            ->where('email', $email)
            ->get();
    
    //echo $password . '<br>';

    if(sizeof($query_result) == 0){
      echo 'email tidak ditemukan!';
      return false;
    }
    //echo 'Password yang ada di db : ' . $query_result[0]['password'] . '<br>';

    if(password_verify($password, $query_result[0]['password'])){
      session_start();
      $_SESSION["first-name"] = $query_result[0]['first_name'];
      $_SESSION["last-name"] = $query_result[0]['last_name'];
      return true;
    }else{
      echo 'password salah!';
      return false;
    }
  }
}

?>