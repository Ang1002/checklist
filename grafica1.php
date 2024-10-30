<?php
$servername = "localhost";
$username = "root";
$password = "0084321";
$dbname = "projectroute";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Consulta SQL para encontrar el área con mayor frecuencia de alertas
$sql_max_area = "
    SELECT area, COUNT(*) AS frecuencia
    FROM alerta
    GROUP BY area
    ORDER BY frecuencia DESC
    LIMIT 1
";

$result_max_area = $conn->query($sql_max_area);

if ($result_max_area->num_rows > 0) {
    $row = $result_max_area->fetch_assoc();
    $area_mas_repetida = $row['area'];
    $frecuencia_maxima = $row['frecuencia'];

    echo "El área con más alertas es: " . $area_mas_repetida . " con " . $frecuencia_maxima . " alertas.";
} else {
    echo "No se encontraron áreas de alertas.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Área con más reporte de alertas final</title>
    <!-- Incluir la biblioteca ApexCharts desde CDN -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>
<body>
    <h1>Área con más reporte de alertas final</h1>
    <div id="chart_alertas"></div>

    <!-- Script JavaScript para configurar y renderizar la gráfica -->
    <script>
        var options_chart_alertas = {
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    horizontal: true
                }
            },
            series: [{
                data: <?php echo $chart_data_json_alertas; ?>
            }],
            xaxis: {
                categories: <?php echo json_encode($chart_data_alertas['labels']); ?>
            }
        };

        var chart_alertas = new ApexCharts(document.querySelector("#chart_alertas"), options_chart_alertas);
        chart_alertas.render();

        
    </script>
</body>
</html>
