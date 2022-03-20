<?php
require_once "services/view.php";
class viewController{

  public static function viewIndex(){
    return View::createView('index.php', []);  
  }

}
?>