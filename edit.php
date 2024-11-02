<?php
include 'config.php';

$id = $_GET['id'];
$query = "SELECT * FROM agendamentos WHERE id = $id";
$result = $conn->query($query);
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $bairro = $_POST['bairro'];
    $equipamento = $_POST['equipamento'];
    $horario = $_POST['horario'];
    $data = $_POST['data'];
    $endereco = $_POST['endereco'];
    $defeito_resumo = $_POST['defeito_resumo'];

    $query = "UPDATE agendamentos SET nome='$nome', bairro='$bairro', equipamento='$equipamento', horario='$horario', data='$data', endereco='$endereco', defeito_resumo='$defeito_resumo' WHERE id=$id";
    $conn->query($query);

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Agendamento</title>
    <link rel="stylesheet" href="css/others.css">
</head>
<body>
    <h1>Editar Agendamento</h1>
    <a href="index.php" class="btn-voltar">← Voltar para a página inicial</a>
    <form method="POST" action="">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($row['nome'] ?? '') ?>" required>

        <label for="bairro">Bairro:</label>
        <input type="text" name="bairro" id="bairro" value="<?= htmlspecialchars($row['bairro'] ?? '') ?>" required>

        <label for="equipamento">Equipamento:</label>
        <input type="text" name="equipamento" id="equipamento" value="<?= htmlspecialchars($row['equipamento'] ?? '') ?>" required>

        <label for="horario">Horário:</label>
        <input type="time" name="horario" id="horario" value="<?= htmlspecialchars($row['horario'] ?? '') ?>" required>

        <label for="data">Data:</label>
        <input type="date" name="data" id="data" value="<?= htmlspecialchars($row['data'] ?? '') ?>" required>

        <label for="endereco">Endereço:</label>
        <input type="text" name="endereco" id="endereco" value="<?= htmlspecialchars($row['endereco'] ?? '') ?>">

        <label for="defeito_resumo">Defeito Resumo:</label>
        <input type="text" name="defeito_resumo" id="defeito_resumo" value="<?= htmlspecialchars($row['defeito_resumo'] ?? '') ?>">

        <button type="submit">Salvar Alterações</button>
    </form>
</body>
</html>
