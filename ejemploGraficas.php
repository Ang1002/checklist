<?php
// Datos de ejemplo para la gráfica de pastel
$data_pie = [
  ['Areas', 'alertas'],
  ['Stepp', 11],
  ['Recepción', 2],
  ['Vacio', 2],
  ['Carbón', 2],
  ['Conectores', 7],
  ['Hornos de Flexión', 2],
  ['Mezzanine', 2],
  ['Inyección', 2],
  ['Suaje', 7],
  ['Soplado', 2],
  ['Carbón', 2],
  ['Bodega', 7],
  ['Embarques PT', 2],
  ['Extrucción', 2],
  ['Bodega', 7],
  ['GP12', 7],
  ['Moldes de Flexión', 7]
];

// Datos de ejemplo para la gráfica de línea (reportes o incidencias)
$data_line = [
  ['Areas', 'reportes'],
  ['Stepp',  10],
  ['Recepción',  8],
  ['Vacio',  7],
  ['Carbón', 6],
  ['Conectores',  8],
  ['Hornos de Flexión',  10],
  ['Mezzanine', 8],
  ['Inyección', 7],
  ['Suaje',  6],
  ['Soplado',  8],
  ['Carbón',  10],
  ['Bodega',  8],
  ['Embarques PT', 7],
  ['Extrucción',  6],
  ['Bodega', 8],
  ['GP12',  6],
  ['Moldes de Flexión',  8]
];

// Convertir los datos a formato JSON para pasarlo al script de Google Charts
$data_pie_json = json_encode($data_pie);
$data_line_json = json_encode($data_line);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <link rel="stylesheet" href="style_grafica_ejemplo.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="icon" href="imagenes/kayser_icon.ico" type="image/x-icon">

  <title>Gráficas</title>
  <!-- Incluir la librería de Google Charts -->
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawCharts);

    function drawCharts() {
      // Datos de ejemplo para la gráfica de pastel
      var data_pie = <?php echo json_encode($data_pie); ?>;
      // Datos de ejemplo para la gráfica de línea
      var data_line = <?php echo json_encode($data_line); ?>;

      // Configuración y opciones para la gráfica de pastel
      var pieOptions = {
        title: 'Áreas con más alertas',
        pieHole: 0.4,
        animation: {
          startup: true,
          duration: 1000,
          easing: 'out'
        },
        legend: { position: 'bottom' },
        backgroundColor: 'black' // Color de fondo para la gráfica de pastel
      };

      // Configuración y opciones para la gráfica de línea
      var lineOptions = {
        title: 'Reportes de incidencias por área',
        curveType: 'function',
        legend: { position: 'bottom' },
        backgroundColor: 'black' // Color de fondo para la gráfica de línea
      };

      // Crear instancias de las gráficas
      var pieChart = new google.visualization.PieChart(document.getElementById('pie_chart_div'));
      var lineChart = new google.visualization.LineChart(document.getElementById('line_chart_div'));

      // Dibujar las gráficas
      pieChart.draw(google.visualization.arrayToDataTable(data_pie), pieOptions);
      lineChart.draw(google.visualization.arrayToDataTable(data_line), lineOptions);
    }
  </script>
</head>
<body>
  <center>
    <header>
      <nav>
        <h2><img src="imagenes/kayser_logo2-removebg-preview (1).png" alt="Logo" width="180" height="80"></h2>
        <ul>
          <li class="main-nav__item"><a class="main-nav__link" href="menu.php" data-link-alt=""> <svg
                xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-border-width"
                viewBox="0 0 16 16">
                <path
                  d="M0 3.5A.5.5 0 0 1 .5 3h15a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H.5a.5.5 0 0 1-.5-.5zm0 5A.5.5 0 0 1 .5 8h15a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H.5a.5.5 0 0 1-.5-.5zm0 4a.5.5 0 0 1 .5-.5h15a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5" />
              </svg> Inicio </a></li>
        </ul>
      </nav>
    </header>

    <div id="pie_chart_div" class="chart-container"></div>
    <div id="line_chart_div" class="chart-container"></div>
  
  </center>
</body>
</html>
