<?php
    use Atk4\Dsql\Query;
    require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/model/Base.php';

    // class User 
    class Role
    {
        public int $id;
        public string $name;
        public ?string $description;

        //get permissions
        public function get_role(Query $query) {
            $get_permission = new Base(true);
            $permissions = $get_permission->getData($query, 'class', 'Role');
            return $permissions;
        }

        //get user has role
        public function get_user_has_role(Query $query) {
            $get_user_has_role = new Base(true);
            $permissions = $get_user_has_role->getData($query, 'class', 'user_has_role');
            return $permissions;
        }
    }

?>