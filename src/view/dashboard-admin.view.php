<?php
  include_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/view/sidebar.view.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/view/top-navbar.view.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/SessionVariable.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/Path.php';
  $set_session = new SessionVariable();
  $path = new Path();

  if (!$set_session->check_permission(['view admin dashboard'])) {
    header("Location: " . $path->pageURL . "/ashboard-framework-v1/src/view/403.view.php");
  }
  
  include_once("../model/Dashboard.php");
  $D = new Dashboard();
  
  $userInfo = $D->getUserInfoFromID($_SESSION["user_id"]);
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

    <link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css" />

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
      <div class="layout-container">

        <!-- Sidebar -->
        <?php
          $sidebar = new Sidebar("dashboard-admin", $set_session);
          $sidebar->sidebar_html();
        ?>
        <!-- / Sidebar -->

        <!-- Layout container -->
        <div class="layout-page">

          <!-- Top Navbar -->
          <?php
            $topbar = new TopNavBar($set_session);
            $topbar->topNavBar_html();
            $orgInfo = $D->getOrgInfoFromID($topbar->set_session->current_org_id);
          ?>
          <!-- / Top Navbar -->

          

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4">
                Dashboard (admin)
              </h4>

              <div class="row" >
                <div class="col-lg-6 mb-4 order-0">
                  <div class="card h-100">
                    <div class="d-flex align-items-end row">
                      <div class="col-sm-7">
                        <div class="card-body"  style="padding-bottom:20%">
                          <h5 class="card-title text-primary" style="padding-top:5%">Welcome Back <?php echo $userInfo["first_name"];?>!</h5>
                          <p class="mb-4">
                            You have now logged in <span class="fw-bold"><?php echo $orgInfo['name'] ?></span>.
                          </p>
                        </div>
                      </div>
                      <div class="col-sm-5 text-center text-sm-left"
                            style="padding-bottom:4%;">
                        <div class="card-body pb-0 px-0 px-md-4">
                          <img
                            src="../assets/img/TechUpTasLogo.png"
                            alt="View Badge User"
                            data-app-dark-img="illustrations/man-with-laptop-dark.png"
                            data-app-light-img="illustrations/man-with-laptop-light.png"
                            height="140"
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 mb-4 order-0">
                  <div class="card h-100">
                    <div class="d-flex align-items-end row">
                      <div class="col-sm-7">
                        <div class="card-body">
                          <h5 class="card-title text-primary">Congratulations <?php echo $userInfo["first_name"];?>! 🎉</h5>
                          <p class="mb-4">

                          <?php
                          $events = $D->getMonthlySupervisedEvents($userInfo['id']);
                          $rate = $D->getMonthlyHandledRequests($userInfo['id']);
                          ?>
                            You have handle <span class="fw-bold"><?php echo $rate ;?>%</span> request 
                            and run <span class="fw-bold"><?php echo $events->num_rows ;?> </span> events this month.
                          </p>
                          <span class="demo-inline-spacing">

                          <?php
                            if ($set_session->check_permission(['view requests'])) {
                          ?>
                              <a href="requests.view.php" class="btn btn-sm btn-outline-primary"><i class="tf-icons bx bx-envelope"></i>&nbsp View Requests</a>
                          <?php
                            }
                          ?>

                          <?php
                            if ($set_session->check_permission(['view events'])) {
                          ?>
                            <a href="events.view.php" class="btn btn-sm btn-outline-primary"><i class="tf-icons bx bx-calendar-event"></i>&nbsp View Events</a>
                          <?php
                            }
                          ?>
                            
                            
                          </span>
                        </div>
                      </div>
                      <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                          <img
                            src="../assets/img/illustrations/man-with-laptop-light.png"
                            height="140"
                            alt="View Badge User"
                            data-app-dark-img="illustrations/man-with-laptop-dark.png"
                            data-app-light-img="illustrations/man-with-laptop-light.png"
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>


              <div class="row" >

                <?php
                  if ($set_session->check_permission(['view events'])) {
                ?>
                  <div class="col-lg-6 mb-4 order-0">
                    
                    <div class="card h-100">
                      <h5 class="card-header">Upcoming events</h5>
                      <hr class="my-0" />
                      
                      
                      <div class="col-lg-12 mb-4 order-0" style="padding-top: 20px;padding-left: 20px;padding-right: 20px;" >
<!--
                        <div class="row" style="padding: 5px;" >
                          <a href="view-event.view.php">
                            <div class="card">
                              <div class="d-flex align-items-end row">
                                <div class="col-sm-3">
                                  <div class="card-body" style="text-align: center;">
                                    <span style="clear: both; display: inline-block; overflow: hidden; white-space: nowrap;">
                                      <h1 style="color: #1775F1;">
                                        7<br>
                                        AUG
                                      </h1>
                                      <h6 >
                                        12:30 pm
                                      </h6>
                                    </span>
                                  </div>  
                                </div>
                                <div class="col-sm-9 text-sm-left">
                                  <div class="card-body">
                                    <h5 class="card-title">Tutoring</h5>
                                    <p class="mb-4" style="color: black;">
                                      Provide tutoring to UTAS students. 
                                      <br>
                                      <small class="text-muted">Chloe An</small>
                                    </p>
                                    
                                  </div>
                                </div>
                              </div>
                            </div>
                          </a>
                        </div>
-->
                        <?php 
                            echo $D->getEvents();
                        ?>
                      </div>

                      <span style="padding-left: 15px;" >
                        <div class="row">
                          <div class="card-body" style="padding-top: 0px;">
                            <a href="events.view.php" class="btn btn-lg btn-outline-primary"><i class="tf-icons bx bx-calendar-event bx-sm"></i>&nbsp View Events</a>
                          </div>
                        </div>
                      </span>

                    </div>
                  </div>

                <?php
                  }
                ?>


                <?php
                  if ($set_session->check_permission(['view requests'])) {
                ?>
                  <div class="col-lg-6 mb-4 order-0">
                  
                    <div class="card h-100">
                      <h5 class="card-header">Pending requests</h5>
                      <hr class="my-0" />
                      
                      
                      <div class="col-lg-12 mb-4 order-0" style="padding-top: 20px;padding-left: 20px;padding-right: 20px;" >
<!--
                        <div class="row" style="padding: 5px;" >
                          <a href="requests.view.php">
                            <div class="card">
                              <div class="d-flex align-items-end row">
                                <div class="col-sm-4" style="text-align: center;padding-top: 6.5px;">
                                  <img
                                    src="../assets/img/avatars/5.png"
                                    height="136"
                                    alt="View Badge User"
                                    data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                    data-app-light-img="illustrations/man-with-laptop-light.png"
                                    style="border-radius: 50%;"
                                  /> 
                                  <p style="color: black; padding-top: 5px; text-align: center;">
                                    Woody Gay
                                  </p>
                                </div>
                                <div class="col-sm-8 text-sm-left">
                                  <div class="card-body" style="padding-bottom: 8%;">
                                    <h5 class="card-title">Tutoring (1.5 hours)</h5>
                                    <p class="mb-4" style="color: black;">
                                      Provide tutoring to UTAS students. 
                                      <br>
                                      <small class="text-muted">15 June</small>
                                      <br>
                                    </p>
                                    
                                  </div>
                                </div>
                              </div>
                            </div>
                          </a>
                        </div>
-->
                        <?php echo $D->getRequests();?>
                      </div>

                      <span style="padding-left: 15px;" >
                        <div class="row">
                          <div class="card-body"  style="padding-top: 0px;">
                            <a href="requests.view.php" class="btn btn-lg btn-outline-primary"><i class="tf-icons bx bx-envelope bx-sm"></i>&nbsp View Requests</a>
                          </div>
                        </div>
                      </span>
                      
                    </div>
                    
                  </div>
              
                <?php
                  }
                ?>
            
               </div>

              <h4 class="fw-bold py-3 mb-4">
                <span class="text-muted fw-light">Dashboard (admin)/</span> Analytics
              </h4>
              <div class="row">

                <div class="col-lg-6 mb-4 order-0">
                  <div class="card">
                    <div class="d-flex align-items-end row">
                      <div id="attendance_report"></div>
                    </div>
                  </div>
                </div>

                <div class="col-lg-6 mb-4 order-0">
                  <div class="card">
                    <div class="d-flex align-items-end row">
                      <div id="new_volunteer_report"></div>
                    </div>
                  </div>
                </div>


              </div>


              <div class="row">

                <div class="col-lg-6 mb-4 order-0">
                  <div class="card">
                    <div class="d-flex align-items-end row">
                      <div id="top_volunteer_report"></div>
                    </div>
                  </div>
                </div>

                <div class="col-lg-6 mb-4 order-0">
                  <div class="card">
                    <div class="d-flex align-items-end row">
                      <div id="activity_type_report"></div>
                    </div>
                  </div>
                </div>


              </div>

              <div class="row">

                <div class="col-lg-6 mb-4 order-0">
                  <div class="card">
                    <div class="d-flex align-items-end row">
                      <div id="engagement_report"></div>
                    </div>
                  </div>
                </div>

                <div class="col-lg-6 mb-4 order-0">
                  <div class="card">
                    <div class="d-flex align-items-end row">
                      <div id="volunteer_age_report"></div>
                    </div>
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
    <script src="../assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="../assets/js/dashboards-analytics.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- MonthlyEventAttendance -->
    <script>
        <?php
            echo $D->getMonthlyEventAttendance();
  
            echo $D->getTypeOfActivity();

        ?>
    </script>
    <script src="../assets/js/dashboard_charts.js"></script>


  </body>
</html>
