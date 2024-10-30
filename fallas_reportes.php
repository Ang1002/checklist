<?php
// Configuración de la conexión a la base de datos
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

// Obtener el identificador del elemento del parámetro GET
$identificador_elemento = $_GET['elemento'];

// Consulta para obtener las fallas filtradas por identificador de elemento
$sql = "SELECT id, descripcion FROM fallas3 WHERE identificador_elemento = '$identificador_elemento'";
$result = $conn->query($sql);

// Preparar arreglo para el resultado
$fallas = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $falla = array(
            'id' => $row["id"],
            'descripcion' => $row["descripcion"]
        );
        $fallas[] = $falla;
    }
}

// Devolver resultado como JSON
header('Content-Type: application/json');
echo json_encode($fallas);

$conn->close();
?>
