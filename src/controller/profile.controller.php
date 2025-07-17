<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/model/Profile.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/Path.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/SessionVariable.php';
	$set_session = new SessionVariable();

    $path = new Path();

    $fields = ['first_name', 'last_name', 'preferred_name' , 'email', 'phone', 'photo_path', 'state', 'username','role'];
    $conditions = [];
    if(isset($_SESSION["user_id"])){
        $conditions['id'] = $_SESSION["user_id"];
    }

    $limit = 0;
    $filter_profile = new Profile(true);
    $profile = $filter_profile->filter_Profile($fields, $conditions, $limit);
    $profile = $profile[0];
    $_SESSION['profileImage'] = $profile->photo_path;

?>