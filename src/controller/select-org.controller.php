<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/SessionVariable.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/Path.php';

    $set_session = new SessionVariable();
    $path = new Path();

    // print("<br><br>post data in select-org controller <pre>".print_r($_POST,true)."</pre>");

    if (isset($_POST['org_uuid'])) {

        //check if user joined the org
        if ($set_session->verifty_joined_org($_POST['org_uuid'], true)) {
            // print("<br><br>session class<pre>".print_r($set_session,true)."</pre>");
            // print("<br><br>session variable<pre>".print_r($_SESSION,true)."</pre>");

            //if users has the permission to view admin dashbaord then rediect them to admin dashbaord
            //if users has the permission to view admin volunteer then rediect them to volunteer dashbaord
            if ($set_session->check_permission(['view admin dashboard'])) {
                //echo "admin";
                header("Location: " . $path->pageURL . "/dashboard-framework-v1/src/view/dashboard-admin.view.php");
            } elseif ($set_session->check_permission(['view volunteer dashboard'])) {
                //echo "volunteer";
                header("Location: " . $path->pageURL . "/dashboard-framework-v1/src/view/dashboard-volunteers.view.php");
            } elseif (!$set_session->check_permission()) {
                $set_session->destory_session();
                header("Location: " . $path->pageURL . "/dashboard-framework-v1/src/view/login.view.php?permission");
            }
            
        } else {
            $set_session->destory_session();
            header("Location: " . $path->pageURL . "/dashboard-framework-v1/src/view/login.view.php?wrongOrg");
        }

    } else {
        header("Location: " . $path->pageURL . "/dashboard-framework-v1/src/controller/logout.controller.php");
    }
?>