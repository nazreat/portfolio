<?php
    use Atk4\Dsql\Query;
    require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/model/Base.php';

    // class User 
    class Permission
    {
        public int $id;
        public string $name;
        public ?string $description;
        public int $permission_group_id;

        //get permissions
        public function get_permissions(Query $query) {
            $get_permission = new Base(true);
            $permissions = $get_permission->getData($query, 'class', 'Permission');
            return $permissions;
        }
    }

?>