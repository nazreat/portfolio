<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/model/Staff.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/Path.php';
    $path = new Path();
    $fields = ['first_name', 'last_name', 'image', 'role', 'suburb', 'registration_date'];
    $conditions = [];
    if(isset($_POST["first_name"]) && $_POST["first_name"]!=""){
        $conditions['first_name'] = $_POST["first_name"];
    }
    
    if (isset($_POST["last_name"])  && $_POST["last_name"]!="") {
        $conditions['last_name'] = $_POST["last_name"];
    }
    
    if (isset($_POST["suburb"])  && $_POST["suburb"]!="") {
        $conditions['suburb'] = $_POST["suburb"];
    }
    
    if (isset($_POST["role"]) && $_POST["role"]!="") {
        $conditions['role'] = $_POST["role"];
    }

 
    $limit = isset($_POST["per_page"]) ? $_POST["per_page"] : 0;
    $filter_staff = new Staff(true);
    $staffs = $filter_staff->filter_staff($fields, $conditions, $limit);


?>