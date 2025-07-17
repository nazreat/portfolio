 <?php 
	require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/model/Profile.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/Path.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/SessionVariable.php';
	$set_session = new SessionVariable();

	if ($_SERVER["REQUEST_METHOD"] === "POST") {
		if(!isset($_FILES['profileImage']['name'])){
			$targetImagePath = $_SESSION['profileImage'];
		}elseif ($_FILES['profileImage']['name'] !="") {
			$allowedFormats = ["image/jpeg", "image/png"]; 
			$uploadedImageType = $_FILES['profileImage']['type'];

			if (!in_array($uploadedImageType, $allowedFormats)) {
			    echo "<script>
			    	alert(". $_FILES['profileImage']['name'].");
			    	location.href='". $_FILES['profileImage']['name'] ."';
			    	</script>"; 
			    exit;
			}

		    $imageDir = '../uploads/';
		    $uploadedImage = $_FILES['profileImage']['tmp_name'];
		    $imageFilename = $_FILES['profileImage']['name'];
		    $targetImagePath = $imageDir . $imageFilename;

		    move_uploaded_file($uploadedImage, $targetImagePath);

            $data = [
                'first_name' => $_POST["first_name"],
                'last_name' => $_POST["last_name"],
                'photo_path' => $targetImagePath,
                'role' => $_POST["role"],
                'suburb' => $_POST["suburb"],
                'email' => $_POST["email"],
                'phone' => $_POST["phone"],
                'state' => $_POST["state"],
                'username' => $_POST["username"],
            ];
            
		}else{
            $data = [
                'first_name' => $_POST["first_name"],
                'last_name' => $_POST["last_name"],
                'role' => $_POST["role"],
                'suburb' => $_POST["suburb"],
                'email' => $_POST["email"],
                'phone' => $_POST["phone"],
                'state' => $_POST["state"],
                'username' => $_POST["username"],
            ];
        }

	}

	$conditions = [];
    if(isset($_SESSION["user_id"])){
		$conditions = [
			'id' => $_SESSION['user_id'], 
		];
    }



	$update_profile = new Profile(true);
	$profile = $update_profile->update_Profile($data, $conditions);

	if($profile > 0){
		header("Location: " . $path->pageURL . "/dashboard-framework-v1/src/view/profile.view.php");
	}else {
		header("Location: " . $path->pageURL . "/dashboard-framework-v1/src/view/profile.view.php");
	}

 ?>