<?php
$db = "railway";
$dbhost = "trolley.proxy.rlwy.net";
$port = 22777;

$username = $_POST["username"];
$password = $_POST["password"];
$email = $_POST["email"];

$conn = mysqli_connect($dbhost, $username, $password, $db, $port);

if (!$conn) {
    echo json_encode(["success" => false, "message" => "Erro de conexão: " . mysqli_connect_error()]);
    exit();
}

$sql = "CALL ListarJogosDoJogador(?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

$dados = [];
while ($row = $result->fetch_assoc()) {
    $dados[] = $row;
}

// Envia diretamente a lista (como espera o ListView.builder no Flutter)
echo json_encode($dados);

$stmt->close();
$conn->close();
?>
