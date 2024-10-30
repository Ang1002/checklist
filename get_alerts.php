<?php
$servername = "localhost";
$username = "root";
$password = "0084321";
$dbname = "projectroute";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(array('error' => "Conexión fallida: " . $conn->connect_error)));
}

// Obtener alertas de la base de datos
$query_alertas = "SELECT id, elemento, area, falla, fecha_alerta, estatus FROM alerta WHERE estatus = 'Aceptada' AND DATE(fecha_alerta) = CURDATE()";
$result_alertas = $conn->query($query_alertas);

if (!$result_alertas) {
    die(json_encode(array('error' => "Error en la consulta de alertas: " . $conn->error)));
}

$alerts = array();
if ($result_alertas->num_rows > 0) {
    while ($row = $result_alertas->fetch_assoc()) {
        $alerts[] = array(
            'id' => $row['id'],
            'elemento' => $row['elemento'],
            'area' => $row['area'],
            'falla' => $row['falla'],
            'fecha_alerta' => $row['fecha_alerta'],
            'estatus' => $row['estatus']
        );
    }
}

header('Content-Type: application/json');
echo json_encode(array('alertas' => $alerts));

$conn->close();
?>
