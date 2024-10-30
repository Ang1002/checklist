<?php
$db_host = "localhost";
$db_username = "root";
$db_password = "0084321";
$db_name = "projectroute";

// Función para conectar a la base de datos
function connectDB() {
    global $db_host, $db_username, $db_password, $db_name;

    // Conexión a la base de datos
    $conn = new mysqli($db_host, $db_username, $db_password, $db_name);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Establecer charset a UTF-8
    $conn->set_charset("utf8");

    return $conn;
}
?>
