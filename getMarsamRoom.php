<?php
$db = "railway";
$dbhost = "trolley.proxy.rlwy.net";
$username = $_POST["username"];
$password = $_POST["password"];

$conn = mysqli_connect($dbhost, $username, $password, $db, 22777);// Create connection

if (!$conn) {// Check connection
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM `ocupaçãolabirinto` WHERE `IDJogo` = (SELECT MAX(`IDJogo`) FROM `ocupaçãolabirinto`) ORDER BY `Sala`;";

$result = mysqli_query($conn, $sql);// Execute the query
$response = array();
if (mysqli_num_rows($result) > 0) {// Check if any row is returned
     while ($row = mysqli_fetch_assoc($result)) {//Iterates trough the result and puts entries in response
        array_push($response, $row);
    }
} else {
    $response = array();// If no rows are returned, initialize an empty response
}

mysqli_close($conn);// Close the connection

echo json_encode($response);// Convert the response array to JSON format
?>
