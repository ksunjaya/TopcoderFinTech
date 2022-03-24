<?php
require_once "services/view.php";
class viewController{

  public static function viewIndex(){
    return View::createView('login.php', []);  
  }

  public static function viewDashboard(){
    return View::createDashboard('',[]);

  public static function viewLogin(){
    return View::createAuthView('login.php', []);  
  }

  public static function viewRegister(){
    return View::createAuthView('signup.php', []);  
  }
  
}
?>