-<?php
   $db = "railway";
   $dbhost = "trolley.proxy.rlwy.net";
   $username = $_POST["username"];
   $password = $_POST["password"];
	$conn = mysqli_connect($dbhost, $username, $password, $db, 22777);	
	$sql = "CALL startGame()";
	$result = mysqli_query($conn, $sql);
	mysqli_close ($conn);
	echo json_encode($result);
?>
