<?php
  include_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/view/sidebar.view.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/view/top-navbar.view.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/SessionVariable.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/Path.php';
  $set_session = new SessionVariable();
  $path = new Path();

  if (!$set_session->check_permission(['edit events'])) {
    header("Location: " . $path->pageURL . "/dashboard-framework-v1/src/view/403.view.php");
  }

  include_once("../model/Event.php");
  $E = new Event();
  
  if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $eventInfo = $E->getEventInfoFromID($id);
    } 

    
  include_once("../model/User.php");
  $U = new User();
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
          $sidebar = new Sidebar("events", $set_session);
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
                Edit Event
              </h4>
              <div class="row">
                <div class="col-md-12">
                  <div class="card mb-4">
                    <h5 class="card-header">Event details</h5>
                    <hr class="my-0" />
                    <div class="card-body">
                      <form id="formAccountSettings" method="POST" action="<?php echo $path->pageURL; ?>/dashboard-framework-v1/src/controller/update-event.controller.php?id=<?php echo $id?>" enctype="multipart/form-data">
                        <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label">Name</label>
                            <input
                              class="form-control"
                              type="text"
                              id="name"
                              name="name"
                              <?php 
                              if($eventInfo['name']!=NULL && $eventInfo['name']!="" )
                              echo "value= '".$eventInfo['name']."'";
                              ?>
                              placeholder="Name"
          
                            />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="date" class="form-label">Date</label>
                            <input class="form-control" type="date" id="date" value="2021-12-15"
                            />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label">Location</label>
                            <input
                              class="form-control"
                              type="text"
                              id="location"
                              name="location"
                              <?php 
                              if($eventInfo['location']!=NULL && $eventInfo['location']!="" )
                              echo "value= '".$eventInfo['location']."'";
                              ?>
                              placeholder="Location"
                              
                            />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="supervisor" class="form-label">Supervisor</label>
                            <select id="supervisor" name="supervisor" class="select2 form-select">
                              <option disabled selected value>-- Select a supervisor --</option>
                            <?php 
                              $users = $U->getSupervisors();
                  
                              foreach($users as $user){
                                echo "<option value='".$user['id'] ."' ";
                                if ($user['id'] ==$eventInfo['supervisor'] ) echo "selected";
                                echo ">".$user['first_name']. " " . $user['last_name'].  "</option>";
                              }
      
                              ?>
                            </select>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="start_time" class="form-label">Start Time</label>
                            <input
                              class="form-control"
                              type="text"
                              id="start_time"
                              name="start_time"
                              <?php 
                              if($eventInfo['start_time']!=NULL && $eventInfo['start_time']!="" )
                              echo "value= '".$eventInfo['start_time']."'";
                              ?>
                              
                            />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="end_time" class="form-label">End Time</label>
                            <input
                              class="form-control"
                              type="text"
                              id="end_time"
                              name="end_time"
                              <?php 
                              if($eventInfo['end_time']!=NULL && $eventInfo['end_time']!="" )
                              echo "value= '".$eventInfo['end_time']."'";
                              ?>
                              
                            />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="participants" class="form-label">Participants</label>
                            <input
                              class="form-control"
                              type="text"
                              id="participants"
                              name="participants"
                              <?php 
                              if($eventInfo['participants']!=NULL && $eventInfo['participants']!="" )
                              echo "value= '".$eventInfo['participants']."'";
                              ?>
                              
                            />
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" name="status" class="select2 form-select" >
                              <option disabled selected value>-- Select a status --</option>
                              <option value=6 <?php if($eventInfo['status'] == 6) echo "selected"; ?> >UPCOMING</option>
                              <option value=4 <?php if($eventInfo['status'] == 4) echo "selected"; ?>>COMPLETED</option>
                              <option value=7 <?php if($eventInfo['status'] == 7) echo "selected"; ?>>CANCELLED</option>
                              <option value=5 <?php if($eventInfo['status'] == 5) echo "selected"; ?>>IN PROGRESS</option>
                            </select>
                          </div>

                          <div class="mb-3 col-md-12">
                            <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                            <textarea 
                              class="form-control" 
                              id="exampleFormControlTextarea1" 
                              rows="4"
                            ><?php 
                              if($eventInfo['description']!=NULL && $eventInfo['description']!="" )
                              echo $eventInfo['description'];
                              ?>
                          </textarea>
                          </div>
                        </div>
                        <div class="mt-2">
                          <a href="events.view.php">
                            <button type="submit" class="btn btn-outline-primary me-2">
                              Submit
                            </button>
                          </a>

                          <a href="events.view.php">
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
