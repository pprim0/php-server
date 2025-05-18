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

header('Content-Type: application/json');

// Adicionando cabeçalhos CORS para permitir requisições de qualquer origem
header('Access-Control-Allow-Origin: *'); // Permite requisições de qualquer origem
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

try {
    // Tenta conectar com as credenciais fornecidas
    $conn = mysqli_connect($dbhost, $username, $password, $db, $port);

    if (!$conn) {
        http_response_code(500); // Força erro 500 no HTTP
        $return["message"] = "Erro de conexão à base de dados: " . mysqli_connect_error();
        $return["debug"] = [
            "email_recebido" => $email,
            "username_recebido" => $username
        ];
        header('Content-Type: application/json');
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
    $return["debug"] = [
        "email_recebido" => $email,
        "username_recebido" => $username
    ];
    header('Content-Type: application/json');
    echo json_encode($return);
}
?>
