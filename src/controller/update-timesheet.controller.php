<?php 
	require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/model/Timesheet.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/Path.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/SessionVariable.php';
	$set_session = new SessionVariable();

	if ($_SERVER["REQUEST_METHOD"] === "POST") {
		
            $data = [
                'activities' => $_POST["activiy_name"],
                'activities_type' => $_POST["activiy_type"],
                'supervisor' => $_POST["supervisor"],
                'start_time' => $_POST["start_time"],
                'end_time' => $_POST["end_time"],
                'date' => $_POST["date"],
            ];

	}


    $conditions = [
        'id' => $_GET['id']
    ];

	$update_timesheet = new Timesheet(true);
	$timesheet = $update_timesheet->update_timesheet($data, $conditions);

	if($timesheet > 0){
		header("Location: " . $path->pageURL ."/dashboard-framework-v1/src/view/edit-timesheet.view.php?id=". $_GET['id']);
	}else {
        header("Location: " . $path->pageURL ."/dashboard-framework-v1/src/view/edit-timesheet.view.php?id=". $_GET['id']);
	}

 ?>