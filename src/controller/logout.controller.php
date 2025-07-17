<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/SessionVariable.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/Path.php';
    
    $set_session = new SessionVariable();

    if ($set_session->destory_session()) {
        header("Location: " . $path->pageURL . "/dashboard-framework-v1/src/view/login.view.php");
    }
?>