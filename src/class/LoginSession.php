<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/SessionVariable.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/Path.php';

  class LoginSession extends SessionVariable {
      
      public function __construct()
      {
        $this->start_session();

        if ($this->authorise()) {
          echo "LoginSession";
          header('Location: ' . (new Path)->pageURL . '/dashboard-framework-v1/src/view/org-list.view.php');
        }
      }

  }

?>