<?php
require 'vendor/autoload.php';
require_once "services/mySQLDB.php";
require_once "services/randomStringGenerator.php";

class CustomerController{
  protected $db, $builder;
  protected $h, $customer;
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

    $this->customer = $this->h->table('customer');
  }

  //dipanggil dari method POST, return TRUE kalau berhasil masukin data ke db.
  public function createNewUser(){
    $name = $_POST['name'];
    $email = $_POST['email'];
    //data cleaning:
    $name = $this->db->escapeString($name);
    $email = $this->db->escapeString($email);
    
    //cek dulu apakah email nya sudah terdaftar atau belum
    if($this->isEmailRegistered($email)) return false;

    //bikin url random nya
    $link = $this->generateURL();

    //jalanin query
    $this->client->insert([
                  'name' => $name,
                  'email' => $email,
                  'link' => $link
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
    $query_result = $this->customer->select()
            ->where('email', $email)
            ->get();

    if(sizeof($query_result) == 0) return false;
    else return true;
  }

  private function isURLRegistered($url){
    $query_result = $this->customer->select()
            ->where('link', $url)
            ->get();

    if(sizeof($query_result) == 0) return false;
    else return true;
  }

  private function generateURL(){
    $rng = new RandomStringGenerator();
    $url = "";
    do{
      $url = $rng->generate(30);
    }while($this->isURLRegistered($url));

    return $url;
  }
}
?>