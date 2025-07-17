<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/model/User.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/model/Organisation_has_user.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/model/Permission.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/model/Role.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/model/Organisation.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/Path.php';

use Atk4\Dsql\Mysql\Query as MysqlQuery;

//create session variable if user exist
class SessionVariable
{
    // email that user used to login
    public $email;

    // password that user used to login
    public $password;

    // ID field in users table
    // Once user login, set this propoty and stor in session
    public $user_id;

    // If $user_id only has one record in org_has_user table, then set the following two propoties and stor in session
    // If $user_id only has more then one record in org_has_user table, then don't set the following two propoties
    public $current_org_id;

    // ID field in org_has_user table
    // ID for their user profile for this specific org
    public $current_session_id;

    // If the user has several orgs, then set this propoty
    public $org_ids = array();

    // If the user has several orgs, then set this propoty
    public $session_ids = array();

    //Only set this propoty after setting $current_org_id, don't store in php session cuz it can be modified any time
    public $roles = array();

    //Only set this propoty after setting $current_org_id, don't store in php session cuz it can be modified any time
    public $permissions = array();

    //pass in false if you need authorise to return false and do further action
    //instead of redirecting the users to access denined page

    //Note: This parent class constructor should handle the logic for dashboard page
    //other pages should be handled 
    public function __construct($authorise_on_start = True)
    {
        /*$this->start_session();

            if ($default) {
                $this->authorise($default);
            }


            header("Location: ".$default);*/

        $this->start_session();

        if ($authorise_on_start) {
            $path = new Path();

            if ($this->authorise()) {

                //if the users have not selected an organzation,
                //rediect them back to organization list page
                if (isset($_SESSION["current_org_id"])) {

                    //check if the users is joining the org
                    if ($this->verifty_joined_org()) {


                        // print("<br><br>session class<pre>".print_r($set_session,true)."</pre>");
                        // print("<br><br>session variable<pre>".print_r($_SESSION,true)."</pre>");

                        $this->set_sessions_properties();


                        // print("<br><br>session class<pre>".print_r($set_session,true)."</pre>");
                        // print("<br><br>session variable<pre>".print_r($_SESSION,true)."</pre>");

                    } else {
                        $this->destory_session();
                        header("Location: " . $path->pageURL . "/dashboard-framework-v1/src/view/login.view.php");
                    }
                } else {
                    header("Location: " . $path->pageURL . "/dashboard-framework-v1/src/view/org-list.view.php");
                }
            } else {
                header("Location: " . $path->pageURL . "/dashboard-framework-v1/src/view/403.view.php");
            }
        }
    }

    //set session variable and properties ater user authenticate successfully
    public function set_sessions_properties()
    {

        if (isset($_SESSION["user_id"])) {
            $this->user_id = $_SESSION["user_id"];
        }
        // else {
        //     $_SESSION["user_id"] = $this->user_id;

        //get all permission related data of a user and then store it into a session variable
        $this->get_org_has_user();

        //if the user only joined one organization 
        if (empty($this->org_ids)) {
            $_SESSION["current_org_id"] = $this->current_org_id;
            $_SESSION["current_session_id"] = $this->current_session_id;


            $this->get_role();
            // print("<br><br>role<pre>".print_r($this->roles,true)."</pre>");

            $this->get_permission();
            // print("<br><br>permission<pre>".print_r($this->permissions,true)."</pre>");

        } elseif (!empty($this->org_ids)) {

            if (!isset($_SESSION["current_org_id"]) && !isset($_SESSION["current_session_id"])) {

                if (isset($this->current_org_id) && isset($this->current_session_id)) {
                    $_SESSION["current_org_id"] = $this->current_org_id;
                    $_SESSION["current_session_id"] = $this->current_session_id;

                    $this->get_role();
                    // print("<br><br>role<pre>".print_r($this->roles,true)."</pre>");

                    $this->get_permission();
                    // print("<br><br>permission<pre>".print_r($this->permissions,true)."</pre>");
                }
            } else {

                // $_SESSION["current_org_id"] = $this->current_org_id;
                // $_SESSION["current_session_id"] = $this->current_session_id;

                // $this->get_role();
                // print("<br><br>role<pre>".print_r($this->roles,true)."</pre>");

                // $this->get_permission();
                // print("<br><br>permission<pre>".print_r($this->permissions,true)."</pre>");

                $this->current_org_id = $_SESSION["current_org_id"];
                $this->current_session_id = $_SESSION["current_session_id"];

                $this->get_role();
                // print("<br><br>role<pre>".print_r($this->roles,true)."</pre>");

                $this->get_permission();
                // print("<br><br>permission<pre>".print_r($this->permissions,true)."</pre>");
            }
        }

        return true;
    }

    //check if username and password correct
    //if so, return true. Otherwise return false
    public function authenticate(string $email, string $password)
    {
        #construct query to retrieve record that match the email that user enter
        $query = new MysqlQuery();
        $query
            ->table('user')
            ->field(['ID', 'Email', 'Password'])
            ->where('Email', '=', $email);
        $query->params = [$email];

        //get users
        $get_users = new User(true);
        $users = $get_users->get_users($query);
        echo "<pre>Users result: " . print_r($users, true) . "</pre>";
        exit;


        // if ($users) {
        //     $this->user_id = $users[0]->ID;
        // } else {
        //     $auth_status = false;
        //     return $auth_status;
        // }

        if (!$users) {
            $auth_status = false;
            return $auth_status;
        }


        // print("<pre>".print_r($users,true)."</pre>");

        if (password_verify($password, $users[0]->Password)) {
            $this->user_id = $users[0]->ID;
            $_SESSION["user_id"] = $this->user_id;
            $_SESSION['login_status'] = true;
            echo "login successfully";
            echo "<br><br>";
            // $auth_status = true;
        } else {
            $_SESSION['login_status'] = false;
        }

        return $_SESSION['login_status'];
    }


    public function get_org_has_user()
    {
        $query = new MysqlQuery();
        $query
            ->field("organisation_has_user.id")
            ->field("organisation_has_user.organisation_id")
            ->table("organisation_has_user")
            ->join("user.id", "organisation_has_user.user_id", "inner")
            ->join("organisation.id", "organisation_has_user.organisation_id", "inner")
            ->where("user.id", "=", $this->user_id)
            ->where("user.status_id", "=", 1)
            ->where("organisation_has_user.status_id", "=", 1)
            ->where("organisation.status_id", "=", 1);

        // echo "<br><br>";
        // echo $query->render();
        // echo "<br><br>";

        //get session data
        $get_session_data = new Organisation_has_user();
        $session_data = $get_session_data->get_session_data($query);

        //if there is record retrun
        if ($session_data) {

            if (count($session_data) > 1) {

                $temp_session_ids = array();
                $temp_org_ids = array();

                foreach ($session_data as $data) {

                    array_push($temp_session_ids, $data->id);
                    array_push($temp_org_ids, $data->organisation_id);
                }

                $this->session_ids = $temp_session_ids;
                $this->org_ids = $temp_org_ids;
            } else {
                $this->current_org_id = $session_data[0]->organisation_id;
                $this->current_session_id = $session_data[0]->id;
            }

            //if there is no record return
        } else {
            // echo "No matched record";
            return false;
        }
    }

    //get role base on $_SESSION["current_session_id"]
    public function get_role()
    {
        $query = new MysqlQuery();
        $query
            ->field([
                'role.id',
                'role.name'
            ])
            ->table('role')
            ->join('user_has_role.role_id', 'role.id', 'inner')
            ->join('organisation_has_user.id', 'user_has_role.organisation_has_user_id', 'inner')
            ->join('organisation.id', 'organisation_has_user.organisation_id', 'inner')
            ->where("organisation_has_user.id", "=", $_SESSION["current_session_id"])
            ->where("organisation_has_user.status_id", "=", 1)
            ->where("organisation.status_id", "=", 1);

        // echo "<br><br>";
        // echo $query->render();
        // echo "<br><br>";

        //get permission
        $get_role = new Role();
        $role = $get_role->get_role($query);
        $this->roles = $role;
    }

    //get permission base on $_SESSION["current_session_id"]
    public function get_permission()
    {
        $query = new MysqlQuery();
        $query
            ->field([
                'permission.id',
                'permission.name'
            ])
            ->table('permission')
            ->join('role_has_permission.permission_id', 'permission.id', 'inner')
            ->join('role.id', 'role_has_permission.role_id', 'inner')
            ->join('user_has_role.role_id', 'role.id', 'inner')
            ->join('organisation_has_user.id', 'user_has_role.organisation_has_user_id', 'inner')
            ->join('organisation.id', 'organisation_has_user.organisation_id', 'inner')
            ->where("organisation_has_user.id", "=", $_SESSION["current_session_id"])
            ->where("organisation_has_user.status_id", "=", 1)
            ->where("organisation.status_id", "=", 1);

        // echo "<br><br>";
        // print("Query that get permisssion:<pre>".print_r($query,true)."</pre>");
        // echo "<br><br>";

        //get permission
        $get_permission = new Permission();
        $permission = $get_permission->get_permissions($query);
        $this->permissions = $permission;
    }

    //check if the user has logged in
    //pass in true if you need the function to return false
    //instead
    public function authorise()
    {

        if ((isset($_SESSION['login_status'])) && ($_SESSION['login_status'] == true)) {
            return true;
        } else {
            return false;
        }
    }

    //get session variables and assign them to the property
    public function get_session()
    {

        if (isset($_SESSION["user_id"])) {
            $this->user_id = $_SESSION["user_id"];
        } else {
            echo "no user_id set in session";
        }

        if (isset($_SESSION["current_org_id"])) {
            $this->current_org_id = $_SESSION["current_org_id"];
        } else {
            echo "no current_org_id set in session";
        }

        if (isset($_SESSION["current_session_id"])) {
            $this->current_session_id = $_SESSION["current_session_id"];
        } else {
            echo "no current_session_id set in session";
        }
    }

    //check if the permission list contain passed in permissions
    public function check_permission(array $require_permissions = null, bool $all = true)
    {

        if (empty($this->permissions)) {
            $this->get_permission();
        }

        $transformed_permissions = array();

        if (!$this->permissions) {
            return false;
        } else {
            foreach ($this->permissions as $permission) {
                array_push($transformed_permissions, $permission->name);
            }
        }

        if ($all) {


            //check if the users has all the require permissions
            if (empty(array_diff($require_permissions, $transformed_permissions))) {
                //echo "user has all the require permission<br><br>";
                return true;
            } else {
                //echo "user does not have all the require permission<br><br>";
                return false;
            }
        } else {
            //TODO: check if any requier permission exist in the permission that the users have

            if (empty(array_intersect($transformed_permissions, $require_permissions))) {
                echo "user does not have any of the require permission<br><br>";
                return false;
            } else {
                echo "user has at least one of the require permission<br><br>";
                return true;
            }
        }
    }


    //get organizations base on $org_ids or $_SESSION["current_org_id"]
    public function get_organizations(string $uuid = null)
    {
        $query = new MysqlQuery();
        $query
            ->field([
                'organisation.id',
                'organisation.uuid',
                'organisation.name'
            ])
            ->table('organisation')
            ->where("organisation.status_id", "=", 1);


        if (is_null($uuid)) {

            if (!empty($this->org_ids)) {

                $or_clause = array();

                foreach ($this->org_ids as $org_id) {

                    array_push($or_clause, ["organisation.id", "=", $org_id]);
                    // $query
                    // ->where("organisation.id", "=", $org_id);
                }

                $query
                    ->where($or_clause);
            } else {
                $query
                    ->where("organisation.id", "=", $_SESSION["current_org_id"]);
            }
        } else {
            $query
                ->where("organisation.uuid", "=", $uuid);
        }


        // echo "<br><br>";
        // echo $query->render();
        // echo "<br><br>";

        // print("<br><br>query<pre>".print_r($query,true)."</pre>");

        //get organizations
        $get_organizations = new Organisation();
        $organizations = $get_organizations->get_oganisation($query);
        return $organizations;
    }

    //verify if the user joined a company 
    public function verifty_joined_org(string $uuid = null, $switch_org = false)
    {

        if (is_null($uuid)) {
            $query = new MysqlQuery();

            $query
                ->field(['id'])
                ->table("organisation_has_user")
                ->where("organisation_has_user.user_id", "=", $_SESSION["user_id"])
                ->where("organisation_has_user.id", "=", $_SESSION['current_session_id'])
                ->where("organisation_has_user.status_id", "=", 1);

            // echo "<br><br>";
            // echo $query->render();
            // echo "<br><br>";

            // print("<br><br>query<pre>".print_r($query,true)."</pre>");

            //verify if the user joined a company 
            $get_org_has_user = new Organisation_has_user();
            $org_has_user = $get_org_has_user->get_session_data($query);

            // print("<br><br>org_has_user<pre>".print_r($org_has_user,true)."</pre>");

            //if there is record retrun, which means user joined the org
            if ($org_has_user) {
                // echo "user joined the org";
                $user_joined_org = true;
                //if there is no record return, which means user did not join the org
            } else {
                // echo "user did not join the org";
                $user_joined_org = false;
            }

            return $user_joined_org;
        } else {
            $org_id = $this->get_organizations($uuid);
        }



        //check if uuid exist in org table or user is joinin an org
        if ($org_id) {
            $query = new MysqlQuery();

            $query
                ->field(['id'])
                ->table("organisation_has_user")
                ->where("organisation_has_user.user_id", "=", $_SESSION["user_id"])
                ->where("organisation_has_user.organisation_id", "=", $org_id[0]->id)
                ->where("organisation_has_user.status_id", "=", 1);

            // echo "<br><br>";
            // echo $query->render();
            // echo "<br><br>";

            // print("<br><br>query<pre>".print_r($query,true)."</pre>");

            //verify if the user joined a company 
            $get_org_has_user = new Organisation_has_user();
            $org_has_user = $get_org_has_user->get_session_data($query);

            // print("<br><br>org_has_user<pre>".print_r($org_has_user,true)."</pre>");

            //if there is record retrun, which means user joined the org
            if ($org_has_user) {
                echo "user joined " . $org_id[0]->name;

                if ($switch_org) {
                    $this->current_org_id = $org_id[0]->id;
                    $this->current_session_id = $org_has_user[0]->id;
                    $_SESSION["current_org_id"] = $org_id[0]->id;
                    $_SESSION["current_session_id"] = $org_has_user[0]->id;
                    $this->set_sessions_properties();
                }

                $user_joined_org = true;
                //if there is no record return, which means user did not join the org
            } else {
                echo "user did not join  " . $org_id[0]->name;
                $user_joined_org = false;
            }

            return $user_joined_org;
        } else {
            echo "uuid does not exist in org table";
            return false;
        }
    }

    //nice to have
    public static function start_session()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
            // echo 'session started';
            // echo '<br><br>';
            return true;
        } else {
            // echo 'session already started';
            // echo '<br><br>';
            return false;
        }
    }

    public static function destory_session()
    {
        self::start_session();

        // remove all session variables
        session_unset();

        // destroy the session
        session_destroy();

        if (session_status() === PHP_SESSION_NONE) {
            // echo "session destoryed successfully";
            // echo '<br><br>';
            return true;
        } else {
            // echo "session still exist";
            // echo '<br><br>';
            return false;
        }
    }
}
