<?php
$db = "railway";
$dbhost = "trolley.proxy.rlwy.net";
$port = 22777;

$username = $_POST["username"];
$password = $_POST["password"];
//$email = $_POST["email"];
//$descricao = $_POST["descricao"];

// ⚠️ Hardcoded para testes via emulador
$email = "player7@gmail.pt";
$descricao = "teste emulador";

$conn = mysqli_connect($dbhost, $username, $password, $db, $port);

if (!$conn) {
    echo json_encode(["success" => false, "message" => "Erro de conexão: " . mysqli_connect_error()]);
    exit();
}

$sql = "CALL CriarJogo('$email', '$descricao')";
$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    echo json_encode(["success" => true, "IDNovoJogo" => $row["IDNovoJogo"]]);
} else {
    echo json_encode(["success" => false, "message" => mysqli_error($conn)]);
}

mysqli_close($conn);
?>
