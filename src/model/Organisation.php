<?php
    use Atk4\Dsql\Query;
    require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/model/Base.php';

    class Organisation
    {
        public int $id;
        public string $name;
        public int $status_id;
        public string $uuid;
        public DateTime $created_at;

        //get session data
        public function get_oganisation(Query $query) {
            $get_organisation = new Base(true);
            $organisation = $get_organisation->getData($query, 'class', 'Organisation');
            
            return $organisation;
        }
    }

?>