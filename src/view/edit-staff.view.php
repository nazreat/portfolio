<?php
  include_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/view/sidebar.view.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/view/top-navbar.view.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/SessionVariable.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/Path.php';
  $set_session = new SessionVariable();
  $path = new Path();

  if (!$set_session->check_permission(['edit staff'])) {
    header("Location: " . $path->pageURL . "/dashboard-framework-v1/src/view/403.view.php");
  }

    
  include_once("../model/User.php");
  $U = new User();

  if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $userInfo = $U->getUserInfoFromID($id);
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
                Edit Staff
              </h4>
              <form id="formstaffsettings" method="POST" action="<?php echo $path->pageURL; ?>/dashboard-framework-v1/src/controller/update-staff.controller.php?id=<?php echo $id?>" enctype="multipart/form-data">
              <div class="row">
                <div class="col-md-12">
                  <div class="card mb-4">
                    <h5 class="card-header">Staff details</h5>
                    <!-- Account -->
                    <div class="card-body">
                      <div class="d-flex align-items-start align-items-sm-center gap-4">
                      <img
                         <?php 
                         if ($userInfo['photo_path'] == null)
                          {
                            echo "src='../assets/img/avatars/1.png'";
                          }else
                            echo "src=". $userInfo['photo_path'];
                          ?>
             
                          alt="user-avatar"
                          class="d-block rounded"
                          height="100"
                          width="100"
                          id="uploadedAvatar"
                        />
                        <div class="button-wrapper">
                          <label for="upload" class="btn btn-outline-primary me-2 mb-4" tabindex="0">
                            <span class="d-none d-sm-block">Upload a photo</span>
                            <i class="bx bx-upload d-block d-sm-none"></i>
                            <input
                              type="file"
                              id="upload"
                              class="account-file-input"
                              name="staffImage"
                              hidden
                              accept="image/png, image/jpeg"
                            />
                          </label>
                          <button type="button" class="btn btn-outline-danger account-image-reset mb-4">
                            <i class="bx bx-reset d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Reset</span>
                          </button>

                          <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                        </div>
                      </div>
                    </div>
                    <hr class="my-0" />
                    <div class="card-body">
                      <form id="formAccountSettings" method="POST" onsubmit="return false">
                        <div class="row">
                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label">First Name</label>
                            <input
                              class="form-control"
                              type="text"
                              id="firstName"
                              name="firstName"
                              <?php 
                            if($userInfo['first_name']!=NULL && $userInfo['first_name']!="" )
                            echo "value= '".$userInfo['first_name']."'";
                            ?>
                              placeholder="First Name"
                              
                            />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input 
                            class="form-control" 
                            type="text" 
                            name="lastName" 
                            id="lastName" 
                            <?php 
                            if($userInfo['last_name']!=NULL && $userInfo['last_name']!="" )
                            echo "value= '".$userInfo['last_name']."'";
                            ?>
                            placeholder="Last Name"
                            />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="username" class="form-label">Username</label>
                            <input 
                            class="form-control" 
                            type="text" 
                            name="username" 
                            id="username" 
                            <?php 
                            if($userInfo['username']!=NULL && $userInfo['username']!="" )
                            echo "value= '".$userInfo['username']."'";
                            ?>
                            placeholder="Username"
                            />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input
                              class="form-control"
                              type="text"
                              id="email"
                              name="email"
                              <?php 
                              if($userInfo['email']!=NULL && $userInfo['email']!="" )
                              echo "value= '".$userInfo['email']."'";
                              ?>
                              placeholder="example@email.com"
                              
                            />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="role" class="form-label">Role</label>
                            <input 
                            class="form-control" 
                            type="text" 
                            name="role" 
                            id="role" 
                            <?php 
                              if($userInfo['role']!=NULL && $userInfo['role']!="" )
                              echo "value= '".$userInfo['role']."'";
                              ?>
                            placeholder="Role"
                            />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label class="form-label" for="phoneNumber">Phone Number</label>
                            <div class="input-group input-group-merge">
                              <span class="input-group-text">AUS (+61)</span>
                              <input
                                type="text"
                                id="phoneNumber"
                                name="phoneNumber"
                                class="form-control"
                                placeholder="Phone Numnber"
                                <?php 
                              if($userInfo['phone']!=NULL && $userInfo['phone']!="" )
                              echo "value= '".$userInfo['phone']."'";
                              ?>
                                
                              />
                            </div>
                          </div>
                       
                          <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Suburb</label>
                            <input type="text" class="form-control" id="suburb" name="suburb" placeholder="Suburb"
                            <?php 
                              if($userInfo['suburb']!=NULL && $userInfo['suburb']!="" )
                              echo "value= '".$userInfo['suburb']."'";
                              ?>
                              />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="state" class="form-label">State</label>
                            <select id="state" name="state" class="select2 form-select">
                              <option disabled selected value>-- Select a state --</option>
                              <option value="ACT" <?php if($userInfo['state']=="ACT") echo "selected" ;?> >Australian Capital Territory</option>
                              <option value="NSW" <?php if($userInfo['state']=="NSW") echo "selected" ;?> >New South Wales</option>
                              <option value="NT " <?php if($userInfo['state']=="NT ") echo "selected" ;?>>Northern Territory</option>
                              <option value="QLD" <?php if($userInfo['state']=="QLD") echo "selected" ;?>>Queensland</option>
                              <option value="SA " <?php if($userInfo['state']=="SA ") echo "selected" ;?>>South Australia</option>
                              <option value="TAS" <?php if($userInfo['state']=="TAS") echo "selected" ;?>>Tasmania</option>
                              <option value="VIC" <?php if($userInfo['state']=="VIC") echo "selected" ;?>>Victoria</option>
                              <option value="WA " <?php if($userInfo['state']=="WA ") echo "selected" ;?>>Western Australia</option>
                            </select>
                          </div>
                        </div>
                        <div class="mt-2">
                          <a href="staff-list.view.php">
                            <button type="submit" class="btn btn-outline-primary me-2">
                              Save
                            </button>
                          </a>

                          <a href="staff-list.view.php">
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
