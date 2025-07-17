<?php
  include_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/view/sidebar.view.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/view/top-navbar.view.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/SessionVariable.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/Path.php';
  $set_session = new SessionVariable();
  $path = new Path();

  if (!$set_session->check_permission(['edit timesheets'])) {
    header("Location: " . $path->pageURL . "/dashboard-framework-v1/src/view/403.view.php");
  }

  include_once("../model/User.php");
  $U = new User();

  include_once("../model/Timesheet.php");
  $T = new Timesheet();

  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $timesheetInfo = $T->getTimesheetInfoFromID($id);
} 

?>

<!DOCTYPE html>

<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Volunteer Activities Tracker</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/TechUpTasLogo.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../assets/js/config.js"></script>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">


        <!-- Sidebar -->
        <?php
          $sidebar = new Sidebar("timesheets", $set_session);
          $sidebar->sidebar_html();
        ?>
        <!-- / Sidebar -->

        <!-- Layout container -->
        <div class="layout-page">

          <!-- Top Navbar -->
          <?php
            $sidebar = new TopNavBar($set_session);
            $sidebar->topNavBar_html();
          ?>
          <!-- / Top Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4">
                Edit Timesheet
              </h4>
              <div class="row">
                <div class="col-md-12">
                  <div class="card mb-4">
                    <h5 class="card-header">Timesheet details</h5>
                    <hr class="my-0" />
                    <div class="card-body">
                      <form id="formAccountSettings" method="POST" action="<?php echo $path->pageURL; ?>/dashboard-framework-v1/src/controller/update-timesheet.controller.php?id=<?php echo $id?>" enctype="multipart/form-data">
                        <div class="row">
                          <div class="mb-3 col-md-6">
                            <label for="date" class="form-label">Date</label>
                            <input class="form-control" name="date" type="date"  <?php 
                              if($timesheetInfo['date']!=NULL && $timesheetInfo['date']!="" )
                              echo "value= '".$timesheetInfo['date']."'";
                              ?>
                              id="date" />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="date" class="form-label">Start Time</label>
                            <input class="form-control" name="start_time"  type="time" <?php 
                              if($timesheetInfo['start_time']!=NULL && $timesheetInfo['start_time']!="" )
                              echo "value= '".$timesheetInfo['start_time']."'";
                              ?> id="html5-time-input">
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="date"  class="form-label">End Time</label>
                            <input class="form-control" type="time" name="end_time"
                            <?php 
                              if($timesheetInfo['end_time']!=NULL && $timesheetInfo['end_time']!="" )
                              echo "value= '".$timesheetInfo['end_time']."'";
                              ?>

                            id="html5-time-input">
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="activiy_name" class="form-label">Activiy Name</label>
                            <input
                              class="form-control"
                              type="text"
                              id="activiy_name"
                              name="activiy_name"
                              <?php 
                              if($timesheetInfo['activities']!=NULL && $timesheetInfo['activities']!="" )
                              echo "value= '".$timesheetInfo['activities']."'";
                              ?>
                              placeholder="Activiy Name"
                            />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="activity_type" class="form-label">ACTIVITIES TYPE</label>
                            <select class="form-select" name="activiy_type" id="exampleFormControlSelect1" aria-label="Default select example">
                              <option disabled selected value>-- Select a type --</option>
                              <option value="Project" <?php if($timesheetInfo['activities_type']!=NULL && $timesheetInfo['activities_type']=="Project" ) echo "selected ";?> >Project</option>
                              <option value="Event"  <?php if($timesheetInfo['activities_type']!=NULL && $timesheetInfo['activities_type']=="Event" ) echo "selected ";?>>Event</option>
                              <option value="Other"  <?php if($timesheetInfo['activities_type']!=NULL && $timesheetInfo['activities_type']=="Other" ) echo "selected ";?>>Other</option>
                            </select>
                            <div class="form-text">
                            </div>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="supervisor" class="form-label">Supervisor</label>
                            <select id="supervisor" name="supervisor" class="select2 form-select">
                              <option disabled selected value>-- Select a supervisor --</option>
                            <?php 
                              $users = $U->getSupervisors();
                  
                              foreach($users as $user){
                                echo "<option value='".$user['id'] ."' ";
                                if ($user['id'] ==$timesheetInfo['supervisor'] ) echo "selected";
                                echo ">".$user['first_name']. " " . $user['last_name'].  "</option>";
                              }
      
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="mt-2">
                          <a href="timesheets.view.php">
                            <button type="submit" class="btn btn-outline-primary me-2">
                              Save
                            </button>
                          </a>

                          <a href="timesheets.view.php">
                            <button type="button" class="btn btn-outline-danger me-2">
                              Cancel
                            </button>
                          </a>

                        </div>
                      </form>
                    </div>
                    <!-- /Account -->
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="../assets/js/pages-account-settings-account.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
