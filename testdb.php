<?php
$dbhost = "trolley.proxy.rlwy.net"; // ou o host atual da Railway
$db = "railway";
$username = "joao_player";
$password = "joao";

$conn = mysqli_connect($dbhost, $username, $password, $db);

if (!$conn) {
    die("Erro na ligação: " . mysqli_connect_error());
}
echo "Ligação estabelecida com sucesso!";
?>
