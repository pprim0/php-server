-<?php
    $db = "railway";
	$dbhost = "trolley.proxy.rlwy.net";
	$username = $_POST["username"];
	$password = $_POST["password"];
	$doorOrigin = $_POST["SalaOrigemController"];
	$doorDestiny = $_POST["SalaDestinoController"];
	$conn = mysqli_connect($dbhost, $username, $password, $db, 22777);	
	$sql = "CALL closeDoor($doorOrigin,$doorDestiny)";
	$result = mysqli_query($conn, $sql);
	mysqli_close ($conn);
	echo json_encode($result);
?>
