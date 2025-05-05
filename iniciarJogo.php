<?php
header("Content-Type: application/json");

$db = "railway";
$dbhost = "trolley.proxy.rlwy.net";
$dbport = 22777;

// Verifica se recebeu os parâmetros esperados
if (!isset($_POST["username"]) || !isset($_POST["password"])) {
    echo json_encode(["success" => false, "message" => "Missing credentials"]);
    exit;
}

$username = $_POST["username"];
$password = $_POST["password"];

$conn = mysqli_connect($dbhost, $username, $password, $db, $dbport);

if (!$conn) {
    echo json_encode(["success" => false, "message" => "Connection failed: " . mysqli_connect_error()]);
    exit;
}

// Chama a stored procedure CriarJogo
$sql = "CALL CriarJogo()";
$result = mysqli_query($conn, $sql);

if ($result) {
    echo json_encode(["success" => true, "message" => "Jogo criado com sucesso"]);
} else {
    echo
