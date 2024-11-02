<?php
$host = "localhost";
$user = "root";       // Usuário do banco de dados
$password = "01041993";     // Senha do banco de dados
$database = "atendimento_bot";  // Nome do banco de dados

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}
?>
