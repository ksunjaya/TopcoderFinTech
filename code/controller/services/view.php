<?php

class View {

    public static function createView ($view, $param)
    {
        foreach ($param as $key => $value)
        {
            $$key = $value;
        }

        ob_start();
        include 'view/pages/'.$view;
        $content = ob_get_contents();
        ob_end_clean();
        
        ob_start();
        include 'view/layout/layout.php';
        $include = ob_get_contents();
        ob_end_clean();
        return $include;
    }

    public static function createDashboard ($view, $param)
    {
        foreach ($param as $key => $value)
        {
            $$key = $value;
        }

        ob_start();
        include 'view/components/table.php';
        $table = ob_get_contents();
        ob_end_clean();
        
        ob_start();
        include 'view/layout/dashboard_layout.php';
        $include = ob_get_contents();
        ob_end_clean();
        return $include;
    }
}
?>