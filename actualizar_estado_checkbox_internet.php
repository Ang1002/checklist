<?php
// Establecer la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "0084321";
$dbname = "projectroute";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se ha enviado la solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos enviados desde JavaScript
    $fecha = $_POST['fecha'];
    $isChecked = $_POST['isChecked'];
    $day = $_POST['day'];

    // Actualizar la base de datos con los datos recibidos
    $sql = "UPDATE internet SET $day = '$fecha' WHERE id = $isChecked";

    if ($conn->query($sql) === TRUE) {
        // Si la actualización fue exitosa, devolvemos un mensaje de éxito
        echo "Estado del checkbox actualizado correctamente.";
    } else {
        // Si hubo un error en la actualización, devolvemos un mensaje de error
        echo "Error al actualizar el estado del checkbox: " . $conn->error;
    }
} else {
    // Si no se recibió una solicitud POST, imprimir un mensaje de error
    echo "Error: No se recibió una solicitud POST";
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
