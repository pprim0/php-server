<?php
header('Content-Type: application/json');

$db = "railway";
$dbhost = "trolley.proxy.rlwy.net";
$username = $_POST["username"];
$password = $_POST["password"];

header('Access-Control-Allow-Origin: *'); // Permitir chamadas de qualquer origem
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

$conn = mysqli_connect($dbhost, $username, $password, $db, 22777);
if (!$conn) {
    echo json_encode(["success" => false, "message" => "Erro de ligação"]);
    exit;
}

// Consulta os últimos 20 registos do jogo ativo
$sql = "
    SELECT s.Hour, s.Sound
    FROM Sound s
    WHERE s.IDJogo = (
        SELECT IDJogo FROM Jogo WHERE isRunning = 1 LIMIT 1
    )
    ORDER BY s.Hour DESC
    LIMIT 10
";

$result = mysqli_query($conn, $sql);
$response = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $response[] = $row;
    }
}

mysqli_close($conn);
echo json_encode($response);
?>
