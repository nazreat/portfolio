<?php
    use Atk4\Dsql\Query;
    require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/model/Base.php';
    include_once($_SERVER['DOCUMENT_ROOT'] . "/dashboard-framework-v1/db_conn.php");


    // class Event 
    class Event
    {
        public int $id;
        public string $event_name;
        public string $location;
        public string $start_time;
        public string $end_time;
        public string $event_status_id;
        public string $description;
        public string $start_date;
        public string $end_date;
        public string $date_created;
        public string $event_organisation_id;
        public int $participants;

        //get events
        public function get_events(Query $query) {
            $get_events = new Base(true);
            $events = $get_events->getData($query, 'class', 'Event');

            return $events;
        }

        public function update_Event(array $data, array $conditions) {
            $base = new Base(true); 
            $affected_rows = $base->updateData('event', $data, $conditions);
            return $affected_rows;
        }

        public function insert_event(array $data) {
            $base = new Base(true); 
            $new_id = $base->insertData($data, 'event');
            return $new_id;
        }


        public function delete_event(array $conditions_foreign, $conditions_event) {
            $base = new Base(true); 

            $affected_foreign_rows = $base->deleteData( 'event_has_participant', $conditions_foreign);

            $affected_events_rows = $base->deleteData( 'event', $conditions_event);

            return $affected_events_rows;
        }

        public function filter_event(array $fields, array $conditions, int $page, int $perPage){
            $base = new Base(true); 
            $results = $base->filterDataAndPage('event', $fields, $conditions, $page, $perPage);

            return $results;
        }

        public function getEventInfoFromID($id){
            global $mysqli;
            $query = "SELECT * FROM `event` WHERE `id` = " . $id;
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

        public function getParticipants($id){
            global $mysqli;
            $query = "SELECT Count(*) FROM `event_has_participant` WHERE `event_id` = " . $id ;
            $result = mysqli_query($mysqli, $query);
            $e = mysqli_fetch_assoc($result);

            return $e['Count(*)'];
        }

        public function joinEvent($e_id,$u_id){
            global $mysqli;
            $base = new Base(true); 
            $query = "SELECT Count(*) FROM `event_has_participant` WHERE `user_id` = " . $u_id . " AND `event_id` = " . $e_id ;
            $result = mysqli_query($mysqli, $query);
            $e = mysqli_fetch_assoc($result);


            if($e['Count(*)']=="0"){
                $data = [
                    'user_id' => $u_id,
                    'event_id' => $e_id,
                ];
    
                $new_id = $base->insertData($data, 'event_has_participant');
                return $new_id;
            }

        }

        public function check_if_joined($e_id,$u_id){
            global $mysqli;
            $base = new Base(true); 
            $query = "SELECT Count(*) FROM `event_has_participant` WHERE `user_id` = " . $u_id . " AND `event_id` = " . $e_id ;
            $result = mysqli_query($mysqli, $query);
            $e = mysqli_fetch_assoc($result);


            if($e['Count(*)']=="0"){
                return false;
            }else{
                return true;
            }

        }

    }

?>