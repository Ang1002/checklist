<?php

// Incluir archivo de conexión
include 'conexion.php';

// Conectar a la base de datos
$conn = connectDB();

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Configurar el entorno de errores (solo para desarrollo)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Incluir la configuración de la base de datos
include 'db_config.php'; // Asegúrate de que esta línea esté correcta y apunta a tu archivo de configuración de la base de datos

// Obtener datos del POST
$identificador_elemento = $_POST['identificador_elemento'];

// Preparar la consulta
$query = "SELECT id, fallaname, identificador_caract 
          FROM check_fallas 
          WHERE identificador_elemento = :identificador_elemento";

$stmt = $pdo->prepare($query);

// Asignar parámetros
$stmt->execute(['identificador_elemento' => $identificador_elemento]);

// Obtener resultados
$fallas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Enviar respuesta como JSON
header('Content-Type: application/json');
echo json_encode($fallas)
?>
