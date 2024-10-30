<?php
// Datos de conexión a la base de datos
$host = 'localhost'; // Cambia esto si tu host es diferente
$user = 'root'; // Cambia esto con tu usuario de base de datos
$password = '0084321'; // Cambia esto con tu contraseña de base de datos
$database = 'projectroute'; // Cambia esto con el nombre de tu base de datos

// Crear conexión a la base de datos
$conn = new mysqli($host, $user, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
// Obtener el identificador del elemento
$identificador_elemento = $_POST['identificador_elemento'];

// Consulta para obtener las incidencias de la tabla fallas3
$query = "SELECT id, descripcion FROM fallas3 WHERE identificador_elemento = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $identificador_elemento);
$stmt->execute();
$result = $stmt->get_result();

// Crear un array para almacenar las incidencias    
$incidencias = array();
while ($row = $result->fetch_assoc()) {
    $incidencias[] = $row;
}

// Devolver el array en formato JSON
echo json_encode($incidencias);

// Cerrar la conexión
$stmt->close();
$conn->close();
?>


