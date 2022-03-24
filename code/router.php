<?php 
    $url = $_SERVER['REDIRECT_URL'];
    $baseURL = $_SERVER['REQUEST_URI']; 
    $baseURL = dirname($baseURL);

    if($_SERVER["REQUEST_METHOD"] == "GET"){
        switch($url){
            case $baseURL.'/index':
                require_once "controller/viewController.php";
                echo ViewController::viewIndex();
                break;
            case $baseURL.'/onboard':
                require_once "controller/viewController.php";
                echo ViewController::viewOnboard();
                break;
            case $baseURL.'/login':
                require_once "controller/viewController.php";
                echo ViewController::viewLogin();
                break;
            case $baseURL.'/signup':
                require_once "controller/viewController.php";
                echo ViewController::viewSignup();
                break;
            default :
                echo '404 not found';
                break;
        }

    //sementara tidak butuh post krn cuma ganti" page aja    
    }else if($_SERVER["REQUEST_METHOD"] == "POST"){
        switch($url){
            case $baseURL.'/signup':
                require_once "controller/clientController.php";
                $clientController = new ClientController();
                $result = $clientController->createNewUser();
                if($result == true) echo 'BERHASIL!'; //sementara aja, TO BE DELETED
                else echo 'GAGAL!';
                break;
            default :
                echo '404 not found';
                break;
        }
    }

?>