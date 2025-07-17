<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/SessionVariable.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/Path.php';

  class OrgListSession extends SessionVariable {
      
      public function __construct()
      {
        $path = new Path();
        $this->start_session();

        // print("<pre>".print_r($_SESSION,true)."</pre>");

        if ($this->authorise()) {

          $this->set_sessions_properties();

          //if the user only joined one organzation or already selected an organzation to login
          //redirect them to the dashboard page
          if (isset($_SESSION["current_org_id"])) {
            // echo "OrgListSession";
            //header("Location: " . $path->pageURL . "/dashboard-framework-v1/src/view/dashboard.view.php");

            //if users has the permission to view admin dashbaord then rediect them to admin dashbaord
            //if users has the permission to view admin volunteer then rediect them to volunteer dashbaord
            if ($this->check_permission(['view admin dashboard'])) {
              echo "admin";
              header("Location: " . $path->pageURL . "/dashboard-framework-v1/src/view/dashboard-admin.view.php");
            } elseif ($this->check_permission(['view volunteer dashboard'])) {
              echo "volunteer";
              header("Location: " . $path->pageURL . "/dashboard-framework-v1/src/view/dashboard-volunteers.view.php");
            } elseif (!self::check_permission()) {
              $organization = self::get_organizations();
              self::destory_session();
              header("Location: " . $path->pageURL . "/dashboard-framework-v1/src/view/login.view.php?permission&org=" . $organization[0]->name);
          }

          } 
          
        } else {
          header("Location: " . $path->pageURL . "/dashboard-framework-v1/src/view/403.view.php");
        }
      }

  }

?>