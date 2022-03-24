<?php 
    $url = $_SERVER['REDIRECT_URL'];
    $baseURL = $_SERVER['REQUEST_URI']; 
    $baseURL = dirname($baseURL);

    if($_SERVER["REQUEST_METHOD"] == "GET"){
        switch($url){
            case $baseURL.'/index':
                require_once "controller/viewController.php";
                $idxCtrl = new viewController();
                echo $idxCtrl->viewIndex();
                break;
            case $baseURL.'/login':
                require_once "controller/viewController.php";
                $idxCtrl = new viewController();
                echo $idxCtrl->viewLogin();
                break;
            case $baseURL.'/signup':
                require_once "controller/viewController.php";
                $idxCtrl = new viewController();
                echo $idxCtrl->viewRegister();
                break;
            default :
                echo '404 not found';
                break;
        }

    //sementara tidak butuh post krn cuma ganti" page aja    
    }else if($_SERVER["REQUEST_METHOD"] == "POST"){
        switch($url){
            default :
                echo '404 not found';
                break;
        }
    }

?>