<?php
    use Atk4\Dsql\Query;
    require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/model/Base.php';
    include_once($_SERVER['DOCUMENT_ROOT'] . "/dashboard-framework-v1/db_conn.php");

    // class User 
    class User
    {
        public int $id;
        public string $first_name;
        public string $last_name;
        public ?string $preferred_name;
        public string $email;
        public ?string $address;
        public ?string $state;
        public ?string $phone;
        public string $username;
        public string $password;
        public ?string $photo_path ;
        public int $status_id;
        public DateTime $created_at;
        public string $uuid;
        public string $role;

        //get users
        public function get_users(Query $query) {
            $get_users = new Base(true);
            $users = $get_users->getData($query, 'class', 'User');
            return $users;
        }

        public function insert_organisation_has_user(array $data) {
            $base = new Base(true); 
            $new_id = $base->insertData($data, 'organisation_has_user');
            return $new_id;
        }

        public function insert_staff(array $data) {
            $base = new Base(true); 
            $new_id = $base->insertData($data, 'user');
            return $new_id;
        }

        public function filter_staff(array $fields, array $conditions, int $limit){
            $base = new Base(true); 
            $results = $base->filterData('user', $fields, $conditions, $limit);
            return $results;
        }

        public function getUserInfoFromID($id){
            global $mysqli;
            $query = "SELECT * FROM `user` WHERE `id` = " . $id;
            $result = mysqli_query($mysqli, $query);
            $e = mysqli_fetch_assoc($result);
            return $e;
        }

        public function getSupervisors(){
            global $mysqli;
            $query = "SELECT * FROM `user` WHERE `role` = 'supervisor' " ;
            $result = mysqli_query($mysqli, $query);
            return $result;
        }


    }

?>