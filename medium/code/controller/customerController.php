<?php
require 'vendor/autoload.php';
require_once "services/mySQLDB.php";
require_once "services/randomStringGenerator.php";
require_once "model/customer.php";

class CustomerController{
  protected $db, $builder;
  protected $h, $customer;
  protected $mail;
  private $hostname;

  public function __construct(){
    $this->db = new MySQLDB();
    $ini_array = parse_ini_file("properties.ini");
    $this->hostname = $ini_array['hostname'];
    $this->initMailer();

    $servername = $ini_array['servername'];
    $dbname = $ini_array['dbname'];
    $username = $ini_array['username'];
    $password = $ini_array['password'];
    $connection = new PDO('mysql:host='.$servername.';dbname='.$dbname.';charset=utf8', $username, $password);
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
                  'link' => $link,
                  'status' => 0
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
  
  //handle link yang dikasih ke user di email.
  public function registerCustomer(){
    $passport_number = $this->db->escapeString($_POST['passport-number']);
    $dob = $this->db->escapeString($_POST['dob']);
    $nationality = $this->db->escapeString($_POST['nationality']);
    $cor = $this->db->escapeString($_POST['cor']);
    $phone_number = $this->db->escapeString($_POST['phone-number']);
    $occupation = $this->db->escapeString($_POST['occupation']);
    $curr_addr = $this->db->escapeString($_POST['curr-addr']);
    $userid = $this->db->escapeString($_POST['cust-id']);
    //result:
    $result = array();
    //urus upload files dulu
    mkdir(dirname(__DIR__).'\\uploads\\'.$userid);
    $s_passport = $this->uploadFile('passport-img', $userid);
    if($s_passport == NULL) {
      $result['status'] = false;
      $result['msg'] = 'Passport upload failed.';
      return json_encode($result);
    }
    $s_video = $this->uploadFile('video', $userid);
    if($s_video == NULL){
      $result['status'] = false;
      $result['msg'] = 'Video upload failed.';
      return json_encode($result);
    }
    //urus db
    $this->customer->update()
      ->set([
        'passport_path' => $s_passport,
        'video_path' => $s_video,
        'passport_number' => $passport_number,
        'birth_date' => $dob,
        'nationality' => $nationality,
        'country' => $cor,
        'phone' => $phone_number,
        'occupation' => $occupation,
        'address' => $curr_addr,
        'status' => 1
      ])
      ->where('id', $userid)
    ->execute();

    //$result = array();
    $result['status'] = true;
    return json_encode($result);
  }

  public function getAll($name_filter = NULL){
    if($name_filter == NULL) 
      $name_filter = "";
    $name_filter = $this->db->escapeString($name_filter);
    $query_result = $this->customer->select(['id', 'name', 'email', 'status'])
                        ->where('name', 'like', '%'.$name_filter.'%')
                        ->get();
    $result = array();
    for($i = 0; $i < sizeof($query_result); $i++){
      $result[] = new Customer($query_result[$i]['id'], $query_result[$i]['name'], $query_result[$i]['email'], $query_result[$i]['status']);
    }
    return $result;
  }

  //AJAX 
  public function getDetailsFromId(){
    $id = $this->db->escapeString($_GET['id']);
    $query_result = $this->customer->select()
                      ->where('id', $id)
                      ->get();
    return json_encode($query_result[0]);
  }

  public function uploadFile($name, $userid){
    $destination = dirname(__DIR__).'/uploads/'.$userid.'/';
    if($_FILES[$name]['name'] != ""){
      $oldname = $_FILES[$name]['tmp_name'];
      $newname = $destination.$_FILES[$name]['name'];
      if(move_uploaded_file($oldname, $newname)){
        return $newname;
      }else return NULL;
    }else return NULL;
  }

  public function isLinkRegistered($link){
    $link = $this->db->escapeString($link);
    $query_result = $this->customer->select()
            ->where('link', $link)
            ->where('status', 0)
            ->get();

    if(sizeof($query_result) == 0) return NULL;
    else return $query_result[0]['id'];
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
      $content = "Hello ".$name."!,
      <br><br>
      Thank you for registering to our Fintech Website!
      <br><br>
      First of all, we need a little more  information about you 
      so you can use our website smoothly.
      <br><br>
      Please click the link to complete your registration:
      <a href='".$this->hostname.$baseURL."/new-customer?link=".$url."'>Registration Link</a>
      <br><br>
      Thank you for being a part of our Fintech community!
      <br><br>
      Best Regards, 
      Fintech team
      <br>
      NB:
      if it wasn't you, please ignore this email";
      $this->mail->Body = $content;

      $this->mail->send();
      return true;
    }catch(Exception $e){
      return "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
    }
  }
}
?>