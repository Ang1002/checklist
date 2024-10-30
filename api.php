<?php
header('Content-Type: application/json');

// Configuración de la conexión a la base de datos
$host = 'localhost'; // Cambia si es necesario
$db = 'projectroute'; // Nombre de tu base de datos
$user = 'root'; // Tu usuario de la base de datos
$pass = '0084321'; // Tu contraseña de la base de datos

// Crear conexión
$conn = new mysqli($host, $user, $pass, $db);

// Verificar conexión
if ($conn->connect_error) {
    die(json_encode(["error" => "Conexión fallida: " . $conn->connect_error]));
}

// Consulta para el estatus de las alertas
$result = $conn->query("SELECT estatus, COUNT(*) as cantidad FROM alerta WHERE estatus IN ('Aceptada', 'En Proceso', 'Resuelta') GROUP BY estatus");
$estatusData = [];
while ($row = $result->fetch_assoc()) {
    $estatusData[$row['estatus']] = $row['cantidad'];
}

// Asegurarse de que todas las categorías estén presentes, incluso si no hay alertas
$estatus = ['Aceptada' => 0, 'En Proceso' => 0, 'Resuelta' => 0];
foreach ($estatusData as $key => $value) {
    if (array_key_exists($key, $estatus)) {
        $estatus[$key] = $value;
    }
}

// Devolver datos como JSON
echo json_encode([
    'estatus' => $estatus,  // Cambiar aquí
]);

$conn->close();
?>
