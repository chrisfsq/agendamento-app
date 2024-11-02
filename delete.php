<?php
include 'config.php';

$id = $_GET['id'];
$query = "DELETE FROM agendamentos WHERE id = $id";
$conn->query($query);

header("Location: index.php");
?>
