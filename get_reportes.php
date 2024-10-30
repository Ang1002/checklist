<?php
header('Content-Type: application/json');

// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "0084321";
$dbname = "projectroute";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consultar reportes (puedes ajustar la consulta según tus necesidades)
$sql = "SELECT * FROM reportes2"; // Ajusta la consulta según lo que necesites
$result = $conn->query($sql);

// Preparar respuesta JSON
$response = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $response[] = $row;
    }
}

// Devolver respuesta como JSON
echo json_encode($response);

$conn->close();
?>
