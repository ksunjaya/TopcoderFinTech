<?php
require 'vendor/autoload.php';
require_once "services/mySQLDB.php";
require_once "services/randomStringGenerator.php";

class CustomerController{
  protected $db, $builder;
  protected $h, $customer;
  protected $mail;

  public function __construct(){
    $this->db = new MySQLDB();
    $this->initMailer();

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
    $post = json_decode(file_get_contents('php://input'), true);
    $name = $post['name'];
    $email = $post['email'];
    //data cleaning:
    $name = $this->db->escapeString($name);
    $email = $this->db->escapeString($email);
    
    $result = array();
    //cek dulu apakah email nya sudah terdaftar atau belum
    if($this->isEmailRegistered($email)){
      $result['result'] = false;
      $result['msg'] = "Email has already been registered.";
      return json_encode($result);
    } 

    //bikin url random nya
    $link = $this->generateURL();

    //jalanin query
    $this->customer->insert([
                  'name' => $name,
                  'email' => $email,
                  'link' => $link
                  ])->execute();
      
    $status = $this->sendEmail($email, $name, $link);
    if($status == true) {
      $result['result'] = true;
      $result['email'] = $email;
    }else{
      $result['result'] = false;
      $result['msg'] = $status;
    }
    return json_encode($result);
  }

  public function isLinkRegistered($link){
    $link = $this->db->escapeString($link);
    $query_result = $this->customer->select()
            ->where('link', $link)
            ->get();

    if(sizeof($query_result) == 0) return false;
    else return true;
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

  private function initMailer(){
    $ini_array = parse_ini_file("properties.ini");
    $this->mail = new PHPMailer\PHPMailer\PHPMailer();
    $this->mail->IsSMTP();
    $this->mail->Mailer = "smtp";
    //$this->mail->SMTPDebug  = 1;  
    $this->mail->SMTPAuth   = TRUE;
    $this->mail->SMTPSecure = "tls";
    $this->mail->Port       = 587;
    $this->mail->Host       = "smtp.gmail.com";
    $this->mail->Username   = $ini_array['email-username'];
    $this->mail->Password   = $ini_array['email-password'];
    //untuk bypass ssl, ga rekomen pisan.
    $this->mail->SMTPOptions = [
      'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true,
      ]
    ];
  }

  private function sendEmail($recipient, $name, $url){
    //get web url information
    $baseURL = $_SERVER['REQUEST_URI']; 
    $baseURL = dirname($baseURL);
    
    try{
      $this->mail->IsHTML(true);
      $this->mail->AddAddress($recipient, $name);
      $this->mail->SetFrom("proyek.informatika.c@gmail.com", "fintech-no-reply");
      $this->mail->Subject = "Authentication Registration Link";
      $content = "Hello " . $name . ", click the link below to complete registration.<br>"
                ."<a href='localhost".$baseURL."/new-customer?link=".$url."'>Registration Link</a>";
      $this->mail->Body = $content;

      $this->mail->send();
      return true;
    }catch(Exception $e){
      return "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
    }
  }
}
?>