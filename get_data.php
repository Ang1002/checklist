<?php
$servername = "localhost";
$username = "root";
$password = "0084321";
$dbname = "projectroute";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$period = $_GET['period'];

function fetchData($conn, $sql) {
    $result = $conn->query($sql);
    $data = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

// Definir las consultas SQL según el periodo
$sql_period = "";
if ($period == 'week') {
    $sql_period = "DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
} elseif ($period == 'month') {
    $sql_period = "DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
} else {
    $sql_period = "DATE_SUB(CURDATE(), INTERVAL 1 YEAR)"; // Valor predeterminado
}


$sql_areas = "SELECT area, COUNT(*) as frecuencia FROM alerta WHERE fecha_alerta >= $sql_period GROUP BY area";
$sql_fallas = "SELECT falla, COUNT(*) as frecuencia FROM alerta WHERE fecha_alerta >= $sql_period GROUP BY falla";
$sql_elementos = "SELECT elemento, COUNT(*) as frecuencia FROM alerta WHERE fecha_alerta >= $sql_period GROUP BY elemento HAVING COUNT(*) > 1";
$sql_reportes_dia = "SELECT DATE(fecha_alerta) as fecha, COUNT(*) as frecuencia FROM alerta WHERE fecha_alerta >= $sql_period GROUP BY DATE(fecha_alerta)";

$sql_alerta = "SELECT COUNT(*) as count_alerta FROM alerta WHERE fecha_alerta >= $sql_period";
$sql_reportes2 = "SELECT COUNT(*) as count_reportes2 FROM reportes2 WHERE fecha >= $sql_period";

$areas_data = fetchData($conn, $sql_areas);
$fallas_data = fetchData($conn, $sql_fallas);
$elementos_data = fetchData($conn, $sql_elementos);
$reportes_dia_data = fetchData($conn, $sql_reportes_dia);

// Contar las alertas y reportes2
$sql_alerta = "SELECT COUNT(*) as count_alerta FROM alerta WHERE fecha_alerta >= $sql_period";
$result_alerta = $conn->query($sql_alerta);
$count_alerta = $result_alerta->fetch_assoc()['count_alerta'];

$sql_reportes2 = "SELECT COUNT(*) as count_reportes2 FROM reportes2 WHERE fecha >= $sql_period";
$result_reportes2 = $conn->query($sql_reportes2);
$count_reportes2 = $result_reportes2->fetch_assoc()['count_reportes2'];

$conn->close();

echo json_encode([
    'donut' => [
        'series' => [$count_alerta, $count_reportes2],
        'labels' => ['Alertas', 'Incidencias']
    ],
    'areas' => [
        'categories' => array_column($areas_data, 'area'),
        'series' => array_column($areas_data, 'frecuencia')
    ],
    'fallas' => [
        'categories' => array_column($fallas_data, 'falla'),
        'series' => array_column($fallas_data, 'frecuencia')
    ],
    'elementos' => [
        'categories' => array_column($elementos_data, 'elemento'),
        'series' => array_column($elementos_data, 'frecuencia')
    ],
    'reportes' => [
        'categories' => array_column($reportes_dia_data, 'fecha'),
        'series' => array_column($reportes_dia_data, 'frecuencia')
    ]
]);


?>
