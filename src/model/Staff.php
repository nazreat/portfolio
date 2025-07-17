<?php
    use Atk4\Dsql\Query;
    require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/model/Base.php';

    // class Staff 
    class Staff
    {
        public int $id;
        public string $first_name;
        public string $last_name;
        public string $image;
        public string $role;
        public string $suburb;
        public string $registration_date;
        public int $password;
        public string $email;
        public string $phone_number;
        public string $state;


        //get staffs
        public function get_staffs(Query $query) {
            $get_staffs = new Base(true);
            $staffs = $get_staffs->getData($query, 'class', 'staff');
            return $staffs;
        }

        public function insert_staff(array $data) {
            $base = new Base(true); 
            $new_id = $base->insertData($data, 'staff');
            return $new_id;
        }

        public function filter_staff(array $fields, array $conditions, int $limit){
            $base = new Base(true); 
            $results = $base->filterData('staff', $fields, $conditions, $limit);
            return $results;
        }
    }

?>