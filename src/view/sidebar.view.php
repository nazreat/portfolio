<?php

    class Sidebar {
        // Properties
        public $page; //set the page name active
        public SessionVariable $set_session;

        public function __construct(string $page = null, SessionVariable $set_session) {
            $this->page = $page;
            $this->set_session = $set_session;
        }
    
        // Methods
        public function sidebar_html() : void {
            $this->set_session->set_sessions_properties();
?>

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <img
                    src="../assets/img/TechUpTasLogo.png"
                    height="50"
                    alt="View Badge User"
                    data-app-dark-img="illustrations/man-with-laptop-dark.png"
                    data-app-light-img="illustrations/man-with-laptop-light.png"
                />
                    <span class="menu-text fw-bolder ms-2" style="font-size: 40px; color: #1775F1;">VAT</span>

                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                    <i class="bx bx-chevron-left bx-sm align-middle"></i>
                </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                <!-- Dashboard -->

                <?php
                    if ($this->set_session->check_permission(['view admin dashboard'])) {
                ?>

                <li class="menu-item <?php if ($this->page == "dashboard-admin") { echo " active"; } ?>">
                    <a href="dashboard-admin.view.php" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div data-i18n="Analytics">Dashboard (admin)</div>
                    </a>
                </li>

                <?php
                    }

                    if ($this->set_session->check_permission(['view volunteer dashboard'])) {
                ?>

                <li class="menu-item <?php if ($this->page == "dashboard-volunteers") { echo " active"; } ?>">
                    <a href="dashboard-volunteers.view.php" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div data-i18n="Analytics">Dashboard (volunteer)</div>
                    </a>
                </li>

                <?php
                    }

                    if ($this->set_session->check_permission(['view timesheets'])) {
                ?>

                <li class="menu-item <?php if ($this->page == "timesheets") { echo " active"; } ?>">
                    <a href="timesheets.view.php" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-time-five"></i>
                    <div data-i18n="Basic">Timesheets</div>
                    </a>
                </li>

                <?php
                    }

                    if ($this->set_session->check_permission(['view events'])) {
                ?>

                <li class="menu-item <?php if ($this->page == "events") { echo " active"; } ?>">
                    <a href="events.view.php" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-calendar-event"></i>
                    <div data-i18n="Basic">Events</div>
                    </a>
                </li>

                <?php
                    }

                    if ($this->set_session->check_permission(['view requests'])) {
                ?>

                <li class="menu-item <?php if ($this->page == "requests") { echo " active"; } ?>">
                    <a href="requests.view.php" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-envelope"></i>
                    <div data-i18n="Basic">Requests</div>
                    </a>
                </li>

                <?php
                    }

                    if ($this->set_session->check_permission(['view staff'])) {
                ?>

                <li class="menu-item <?php if ($this->page == "staff-list") { echo " active"; } ?>">
                    <a href="staff-list.view.php" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user-circle"></i>
                    <div data-i18n="Basic">Staff</div>
                    </a>
                </li>

                <?php
                    }
                ?>

                

                </ul>
            </aside>


<?php            
        }
    }

?>


        