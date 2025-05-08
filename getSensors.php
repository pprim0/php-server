<?php
$db = "railway";
$dbhost = "trolley.proxy.rlwy.net";
$username = $_POST["username"];
$password = $_POST["password"];

$conn = mysqli_connect($dbhost, $username, $password, $db, 22777);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Buscar normalnoise da tabela Setup
$noiseResult = mysqli_query($conn, "SELECT normalnoise FROM Setup LIMIT 1");
$normalNoise = 5.0;
if ($noiseResult && mysqli_num_rows($noiseResult) > 0) {
    $row = mysqli_fetch_assoc($noiseResult);
    $normalNoise = floatval($row["normalnoise"]);
}

// Buscar os últimos 20 registos
$sql = "
    SELECT s.Hour, s.Sound
    FROM Sound s
    WHERE s.IDJogo = (
        SELECT IDJogo FROM Jogo WHERE isRunning = 1 LIMIT 1
    )
    ORDER BY s.Hour DESC
    LIMIT 20
";

$result = mysqli_query($conn, $sql);
$response = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $row["normalnoise"] = $normalNoise;
        array_unshift($response, $row); // mantém em ordem ASC
    }
}

mysqli_close($conn);
header('Content-Type: application/json');
echo json_encode($response);
?>
