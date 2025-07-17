<?php
    use Atk4\Dsql\Query;
    require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/model/Base.php';

    // class Profile 
    class Profile
    {
        public int $id;
        public string $first_name;
        public string $last_name;
        public string $preferred_name;
        public string $email;
        public string $phone;
        public string $username;
        public string $password;
        public string $photo_path;
        public string $address;
        public string $state;
        public int $status_id;
        public string $created_at;
        public string $uuid;
        public string $suburb;
        public string $role;


        public function update_Profile(array $data, array $conditions) {
            $base = new Base(true); 
            $affected_rows = $base->updateData('User', $data, $conditions);
            return $affected_rows;
        }

        public function filter_Profile(array $fields, array $conditions, int $limit){
            $base = new Base(true); 
            $results = $base->filterData('User', $fields, $conditions, $limit);
            return $results;
        }
    }

?>