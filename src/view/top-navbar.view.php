<?php

    class TopNavBar {
        // Properties
        public SessionVariable $set_session;
        public function __construct(SessionVariable $set_session) {
            $this->set_session = $set_session;
        }

        // Methods
        public function topNavBar_html() : void {
            require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/Path.php';
            $path = new Path();

?>

    <nav
        class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
        id="layout-navbar"
        >
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>
        
        <?php
            $this->set_session->set_sessions_properties();
            
            $organizations = $this->set_session->get_organizations();

            if (count($organizations) == 1) {
        ?>
                <button type="button" class="btn btn-primary" style="white-space: nowrap;">
    
                <?php
                    echo $organizations[0]->name;
                ?>

            </button>
        <?php
            } else {
        ?>

       


                <form 
                    action="<?php echo $path->pageURL; ?>/dashboard-framework-v1/src/controller/select-org.controller.php" 
                    method="POST"
                    id="my_form"
                >

                    <!-- <div class="navbar-nav d-flex align-items-center" id="navbar-collapse">
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">TechUp Tasmania</button>
                            <ul class="dropdown-menu" onchange="this.form.submit()">
        
                                <?php
                                    //foreach ($organizations as $organization) {
                                ?>

                                    <li>
                                        <a 
                                            name="org_uuid"
                                            value="<?php //echo $organization->uuid; ?>"
                                            class="dropdown-item" 
                                            onclick="document.getElementById('my_form').submit();"
                                        >
                                            <?php //echo $organization->name; ?>
                                        </a>
                                    </li>
        
                                <?php
                                    //}
                                ?>
                            </ul>
                        </div> 
                    </div> -->


                    <select 
                        class="btn btn-outline-primary" 
                        data-bs-toggle="dropdown" 
                        aria-expanded="false" 
                        name="org_uuid" 
                        onchange="this.form.submit()"
                    >
        
                    <?php
                        foreach ($organizations as $organization) {
                    ?>

                        <option 
                            value= <?php echo $organization->uuid ?>
                            <?php
                                if ($organization->id == $this->set_session->current_org_id) { 
                                    echo "selected"; 
                                } 
                            ?>

                        >
        
                        <?php
                            echo $organization->name;
                        ?>

                        </option>
        
                    <?php
                        }
                    ?>

                    </select>

                </form>
        
        <?php
            }
        ?>
        
        <?php

        ?>

        <?php 
            include $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/controller/profile.controller.php';
         ?>
        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

            <ul class="navbar-nav flex-row align-items-center ms-auto">

            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                <div class="avatar avatar-online">
                    <?php if ($profile->photo_path != null): ?>
                        <img src="<?php echo $profile->photo_path ?>" alt class="w-px-40 h-auto rounded-circle" />
                    <?php else: ?>
                        <img src="../assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                    <?php endif ?>
                    
                </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="#">
                    <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                        <div class="avatar avatar-online">
                            <?php if ($profile->photo_path != null): ?>
                                <img src="<?php echo $profile->photo_path ?>" alt class="w-px-40 h-auto rounded-circle" />
                            <?php else: ?>
                                <img src="../assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                            <?php endif ?>
                        </div>
                        </div>
                        <div class="flex-grow-1">
                        <span class="fw-semibold d-block"><?php echo $profile->first_name.' '.$profile->last_name ?></span>
                        <small class="text-muted"><?php echo $profile->role ?></small>
                        </div>
                    </div>
                    </a>
                </li>
                <li>
                    <div class="dropdown-divider"></div>
                </li>
                <li>
                    <a class="dropdown-item" href="profile.view.php">
                    <i class="bx bx-user me-2"></i>
                    <span class="align-middle">My Profile</span>
                    </a>
                </li>
                <li>
                    <div class="dropdown-divider"></div>
                </li>
                <li>
                    <a class="dropdown-item" href="<?php echo $path->pageURL; ?>/dashboard-framework-v1/src/controller/logout.controller.php">
                    <i class="bx bx-power-off me-2"></i>
                    <span class="align-middle">Log Out</span>
                    </a>
                </li>
                </ul>
            </li>
            <!--/ User -->
            </ul>
        </div>
        </nav>

<?php            
        }
    }

?>


        