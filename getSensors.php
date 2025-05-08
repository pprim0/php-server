<?php
$db = "railway";
$dbhost = "trolley.proxy.rlwy.net";
$username = $_POST["username"];
$password = $_POST["password"];

$conn = mysqli_connect($dbhost, $username, $password, $db, 22777);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT Hour, Sound, normalnoise 
        FROM Sound, setupmaze 
        WHERE Sound.IDJogo = (
            SELECT IDJogo FROM Jogo WHERE isRunning = 1 LIMIT 1
        )
        AND Hour >= NOW() - INTERVAL 10 SECOND
        ORDER BY Hour DESC;";

$result = mysqli_query($conn, $sql);
$response = array();

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($response, $row);
    }
}

mysqli_close($conn);
header('Content-Type: application/json');
echo json_encode($response);
?>
