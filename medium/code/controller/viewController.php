<?php
require_once "services/view.php";
class ViewController{

  public static function viewIndex(){
    return View::createView('index.php', []);  
  }

  public static function viewCustomerList(){
    return View::createView('customerList.php', []);
  }

  public static function viewOnboardCustomer(){
    return View::createView('onboardCustomer.php', []);
  }

  public static function viewLogin(){
    @session_start();
    if(isset($_SESSION['first-name'])){
      header('Location: onboard'); //sudah melakukan login
      return;
    } 
    return View::createAuthView('login.php', []);  
  }

  public static function viewSignup(){
    return View::createAuthView('signup.php', []);  
  }
  
}
?>