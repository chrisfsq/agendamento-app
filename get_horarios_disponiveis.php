<?php
include 'config.php';

if (isset($_POST['data'])) {
    $data = $_POST['data'];

    $query = "SELECT horario FROM horarios WHERE data = '$data' AND disponivel = 1";
    $result = $conn->query($query);


    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['horario']}'>{$row['horario']}</option>";
        }
    } else {
        echo "<option value=''>Sem horários disponíveis</option>";
    }
}
?>
