<?php
$db = "railway";
$dbhost = "trolley.proxy.rlwy.net";
$username = $_POST["username"];
$password = $_POST["password"];

$conn = mysqli_connect($dbhost, $username, $password, $db, 22777);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Seleciona o ID do jogo em execução
$idJogoQuery = "SELECT IDJogo FROM Jogo WHERE isRunning = 1 LIMIT 1";
$idJogoResult = mysqli_query($conn, $idJogoQuery);
$response = array();

if ($idJogoResult && mysqli_num_rows($idJogoResult) > 0) {
    $row = mysqli_fetch_assoc($idJogoResult);
    $idJogo = $row['IDJogo'];

    // Vai buscar os últimos 20 registos desse jogo
    $sql = "
        SELECT Hour, Sound
        FROM Sound
        WHERE IDJogo = $idJogo
        ORDER BY Hour DESC
        LIMIT 10
    ";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $row["Sound"] = str_replace(',', '.', $row["Sound"]); // Normaliza formato
            array_push($response, $row);
        }

        // Inverter para ordem cronológica crescente (para o gráfico)
        $response = array_reverse($response);
    }
}

mysqli_close($conn);
header('Content-Type: application/json');
echo json_encode($response);
?>
