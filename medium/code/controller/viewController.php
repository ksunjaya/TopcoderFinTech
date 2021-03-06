<?php
require_once "services/view.php";
class ViewController{

  public static function viewIndex(){
    header('Location: login');
  }

  public static function viewCustomerList(){
    require_once 'controller/customerController.php';
    $cc = new CustomerController();
    if(isset($_GET['c-name']) && $_GET['c-name'] != ''){
      $customer_list = $cc->getAll($_GET['c-name']);
    }
    $customer_list = $cc->getAll();

    return View::createView('customerList.php', [
      'customer_list' => $customer_list
    ]);
  }

  public static function viewLogin(){
    @session_start();
    if(isset($_SESSION['first-name'])){
      header('Location: customer-list'); //sudah melakukan login
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
    $custId = $cc->isLinkRegistered($_GET['link']);
    if($custId != NULL){
      return View::createNewCustomerView('newCustomer.php', [
        'id' => $custId
      ]); 
    }else{
      return View::createNewCustomerView('newCustomerError.php', [
        'message' => "Your registration link is invalid. Please contact our customer support if you believe this is a mistake."
      ]);
    }
  }

  public static function viewNewCustomerSuccess(){
    return View::createNewCustomerView('newCustomerSuccess.php', []);
  }
  
}
?>