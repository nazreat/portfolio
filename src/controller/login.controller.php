<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/SessionVariable.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/Path.php';
    $set_session = new SessionVariable();
    $path = new Path();

    $set_session->start_session();

    if (isset($_POST["email"]) && $_POST["password"]) {
        //check if username and password are correct
        if ($set_session->authenticate($_POST["email"], $_POST["password"])) {
            $set_session->set_sessions_properties();
            print("<pre>".print_r($set_session,true)."</pre>");
            if (empty($set_session->org_ids)) {
                if (isset($set_session->current_org_id)) {
                    print("<pre>session variable: ".print_r($_SESSION,true)."</pre>");

                    //if users has the permission to view admin dashbaord then rediect them to admin dashbaord
                    //if users has the permission to view admin volunteer then rediect them to volunteer dashbaord
                    if ($set_session->check_permission(['view admin dashboard'])) {
                        echo "admin";
                        header("Location: " . $path->pageURL . "/dashboard-framework-v1/src/view/dashboard-admin.view.php");
                    } elseif ($set_session->check_permission(['view volunteer dashboard'])) {
                        echo "volunteer";
                        header("Location: " . $path->pageURL . "/dashboard-framework-v1/src/view/dashboard-volunteers.view.php");
                    }

                }
            }

            
            header("Location: " . $path->pageURL . "/dashboard-framework-v1/src/view/org-list.view.php");
        } else {
            echo "Wrong username or password<br><br>";
            
            // print("ENV<pre>".print_r(getenv(),true)."</pre>");
            header("Location: " . $path->pageURL . "/dashboard-framework-v1/src/view/login.view.php?wrongDetails");
        }
    } elseif (isset($_POST["email"]) || $_POST["password"]) {
        echo "Missing username or password<br><br>";
        header("Location: " . $path->pageURL . "/dashboard-framework-v1/src/view/login.view.php?missingDetails");  
    } else {
        header('Location: ' . $path->pageURL . '/dashboard-framework-v1/src/controller/logout.controller.php');
    }
    


?>