<?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/Path.php';
    header("Location: " . (new Path())->pageURL . "/dashboard-framework-v1/src/view/login.view.php");
?>