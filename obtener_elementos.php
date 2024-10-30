<?php
// Establecer la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "0084321";
$dbname = "projectroute";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el área seleccionada del POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Areas'])) {
    $area_seleccionada = $_POST['Areas'];

    // Consulta SQL para obtener los elementos según el área seleccionada
    if ($area_seleccionada == 'todas') {
        $sql_elementos_area = "SELECT id, NameElemento FROM elementos";
    } else {
        $sql_elementos_area = "SELECT id, NameElemento FROM elementos WHERE areas = ?";
        $stmt = $conn->prepare($sql_elementos_area);
        $stmt->bind_param("s", $area_seleccionada);
        $stmt->execute();
        $resultado_elementos_area = $stmt->get_result();
    }

    // Preparar el array de elementos a devolver
    $elementos = array();

    if ($area_seleccionada !== 'todas') {
        while ($row = $resultado_elementos_area->fetch_assoc()) {
            $elementos[] = $row;
        }
    }

    // Devolver los elementos como JSON
    echo json_encode($elementos);
}

// Cerrar la conexión
$conn->close();
?>
