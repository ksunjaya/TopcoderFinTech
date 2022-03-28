<?php
require_once "services/view.php";
class ViewController{

  public static function viewIndex(){
    return View::createView('index.php', []);  
  }

  public static function viewOnboard(){
    return View::createView('onboard.php', []);
  }

  public static function viewLogin(){
   
    return View::createAuthView('login.php', []);  
  }

  public static function viewSignup(){
    return View::createAuthView('signup.php', []);  
  }
  
}
?>