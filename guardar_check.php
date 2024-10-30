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

// Verificar si se recibieron los datos necesarios mediante POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $id = $_POST['id'];
    $columna = $_POST['columna'];

    // Crear la consulta SQL para actualizar la columna correspondiente con la fecha actual
    $sql = "UPDATE guardar_check SET $columna = CURDATE() WHERE elemento_id = ?";

    // Preparar la consulta
    $stmt = $conn->prepare($sql);

    // Vincular los parámetros
    $stmt->bind_param("i", $id);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // La consulta se ejecutó correctamente
        echo "La fecha se ha insertado correctamente.";
    } else {
        // Error al ejecutar la consulta
        echo "Error al insertar la fecha.";
    }

    // Cerrar la conexión
    $conn->close();
} else {
    // Si no se recibió una solicitud POST, mostrar un mensaje de error
    echo "Error: no se recibieron los datos necesarios.";
}
?>
