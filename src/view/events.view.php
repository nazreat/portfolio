<?php
  include_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/view/sidebar.view.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/view/top-navbar.view.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/SessionVariable.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/controller/event.controller.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/Path.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . "/dashboard-framework-v1/src/include/dbh.inc.php";

  $set_session = new SessionVariable();
  $path = new Path();

  include_once("../model/Event.php");
  $e = new Event();

  include_once("../model/User.php");
  $U = new User();

  // $events = (array)$events[0];
  // print_r($events);exit();

  if (!$set_session->check_permission(['view events'])) {
    header("Location: " . $path->pageURL . "/dashboard-framework-v1/src/view/403.view.php");
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
                View Events
              </h4>

              <!-- Basic Bootstrap Table -->
              <div class="card">


                <h5 class="card-header">

                  <p class="demo-inline-spacing">

                      <?php
                        if ($set_session->check_permission(['add events'])) {
                      ?>
                        <a
                          class="btn btn-outline-primary me-1"
                          href="create-event.view.php" style="margin-right: auto"
                        >
                          <span class="tf-icons bx bx-plus-circle"></span>&nbsp; Create Event
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
                            <label for="name" class="form-label">Name</label>
                            <input
                              type="text"
                              class="form-control"
                              id="name"
                              placeholder="Name"
                              name="name"
                            />
                            <div class="form-text">
                            </div>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="location" class="form-label">Location</label>
                            <input
                              type="text"
                              class="form-control"
                              id="location"
                              placeholder="Location"
                              name="localtion"
                            />
                            <div class="form-text">
                            </div>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="date (after)" class="form-label">Date (After)</label>
                              <input class="form-control" name="date_after" type="date" value="" id="date (after)" />
                            <div class="form-text">
                            </div>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="date (before)" class="form-label">Date (Before)</label>
                              <input class="form-control" name="date_before" type="date" value="" id="date (before)" />
                            <div class="form-text">
                            </div>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="supervisor" class="form-label">Supervisor</label>
                            <input
                              type="text"
                              class="form-control"
                              id="supervisor"
                              placeholder="Supervisor"
                              name="supervisor"
                            />
                            <div class="form-text">
                            </div>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                              <option disabled selected value>-- Select a status --</option>
                              <option value="UPCOMING">UPCOMING</option>
                              <option value="COMPLETED">COMPLETED</option>
                              <option value="CANCELLED ">CANCELLED</option>
                              <option value="IN PROGRESS">IN PROGRESS</option>
                            </select>
                            <div class="form-text">
                            </div>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="particiants_minium" class="form-label">Particiants (Minium)</label>
                            <input name="particiants_min" class="form-control" type="number" value="" id="html5-number-input" />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="particiants_maximum" class="form-label">Particiants (Maximum)</label>
                            <input name="particiants_max" class="form-control" type="number" value="" id="html5-number-input" />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="events_per_page" class="form-label">Events per page</label>
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

                          <span >
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
                        <th>Name<i class='bx bxs-sort-alt' ></i></th>
                        <th>Date<i class='bx bxs-sort-alt' ></i></th>
                        <th>Location<i class='bx bxs-sort-alt' ></i></th>
                        <th>Supervisor <i class='bx bxs-down-arrow bx-xs'></i></th>
                        <th>Status<i class='bx bxs-sort-alt' ></i></th>
                        <th>Joined<i class='bx bxs-sort-alt' ></i></th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      <?php foreach ($events as $key => $value): ?>
                          <tr>
                            <td>
                              <?php echo $value->name ?>
                            </td>
                            <td>
                              <?php echo $value->event_date ?>
                            </td>
                            <td>
                              <?php echo $value->location ?>
                            </td>
                            <td>
                              <?php 
                              $supervisor = $U->getUserInfoFromID($value->supervisor);
                              
                              echo $supervisor['first_name']." ". $supervisor['last_name'] ?>
                            </td>
                            <td>
                            <?php 
                            if( $e->getStatus($value->status) == "UPCOMING" ) echo " <span class='badge bg-label-warning me-1'>";
                            if( $e->getStatus($value->status) == "COMPLETED" ) echo " <span class='badge bg-label-success me-1'>";
                            if( $e->getStatus($value->status) == "CANCELLED" ) echo " <span class='badge bg-label-danger me-1'>";
                            if( $e->getStatus($value->status) == "IN PROGRESS" ) echo " <span class='badge bg-label-primary me-1'>";
                            ?>
                      
                                <?php echo $e->getStatus($value->status); ?>
                              </span>
                            </td>
                            <td>
                              <?php 
                              if($e->check_if_joined($value->id, $_SESSION['user_id'])==true){
                                echo "Yes";
                              }else{
                                echo "No";
                              }
                              ?>
                            </td>
                           
                            <td>
                              <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                  <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                  <a class="dropdown-item" href="view-event.view.php?id=<?php echo $value->id; ?>" style="color: blue;"
                                    ><i class='bx bxs-show me-2'></i> View details</a
                                  >
                                  

                                  <?php
                                    if ($set_session->check_permission(['join events'])) {
                                  ?>
                                    <a class="dropdown-item" href="events.view.php?id=<?php echo $value->id ;?>&join=true" style="color: green;" 
                                      ><i class='bx bx-user-plus me-2'></i> Join event</a
                                    >
                                  <?php
                                    }
                                  ?>

                                  <?php
                                    if ($set_session->check_permission(['edit events'])) {
                                  ?>
                                    <a class="dropdown-item" href="edit-event.view.php?id=<?php echo $value->id; ?>"
                                      ><i class="bx bx-edit-alt me-2"></i> Edit</a
                                    >
                                  <?php
                                    }
                                  ?>
                                  <?php
                                    if ($set_session->check_permission(['delete events'])) {
                                  ?>
                                    <a class="dropdown-item" href="events.view.php?id=<?php echo $value->id ;?>&delete=true" style="color: red;"
                                      ><i class="bx bx-trash me-2"></i> Cancel</a
                                    >
                                  <?php
                                    }
                                  ?>
                                </div>
                              </div>
                            </td>
                          </tr>
                      <?php endforeach ?>
                      <!-- <tr>
                        <td>
                          Tutoring
                        </td>
                        <td>
                          15/12/2023
                        </td>
                        <td>
                          Sandy Bay
                        </td>
                        <td>
                          Chloe An
                        </td>
                        <td>
                          15
                        </td>
                        <td>
                          <span class="badge bg-label-warning me-1">Upcoming</span>
                        </td>
                        <td>
                          <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="view-event.view.php" style="color: blue;"
                                ><i class='bx bxs-show me-2'></i> View details</a
                              >
                              

                              <?php
                                if ($set_session->check_permission(['join events'])) {
                              ?>
                                <a class="dropdown-item" href="javascript:void(0);" style="color: green;" 
                                  ><i class='bx bx-user-plus me-2'></i> Join event</a
                                >
                              <?php
                                }
                              ?>

                              <?php
                                if ($set_session->check_permission(['edit events'])) {
                              ?>
                                <a class="dropdown-item" href="edit-event.view.php"
                                  ><i class="bx bx-edit-alt me-2"></i> Edit</a
                                >
                              <?php
                                }
                              ?>
                              <?php
                                if ($set_session->check_permission(['delete events'])) {
                              ?>
                                <a class="dropdown-item" href="javascript:void(0);" style="color: red;"
                                  ><i class="bx bx-trash me-2"></i> Cancel</a
                                >
                              <?php
                                }
                              ?>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Gathering
                        </td>
                        <td>
                          10/10/2022
                        </td>
                        <td>
                          Hobart City
                        </td>
                        <td>
                          Sam Tong
                        </td>
                        <td>
                          10
                        </td>
                        <td>
                          <span class="badge bg-label-success me-1">Completed</span>
                        </td>
                        <td>
                          <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="view-event.view.php" style="color: blue;"
                                ><i class='bx bxs-show me-2'></i> View details</a
                              >
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Tutoring
                        </td>
                        <td>
                          10/11/2023
                        </td>
                        <td>
                          Hobart City
                        </td>
                        <td>
                          David Hui
                        </td>
                        <td>
                          5
                        </td>
                        <td>
                          <span class="badge bg-label-danger me-1">Cancelled</span>
                        </td>
                        <td>
                          <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="view-event.view.php" style="color: blue;"
                                ><i class='bx bxs-show me-2'></i> View details</a
                              >
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Tutoring
                        </td>
                        <td>
                          10/05/2023
                        </td>
                        <td>
                          Glenorchy
                        </td>
                        <td>
                          David Hui
                        </td>
                        <td>
                          10
                        </td>
                        <td>
                          <span class="badge bg-label-primary me-1">In Progress</span>
                        </td>
                        <td>
                          <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="view-event.view.php" style="color: blue;"
                                ><i class='bx bxs-show me-2'></i> View details</a
                              >
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Training
                        </td>
                        <td>
                          10/10/2023
                        </td>
                        <td>
                          Kingston
                        </td>
                        <td>
                          Woody Gay
                        </td>
                        <td>
                          10
                        </td>
                        <td>
                          <span class="badge bg-label-warning me-1">Upcoming</span>
                        </td>
                        <td>
                          <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="view-event.view.php" style="color: blue;"
                                ><i class='bx bxs-show me-2'></i> View details</a
                              >
                              

                              <?php
                                if ($set_session->check_permission(['join events'])) {
                              ?>
                                <a class="dropdown-item" href="javascript:void(0);" style="color: green;" 
                                  ><i class='bx bx-user-plus me-2'></i> Join event</a
                                >
                              <?php
                                }
                              ?>

                              <?php
                                if ($set_session->check_permission(['edit events'])) {
                              ?>
                                <a class="dropdown-item" href="edit-event.view.php"
                                  ><i class="bx bx-edit-alt me-2"></i> Edit</a
                                >
                              <?php
                                }
                              ?>
                              <?php
                                if ($set_session->check_permission(['delete events'])) {
                              ?>
                                <a class="dropdown-item" href="javascript:void(0);" style="color: red;"
                                  ><i class="bx bx-trash me-2"></i> Cancel</a
                                >
                              <?php
                                }
                              ?>
                            </div>
                          </div>
                        </td>
                      </tr> -->
                      <tr></tr>
                    </tbody>
                  </table>
                </div>
    

                <!-- / Delete and Join Events -->
                <?php
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];

                    if(isset($_GET['join'])){
                      $e->joinEvent($id, $_SESSION['user_id']);
                      // Use JavaScript to redirect after successful delete
                      echo '<script type="text/javascript">';
                      echo 'window.location.href = "/dashboard-framework-v1/src/view/events.view.php";';
                      echo '</script>';
                      exit();
                    }
                    
                    if(isset($_GET['delete'])){
                      
                      $conditions_foreign = [
                        'event_id' => $id,
                      ];

                      $conditions_event = [
                        'id' => $id,
                      ];

                      $deleted = $e->delete_event($conditions_foreign,$conditions_event);

                      if($deleted > 0){
                        echo '<script type="text/javascript">';
                        echo 'window.location.href = "/dashboard-framework-v1/src/view/events.view.php";';
                        echo '</script>';
                        exit();
                      }else {
                        echo '<script type="text/javascript">';
                        echo 'window.location.href = "/dashboard-framework-v1/src/view/events.view.php";';
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
