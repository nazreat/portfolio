<?php
  include_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/view/sidebar.view.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/view/top-navbar.view.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/SessionVariable.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/controller/timesheet.controller.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/Path.php';
  $set_session = new SessionVariable();
  $path = new Path();

  if (!$set_session->check_permission(['view timesheets'])) {
    header("Location: " . $path->pageURL . "/dashboard-framework-v1/src/view/403.view.php");
  }

  include_once("../model/User.php");
  $U = new User();

  include_once("../model/Timesheet.php");
  $T = new Timesheet();
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
                View Timesheets
              </h4>

              <!-- Basic Bootstrap Table -->
              <div class="card">




                <h5 class="card-header">

                  <p class="demo-inline-spacing">

                    <?php
                      if ($set_session->check_permission(['add timesheets'])) {
                    ?>
                      <a
                        class="btn btn-outline-primary me-1"
                        href="create-timesheet.view.php" style="margin-right: auto"
                      >
                        <span class="tf-icons bx bx-plus-circle"></span>&nbsp; Create Timesheet
                      </a>
                    <?php
                      }
                    ?>
                      
                      <button
                        class="btn btn-outline-secondary me-1"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseExample"
                        aria-expanded="false"
                        aria-controls="collapseExample" style="margin-right: auto"
                      >
                        <span class="tf-icons bx bx-filter-alt"></span>&nbsp; Filter
                      </button>
                  </p>
                  
                <form action="" method="post">
                  <div class="collapse" id="collapseExample">
                    <div class="d-grid p-3 border">
                      <div class="row">
                        
                  
                          <div class="mb-3 col-md-6">
                            <label for="date (after)" class="form-label">Date (After)</label>
                              <input name="date_after" class="form-control" type="date" value="" id="date (after)" />
                            <div class="form-text">
                            </div>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="date (before)" class="form-label">Date (Before)</label>
                              <input name="date_before" class="form-control" type="date" value="" id="date (before)" />
                            <div class="form-text">
                            </div>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="activity_name" class="form-label">Activity Name</label>
                            <input
                              type="text"
                              class="form-control"
                              id="activity_name"
                              placeholder="Activity Name"
                              name="activity_name"
                            />
                            <div class="form-text">
                            </div>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="activity_type" class="form-label">ACTIVITIES TYPE</label>
                            <select class="form-select" name="activity_type" id="exampleFormControlSelect1" aria-label="Default select example">
                              <option disabled selected value>-- Select a type --</option>
                              <option value="project">Project</option>
                              <option value="event">Event</option>
                              <option value="other">Other</option>
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
                            
                                echo ">".$user['first_name']. " " . $user['last_name'].  "</option>";
                              }
      
                              ?>
                            </select>
                            <div class="form-text">
                            </div>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                              <option disabled selected value>-- Select a status --</option>
                              <option value=11>Pending</option>
                              <option value=8>Approved</option>
                              <option value=9>Declined</option>
                            </select>
                            <div class="form-text">
                            </div>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="timesheets_per_page" class="form-label">Timesheets per page</label>
                            <select name="per_page" class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                              <option disabled selected value>-- Select a number --</option>
                              <option value="5">5</option>
                              <option value="10">10</option>
                              <option value="25">25</option>
                              <option value="50">50</option>
                            </select>
                            <div class="form-text">
                            </div>
                          </div>
                          <span>
                            <button type="submit" class="btn btn-outline-primary">
                              Apply
                            </button>
                            <button type="reset" class="btn btn-outline-danger">
                              Clear
                            </button>
                          </span>

                        </div>
                    </div>
                  </div>
                </form>
                </h5>
                <div class="card-body">
                
                <div class="table-responsive text-nowrap">
                  <table class="table ">
                   <caption class="ms-4">
                      <span style="float:left;">Showing <?php echo $fromRecord ?> to <?php echo $toRecord ?> of <?php echo $totalRecords ?> entries</span>
                    </caption>
                    <thead>
                      <tr>
                        <th>Date<i class='bx bxs-sort-alt' ></i></th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Activity Name <i class='bx bxs-up-arrow bx-xs' ></i></th>
                        <th>Activity Type<i class='bx bxs-sort-alt' ></i></th>
                        <th>Supervisor <i class='bx bxs-down-arrow bx-xs'></th>
                        <th>Status<i class='bx bxs-sort-alt' ></i></th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      <?php foreach ($timesheets as $key => $value): ?>
                        <tr>
                          <td>
                            <?php echo $value->date ?>
                          </td>
                          <td>
                            <?php echo $value->start_time ?>
                          </td>
                          <td>
                            <?php echo $value->end_time ?>
                          </td>
                          <td>
                            <?php echo $value->activities ?>
                          </td>
                          <td>
                            <?php echo $value->activities_type ?>
                          </td>
                          <td>
                          <?php 
                              $supervisor = $U->getUserInfoFromID($value->supervisor);
                              
                              echo $supervisor['first_name']." ". $supervisor['last_name'] ?>
                          </td>
                          <td>
                            <?php 
                            if( $T->getStatus($value->status) == "PENDING" ) echo " <span class='badge bg-label-warning me-1'>";
                            if( $T->getStatus($value->status) == "APPROVED" ) echo " <span class='badge bg-label-success me-1'>";
                            if( $T->getStatus($value->status) == "DECLINED" ) echo " <span class='badge bg-label-danger me-1'>";
                            ?>
                              <?php echo strtoupper($T->getStatus($value->status)) ?>
                            </span>
                          </td>
                          <td>
                            <div class="dropdown">
                              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                              </button>
                              <div class="dropdown-menu">
                                

                                <?php
                                  if ($set_session->check_permission(['edit timesheets'])) {
                                ?>
                                  <a class="dropdown-item" href="edit-timesheet.view.php?id=<?php echo  $value->id ?>"
                                    ><i class="bx bx-edit-alt me-2"></i> Edit</a
                                  >
                                <?php
                                  }
                                ?>
                                

                                <?php
                                  if ($set_session->check_permission(['delete timesheets'])) {
                                ?>
                                  <a class="dropdown-item" href="timesheets.view.php?id=<?php echo $value->id ?>&withdraw=true" style="color: red;"
                                    ><i class="bx bx-trash me-2"></i> Withdraw</a
                                  >
                                <?php
                                  }
                                ?>
                              </div>
                            </div>
                          </td>
                        </tr>
                      <?php endforeach ?>
                      <tr></tr>
                    </tbody>
                  </table>
                </div>

                <!-- / Withdraw Timesheet -->
                <?php
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];

                    if(isset($_GET['withdraw'])){
                      
              
                      $conditions = [
                        'id' => $id,
                      ];

                      $deleted = $T->delete_timesheet($conditions);

                      if($deleted > 0){
                        echo '<script type="text/javascript">';
                        echo 'window.location.href = "/dashboard-framework-v1/src/view/timesheets.view.php";';
                        echo '</script>';
                        exit();
                      }else {
                        echo '<script type="text/javascript">';
                        echo 'window.location.href = "/dashboard-framework-v1/src/view/timesheets.view.php";';
                        echo '</script>';
                        exit();
                      }
                    }

                } 
              ?>


                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-end" >
                      <?php echo generatePaginationLinks($page, $totalPages); ?>
                    </ul>
                </nav>

                      </div>

                      
                      </div>
              <!--/ Basic Bootstrap Table -->

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
  </body>
</html>
