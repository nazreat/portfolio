<?php 
	require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/model/Profile.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/Path.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/SessionVariable.php';
	$set_session = new SessionVariable();

	if ($_SERVER["REQUEST_METHOD"] === "POST") {
		if(!isset($_FILES['staffImage']['name'])){
			$targetImagePath = $_SESSION['staffImage'];
		}elseif ($_FILES['staffImage']['name'] !="") {
			$allowedFormats = ["image/jpeg", "image/png"]; 
			$uploadedImageType = $_FILES['staffImage']['type'];

			if (!in_array($uploadedImageType, $allowedFormats)) {
			    echo "<script>
			    	alert(". $_FILES['staffImage']['name'].");
			    	location.href='". $_FILES['staffImage']['name'] ."';
			    	</script>"; 
			    exit;
			}

		    $imageDir = '../uploads/';
		    $uploadedImage = $_FILES['staffImage']['tmp_name'];
		    $imageFilename = $_FILES['staffImage']['name'];
		    $targetImagePath = $imageDir . $imageFilename;

		    move_uploaded_file($uploadedImage, $targetImagePath);

            $data = [
                'first_name' => $_POST["firstName"],
                'last_name' => $_POST["lastName"],
                'photo_path' => $targetImagePath,
                'role' => $_POST["role"],
                'suburb' => $_POST["suburb"],
                'email' => $_POST["email"],
                'phone' => $_POST["phoneNumber"],
                'state' => $_POST["state"],
                'username' => $_POST["username"],
            ];
            
		}else{
            $data = [
                'first_name' => $_POST["firstName"],
                'last_name' => $_POST["lastName"],
                'role' => $_POST["role"],
                'suburb' => $_POST["suburb"],
                'email' => $_POST["email"],
                'phone' => $_POST["phoneNumber"],
                'state' => $_POST["state"],
                'username' => $_POST["username"],
            ];
        }

	}



    $conditions = [
        'id' => $_GET['id']
    ];

	$update_profile = new Profile(true);
	$profile = $update_profile->update_Profile($data, $conditions);

	if($profile > 0){
		header("Location: " . $path->pageURL ."/dashboard-framework-v1/src/view/view-staff.view.php?id=". $_GET['id']);
	}else {
        header("Location: " . $path->pageURL ."/dashboard-framework-v1/src/view/view-staff.view.php?id=". $_GET['id']);
	}

 ?>