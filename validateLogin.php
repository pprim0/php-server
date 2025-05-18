<?php 
ini_set('display_errors', 0);
error_reporting(E_ERROR | E_PARSE);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$db = "railway";
$dbhost = "trolley.proxy.rlwy.net";
$port = 22777;

$username = $_POST["username"] ?? null;
$password = $_POST["password"] ?? null;
$email = $_POST["email"] ?? null;

$return = [
    "success" => false,
    "valid_email" => false,
    "message" => ""
];

if (!$username || !$password || !$email) {
    $return["message"] = "Campos em falta.";
    echo json_encode($return);
    exit();
}

try {
    $conn = mysqli_connect($dbhost, $username, $password, $db, $port);

    if (!$conn) {
        $return["message"] = "Erro de conexão à base de dados: " . mysqli_connect_error();
        $return["debug"] = ["email_recebido" => $email, "username_recebido" => $username];
        echo json_encode($return);
        exit();
    }

    $return["success"] = true;

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
    echo json_encode($return);

} catch (Exception $e) {
    $return["message"] = "Exceção: " . $e->getMessage();
    echo json_encode($return);
}
?>
