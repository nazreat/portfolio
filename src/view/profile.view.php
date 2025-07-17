<?php
  include_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/view/sidebar.view.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/view/top-navbar.view.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/SessionVariable.php';
  include $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/controller/profile.controller.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/Path.php';
  $set_session = new SessionVariable();
  $path = new Path();
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
          $sidebar = new Sidebar(null, $set_session);
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
                Profile
              </h4>
              <form id="formAccountSettings" method="POST" action="<?php echo $path->pageURL; ?>/dashboard-framework-v1/src/controller/update-profile.controller.php" enctype="multipart/form-data">
              <div class="row">
                <div class="col-md-12">
                  <div class="card mb-4">
                    <h5 class="card-header">Profile details</h5>
                    <!-- Account -->
                    <div class="card-body">
                      <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img
                          <?php if ($profile->photo_path == null): ?>
                            src="../assets/img/avatars/1.png"
                          <?php else: ?>
                            src = "<?php echo $profile->photo_path ?>"
                          <?php endif ?>
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
                              hidden
                              accept="image/png, image/jpeg"
                              name = "profileImage"
                            />
                          </label>
                          <button type="button" class="btn btn-outline-danger account-image-reset mb-4">
                            <i class="bx bx-reset d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Reset</span>
                          </button>

                          <p class="text-muted mb-0">Allowed JPEG or PNG. Max size of 800K</p>
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
                              name="first_name"
                              value="<?php echo $profile->first_name ?>"
                              placeholder="First Name"
                            />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input 
                            class="form-control" 
                            type="text" 
                            name="last_name" 
                            id="lastName" 
                            value="<?php echo $profile->last_name ?>" 
                            placeholder="Last Name"/>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="username" class="form-label">Username</label>
                            <input 
                            class="form-control" 
                            type="text" 
                            name="username" 
                            id="username" 
                            value="<?php echo $profile->username ?>" 
                            placeholder="Username"/>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input
                              class="form-control"
                              type="text"
                              id="email"
                              name="email"
                              value="<?php echo $profile->email ?>"
                              placeholder="example@email.com"
                            />
                          </div>
                          <div class="mb-3 col-md-6">
                          <label for="role" class="form-label">Role</label>
                            <select id="role" name="role" class="form-select">
                              <?php if ($profile->role != null): ?>
                                  <option selected value="<?php echo $profile->role ?>"><?php echo $profile->role ?></option>
                              <?php endif ?>
                              <option disabled value>-- Select a role --</option>
                              <option value="volunteer">Volunteer</option>
                              <option value="Founding developer">Supervisor</option>
                              <option value="Founding developer">Admin</option>
                            </select>
                          </div>

                      

                          <div class="mb-3 col-md-6">
                            <label class="form-label" for="phoneNumber">Phone Number</label>
                            <div class="input-group input-group-merge">
                              <span class="input-group-text">AUS (+61)</span>
                              <input
                                type="text"
                                id="phoneNumber"
                                name="phone"
                                class="form-control"
                                placeholder="123-456-789"
                                value="<?php echo $profile->phone ?>"
                              />
                            </div>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Suburb</label>
                            <select id="suburb" name="suburb" class="select2 form-select">
                            <?php if ($profile->suburb != null): ?>
                                  <option selected value="<?php echo $profile->suburb ?>"><?php echo $profile->suburb ?></option>
                              <?php endif ?>
                            <option disabled value>-- Select a suburb --</option>      
                            <option value="Acton Park">Acton Park</option>
                            <option value="Austins Ferry">Austins Ferry</option>
                            <option value="Bagdad">Bagdad</option>
                            <option value="Battery Point">Battery Point</option>
                            <option value="Beaconsfield">Beaconsfield</option>
                            <option value="Beauty Point">Beauty Point</option>
                            <option value="Bellerive">Bellerive</option>
                            <option value="Berriedale">Berriedale</option>
                            <option value="Blackmans Bay">Blackmans Bay</option>
                            <option value="Blackstone Heights">Blackstone Heights</option>
                            <option value="Break O'Day">Break O'Day</option>
                            <option value="Bridgewater">Bridgewater</option>
                            <option value="Bridport">Bridport</option>
                            <option value="Brighton">Brighton</option>
                            <option value="Burnie">Burnie</option>
                            <option value="Cambridge">Cambridge</option>
                            <option value="Central Coast">Central Coast</option>
                            <option value="Central Highlands">Central Highlands</option>
                            <option value="Chigwell">Chigwell</option>
                            <option value="Circular Head">Circular Head</option>
                            <option value="Claremont">Claremont</option>
                            <option value="Clarence">Clarence</option>
                            <option value="Clarendon Vale">Clarendon Vale</option>
                            <option value="Cressy">Cressy</option>
                            <option value="Currie">Currie</option>
                            <option value="Cygnet">Cygnet</option>
                            <option value="Deloraine">Deloraine</option>
                            <option value="Derwent Valley">Derwent Valley</option>
                            <option value="Devonport">Devonport</option>
                            <option value="Dodges Ferry">Dodges Ferry</option>
                            <option value="Dorset">Dorset</option>
                            <option value="Dynnyrne">Dynnyrne</option>
                            <option value="East Devonport">East Devonport</option>
                            <option value="East Launceston">East Launceston</option>
                            <option value="Evandale">Evandale</option>
                            <option value="Flinders">Flinders</option>
                            <option value="Franklin">Franklin</option>
                            <option value="Gagebrook">Gagebrook</option>
                            <option value="Geeveston">Geeveston</option>
                            <option value="Geilston Bay">Geilston Bay</option>
                            <option value="George Town">George Town</option>
                            <option value="Glamorgan/Spring Bay">Glamorgan/Spring Bay</option>
                            <option value="Glenorchy">Glenorchy</option>
                            <option value="Goodwood">Goodwood</option>
                            <option value="Granton">Granton</option>
                            <option value="Hadspen">Hadspen</option>
                            <option value="Herdsmans Cove">Herdsmans Cove</option>
                            <option value="Hillcrest">Hillcrest</option>
                            <option value="Hobart">Hobart</option>
                            <option value="Hobart city centre">Hobart city centre</option>
                            <option value="Howrah">Howrah</option>
                            <option value="Huon Valley">Huon Valley</option>
                            <option value="Huonville">Huonville</option>
                            <option value="Invermay">Invermay</option>
                            <option value="Kentish">Kentish</option>
                            <option value="King Island">King Island</option>
                            <option value="Kingborough">Kingborough</option>
                            <option value="Kings Meadows">Kings Meadows</option>
                            <option value="Kingston">Kingston</option>
                            <option value="Kingston Beach">Kingston Beach</option>
                            <option value="Latrobe">Latrobe</option>
                            <option value="Lauderdale">Lauderdale</option>
                            <option value="Launceston">Launceston</option>
                            <option value="Launceston city centre">Launceston city centre</option>
                            <option value="Legana">Legana</option>
                            <option value="Lenah Valley">Lenah Valley</option>
                            <option value="Lindisfarne">Lindisfarne</option>
                            <option value="Longford">Longford</option>
                            <option value="Lutana">Lutana</option>
                            <option value="Margate">Margate</option>
                            <option value="Mayfield">Mayfield</option>
                            <option value="Meander Valley">Meander Valley</option>
                            <option value="Miandetta">Miandetta</option>
                            <option value="Midway Point">Midway Point</option>
                            <option value="Montello">Montello</option>
                            <option value="Montrose">Montrose</option>
                            <option value="Moonah">Moonah</option>
                            <option value="Mornington">Mornington</option>
                            <option value="Mount Nelson">Mount Nelson</option>
                            <option value="Mount Stuart">Mount Stuart</option>
                            <option value="Mowbray">Mowbray</option>
                            <option value="New Norfolk">New Norfolk</option>
                            <option value="New Town">New Town</option>
                            <option value="Newnham">Newnham</option>
                            <option value="Newstead">Newstead</option>
                            <option value="North Hobart">North Hobart</option>
                            <option value="Northern Midlands">Northern Midlands</option>
                            <option value="Norwood">Norwood</option>
                            <option value="Oakdowns">Oakdowns</option>
                            <option value="Old Beach">Old Beach</option>
                            <option value="Park Grove">Park Grove</option>
                            <option value="Penguin">Penguin</option>
                            <option value="Perth">Perth</option>
                            <option value="Port Sorell">Port Sorell</option>
                            <option value="Prospect Vale">Prospect Vale</option>
                            <option value="Queenstown">Queenstown</option>
                            <option value="Ranelagh">Ranelagh</option>
                            <option value="Ravenswood">Ravenswood</option>
                            <option value="Richmond">Richmond</option>
                            <option value="Risdon Vale">Risdon Vale</option>
                            <option value="Riverside">Riverside</option>
                            <option value="Rocherlea">Rocherlea</option>
                            <option value="Rokeby">Rokeby</option>
                            <option value="Romaine">Romaine</option>
                            <option value="Rosetta">Rosetta</option>
                            <option value="Saint Leonards">Saint Leonards</option>
                            <option value="Sandford">Sandford</option>
                            <option value="Sandy Bay">Sandy Bay</option>
                            <option value="Scottsdale">Scottsdale</option>
                            <option value="Seven Mile Beach">Seven Mile Beach</option>
                            <option value="Shearwater">Shearwater</option>
                            <option value="Sheffield">Sheffield</option>
                            <option value="Shorewell Park">Shorewell Park</option>
                            <option value="Smithton">Smithton</option>
                            <option value="Snug">Snug</option>
                            <option value="Somerset">Somerset</option>
                            <option value="Sorell">Sorell</option>
                            <option value="South Hobart">South Hobart</option>
                            <option value="South Launceston">South Launceston</option>
                            <option value="Southern Midlands">Southern Midlands</option>
                            <option value="Spreyton">Spreyton</option>
                            <option value="St Helens">St Helens</option>
                            <option value="Summerhill">Summerhill</option>
                            <option value="Taroona">Taroona</option>
                            <option value="Tasman Peninsula">Tasman Peninsula</option>
                            <option value="Tranmere">Tranmere</option>
                            <option value="Trevallyn">Trevallyn</option>
                            <option value="Turners Beach">Turners Beach</option>
                            <option value="Ulverstone">Ulverstone</option>
                            <option value="Upper Burnie">Upper Burnie</option>
                            <option value="Waratah/Wynyard">Waratah/Wynyard</option>
                            <option value="Warrane">Warrane</option>
                            <option value="Waverley">Waverley</option>
                            <option value="West Coast">West Coast</option>
                            <option value="West Hobart">West Hobart</option>
                            <option value="West Launceston">West Launceston</option>
                            <option value="West Moonah">West Moonah</option>
                            <option value="West Tamar">West Tamar</option>
                            <option value="West Ulverstone">West Ulverstone</option>
                            <option value="Westbury">Westbury</option>
                            <option value="Wynyard">Wynyard</option>
                            <option value="Youngtown">Youngtown</option>
                          </select>
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="state" class="form-label">State</label>
                            <select id="state" name="state" class="select2 form-select">
                              <?php if ($profile->state != null): ?>
                                  <option selected value="<?php echo $profile->state ?>"><?php echo $profile->state ?></option>
                              <?php endif ?>
                              <option disabled value>-- Select a state --</option>
                              <option value="Australian Capital Territory">Australian Capital Territory</option>
                              <option value="New South Wales">New South Wales</option>
                              <option value="Northern Territory">Northern Territory</option>
                              <option value="Queensland">Queensland</option>
                              <option value="South Australia">South Australia</option>
                              <option value="Tasmania">Tasmania</option>
                              <option value="Victoria">Victoria</option>
                              <option value="Western Australia">Western Australia</option>
                            </select>
                          </div>
                        </div>
                        <div class="mt-2">
                          <a href="dashboard-admin.view.php">
                            <button type="submit" class="btn btn-outline-primary me-2">
                              Save
                            </button>
                          </a>

                          <a href="dashboard-admin.view.php">
                            <button type="button" class="btn btn-outline-danger me-2">
                              Back
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
