<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $elemento_id = $_POST['elemento_id'];

    // Conectar a la base de datos
    $conn = new mysqli('localhost ', 'root', '0084321', 'projectroute');
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Obtener las fallas asociadas al ID del elemento
    $sql = "SELECT id, descripcion FROM fallas WHERE elemento_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $elemento_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $fallas = array();
    while ($row = $result->fetch_assoc()) {
        $fallas[] = $row;
    }

    echo json_encode($fallas);

    $stmt->close();
    $conn->close();
}
?>
