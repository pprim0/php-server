<?php 
$db = "railway";
$dbhost = "trolley.proxy.rlwy.net";
$port = 22777;

$username = $_POST["username"];
$password = $_POST["password"];
$email = $_POST["email"];

$return = [
    "success" => false,
    "valid_email" => false,
    "message" => ""
];

try {
    // Tenta ligar com as credenciais fornecidas
    $conn = mysqli_connect($dbhost, $username, $password, $db, $port);

    if (!$conn) {
        $return["message"] = "Erro de conexão à base de dados.";
        echo json_encode($return);
        exit();
    }

    // Sucesso de autenticação com username/password
    $return["success"] = true;

    // Verifica se o email corresponde ao username
    $stmt = $conn->prepare("SELECT * FROM Utilizador WHERE Email = ? AND SQLUser = ?");
$stmt->bind_param("ss", $email, $username);

    $stmt->execute();
    $result = $stmt->get_result();

    // Se encontrar o email, é válido
    if ($result->num_rows > 0) {
        $return["valid_email"] = true;
    } else {
        $return["message"] = "Email incorreto.";
    }

    $stmt->close();
    mysqli_close($conn);

    header('Content-Type: application/json');
    echo json_encode($return);

} catch (Exception $e) {
    $return["message"] = "Exceção: " . $e->getMessage();
    header('Content-Type: application/json');
    $return["debug"] = [
    "email" => $email,
    "username" => $username
];

    echo json_encode($return);
}
?>
