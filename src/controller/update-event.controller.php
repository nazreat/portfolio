<?php 
	require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/model/Event.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/Path.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/SessionVariable.php';
	$set_session = new SessionVariable();

	if ($_SERVER["REQUEST_METHOD"] === "POST") {
		
            $data = [
                'name' => $_POST["name"],
                'location' => $_POST["location"],
                'supervisor' => $_POST["supervisor"],
                'start_time' => $_POST["start_time"],
                'end_time' => $_POST["end_time"],
                'participants' => $_POST["participants"],
                'description' => $_POST["description"],
                'status' => $_POST["status"],
            ];

	}


    $conditions = [
        'id' => $_GET['id']
    ];

	$update_event = new Event(true);
	$event = $update_event->update_event($data, $conditions);

	if($event > 0){
		header("Location: " . $path->pageURL ."/dashboard-framework-v1/src/view/view-event.view.php?id=". $_GET['id']);
	}else {
        header("Location: " . $path->pageURL ."/dashboard-framework-v1/src/view/view-event.view.php?id=". $_GET['id']);
	}

 ?>