<?php 
$db = "railway";
$dbhost = "trolley.proxy.rlwy.net";
$username = $_POST["username"];
$password = $_POST["password"];
$email = $_POST["email"];  // novo campo vindo do Flutter

$return = ["message" => "", "success" => false, "step" => ""];

// 1. Tentar ligação com IP, porta, username e password
try {
    $conn = mysqli_connect($dbhost, $username, $password, $db, 22777);
    
    // 2. Verificar se email está associado ao username
    $stmt = mysqli_prepare($conn, "SELECT * FROM Utilizador WHERE Email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $return["success"] = true;
        $return["step"] = "login_sucesso";
    } else {
        $return["message"] = "Mail incorreto!";
        $return["step"] = "email_invalido";
    }

    mysqli_close($conn);
} catch (Exception $e) {
    // Erro na ligação (IP, porta, user/pass)
    $return["message"] = "Erro na ligação: IP ou Porta incorretos!";
    $return["step"] = "falha_ligacao";
}

header('Content-Type: application/json');
echo json_encode($return);
?>
