-<?php
    $db = "railway";
	$dbhost = "trolley.proxy.rlwy.net";
	$username = "root";$_POST["username"];
	$password = "UeFiSShvSBqwfJsKcOvakNnSjvteBkZr";$_POST["password"];
	$doorOrigin = $_POST["SalaOrigemController"];
	$doorDestiny = $_POST["SalaDestinoController"];
	$conn = mysqli_connect($dbhost, $username, $password, $db, 22777);	
	$sql = "CALL closeDoor($doorOrigin,$doorDestiny)";
	$result = mysqli_query($conn, $sql);
	mysqli_close ($conn);
	echo json_encode($result);
?>