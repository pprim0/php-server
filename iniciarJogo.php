<?php
$db = "railway";
$dbhost = "trolley.proxy.rlwy.net";
$port = 22777;

$username = $_POST["username"];
$password = $_POST["password"];
$email = $_POST["email"];
$descricao = $_POST["descricao"];

$conn = mysqli_connect($dbhost, $username, $password, $db, $port);

if (!$conn) {
    echo json_encode([
        "success" => false,
        "message" => "Erro de conexão: " . mysqli_connect_error()
    ]);
    exit();
}

// Verificação opcional de campos
if (empty($email) || empty($descricao)) {
    echo json_encode([
        "success" => false,
        "message" => "Email ou descrição em falta."
    ]);
    mysqli_close($conn);
    exit();
}

// Prepara a chamada à stored procedure
$sql = "CALL CriarJogo('$email', '$descricao')";

try {
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        echo json_encode([
            "success" => true,
            "IDNovoJogo" => $row["IDNovoJogo"]
        ]);
    } else {
        throw new Exception(mysqli_error($conn));
    }
} catch (Exception $e) {
    if (str_contains($e->getMessage(), 'Já existe um jogo ativo')) {
        echo json_encode([
            "success" => false,
            "message" => "⚠️ Já existe um jogo a correr!"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => $e->getMessage()
        ]);
    }
}

mysqli_close($conn);
?>
