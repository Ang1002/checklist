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

// Verificar si se recibió una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $id = $_POST['id'];
    $columna = $_POST['columna'];

    // Actualizar la columna correspondiente con NULL para eliminar la fecha
    $sql = "UPDATE guardar_check SET $columna = NULL WHERE elemento_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // La fecha se ha eliminado correctamente
        echo "La fecha se ha eliminado correctamente.";
    } else {
        // Error al eliminar la fecha
        echo "Error al eliminar la fecha.";
    }

    // Cerrar la conexión
    $conn->close();
}
?>
