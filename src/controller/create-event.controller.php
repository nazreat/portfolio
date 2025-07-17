<?php 
	require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/model/Event.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/Path.php';

	if($_SERVER["REQUEST_METHOD"] === "POST"){
		if($_POST["name"]==NULL || $_POST["supervisor"]==NULL || $_POST["status"]==NULL){
			echo "<script>
		    	alert('Please at least enter: Event Name, Supervisor, and Status.');
		    	location.href='". $path->pageURL . "/dashboard-framework-v1/src/view/create-event.view.php"."';
		    	</script>"; 
		    exit;
		}

		$data = [
		    'name' => $_POST["name"],
		    'location' => $_POST["location"],
		    'supervisor' => $_POST["supervisor"],
		    'start_time' => $_POST["start_time"],
		    'end_time' => $_POST["end_time"],
		    'status' => $_POST["status"],
		    'participants' => $_POST["participants"],
		    'description' => $_POST["description"],
		    'event_date' => $_POST["event_date"],
		
		];
		$insert_event = new Event(true);
		$event = $insert_event->insert_event($data);
		if($event > 0){
			header("Location: " . $path->pageURL . "/dashboard-framework-v1/src/view/events.view.php");
		}else {
			header("Location: " . $path->pageURL . "/dashboard-framework-v1/src/view/create-event.view.php");
		}
	}


 ?>