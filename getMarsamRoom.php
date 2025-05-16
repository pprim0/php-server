<?php
$db = "railway";
$dbhost = "trolley.proxy.rlwy.net";
$username = $_POST["username"];
$password = $_POST["password"];

$conn = mysqli_connect($dbhost, $username, $password, $db, 22777);

header('Access-Control-Allow-Origin: *'); // Permitir chamadas de qualquer origem
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

$response = array();
$response["data"] = array();

$sql = "SELECT * FROM `OcupacaoLabirinto` 
        WHERE `IDJogo` = (SELECT `IDJogo` FROM `Jogo` WHERE `isRunning` = 1 LIMIT 1)
        ORDER BY `Sala`;";

$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($response["data"], $row);
    }
    $response["last_update"] = date("Y-m-d H:i:s");
    $response["success"] = true;
} else {
    $response["success"] = false;
    $response["message"] = "Nenhum dado encontrado.";
}

mysqli_close($conn);
header('Content-Type: application/json');
echo json_encode($response);
?>
