<?php
$host = "localhost";
$user = "root";       
$password = "";     
$database = "atendimento_bot";  

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}
?>
