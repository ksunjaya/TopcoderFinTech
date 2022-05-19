<?php

class View {

    public static function createView ($view, $param)
    {
        foreach ($param as $key => $value)
        {
            $$key = $value;
        }
        
        //cek dulu apakah client sudah melakukan login atau belum
        @session_start();
        if(!isset($_SESSION['first-name'])) header("Location: login?status=3"); //3 = harap melakukan login terlebih dahulu
        
        ob_start();
        include 'view/'.$view;
        $content = ob_get_contents();
        ob_end_clean();
        
        ob_start();
        include 'view/layout/layout.php';
        $include = ob_get_contents();
        ob_end_clean();
        return $include;
    }

    public static function createAuthView ($view, $param){
        foreach ($param as $key => $value)
        {
            $$key = $value;
        }

        ob_start();
        include 'view/'.$view;
        $content = ob_get_contents();
        ob_end_clean();

        ob_start();
        include 'view/layout/authLayout.php';
        $include = ob_get_contents();
        ob_end_clean();

        return $include;
    }
}
?>