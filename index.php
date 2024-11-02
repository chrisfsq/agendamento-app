<?php
include 'config.php';

$nome = $_GET['nome'] ?? '';
$contato = $_GET['contato'] ?? '';
$endereco = $_GET['endereco'] ?? '';
$data = $_GET['data'] ?? '';
$ordenar_por = $_GET['ordenar_por'] ?? 'id';


$query = "SELECT * FROM agendamentos WHERE 1=1";

if (!empty($nome)) {
    $query .= " AND nome LIKE '%" . $conn->real_escape_string($nome) . "%'";
}
if (!empty($contato)) {
    $query .= " AND contato LIKE '%" . $conn->real_escape_string($contato) . "%'";
}
if (!empty($endereco)) {
    $query .= " AND endereco LIKE '%" . $conn->real_escape_string($endereco) . "%'";
}
if (!empty($data)) {
    $query .= " AND data = '" . $conn->real_escape_string($data) . "'";
}


$query .= " ORDER BY " . $conn->real_escape_string($ordenar_por) . " DESC";

date_default_timezone_set('America/Sao_Paulo'); 

$now = new DateTime();

$result = $conn->query($query);


?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Gerenciador de Agendamentos</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // formatar o campo de telefone
            $('#contato').on('input', function() {
                let telefone = $(this).val().replace(/\D/g, ''); // remove todos os caracteres não numéricos
                if (telefone.length > 10) {
                    telefone = telefone.replace(/^(\d{2})(\d{5})(\d{4})$/, "($1) $2-$3"); // formato (XX) XXXXX-XXXX
                } else {
                    telefone = telefone.replace(/^(\d{2})(\d{4})(\d{0,4})$/, "($1) $2-$3"); 
                }
                $(this).val(telefone); 
            });
        });
    </script>
</head>

<body>
    <h1>Lista de Agendamentos</h1>
    <a href="add.php">Adicionar Novo Agendamento</a>

    <!-- Formulário de Pesquisa -->
    <h4>Pesquisar agendamentos:</h4>
    <form method="GET" action="">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($nome) ?>">

        <label for="contato">Telefone:</label>
        <input type="tel" name="contato" id="contato" value="<?= htmlspecialchars($contato) ?>">

        <label for="endereco">Endereço:</label>
        <input type="text" name="endereco" id="endereco" value="<?= htmlspecialchars($endereco) ?>">

        <label for="data">Data:</label>
        <input type="date" name="data" id="data" value="<?= htmlspecialchars($data) ?>">

        <label for="ordenar_por">Ordenar por:</label>
        <select name="ordenar_por" id="ordenar_por">
            <option value="id" <?= ($ordenar_por == 'id') ? 'selected' : '' ?>>ID</option>
            <option value="data" <?= ($ordenar_por == 'data') ? 'selected' : '' ?>>Data</option>
            <option value="horario" <?= ($ordenar_por == 'horario') ? 'selected' : '' ?>>Horário</option>
        </select>

        <button type="submit">Buscar</button>
    </form>



    <!-- Legenda -->
    <div class="legenda">
        <span class="verde">Verde: longe do agendamento (7 dias ou mais)</span>
        <span class="amarelo">Amarelo: agendamento em 3-6 dias</span>
        <span class="laranja">Laranja: agendamento em 1-2 dias</span>
        <span class="vermelho">Vermelho: agendamento hoje</span>
    </div>
    <div class="table-container">
        <table class="agendamentos" border="1">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Contato</th>
                <th>Bairro</th>
                <th>Equipamento</th>
                <th>Horário</th>
                <th>Data</th>
                <th>Endereço</th>
                <th>Defeito Resumo</th>
                <th>Ações</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <?php
  
                $agendamentoDataHora = new DateTime($row['data'] . ' ' . $row['horario']);
                $intervalo = $now->diff($agendamentoDataHora);


                $daysLeft = (int) $intervalo->format('%r%a'); // dias até o agendamento
                $corClasse = '';

                if ($daysLeft >= 7) {
                    $corClasse = 'verde';
                } elseif ($daysLeft >= 3) {
                    $corClasse = 'amarelo';
                } elseif ($daysLeft >= 1) {
                    $corClasse = 'laranja';
                } else {
                    $corClasse = 'vermelho'; // para hoje ou passado
                }
                ?>
                <tr class="<?= $corClasse ?>">
                    <td data-label="ID"><?= $row['id'] ?></td>
                    <td data-label="Nome"><?= $row['nome'] ?></td>
                    <td data-label="Contato"><?= $row['contato'] ?></td>
                    <td data-label="Bairro"><?= $row['bairro'] ?></td>
                    <td data-label="Equipamento"><?= $row['equipamento'] ?></td>
                    <td data-label="Horário"><?= $row['horario'] ?></td>
                    <td data-label="Data"><?= $row['data'] ?></td>
                    <td data-label="Endereço"><?= $row['endereco'] ?></td>
                    <td data-label="Defeito Resumo"><?= $row['defeito_resumo'] ?></td>
                    <td data-label="Ações">
                        <a href="edit.php?id=<?= $row['id'] ?>">✏️</a>
                        <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')">🗑️</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>