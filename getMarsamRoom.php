<?php
$db = "railway";
$dbhost = "trolley.proxy.rlwy.net";
$username = $_POST["username"];
$password = $_POST["password"];

$conn = mysqli_connect($dbhost, $username, $password, $db, 22777);

$response = array();
$response["data"] = array();

$sql = "SELECT * FROM `ocupaçãolabirinto` 
        WHERE `IDJogo` = (SELECT MAX(`IDJogo`) FROM `ocupaçãolabirinto`) 
        ORDER BY `Sala`;";

$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($response["data"], $row);
    }
    // Adiciona o timestamp da última leitura (podes ajustar o campo conforme necessário)
    $response["last_update"] = date("Y-m-d H:i:s");
    $response["success"] = true;
} else {
    $response["success"] = false;
    $response["message"] = "Nenhum dado encontrado.";
}

mysqli_close($conn);
header('Content-Type: application/json');
echo json_encode($response);
?>
