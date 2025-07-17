<?php
  include_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/view/sidebar.view.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/view/top-navbar.view.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/SessionVariable.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/Path.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . "/dashboard-framework-v1/src/include/dbh.inc.php";
  $set_session = new SessionVariable();
  $path = new Path();

  if (!$set_session->check_permission(['view staff'])) {
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



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  </head>


<!----------------- FILTER FUNCTIONs --------------------------->


<?php
$rowperpage = 5;

$filterApplied = false;

$row = isset($_POST['row']) ? intval($_POST['row']) : 0;

if (!isset($_POST['but_prev']) && !isset($_POST['but_next']) && !isset($_POST['page_num'])) {
  $row = 0;
}

$filterFirstName = "";
$filterLastName = "";
$filterRole = "";
$filterSuburb = "";
$filterPerPage = $rowperpage;


if ((isset($_POST['apply'])) || (isset($_POST['pagination_applied']) && ($_POST['pagination_applied'] == 'true' || $_POST['pagination_applied'] == 1))) {

// Initialize filter variables
$filterFirstName = !empty($_POST['stafffirstname']) ? $_POST['stafffirstname'] : (isset($_POST['pagination_firstname']) ? $_POST['pagination_firstname'] : '');
$filterLastName = !empty($_POST['stafflastname']) ? $_POST['stafflastname'] : (isset($_POST['pagination_lastname']) ? $_POST['pagination_lastname'] : '');
$filterRole = !empty($_POST['role']) ? $_POST['role'] : (isset($_POST['pagination_role']) ? $_POST['pagination_role'] : '');
$filterSuburb = !empty($_POST['suburb']) ? $_POST['suburb'] : (isset($_POST['pagination_suburb']) ? $_POST['pagination_suburb'] : '');

if (isset($_POST['staff_per_page'])) 
  {
    $filterPerPage = $_POST['staff_per_page'];  
    $rowperpage = $filterPerPage;
  } 


// Construct the WHERE clause based on the selected filters
$whereClause = "status_id = 1";

if (!empty($filterFirstName)) {
    $whereClause .= " AND first_name LIKE '%$filterFirstName%'";
}

if (!empty($filterLastName)) {
    $whereClause .= " AND last_name LIKE '%$filterLastName%'";
}

if (!empty($filterRole)) {
    $whereClause .= " AND role = '$filterRole'";
}

if (!empty($filterSuburb)) {
    $whereClause .= " AND suburb LIKE '%$filterSuburb%'";
}


$filterApplied = true;
}
?>


<?php

    // Previous Button
    if(isset($_POST['but_prev'])){
      $row = $_POST['row'];
      $row -= $filterPerPage;
      if( $row < 0 ){
          $row = 0;
      }
  }

  // Next Button
  if(isset($_POST['but_next'])){
      $row = $_POST['row'];
      $allcount = $_POST['allcount'];

      $val = $row + $filterPerPage;
      if( $val < $allcount ){
          $row = $val;
      }
  }

    // Page Num Button
    if(isset($_POST['page_num'])){
      $row = ($_POST['page_num'] * $filterPerPage) - $filterPerPage;
      $allcount = $_POST['allcount'];

      $val = $row;
      if( $val < $allcount ){
          $row = $val;
      }
  }
 

    // generating orderby and sort url for table header
    function sortorder($fieldname){
        $sorturl = "?order_by=".$fieldname."&sort=";
        $sorttype = "asc";
        if(isset($_GET['order_by']) && $_GET['order_by'] == $fieldname){
            if(isset($_GET['sort']) && $_GET['sort'] == "asc"){
                $sorttype = "desc";
            }
        }
        $sorturl .= $sorttype;
        return $sorturl;
    }

function getSortingIconClass($columnName) {
  // Define your sorting icon logic here
  // Return 'bx bxs-sort-alt' if not currently sorted by this column
  // Return 'bxs-down-arrow bx-xs' if currently sorted in descending order
  // Return 'bxs-up-arrow bx-xs' if currently sorted in ascending order
  if ($_GET['order_by'] === $columnName) {
    if ($_GET['sort'] === 'asc') {
      return 'bxs-up-arrow bx-xs';
    } else {
      return 'bxs-down-arrow bx-xs';
    }
  } else {
    return 'bx bxs-sort-alt'; // Return a default class here
  }
}

?>

  <body>

  
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">


        <!-- Sidebar -->
        <?php
          $sidebar = new Sidebar("staff-list", $set_session);
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
                View Staff
              </h4>

              <!-- Basic Bootstrap Table -->
              <div class="card">




                <h5 class="card-header">


                  <p class="demo-inline-spacing">
                    
                    <?php
                      if ($set_session->check_permission(['add staff'])) {
                    ?>
                      <a
                        class="btn btn-outline-primary me-1"
                        href="create-staff.view.php" style="margin-right: auto"
                      >
                        <span class="tf-icons bx bx-plus-circle"></span>&nbsp; Add Staff
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
                <div class="collapse" id="collapseExample">
                  <div class="d-grid p-3 border">
                    <!-- <div class="row"> -->
                      
                    <form method="post">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                          <label for="stafffirstname" class="form-label">First name</label>
                          <input type="text" class="form-control" name="stafffirstname" placeholder="First name" />
                          <div class="form-text">
                          </div>
                        </div>
                        <div class="mb-3 col-md-6">
                          <label for="stafflastname" class="form-label">Last name</label>
                          <input type="text" class="form-control" name="stafflastname" placeholder="Last Name" />
                          <div class="form-text">
                          </div>
                        </div>
                        <div class="mb-3 col-md-6">
                          <label for="suburb" class="form-label">Suburb</label>
                          <input type="text" class="form-control" id="suburb" name="suburb" placeholder="Suburb" />
                          <div class="form-text">
                          </div>
                        </div>
                        <div class="mb-3 col-md-6">
                          <label for="role" class="form-label">Role</label>
                          <select class="form-select" name="role" id="role" aria-label="Default select example">
                            <option selected value="">-- Select a role --</option>
                            <option value="Supervisor" <?php if ($filterRole == 'Supervisor') echo 'selected'; ?>>Supervisor</option>
                            <option value="Admin" <?php if ($filterRole == 'Admin') echo 'selected'; ?>>Admin</option>
                          </select>
                          <div class="form-text">
                          </div>
                        </div>
                        <div class="mb-3 col-md-6">
                          <label for="staff_per_page" class="form-label">Staff per page</label>
                          <select class="form-select" name="staff_per_page" id="staff_per_page" aria-label="Default select example">
                            <option value="5" <?php if ($filterPerPage == '5') echo 'selected'; ?>>5</option>
                            <option value="10" <?php if ($filterPerPage == '10') echo 'selected'; ?>>10</option>
                            <option value="25" <?php if ($filterPerPage == '25') echo 'selected'; ?>>25</option>
                            <option value="50" <?php if ($filterPerPage == '50') echo 'selected'; ?>>50</option>
                          </select>
                          <div class="form-text">
                          </div>
                        </div>

                        <span>
                          <button type="submit" name="apply" class="btn btn-outline-primary">
                            Apply
                          </button>
                          <input type="reset" class="btn btn-outline-danger"></input>
                        </span>
                    
                      <!-- </div> -->
                  </div>
                </div>
                </h5>
                <div class="card-body">
                
                <div class="table-responsive text-nowrap">
                  <table class="table ">

                    
                    <thead>
                      <tr>
                        <th><a href="<?php echo sortorder('first_name'); ?>" class="sort <?php if (isset($_GET['order_by']) && $_GET['order_by'] === 'first_name') echo 'active'; ?>" style="color: <?php echo (isset($_GET['order_by']) && $_GET['order_by'] === 'first_name') ? 'blue' : 'inherit'; ?>;text-decoration: none;"> First Name<?php if (isset($_GET['order_by']) && $_GET['order_by'] === 'first_name') { ?>
                        <i class='bx <?php echo getSortingIconClass('first_name'); ?>'></i><?php } else { ?><i class='bx bxs-sort-alt'></i><?php } ?></a></th>

                        <th><a href="<?php echo sortorder('last_name'); ?>" class="sort <?php if (isset($_GET['order_by']) && $_GET['order_by'] === 'last_name') echo 'active'; ?>" style="color: <?php echo (isset($_GET['order_by']) && $_GET['order_by'] === 'last_name') ? 'blue' : 'inherit'; ?>;text-decoration: none;">Last Name<?php if (isset($_GET['order_by']) && $_GET['order_by'] === 'last_name') { ?>
                        <i class='bx <?php echo getSortingIconClass('last_name'); ?>'></i><?php } else { ?><i class='bx bxs-sort-alt'></i><?php } ?></a></th>

                        <th><a class="sort" style="color: inherit; text-decoration: none;">Image</a></th>
                        <th><a class="sort" style="color: inherit; text-decoration: none;">Role</a></th>

                        <th><a href="<?php echo sortorder('suburb'); ?>" class="sort <?php if (isset($_GET['order_by']) && $_GET['order_by'] === 'suburb') echo 'active'; ?>" style="color: <?php echo (isset($_GET['order_by']) && $_GET['order_by'] === 'suburb') ? 'blue' : 'inherit'; ?>;text-decoration: none;">Suburb<?php if (isset($_GET['order_by']) && $_GET['order_by'] === 'suburb') { ?> 
                        <i class='bx <?php echo getSortingIconClass('suburb'); ?>'></i><?php } else { ?><i class='bx bxs-sort-alt'></i><?php } ?></a></th>
                        
                        <th><a href="<?php echo sortorder('created_at'); ?>" class="sort <?php if (isset($_GET['order_by']) && $_GET['order_by'] === 'created_at') echo 'active'; ?>" style="color: <?php echo (isset($_GET['order_by']) && $_GET['order_by'] === 'created_at') ? 'blue' : 'inherit'; ?>;text-decoration: none;">Registration Date<?php if (isset($_GET['order_by']) && $_GET['order_by'] === 'created_at') { ?>
                        <i class='bx <?php echo getSortingIconClass('created_at'); ?>'></i><?php } else { ?><i class='bx bxs-sort-alt'></i><?php } ?></a></th>
                        
                        <th>Actions</th>
                      </tr>
                    </thead>



                  <?php
                  // count total number of rows and pages for sort/filter/standard table 

                  if ($filterApplied)
                  {
                    $sql = "SELECT COUNT(*) AS cntrows FROM user WHERE $whereClause";
                  }
                  else
                  {
                    $sql = "SELECT COUNT(*) AS cntrows FROM user WHERE status_id = 1";
                  }

                  $result = mysqli_query($conn, $sql);
                  $fetchresult = mysqli_fetch_array($result);
                  $allcount = $fetchresult['cntrows'];
                  $totalpages = ceil($allcount / $filterPerPage);
                  ?>


                  <caption class="ms-4">
                    <span style="float:left;">

                      <?php if ($totalpages > 0) : ?>
                        <p>Page <?php echo ($row / $filterPerPage) + 1; ?> of <?php echo $totalpages; ?></p>
                      <?php endif; ?>

                    </span>
                  </caption>

                
                <?php
                  // selecting rows
                  $orderby = " ORDER BY id desc ";
                  if(isset($_GET['order_by']) && isset($_GET['sort'])){
                      $orderby = ' order by '.$_GET['order_by'].' '.$_GET['sort'];
                  }


                  if ($filterApplied) {
                    // SQL query with filtering
                    $sql = "SELECT * FROM user WHERE $whereClause $orderby LIMIT $row, $filterPerPage";
                } else {
                    // SQL query without filtering
                    $sql = "SELECT * FROM user WHERE status_id = 1 $orderby LIMIT $row, $filterPerPage";
                }
                


                  $result = mysqli_query($conn,$sql);
                  while($fetch = mysqli_fetch_array($result)){
                      $firstName = $fetch['first_name'];
                      $lastName  = $fetch['last_name'];
                      //$gender = $fetch['username'];
                      $photo_path =$fetch['photo_path'];
                      $email = $fetch['email']; 
                      $suburb = $fetch['suburb'];
                      $phone = $fetch['phone'];
                      $createdDate = $fetch['created_at'];
                      $state = $fetch['state'];
                      $userid = $fetch['id'];
                      $status = $fetch['status_id'];
                      $role = $fetch['role'];

                      ?>



                    <tbody class="table-border-bottom-0">
                      <tr>
                        <td>
                        <?php echo $firstName; ?>
                        </td>
                        <td>
                        <?php echo $lastName; ?>
                        </td>
                        
                        <td>
                          <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                            <li
                              data-bs-toggle="tooltip"
                              data-popup="tooltip-custom"
                              data-bs-placement="top"
                              class="avatar avatar-xs pull-up"
            
                            >
                            <?php 
                              if ($photo_path != null)
                              echo "<img src=". $photo_path . " alt='Avatar' class='rounded-circle' /> ";
                              ?>
                       
                          
                            </li>
                          </ul>
                        </td>
                        <td>
                        <?php echo $role; ?>
                        </td>
                        
                       <td>
                        <?php echo $suburb; ?>
                        </td>
                         <td>
                        <?php echo $createdDate; ?>
                        </td>
                     
                        <td>
                          <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                            <a class="dropdown-item" href="view-staff.view.php?id=<?php echo $fetch['id']; ?>" style="color: blue;"><i class='bx bxs-show me-2'></i> View details</a>

                    
                              <?php
                                if ($set_session->check_permission(['edit staff'])) {
                              ?>
                           
                            <a class="dropdown-item" href="edit-staff.view.php?id=<?php echo $fetch['id']; ?>"><i class="bx bx-edit-alt me-2"></i> Edit</a>

                              <?php
                                }
                              ?>
                              
                              <?php
                                if ($set_session->check_permission(['delete staff'])) {
                              ?>

                              <a class="dropdown-item" href="staff-list.view.php?id=<?php echo $fetch['id']; ?>" style="color: red;">
                                <i class="bx bx-trash me-2"></i> Delete
                              </a>

                              <?php
                                }
                              ?>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr></tr>
                    </tbody>

                    <?php
                    }
                    ?>

                  </table>
                </div>

              <!-- Delete button staff function -->
              <?php
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];

                    $sql = "UPDATE user SET status_id = 2 WHERE id = ?";
                    $query = $conn->prepare($sql);
                    $query->bind_param("i", $id);

                    $success = $query->execute();
                    mysqli_close($conn);

                    if ($success) {
                        // Use JavaScript to redirect after successful delete
                        echo '<script type="text/javascript">';
                        echo 'window.location.href = "/dashboard-framework-v1/src/view/staff-list.view.php";';
                        echo '</script>';
                        exit();
                    } else {
                        echo "Error deleting user data.";
                    }
                } 
              ?>


                          <!-- Pagination -->

                          <nav aria-label="Page navigation">
                          <form method="post" action="">
                          <!-- Include sorting information in hidden inputs -->
                          <input type="hidden" name="order_by" value="<?php echo $_GET['order_by'] ?? ''; ?>">
                          <input type="hidden" name="sort" value="<?php echo $_GET['sort'] ?? ''; ?>">

                          <input type="hidden" name="pagination_applied" value="<?php echo $filterApplied; ?>">
                          <input type="hidden" name="pagination_firstname" value="<?php echo $filterFirstName; ?>">
                          <input type="hidden" name="pagination_lastname" value="<?php echo $filterLastName; ?>">
                          <input type="hidden" name="pagination_role" value="<?php echo $filterRole; ?>">
                          <input type="hidden" name="pagination_suburb" value="<?php echo $filterSuburb; ?>">
                          <!-- Include other pagination parameters -->
                          <input type="hidden" name="row" value="<?php echo $row; ?>">
                          <input type="hidden" name="allcount" value="<?php echo $allcount; ?>">

                          <!-- Your pagination buttons here -->
                          <ul class="pagination justify-content-end">
                            <li class="page-item <?php echo ($row - $filterPerPage < 0) ? 'disabled' : ''; ?>">
                              <input type="submit" class="page-link" name="but_prev" value="Previous">
                            </li>

                            <?php for ($i = 1; $i <= $totalpages; $i++) { ?>
                              <li class="page-item <?php echo ($row / $filterPerPage + 1 === $i) ? 'active' : ''; ?>">
                                <input type="submit" class="page-link" name="page_num" value="<?php echo $i; ?>">
                              </li>
                            <?php } ?>

                            <li class="page-item <?php echo ($row + $filterPerPage >= $allcount) ? 'disabled' : ''; ?>">
                              <input type="submit" class="page-link" name="but_next" value="Next">
                              </li>
                          </ul>

                          </form>

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

    <!-- custom JS -->
    <script>
      var coll = document.getElementsByClassName("btn btn-outline-secondary collapsible");
      var i;

      for (i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function() {
          this.classList.toggle("active");
          var content = document.getElementById("filter");
          if (content.style.display === "block") {
            content.style.display = "none";
          } else {
            content.style.display = "block";
          }
        });
      }
    </script>

  </body>
</html>