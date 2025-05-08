<?php
header('Content-Type: application/json'); // <-- DEVE vir antes de qualquer saída

$db = "railway";
$dbhost = "trolley.proxy.rlwy.net";
$dbport = 22777; 
$username = $_POST["username"];
$password = $_POST["password"];
$email = $_POST["email"];

$conn = mysqli_connect($dbhost, $username, $password, $db, $dbport);

$response = array();
$response["success"] = false;

if (!$conn) {
    $response["message"] = "Erro na ligação à base de dados.";
    echo json_encode($response);
    exit;
}

$query = "SELECT Score FROM Jogo 
          JOIN Utilizador ON Jogo.Email = Utilizador.Email 
          WHERE Utilizador.Email = '$email' AND Jogo.IsRunning = 1 
          ORDER BY IDJogo DESC LIMIT 1";

$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $response["success"] = true;
    $response["score"] = $row["Score"];
} else {
    $response["message"] = "Nenhum jogo ativo encontrado.";
}

echo json_encode($response);
?>
