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
            case $baseURL.'/customer-list':
                require_once "controller/viewController.php";
                echo ViewController::viewCustomerList();
                break;
            case $baseURL.'/login':
                require_once "controller/viewController.php";
                echo ViewController::viewLogin();
                break;
            case $baseURL.'/signup':
                require_once "controller/viewController.php";
                echo ViewController::viewSignup();
                break;
            case $baseURL.'/new-customer':
                require_once "controller/viewController.php";
                echo ViewController::viewNewCustomer();
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
                if($result == true) header("Location: login?status=1"); //login status = 1 artinya berhasil registrasi
                else                header("Location: signup?status=1"); //signup status = 1 artinya gagal, email udah diambil
                break;
            case $baseURL.'/login':
                require_once "controller/clientController.php";
                require_once "controller/viewController.php";
                $clientController = new ClientController();
                $result = $clientController->loginUser();
                if($result == true) header("Location: customer-list");
                else                header("Location: login?status=2"); //status = 2 artinya gagal login
                break;
            case $baseURL.'/logout':
                session_start();
                session_unset();
                session_destroy();
                header("Location: login");
                break;
            case $baseURL.'/send-onboard':
                require_once "controller/customerController.php";
                $customerController = new CustomerController();
                echo $customerController->createNewUser();
                break;
            default :
                echo '404 not found';
                break;
        }
    }

?>