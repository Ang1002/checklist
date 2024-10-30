<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php');
    exit;
}

// Incluir archivo de conexión
include 'conexion.php';

// Conectar a la base de datos
$conn = connectDB();

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el ID de la alerta desde el formulario
    $alerta_id = isset($_POST['id']) ? $_POST['id'] : '';

    // Actualizar la alerta como "aceptada" en la base de datos
    $sql_update = "UPDATE alerta SET estatus='Aceptada' WHERE id=?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("i", $alerta_id);
    if ($stmt->execute()) {
        echo "Alerta aceptada correctamente.";
        // Redireccionar de vuelta a la página principal o de reportes
        header('Location: check.php');
        exit;
    } else {
        echo "Error al aceptar la alerta: " . $conn->error;
    }
}

// Cerrar conexión
$conn->close();
?>
