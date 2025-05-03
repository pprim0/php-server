-<?php
    $db = "railway";
	$dbhost = "trolley.proxy.rlwy.net";
	$username = "root";$_POST["username"];
	$password = "UeFiSShvSBqwfJsKcOvakNnSjvteBkZr";$_POST["password"];
	$conn = mysqli_connect($dbhost, $username, $password, $db, 22777);	
	$sql = "CALL getPoints()";
	$result = mysqli_query($conn, $sql);
	mysqli_close ($conn);
	echo json_encode($result);
?>