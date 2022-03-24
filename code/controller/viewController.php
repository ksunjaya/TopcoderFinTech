<?php
require_once "services/view.php";
class viewController{

  public static function viewIndex(){
    return View::createView('index.php', []);  
  }

  public static function viewLogin(){
    return View::createView('login.php', []);  
  }

  public static function viewRegister(){
    return View::createView('register.php', []);  
  }
}
?>