 <?php 
	require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/model/User.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/Path.php';

	if ($_SERVER["REQUEST_METHOD"] === "POST") {
		$allowedFormats = ["image/jpeg", "image/png"]; 
		$uploadedImageType = $_FILES['profileImage']['type'];

		if (!in_array($uploadedImageType, $allowedFormats)) {
		    echo "<script>
		    	alert('Invalid image format. Please upload a JPEG or PNG image.');
		    	location.href='". $path->pageURL . "/dashboard-framework-v1/src/view/create-staff.view.php"."';
		    	</script>"; 
		    exit;
		}

	  	$password = $_POST['password'];
	    $confirmPassword = $_POST['confirm_password'];

	    if ($password !== $confirmPassword) {
	    	 echo "<script>
		    	alert('Passwords do not match.');
		    	location.href='". $path->pageURL . "/dashboard-framework-v1/src/view/create-staff.view.php"."';
		    	</script>"; 
	      exit;
	    }

	    $imageDir = '../uploads/';
	    $uploadedImage = $_FILES['profileImage']['tmp_name'];
	    $imageFilename = $_FILES['profileImage']['name'];
	    $targetImagePath = $imageDir . $imageFilename;

	    move_uploaded_file($uploadedImage, $targetImagePath);


	}

	$data = [
	    'first_name' => $_POST["first_name"],
	    'last_name' => $_POST["last_name"],
		'preferred_name' => $_POST["last_name"],
	    'photo_path' => $targetImagePath,
	    'role' => $_POST["role"],
	    'suburb' => $_POST["suburb"],
	    'created_at' => $_POST["registration_date"],
	    'password' => password_hash($_POST["password"],PASSWORD_BCRYPT),
	    'email' => $_POST["email"],
	    'phone' => $_POST["phone_number"],
	    'state' => $_POST["state"],
		'status_id' => 1,
		'created_at' => date("Y-m-d"),
		//'uuid' => uuid_create()
	];
	$insert_staff = new User(true);
	$staff = $insert_staff->insert_staff($data);
	if($staff > 0){
		$organisation_has_user_data = [
			'organisation_id' => 6,
		    'user_id' => $staff,
			'status_id' => 1,
		];
		$res = $insert_staff->insert_organisation_has_user($organisation_has_user_data);
		header("Location: " . $path->pageURL . "/dashboard-framework-v1/src/view/staff-list.view.php");
	}else {
		header("Location: " . $path->pageURL . "/dashboard-framework-v1/src/view/create-staff.view.php");
	}


 ?>