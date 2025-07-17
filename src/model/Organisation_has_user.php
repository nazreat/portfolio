<?php
    use Atk4\Dsql\Query;
    require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/model/Base.php';

    class Organisation_has_user
    {
        public int $id;
        public int $organisation_id;
        public int $user_id;
        public int $status_id;

        //get session data
        public function get_session_data(Query $query) {
            $get_session_data = new Base(true);
            $session_data = $get_session_data->getData($query, 'class', 'Organisation_has_user');
            return $session_data;
        }
    }

?>