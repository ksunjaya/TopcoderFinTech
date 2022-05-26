<?php
// +-----------------+-----------------+------+-----+---------+----------------+
// | Field           | Type            | Null | Key | Default | Extra          |
// +-----------------+-----------------+------+-----+---------+----------------+
// | id              | int(6) unsigned | NO   | PRI | NULL    | auto_increment |
// | name            | varchar(127)    | NO   |     | NULL    |                |
// | email           | varchar(255)    | NO   | UNI | NULL    |                |
// | link            | varchar(255)    | NO   | UNI | NULL    |                |
// | passport_path   | varchar(255)    | YES  |     | NULL    |                |
// | video_path      | varchar(255)    | YES  |     | NULL    |                |
// | passport_number | varchar(30)     | YES  |     | NULL    |                |
// | birth_date      | date            | YES  |     | NULL    |                |
// | nationality     | varchar(50)     | YES  |     | NULL    |                |
// | country         | varchar(50)     | YES  |     | NULL    |                |
// | phone           | varchar(20)     | YES  |     | NULL    |                |
// | occupation      | varchar(40)     | YES  |     | NULL    |                |
// | address         | varchar(127)    | YES  |     | NULL    |                |
// | status          | int(1)          | YES  |     | NULL    |                |
// +-----------------+-----------------+------+-----+---------+----------------+

class Customer{
  public $id, $name, $email, $passport_path, $video_path, $passport_number, $birth_date, $nationality, $country, $phone, $occupation, $address, $status;

  // public function __construct($id, $name, $email, $passport_path, $video_path, $passport_number, $birth_date, $nationality, $country, $phone, $occupation, $address, $status){
  //   $this->id = $id;
  //   $this->name = $name;
  //   $this->email = $email;
  //   $this->passport_path = $passport_path;
  //   $this->video_path = $video_path;
  //   $this->passport_number = $passport_number;
  //   $this->birth_date = $birth_date;
  //   $this->nationality = $nationality;
  //   $this->country = $country;
  //   $this->phone = $phone;
  //   $this->occupation = $occupation;
  //   $this->address = $address;
  //   $this->status = $status;
  // }

  public function __construct($id, $name, $email, $status)
  { 
    $this->id = $id;
    $this->name = $name;
    $this->email = $email;
    $this->status = $status;
  }
}

?>