<?php 
$db = "railway";
$dbhost = "trolley.proxy.rlwy.net";
$port = 22777;

$username = $_POST["username"];
$password = $_POST["password"];
$email = $_POST["email"];

$return = ["success" => false, "message" => ""];

try {
    // Tenta ligar com as credenciais
    $conn = mysqli_connect($dbhost, $username, $password, $db, $port);

    if (!$conn) {
        $return["message"] = "Erro de conexão à base de dados.";
        echo json_encode($return);
        exit();
    }

    // Verifica se o email corresponde ao username na tabela Utilizador
    $stmt = $conn->prepare("SELECT * FROM Utilizador WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $return["success"] = true;
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
    echo json_encode($return);
}
?>
