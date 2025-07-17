<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/OrgListSession.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/Path.php';

  $set_session = new OrgListSession();
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

    

              <?php
                $organizations = $set_session->get_organizations();

                if ($organizations) {
              ?>
    
                  <h4 class="mb-2" style="text-align: center;">Select an organzation</h4>
                  
                  <form 
                    action="<?php echo $path->pageURL; ?>/dashboard-framework-v1/src/controller/select-org.controller.php" 
                    method="post" 
                    class="form"
                  > 

              <?php
                  foreach ($organizations as $organization) {
                ?>
      
                <div class="mb-3">
                  <button 
                    class="btn btn-outline-primary d-grid w-100" 
                    type="submit"
                    name="org_uuid"
                    value="<?php echo $organization->uuid; ?>"
                  >
                    <?php echo $organization->name; ?>
                  </button>
                </div>
  
              <?php
                  }

                } else {
              ?>
                <div class="alert alert-danger" role="alert" style="text-align: center;">
                  You have not joined any organzation yet.
                </div> 

              <?php
                }
              ?>

              <div class="mb-3">
                <a
                  href="<?php echo $path->pageURL; ?>/dashboard-framework-v1/src/controller/logout.controller.php"  
                  class="btn btn-danger d-grid w-100"
                >
                  Back
                </a>
              </div>




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
