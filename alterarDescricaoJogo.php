<?php
$db = "railway";
$dbhost = "trolley.proxy.rlwy.net";
$port = 22777;

$username = $_POST["username"];
$password = $_POST["password"];
$email = $_POST["email"];
$idJogo = $_POST["idjogo"];
$novaDescricao = $_POST["novaDescricao"];

$conn = mysqli_connect($dbhost, $username, $password, $db, $port);

if (!$conn) {
    echo json_encode(["success" => false, "message" => "Erro de conexão: " . mysqli_connect_error()]);
    exit();
}

if (empty($email) || empty($idJogo) || empty($novaDescricao)) {
    echo json_encode(["success" => false, "message" => "Campos obrigatórios em falta."]);
    $conn->close();
    exit();
}

try {
    $sql = "CALL AtualizarDescricaoJogo(?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sis", $email, $idJogo, $novaDescricao);
    $stmt->execute();
    echo json_encode(["success" => true, "message" => "Descrição atualizada com sucesso!"]);
    $stmt->close();
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}

$conn->close();
?>
