<?php
$db = "railway";
$dbhost = "trolley.proxy.rlwy.net";
$port = 22777;

$username = $_POST["username"];
$password = $_POST["password"];
//$email = $_POST["email"];
//$descricao = $_POST["descricao"];

// ⚠️ Hardcoded para testes via emulador
$email = "joao@gmail.com";
$descricao = "teste joao";

$conn = mysqli_connect($dbhost, $username, $password, $db, $port);

if (!$conn) {
    echo json_encode(["success" => false, "message" => "Erro de conexão: " . mysqli_connect_error()]);
    exit();
}

$sql = "CALL CriarJogo('$email', '$descricao')";

try {
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        echo json_encode(["success" => true, "IDNovoJogo" => $row["IDNovoJogo"]]);
    } else {
        throw new Exception(mysqli_error($conn));
    }
} catch (Exception $e) {
    if (str_contains($e->getMessage(), 'Já existe um jogo ativo')) {
        echo json_encode(["success" => false, "message" => "⚠️ Já existe um jogo a correr!"]);
    } else {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
}


mysqli_close($conn);
?>
