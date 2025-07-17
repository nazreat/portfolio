<?php 
	require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/model/Timesheet.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/Path.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/SessionVariable.php';
	$set_session = new SessionVariable();

	if($_SERVER["REQUEST_METHOD"] === "POST"){
		if($_POST["activiy_name"]==NULL || $_POST["supervisor"]==NULL || $_POST["status"]==NULL){
			echo "<script>
		    	alert('Please at least enter: Activity Name, Supervisor, and Status.');
		    	location.href='". $path->pageURL . "/dashboard-framework-v1/src/view/create-timesheet.view.php"."';
		    	</script>"; 
		    exit;
		}


		$data = [
		    'activities' => $_POST["activiy_name"],
		    'activities_type' => $_POST["activity_type"],
		    'supervisor' => $_POST["supervisor"],
		    'start_time' => $_POST["start_time"],
		    'end_time' => $_POST["end_time"],
		    'status' => $_POST["status"],
		    'date' => $_POST["timesheet_date"],
			'volunteer_id' => $_SESSION["user_id"],

		];
		$insert_timesheet = new Timesheet(true);
		$timesheet = $insert_timesheet->insert_timesheet($data);
		if($timesheet > 0){
			header("Location: " . $path->pageURL . "/dashboard-framework-v1/src/view/timesheets.view.php");
		}else {
			header("Location: " . $path->pageURL . "/dashboard-framework-v1/src/view/create-timesheet.view.php");
		}
	}


 ?>