<?php
// Configuración de la conexión a la base de datos
$host = 'localhost'; // Cambia esto según tu configuración
$db = 'projectroute'; // Cambia por el nombre de tu base de datos
$user = 'root'; // Tu usuario de la base de datos
$pass = '0084321'; // Tu contraseña de la base de datos

// Crear conexión
$conn = new mysqli($host, $user, $pass, $db);

// Comprobar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el tipo de consulta (mes o semana) desde la solicitud GET
$tipo = $_GET['tipo'] ?? null; // Usar null si no está definido
$data = [];

// Consultas según el tipo
if ($tipo == 'mes') {
    // Consulta para obtener datos agrupados por mes
    $sql = "SELECT MONTH(fecha_alerta) AS mes, COUNT(*) AS total_alertas 
            FROM alerta 
            GROUP BY MONTH(fecha_alerta)";
} elseif ($tipo == 'semana') {
    $semana = intval($_GET['semana'] ?? 0); // Usar 0 si no está definido
    // Consulta para obtener datos agrupados por semana
    $sql = "SELECT YEAR(fecha_alerta) AS anio, WEEK(fecha_alerta, 1) AS semana, COUNT(*) AS total_alertas 
            FROM alerta 
            WHERE WEEK(fecha_alerta, 1) = $semana 
            GROUP BY YEAR(fecha_alerta), WEEK(fecha_alerta, 1)";
} else {
    die(json_encode(['error' => 'Tipo no válido']));
}

// Ejecutar la consulta
$result = $conn->query($sql);

// Verificar si hay resultados y llenar el arreglo $data
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row; // Agregar datos a la matriz
    }
} else {
    $data = []; // Sin datos
}

// Consulta SQL para contar la frecuencia de cada área
$sql_areas = "SELECT area, COUNT(*) as frecuencia FROM alerta GROUP BY area";
$result_areas = $conn->query($sql_areas);
check_query($result_areas, 'areas');

$areas_data = array();
if (mysqli_num_rows($result_areas) > 0) {
    while($row = $result_areas->fetch_assoc()) {   
        $areas_data[] = $row;
    }
}

// Consulta SQL para contar la frecuencia de cada falla
$sql_fallas = "SELECT falla, COUNT(*) as frecuencia FROM alerta GROUP BY falla HAVING COUNT(*) > 1";
$result_fallas = $conn->query($sql_fallas);
check_query($result_fallas, 'fallas');

$fallas_data = array();
if (mysqli_num_rows($result_fallas) > 0) {
    while($row = $result_fallas->fetch_assoc()) {
        $fallas_data[] = $row;
    }
}

// Consulta SQL para contar la frecuencia de fallas por elemento
$sql_elementos = "SELECT elemento, COUNT(*) as frecuencia FROM alerta GROUP BY elemento HAVING COUNT(*) > 1";
$result_elementos = $conn->query($sql_elementos);
check_query($result_elementos, 'elementos');

$elementos_data = array();
if (mysqli_num_rows($result_elementos) > 0) {
    while($row = $result_elementos->fetch_assoc()) {
        $elementos_data[] = $row;
    }
}

// Consulta SQL para contar la frecuencia de reportes por día
$sql_reportes_dia = "SELECT DATE(fecha_alerta) as fecha, COUNT(*) as frecuencia FROM alerta GROUP BY DATE(fecha_alerta) HAVING COUNT(*) > 1";
$result_reportes_dia = $conn->query($sql_reportes_dia);
check_query($result_reportes_dia, 'reportes_dia');

$reportes_dia_data = array();
if (mysqli_num_rows($result_reportes_dia) > 0) {
    while($row = $result_reportes_dia->fetch_assoc()) {
        $reportes_dia_data[] = $row;
    }
}

// Consulta SQL para contar los elementos en la tabla alerta
$sql_alerta = "SELECT COUNT(*) as count_alerta FROM alerta";
$result_alerta = $conn->query($sql_alerta);
check_query($result_alerta, 'alerta');

$row_alerta = $result_alerta->fetch_assoc();
$count_alerta = $row_alerta['count_alerta'];

// Consulta SQL para contar los elementos en la tabla reportes2
$sql_reportes2 = "SELECT area, COUNT(*) as count_reportes2 FROM reportes2";
$result_reportes2 = $conn->query($sql_reportes2);
check_query($result_reportes2, 'reportes2');

$row_reportes2 = $result_reportes2->fetch_assoc();
$count_reportes2 = $row_reportes2['count_reportes2'];

// Consulta SQL para contar la frecuencia de cada área en reportes2
$sql_areas_reportes2 = "SELECT area, COUNT(*) as frecuencia FROM reportes2 GROUP BY area";
$result_areas_reportes2 = $conn->query($sql_areas_reportes2);
check_query($result_areas_reportes2, 'areas_reportes2');

$areas_reportes2_data = array();
if (mysqli_num_rows($result_areas_reportes2) > 0) {
    while($row = $result_areas_reportes2->fetch_assoc()) {
        $areas_reportes2_data[] = $row;
    }
}

// Consulta SQL para contar la frecuencia de reportes por día en reportes2
$sql_reportes_dia_reportes2 = "SELECT DATE(fecha) as fecha, COUNT(*) as frecuencia FROM reportes2 GROUP BY DATE(fecha) HAVING COUNT(*) > 1";
$result_reportes_dia_reportes2 = $conn->query($sql_reportes_dia_reportes2);
check_query($result_reportes_dia_reportes2, 'reportes_dia_reportes2');

$reportes_dia_reportes2_data = array();
if (mysqli_num_rows($result_reportes_dia_reportes2) > 0) {
    while($row = $result_reportes_dia_reportes2->fetch_assoc()) {
        $reportes_dia_reportes2_data[] = $row;
    }
}

// Consulta SQL para contar la frecuencia de cada área en reportes2 (ordenada por frecuencia)
$sql_areas_reportes2_ordered = "SELECT area, COUNT(*) AS falla FROM reportes2 GROUP BY area ORDER BY falla DESC";
$result_areas_reportes2_ordered = $conn->query($sql_areas_reportes2_ordered);
check_query($result_areas_reportes2_ordered, 'areas_reportes2_ordered');

$areas_reportes2_data = array();
if (mysqli_num_rows($result_areas_reportes2_ordered) > 0) {
    while ($row = $result_areas_reportes2_ordered->fetch_assoc()) {
        $areas_reportes2_data[] = $row;
    }
}

// Consulta SQL para contar la frecuencia de alertas por semana
$sql_alertas_semana = "SELECT YEAR(fecha_alerta) as ano, WEEK(fecha_alerta) as semana, COUNT(*) as frecuencia FROM alerta GROUP BY YEAR(fecha_alerta), WEEK(fecha_alerta)";
$result_alertas_semana = $conn->query($sql_alertas_semana);
check_query($result_alertas_semana, 'alertas_semana');


$alertas_semana_data = array();
if (mysqli_num_rows($result_alertas_semana) > 0) {
    while($row = $result_alertas_semana->fetch_assoc()) {
        $alertas_semana_data[] = $row;
    }
}

$sql_reportes_dia_semana_reportes2 = "
    SELECT 
        YEAR(fecha) AS anio, 
        WEEK(fecha) AS semana, 
        DATE(fecha) AS fecha, 
        COUNT(*) AS frecuencia 
    FROM 
        reportes2 
    GROUP BY 
        YEAR(fecha), WEEK(fecha), DATE(fecha) 
    HAVING 
        COUNT(*) > 1
";
$result_reportes_dia_semana_reportes2 = $conn->query($sql_reportes_dia_semana_reportes2);
check_query($result_reportes_dia_semana_reportes2, 'reportes_dia_semana_reportes2');

$reportes_dia_semana_reportes2_data = array();
if (mysqli_num_rows($result_reportes_dia_semana_reportes2) > 0) {
    while ($row = $result_reportes_dia_semana_reportes2->fetch_assoc()) {
        $reportes_dia_semana_reportes2_data[] = $row;
    }
}


$sql_areas_semanal = "
    SELECT 
        YEAR(fecha_alerta) AS anio, 
        WEEK(fecha_alerta) AS semana, 
        area, 
        COUNT(*) AS frecuencia 
    FROM alerta 
    GROUP BY YEAR(fecha_alerta), WEEK(fecha_alerta), area 
    ORDER BY anio, semana, frecuencia DESC
";
$result_areas_semanal = $conn->query($sql_areas_semanal);
check_query($result_areas_semanal, 'areas_semanal');

$areas_semanal_data = array();
if (mysqli_num_rows($result_areas_semanal) > 0) {
    while ($row = $result_areas_semanal->fetch_assoc()) {
        $areas_semanal_data[] = $row;
    }
}

// Devolver los datos en formato JSON
header('Content-Type: application/json');
echo json_encode($data);

// Cerrar la conexión
$conn->close();
?>
