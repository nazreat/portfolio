<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/LoginSession.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/Path.php';

  //new way
  $set_session = new LoginSession();
  $path = new Path();

?>

<!DOCTYPE html>

<html
  lang="en"
  class="light-style customizer-hide"
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
    <!-- Page -->
    <link rel="stylesheet" href="../assets/vendor/css/pages/page-auth.css" />
    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../assets/js/config.js"></script>
  </head>

  <body>
    <!-- Content -->

    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register -->
          <div class="card">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center">
                <a class="app-brand-link gap-2">
              <img
              src="../assets/img/TechUpTasLogo.png"
              height="50"
              alt="View Badge User"
              data-app-dark-img="illustrations/man-with-laptop-dark.png"
              data-app-light-img="illustrations/man-with-laptop-light.png"
            />
                  <span class="menu-text fw-bolder ms-2" style="font-size: 40px; color: #1775F1;">VAT</span>
                </a>
              </div>
              <!-- /Logo -->
              <h4 class="mb-2">Welcome to <span style="color: #1775F1;">VAT</span>! 👋</h4>
              <p class="mb-4">Please sign-in to your account and start the adventure</p>

              <?php

                if (isset($_GET["wrongDetails"])) {

              ?>

                <div class="alert alert-danger" role="alert" style="text-align: center;">
                    Wrong email or password
                </div>  

              <?php
                  
                } elseif (isset($_GET["missingDetails"])) {

              ?>

                <div class="alert alert-danger" role="alert" style="text-align: center;">
                    Missing email or password
                </div>  

              <?php
                } elseif (isset($_GET["wrongOrg"])) {
              ?>

                <div class="alert alert-danger" role="alert" style="text-align: center;">
                  Organization does not exist
                </div>  

              <?php
                } elseif (isset($_GET["permission"])) {
              ?>

                <div class="alert alert-danger" role="alert" style="text-align: center;">
                  You have no permission granted from <?php echo $_GET["org"] ?> yet.
                </div>  

              <?php
                }
              ?>

              

              <form 
                id="formAuthentication" 
                class="mb-3" 
                action="<?php echo $path->pageURL; ?>/dashboard-framework-v1/src/controller/login.controller.php" 
                method="POST"
              >
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input
                    type="email"
                    class="form-control"
                    id="email"
                    name="email"
                    placeholder="Enter your email"
                    autofocus
                    required
                  />
                </div>
                <div class="mb-3 form-password-toggle">
                  <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">Password</label>
                  </div>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password"
                      class="form-control"
                      name="password"
                      placeholder="Enter your password"
                      aria-describedby="password"
                      required
                    />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>
                
                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                </div>

              </form>
            </div>
          </div>
          <!-- /Register -->
        </div>
      </div>
    </div>

    <!-- / Content -->

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

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
