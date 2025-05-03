<?php 
	$db = "railway";
	$dbhost = "trolley.proxy.rlwy.net";
	$return["message"] = "";
	$return["success"] = false;
	$username = $_POST["username"];
	$password = $_POST["password"];
	//$username = "root";
	//$password = "UeFiSShvSBqwfJsKcOvakNnSjvteBkZr";"UeFiSShvSBqwfJsKcOvakNnSjvteBkZr";"";
	try {
		$conn = mysqli_connect($dbhost, $username, $password, $db, 22777);	
		mysqli_close($conn);		
		header('Content-Type: application/json');
		$return["success"] = true;
		echo json_encode($return);
	} catch (Exception $e) {
		$return["message"] = "The login failed. Check if the user exists in the database.";
		header('Content-Type: application/json');	
		echo json_encode($return);		
	}
?>