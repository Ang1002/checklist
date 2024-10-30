<?php
// check_status.php
header('Content-Type: application/json');

// Obtener el elemento_id desde la solicitud POST
$elemento_id = isset($_POST['elemento_id']) ? intval($_POST['elemento_id']) : 0;

if ($elemento_id <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Elemento ID inválido']);
    exit;
}

// Configuración de la conexión a la base de datos
$host = 'localhost'; 
$user = 'root';  
$password = '0084321'; 
$database = 'projectroute'; 

// Conectar a la base de datos
$mysqli = new mysqli($host, $user, $password, $database);

// Verificar la conexión
if ($mysqli->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Error de conexión: ' . $mysqli->connect_error]);
    exit;
}

// Preparar y ejecutar la consulta para obtener el estado del reporte
$query = $mysqli->prepare("SELECT status FROM reportes2 WHERE elemento_id = ?");
$query->bind_param('i', $elemento_id);
$query->execute();
$query->bind_result($status);
$query->fetch();
$query->close();
$mysqli->close();

// Verificar si se encontró un estado y devolver el resultado
if ($status) {
    echo json_encode(['status' => 'success', 'data' => ['status' => $status]]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No se encontró el reporte para el elemento ID proporcionado']);
}
?>
