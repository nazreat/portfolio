<?php
    use Atk4\Dsql\Query;
    require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/model/Base.php';
    include_once($_SERVER['DOCUMENT_ROOT'] . "/dashboard-framework-v1/db_conn.php");

    // class Timesheet 
    class Timesheet
    {
        public int $id;
        public string $activies_name;
        public string $activities_type;
        public string $volunteer_id;
        public string $start_time;
        public string $end_time;
        public string $status;
        public string $date_created;


        //get Timesheets
        public function get_timesheets(Query $query) {
            $get_timesheets = new Base(true);
            $timesheets = $get_timesheets->getData($query, 'class', 'timesheet');
            return $timesheets;
        }

        public function insert_timesheet(array $data) {
            $base = new Base(true); 
            $new_id = $base->insertData($data, 'timesheet');
            return $new_id;
        }

        public function filter_timesheet(array $fields, array $conditions, int $page, int $perPage){
            $base = new Base(true); 
            $results = $base->filterDataAndPage('timesheet', $fields, $conditions, $page, $perPage);
            return $results;
        }

        public function getTimesheetInfoFromID($id){
            global $mysqli;
            $query = "SELECT * FROM `timesheet` WHERE `id` = " . $id;
            $result = mysqli_query($mysqli, $query);
            $e = mysqli_fetch_assoc($result);
            return $e;
        }

        public function getStatus($status_id){
            global $mysqli;
            $query = "SELECT name FROM `status` WHERE `id` = " . $status_id ;
            $result = mysqli_query($mysqli, $query);
            $e = mysqli_fetch_assoc($result);

            return $e['name'];
        }

        public function update_timesheet(array $data, array $conditions) {
            $base = new Base(true); 
            $affected_rows = $base->updateData('timesheet', $data, $conditions);
            return $affected_rows;
        }

        public function delete_timesheet( $conditions) {
            $base = new Base(true); 

            $rows = $base->deleteData( 'timesheet', $conditions);

            return $rows;
        }


    }

?>