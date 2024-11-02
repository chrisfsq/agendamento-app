<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $contato = $_POST['contato'];
    $bairro = $_POST['bairro'];
    $equipamento = $_POST['equipamento'];
    $horario = $_POST['horario'];
    $data = $_POST['data'];
    $endereco = $_POST['endereco'];
    $defeito_resumo = $_POST['defeito_resumo'];

    $checkQuery = "SELECT * FROM horarios WHERE data = '$data' AND horario = '$horario' AND disponivel = 1";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {

        $query = "INSERT INTO agendamentos (nome, contato, bairro, equipamento, horario, data, endereco, defeito_resumo) VALUES ('$nome', '$contato', '$bairro', '$equipamento', '$horario', '$data', '$endereco', '$defeito_resumo')";
        $conn->query($query);

        $updateQuery = "UPDATE horarios SET disponivel = 0 WHERE data = '$data' AND horario = '$horario'";
        $conn->query($updateQuery);
        
        header("Location: index.php");
    } else {
        echo "<p>O horário selecionado não está mais disponível. Tente um horário diferente.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Agendamento</title>
    <link rel="stylesheet" href="css/others.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#telefone').on('input', function() {
                let telefone = $(this).val().replace(/\D/g, ''); 
                if (telefone.length > 10) {
                    telefone = telefone.replace(/^(\d{2})(\d{5})(\d{4})$/, "($1) $2-$3"); 
                } else {
                    telefone = telefone.replace(/^(\d{2})(\d{4})(\d{0,4})$/, "($1) $2-$3"); 
                }
                $(this).val(telefone);
            });


            $('#data').change(function() {
                const selectedDate = $(this).val();
                
                $.ajax({
                    url: 'get_horarios_disponiveis.php',  
                    type: 'POST',
                    data: { data: selectedDate },
                    success: function(response) {
                        $('#horario').html(response); 
                    }
                });
            });
        });
    </script>
</head>
<body>
    <h1>Adicionar Novo Agendamento</h1>
    <a href="index.php" class="btn-voltar">← Voltar para a página inicial</a>

    <form method="POST" action="">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required>

        <label for="telefone">Telefone:</label>
        <input type="tel" name="contato" id="telefone" required>

        <label for="bairro">Bairro:</label>
        <input type="text" name="bairro" id="bairro" required>
        
        <label for="endereco">Endereço:</label>
        <input type="text" name="endereco" id="endereco">

        <label for="equipamento">Equipamento:</label>
        <input type="text" name="equipamento" id="equipamento" required>

        <label for="data">Data:</label>
        <input type="date" name="data" id="data" required>

        <label for="horario">Horário:</label>
        <select name="horario" id="horario" required>
            <option value="">Selecione uma data primeiro</option>
        </select>

        <label for="defeito_resumo">Defeito Resumo:</label>
        <input type="text" name="defeito_resumo" id="defeito_resumo">

        <button type="submit">Adicionar</button>
    </form>
</body>
</html>
