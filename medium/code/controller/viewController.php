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

  public static function viewNewCustomer(){
    if(!isset($_GET['link'])){
      return View::createNewCustomerView('newCustomerError.php', [
        'message' => "Customer link is not defined. Make sure you've clicked the right link on your email."
      ]);
    }
    require_once 'controller/customerController.php';
    $cc = new CustomerController();
    if($cc->isLinkRegistered($_GET['link'])){
      return View::createNewCustomerView('newCustomer.php', []); 
    }else{
      return View::createNewCustomerView('newCustomerError.php', [
        'message' => "Your registration link is invalid. Please contact our customer support if you believe this is a mistake."
      ]);
    }
  }
  
}
?>