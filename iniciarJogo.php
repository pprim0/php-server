<?php
$db = "railway";
$dbhost = "trolley.proxy.rlwy.net";
$port = 22777;

$username = $_POST["username"];
$password = $_POST["password"];
$email = $_POST["email"];
$descricao = $_POST["descricao"];

header('Access-Control-Allow-Origin: *'); // Permitir chamadas de qualquer origem
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');


$conn = mysqli_connect($dbhost, $username, $password, $db, $port);

if (!$conn) {
    echo json_encode([
        "success" => false,
        "message" => "Erro de conexão: " . mysqli_connect_error()
    ]);
    exit();
}

if (empty(trim($email)) || empty(trim($descricao))) {
    echo json_encode([
        "success" => false,
        "message" => "Email ou descrição inválida (vazios ou só espaços)."
    ]);
    mysqli_close($conn);
    exit();
}


// ✅ Verifica se o utilizador é do tipo PLR
$stmt = $conn->prepare("SELECT Tipo_user FROM Utilizador WHERE Email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $row = $result->fetch_assoc()) {
    if ($row["Tipo_user"] !== "PLR") {
        echo json_encode([
            "success" => false,
            "message" => "Este utilizador não tem permissões para iniciar um jogo."
        ]);
        $stmt->close();
        mysqli_close($conn);
        exit();
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Utilizador não encontrado ou inválido."
    ]);
    $stmt->close();
    mysqli_close($conn);
    exit();
}
$stmt->close();


// Chamada à stored procedure
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
