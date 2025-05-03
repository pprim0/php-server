<?php
header('Content-Type: application/json');

// Dados de acesso à base de dados Railway
$host = "trolley.proxy.rlwy.net";
$database = "railway";
$port = 22777;
$user = "root";
$password = "UeFiSShvSBqwfJsKcOvakNnSjvteBkZr";  // <- tua password aqui

$return = ["success" => false];

if (!isset($_POST["email"]) || !isset($_POST["descricao"])) {
    $return["message"] = "Parâmetros em falta (email ou descrição).";
    echo json_encode($return);
    exit;
}

$email = $_POST["email"];
$descricao = $_POST["descricao"];

try {
    $conn = new mysqli($host, $user, $password, $database, $port);
    if ($conn->connect_error) {
        throw new Exception("Erro de ligação: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("CALL CriarJogo(?, ?)");
    $stmt->bind_param("ss", $email, $descricao);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $return["success"] = true;
    $return["IDNovoJogo"] = $row["IDNovoJogo"];  // <- este campo vem do SELECT da SP

    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    $return["message"] = $e->getMessage();
}

echo json_encode($return);
