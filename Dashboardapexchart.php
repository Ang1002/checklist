<?php
$servername = "localhost";
$username = "root";
$password = "0084321";
$dbname = "projectroute";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Función para manejar errores de consulta
function check_query($result, $query_name) {
    global $conn;
    if (!$result) {
        die("Error en la consulta '$query_name': " . $conn->error);
    }
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


// ---------------------------
// Obtener áreas únicas en la tabla 'elementos'
$sql_areas = "SELECT DISTINCT areas FROM elementos";
$result_areas = $conn->query($sql_areas);
$total_areas = $result_areas->num_rows;

// ---------------------------
// Contar elementos en la tabla 'elementos'
$sql_elementos = "SELECT COUNT(*) as total_elementos FROM elementos";
$result_elementos = $conn->query($sql_elementos);
$row_elementos = $result_elementos->fetch_assoc();
$total_elementos = $row_elementos['total_elementos'];

// ---------------------------
// Contar alertas en la tabla 'alertas'
$sql_total_alertas = "SELECT COUNT(*) as total_alertas FROM alerta";
$result_total_alertas = $conn->query($sql_total_alertas);
$row_total_alertas = $result_total_alertas->fetch_assoc();
$total_alertas = $row_total_alertas['total_alertas'];

// ---------------------------
// Contar reportes en la tabla 'reportes2'
$sql_reportes = "SELECT COUNT(*) as total_reportes FROM reportes2";
$result_reportes = $conn->query($sql_reportes);
$row_reportes = $result_reportes->fetch_assoc();
$total_reportes = $row_reportes['total_reportes'];


// Definir las rutas
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['type']) && $_GET['type'] === 'estatus') {
        // Consulta para obtener el estatus predominante
        $query = "SELECT estatus, COUNT(*) AS total FROM alerta GROUP BY estatus ORDER BY total DESC LIMIT 1";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo json_encode($row);
        } else {
            echo json_encode(['estatus' => 'N/A', 'total' => 0]);
        }
    } elseif (isset($_GET['type']) && $_GET['type'] === 'usuarios') {
        // Consulta para obtener alertas por usuario
        $query = "SELECT user_alert, COUNT(*) AS total_alertas FROM alerta GROUP BY user_alert ORDER BY total_alertas DESC";
        $result = $conn->query($query);

        $usuarios = [];
        while ($row = $result->fetch_assoc()) {
            $usuarios[] = $row;
        }

        echo json_encode($usuarios);
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Dashboard</title>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" />
<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
<link rel="stylesheet" href="assetss/style.css" /> 
<link rel="stylesheet" href="libss/apexcharts.css">

<script src="libss/apexcharts.min.js"></script>



<style>
/* Estilos generales para encabezados */
h1, h2, h3, h4, h5 {
  margin: 0; /* Elimina márgenes predeterminados */
  padding: 0; /* Elimina rellenos predeterminados */
  /* Puedes añadir otros estilos aquí según tus necesidades */
}

/* Resto de tus estilos */
#wrapper {
  display: flex;
  justify-content: center; /* Centra los elementos en el eje horizontal */
  align-items: flex-start; /* Alinea en la parte superior */
  padding: 0px; /* Añade un poco de espacio alrededor */
}

.content-area {
  display: flex; /* Usa flexbox para los elementos internos */
  gap: 10px; /* Espacio entre los elementos */
}

.item {
  text-align: center; /* Centra el texto dentro de cada item */
  flex: 1; /* Hace que cada item tenga el mismo ancho */
  width: 280px; /* Establece un ancho fijo */
  padding: 10px; /* Aumenta el padding para mayor altura */
  height: 90px; /* Establece una altura mínima */
  border-radius: 12px; /* Bordes redondeados opcionales */
  color: white; /* Color del texto */
}

/* Colores diferentes para cada contenedor */
.item:nth-child(1) {
  background-image: linear-gradient(135deg, #ABDCFF 10%, #0396FF 100%); /* Azul degradado */
}

.item:nth-child(2) {
  background-image: linear-gradient(135deg, #FFD580 10%, #FFA500 100%); /* Naranja degradado */
}

.item:nth-child(3) {
  background-image: linear-gradient(135deg, #FFB3B3 10%, #FF4D4D 100%); /* Rojo degradado */
}

.item:nth-child(4) {
  background-image: linear-gradient(135deg, #B392AC 10%, #9B59B6 100%); /* Morado degradado */
}


body {
    background: #343E59; /* Fondo negro azulado */
    color: #ffffff; /* Texto blanco */
    font-family: Montserrat, Arial, sans-serif;
}

.body-bg {
    background: #F3F4FA !important;
}

h1, h2, h3, h4, h5, h6, strong {
    font-weight: 600;
    color: #ffffff; /* Texto blanco */
    text-decoration-color: #ffffff;
}

.content-area {
    max-width: 1300px;
    margin: 0 auto;
}

.box {
    background-color: #2B2D3E; /* Fondo para cajas */
    padding: 25px 20px;
    border-radius: 5px; /* Bordes redondeados */
    box-shadow: 0px 1px 15px 1px rgba(69, 65, 78, 0.08);
    color: #ffffff;
}

.sparkboxes .box {
    padding: 10px;
    position: relative;
    text-shadow: none;
    color: #ffffff; /* Texto blanco */
    width: 200px; /* Ancho específico */
    height: 150px;
}

.sparkboxes .box .details {
    position: absolute;
    color: #ffffff;
    padding-top: -80px; /* Espacio para el título */
    transform: scale(0.7) translate(-22px, 20px);
    width: 200px; /* Ancho específico */
    height: 150px;
}

.sparkboxes strong {
    position: relative;
    z-index: 3;
    top: -8px;
    color: #ffffff; /* Texto blanco */
    width: 200px; /* Ancho específico */
    height: 150px;
}

#text-element {
    position: relative;
    z-index: 10;
}

/* Colores distintos para cada caja y gráfica */
.sparkboxes .box1 {
    background-image: linear-gradient(135deg, #ABDCFF 10%, #0396FF 100%); /* Azul degradado */
    width: 200px; /* Ancho específico */
    height: 150px;
}

.sparkboxes .box2 {
    background-image: linear-gradient(135deg, #FFD580 10%, #FFA500 100%); /* Naranja degradado */
    width: 200px; /* Ancho específico */
    height: 150px;
}

.sparkboxes .box3 {
    background-image: linear-gradient(135deg, #FFB3B3 10%, #FF4D4D 100%); /* Rojo degradado */
    width: 200px; /* Ancho específico */
    height: 150px;
}

.sparkboxes .box4 {
    background-image: linear-gradient(135deg, #B392AC 10%, #9B59B6 100%); /* Morado degradado */
    width: 200px; /* Ancho específico */
    height: 150px;
}   


/* Botones estilizados */
.btn {
    padding: 12px 24px;
    border-radius: 6px;
    margin-left: 10px;
    cursor: pointer;
    border: none;
    color: #ffffff; /* Texto blanco */
}

.btn-primary {
    background-color: #1549b9; /* Azul oscuro */
}

.btn-secondary {
    background-color: #6c757d; /* Gris oscuro */
}

.btn:hover {
    opacity: 0.85; /* Efecto hover */
}

/* Estilos de las gráficas, diferentes colores */
#spark1 .apexcharts-line {
    stroke: #0396FF; /* Azul para spark1 */
    stroke-width: 3px; /* Grosor de la línea */
    z-index: 1;

}

#spark2 .apexcharts-line {
    stroke: #bb8218; /* Naranja para spark2 */
    stroke-width: 3px; /* Grosor de la línea */
    z-index: 1;

}

#spark3 .apexcharts-line {
    stroke: #FF4D4D; /* Rojo para spark3 */
    stroke-width: 3px; /* Grosor de la línea */
    z-index: 1;

}

#spark4 .apexcharts-line {
    stroke: #9B59B6; /* Morado para spark4 */
    stroke-width: 3px; /* Grosor de la línea */
    z-index: 1;

}

/* Extra espaciado para las secciones */
.mt-4 {
    margin-top: 1.5rem;
}

/* Estilos específicos para gráficos */
#spark1 path {
    stroke: #56b4e9 !important;  /* Color para la línea */
    z-index: -1;
    stroke-width: 3px; /* Grosor de la línea */
    width: 200px; /* Ancho específico */
    height: 150px;
}

#spark2 path {
    stroke: #d49919 !important;  /* Color para la línea */
    z-index: -1;
    stroke-width: 3px; /* Grosor de la línea */
    width: 200px; /* Ancho específico */
    height: 150px;
}

#spark3 path {
    stroke: #ff5e57 !important;  /* Color para la línea */
    z-index: -1;
    stroke-width: 3px; /* Grosor de la línea */
    width: 200px; /* Ancho específico */
    height: 150px;
}

#spark4 path {
    stroke: #9b59b6 !important;  /* Color para la línea */
    z-index: -1;
    stroke-width: 3px; /* Grosor de la línea */
    width: 200px; /* Ancho específico */
    height: 150px;
}

#line-adwords path {
    stroke: #179bd8 !important;  /* Color para la línea */
}

#barchart .apexcharts-bar-series .apexcharts-bar-area {
    fill: #f0b342 !important;  /* Color para las barras */
}

#radialBarBottom .apexcharts-radial-series .apexcharts-radial-bar-area {
    fill: #ff4560 !important;  /* Color para el gráfico radial */
}

#areachart path {
    stroke: #9b59b6 !important;  /* Color para la línea del área */
}

#areachart .apexcharts-area {
    fill: rgba(155, 89, 182, 0.4) !important;  /* Color para el relleno del área */
}

/* Para el texto de los números en los gráficos de ApexCharts */
.apexcharts-tooltip {
    color: #ffffff !important;  /* Texto blanco en las tooltips */
}

.apexcharts-title-text, 
.apexcharts-legend-text, 
.apexcharts-datalabel, 
.apexcharts-tooltip-text, 
.apexcharts-yaxis-label, 
.apexcharts-xaxis-label {
    color: #ffffff !important;  /* Texto blanco para títulos y etiquetas */
}

/* Para cambiar el color de los subtítulos y títulos dentro de los contenedores */
.sparkboxes .box .details {
    color: #ffffff !important; /* Texto blanco para subtítulos */
}

.sparkboxes strong {
    color: #ffffff !important; /* Texto blanco para títulos fuertes */
}

/* Opcional: Colores para botones */
.btn {
    color: #ffffff !important; /* Texto blanco en botones */
}

/* Opcional: Estilos para los ejes del gráfico (X e Y) */
.apexcharts-xaxis text,
.apexcharts-yaxis text {
    fill: #ffffff !important; /* Texto blanco para ejes X e Y */
}

/* Estilo para los contenedores de gráficos */
.chart-container {
    padding: 25px 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background-color: #2B2D3E;  /* Fondo para contenedores de gráficos */
}

.chart-title {
    font-size: 20px;
    margin-bottom: 15px;
    color: #ffffff;  /* Texto blanco para títulos */
    text-align: center;
}

/* Ajustes específicos para gráficos de barras */
#areasChart, #reportesDiaChart {
    height: 25px; /* Altura para gráficos de barras */
    width: 20px;
    color: #ffffff;
}

/* Ajustes específicos para gráficos de línea */
#elementosChart, #alertasSemanaChart {
    height: 25px; /* Altura para gráficos de línea */
    width: 20px;
    color: #ffffff;
}

/* Ajustes específicos para gráficos de pastel */
#fallasChart {
    height: 25px; /* Altura para gráficos de pastel */
    width: 20px;
    color: #ffffff;
}

.card {
    position: relative; /* Mantiene el contexto de posición */
    padding-top: 30px; /* Espacio para el título */
}

.sidebar {
    height: 100vh;
    width: 80px;
    background-color: #333;
    color: white;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding-top: 20px;
    position: fixed;
}

.sidebar button {
    background-color: #444;
    color: white;
    border: none;
    padding: 10px 20px;
    margin: 10px 0;
    cursor: pointer;
    font-size: 16px;
}

.sidebar button:hover {
    background-color: #555;
}

.content {
    margin-left: 90px; /* Same as the width of the sidebar */
    padding: 20px;
    flex-grow: 1;
}

.boton-rojo {
    background-color: red; /* Color de fondo rojo */
    color: white; /* Color del texto en blanco */
    padding: 10px 20px; /* Espaciado interno */
    border: none; /* Sin borde */
    border-radius: 5px; /* Bordes redondeados */
    cursor: pointer; /* Cambia el cursor al pasar sobre el botón */
    font-size: 16px; /* Tamaño de la fuente */
    text-decoration: none; /* Sin subrayado */
    display: inline-block; /* Para que se comporte como un bloque */
    transition: background-color 0.3s; /* Efecto de transición */
}

.boton-rojo:hover {
    background-color: darkred; /* Color al pasar el ratón */
} 

</style>

</head>

<body>
    <center>
        <h1 style="color: rgb(255, 255, 255);">Reporte General</h1>
    </center>
   <!-- <div class="sidebar">
        <button onclick="window.location.href='menu.php'"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-reply-fill" viewBox="0 0 16 16">
  <path d="M5.921 11.9 1.353 8.62a.72.72 0 0 1 0-1.238L5.921 4.1A.716.716 0 0 1 7 4.719V6c1.5 0 6 0 7 8-2.5-4.5-7-4-7-4v1.281c0 .56-.606.898-1.079.62z"/>
</svg></button>
    </div>-->

    <div class="main">
    <!-- Botones para cambiar entre semana y mes -->
    <div class="container-fluid">
  <div class="main">
    <!-- Botones para cambiar entre semana y mes -->
   <!-- <div class="row mt-4">
      <div class="col-md-12 text-right">
        <button id="btnSemana" class="btn btn-primary">Por Semana</button>
        <button id="btnMes" class="btn btn-secondary">Por Mes</button>
      </div>
    </div>-->

    <div id="wrapper">
  <div class="content-area">
    <div class="item">
      <h3><?php echo $total_areas; ?></h3>
      <h5>Áreas 
        <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" fill="currentColor" class="bi bi-boxes" viewBox="0 0 16 16">
          <path d="M7.752.066a.5.5 0 0 1 .496 0l3.75 2.143a.5.5 0 0 1 .252.434v3.995l3.498 2A.5.5 0 0 1 16 9.07v4.286a.5.5 0 0 1-.252.434l-3.75 2.143a.5.5 0 0 1-.496 0l-3.502-2-3.502 2.001a.5.5 0 0 1-.496 0l-3.75-2.143A.5.5 0 0 1 0 13.357V9.071a.5.5 0 0 1 .252-.434L3.75 6.638V2.643a.5.5 0 0 1 .252-.434zM4.25 7.504 1.508 9.071l2.742 1.567 2.742-1.567zM7.5 9.933l-2.75 1.571v3.134l2.75-1.571zm1 3.134 2.75 1.571v-3.134L8.5 9.933zm.508-3.996 2.742 1.567 2.742-1.567-2.742-1.567zm2.242-2.433V3.504L8.5 5.076V8.21zM7.5 8.21V5.076L4.75 3.504v3.134zM5.258 2.643 8 4.21l2.742-1.567L8 1.076zM15 9.933l-2.75 1.571v3.134L15 13.067zM3.75 14.638v-3.134L1 9.933v3.134z" />
        </svg>
      </h5>
    </div>

    <div class="item">
      <h3><?php echo $total_elementos; ?></h3>
      <h5>Elementos 
        <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
          <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492M5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0" />
          <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115z" />
        </svg>
      </h5>
    </div>

    <div class="item">
      <h3><?php echo $total_alertas; ?></h3>
      <h5>Alertas 
      <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" fill="currentColor" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
        <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.15.15 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.2.2 0 0 1-.054.06.1.1 0 0 1-.066.017H1.146a.1.1 0 0 1-.066-.017.2.2 0 0 1-.054-.06.18.18 0 0 1 .002-.183L7.884 2.073a.15.15 0 0 1 .054-.057m1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767z"/>
        <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z"/>
    </svg>
      </h5>
    </div>

    <div class="details item">
      <h3><?php echo $total_reportes; ?></h3>
      <h5>Reportes 
      <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" fill="currentColor" class="bi bi-clipboard2-data" viewBox="0 0 16 16">
        <path d="M9.5 0a.5.5 0 0 1 .5.5.5.5 0 0 0 .5.5.5.5 0 0 1 .5.5V2a.5.5 0 0 1-.5.5h-5A.5.5 0 0 1 5 2v-.5a.5.5 0 0 1 .5-.5.5.5 0 0 0 .5-.5.5.5 0 0 1 .5-.5z"/>
        <path d="M3 2.5a.5.5 0 0 1 .5-.5H4a.5.5 0 0 0 0-1h-.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1H12a.5.5 0 0 0 0 1h.5a.5.5 0 0 1 .5.5v12a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5z"/>
        <path d="M10 7a1 1 0 1 1 2 0v5a1 1 0 1 1-2 0zm-6 4a1 1 0 1 1 2 0v1a1 1 0 1 1-2 0zm4-3a1 1 0 0 0-1 1v3a1 1 0 1 0 2 0V9a1 1 0 0 0-1-1"/>
    </svg>
      </h>
    </div>
  </div>
</div>

      




  <!-- Agregar la gráfica circular aquí -->
  <div class="row mt-4">
    <div class="col-md-6">
        <div class="box shadow">
            <h4 class="text-center">Alertas por Semana</h4> <!-- Título para el gráfico de alertas -->
            <div id="chart-alertas-semana"></div> <!-- Gráfico -->
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="box shadow">
            <h4 class="text-center">Conteo de Alertas y reportes de incidencias hasta ahora...</h4> <!-- Título para el gráfico de tablas -->
            <div id="chart-tablas"></div> <!-- Gráfico -->
        </div>
    </div>
</div>


  
<br>
<br>
<br>

   <!-- Sección de gráficos -->
   <div class="charts-row mt-4">
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="chart-container" style="border: none;">
                       <center><h2>Áreas con más problemas</h2></center> 
                        <div id="chart-areas"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="chart-container" style="border: none;">
                        <center><h2>Fallas con más frecuencia</h2></center>
                        <div id="chart-fallas"></div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="chart-container" style="border: none;">
                        <center><h2>Elementos con Más Fallas</h2></center>
                        <div id="chart-elementos"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="chart-container" style="border: none;">
                        <center><h2>Día con más reportes</h2></center>
                        <div id="chart-reportes"></div>
                    </div>
                </div>
            </div>
            <br>
        </div>
    </div>
</div>



    <br><br>

    <center>
    <a href="menu.php" style="background-color:#820709; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; text-decoration: none; display: inline-block; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='darkred'" onmouseout="this.style.backgroundColor='red'">Volver a Menú</a>
</center>

<br>
<br>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="assetss/scripts.js"></script>
  <script>
  // Convertir los datos PHP a un objeto JavaScript
const alertasSemanaData = <?php echo json_encode($alertas_semana_data); ?>;

// Preparar los datos para la gráfica de líneas
const alertasSemanaCategories = alertasSemanaData.map(item => `Semana ${item.semana}, ${item.ano}`);
const alertasSemanaValues = alertasSemanaData.map(item => item.frecuencia);

const alertasSemanaOptions = {
    chart: {
        type: 'line',
        height: 400,
        toolbar: {
            show: true
        },
        animations: {
            enabled: true,
            easing: 'easeinout',
            speed: 800
        }
    },
    series: [{
        name: 'Alertas',
        data: alertasSemanaValues // Aquí deberías tener tu array de datos
    }],
    xaxis: {
    categories: alertasSemanaCategories,
    title: {
        text: 'Semanas'
    },
    labels: {
        rotate: -45 // Rotar las etiquetas para mejorar la legibilidad
    }
    },
    yaxis: {
        title: {
            text: 'Cantidad de Alertas'
        }
    },
    stroke: {
        curve: 'smooth',
        width: 3,
        lineCap: 'round',
        colors: ['#eb3713'], // Color inicial de la línea
        // Configuración de gradiente
        gradient: {
            shade: 'light',
            type: 'vertical',
            shadeIntensity: 0.5,
            gradientToColors: ['#FF5733', '#FFC300', '#59e314'],
            inverseColors: false,
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 50, 100]
        }
    },
    markers: {
        size: 4,
        colors: ['#ffc300'], // Color de los marcadores
        strokeColors: '#fff',
        strokeWidth: 2
    },
    dataLabels: {
        enabled: false
    },
    title: {
        text: 'Alertas por',
        align: 'center',
        style: {
            fontSize: '20px',
            fontWeight: 'bold',
            color: '#333'
        }
    },
    tooltip: {
        theme: 'dark'
    }
};

// Crear la gráfica de líneas
const alertasSemanaChart = new ApexCharts(document.querySelector("#chart-alertas-semana"), alertasSemanaOptions);
alertasSemanaChart.render();

    
    // Convertir los datos PHP a un objeto JavaScript
    const alertaCount = <?php echo $count_alerta; ?>;
    const reportes2Count = <?php echo $count_reportes2; ?>;

    // Preparar los datos para la gráfica circular
    const data = {
        series: [alertaCount, reportes2Count],
        labels: ['Alertas', 'Incidencias']
    };

    // Opciones de la gráfica circular
    const options = {
        chart: {
            type: 'donut',
            height: 350,
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 800,
                animateGradually: {
                    enabled: true,
                    delay: 150
                },
                dynamicAnimation: {
                    enabled: true,
                    speed: 350
                }
            }
        },
        labels: data.labels,
        series: data.series,
        colors: ['#80060e', '#e69122'],
        legend: {
            show: true,
            position: 'bottom'
        },
        dataLabels: {
            enabled: true,
            enabledOnSeries: undefined,
            formatter: function (val, opts) {
                return opts.w.globals.labels[opts.seriesIndex] + ": " + val
            },
            textAnchor: 'middle',
            distributed: false,
            offsetX: 0,
            offsetY: 0,
            style: {
                fontSize: '12px',
                fontFamily: 'Helvetica, Arial, sans-serif',
                fontWeight: 'bold',
                colors: ['#ffffff'],
            },
            dropShadow: {
                enabled: false,
                top: 1,
                left: 1,
                blur: 1,
                opacity: 0.45
            }
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    show: false
                }
            }
        }],
        title: {
        text: 'Alertas y Reportes de incidencias ',
        align: 'center',
        style: {
            fontSize: '20px',
            fontWeight: 'bold',
            color: '#333'
        }
    },
    tooltip: {
        theme: 'dark'
    }
    };

    // Crear la gráfica circular
    const chart = new ApexCharts(document.querySelector("#chart-tablas"), options);
    chart.render();

    // Convertir los datos PHP a un objeto JavaScript
    const areasData = <?php echo json_encode($areas_data); ?>;
    const fallasData = <?php echo json_encode($fallas_data); ?>;
    const elementosData = <?php echo json_encode($elementos_data); ?>;
    const reportesDiaData = <?php echo json_encode($reportes_dia_data); ?>;

    // Preparar los datos para la gráfica de áreas
    const areasCategories = areasData.map(item => item.area);
    const areasValues = areasData.map(item => item.frecuencia);

    // Opciones de la gráfica de áreas
    const areasOptions = {
        chart: {
            type: 'bar',
            height: 400,
            toolbar: {
                show: true
            },
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 1000,
                animateGradually: {
                    enabled: true,
                    delay: 150
                },
                dynamicAnimation: {
                    enabled: true,
                    speed: 500
                }
            }
        },
        series: [{
            name: 'Frecuencia',
            data: areasValues
        }],
        xaxis: {
            categories: areasCategories,
            title: {
                text: 'Áreas'
            }
        },
        yaxis: {
            title: {
                text: 'Frecuencia'
            }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded'
            },
        },
        dataLabels: {
            enabled: false
        },
        title: {
            text: '',
            align: 'center',
            style: {
                fontSize: '20px',
                fontWeight: 'bold',
                color: '#333'
            }
        },
        colors: ['#0470d9'],
        tooltip: {
            theme: 'dark'
        }
    };

    // Crear la gráfica de áreas
    const areasChart = new ApexCharts(document.querySelector("#chart-areas"), areasOptions);
    areasChart.render();




    // Preparar los datos para la gráfica de fallas
    const fallasCategories = fallasData.map(item => item.falla);
    const fallasValues = fallasData.map(item => item.frecuencia);

  // Opciones de la gráfica de fallas
  const fallasOptions = {
        chart: {
            type: 'bar',
            height: 400,
            toolbar: {
                show: true
            },
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 800,
                animateGradually: {
                    enabled: true,
                    delay: 150
                },
                dynamicAnimation: {
                    enabled: true,
                    speed: 350
                }
            }
        },
        series: [{
            name: 'Frecuencia',
            data: fallasValues
        }],
        xaxis: {
            categories: fallasCategories,
            title: {
                text: 'Fallas'
            }
        },
        yaxis: {
            title: {
                text: 'Frecuencia'
            }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded'
            },
        },
        dataLabels: {
            enabled: false
        },
        title: {
            text: '',
            align: 'center',
            style: {
                fontSize: '20px',
                fontWeight: 'bold',
                color: '#333'
            }
        },
        colors: ['#c23b06'],
        tooltip: {
            theme: 'dark'
        }
    };
    // Crear la gráfica de fallas
    const fallasChart = new ApexCharts(document.querySelector("#chart-fallas"), fallasOptions);
    fallasChart.render();

    // Preparar los datos para la gráfica de elementos
    const elementosCategories = <?php echo json_encode(array_column($elementos_data, 'elemento')); ?>;
    const elementosValues = <?php echo json_encode(array_column($elementos_data, 'frecuencia')); ?>;

    // Opciones de la gráfica de elementos (bar chart)
    const elementosOptions = {
        chart: {
            type: 'bar',
            height: 400,
            toolbar: {
                show: true
            },
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 800,
                animateGradually: {
                    enabled: true,
                    delay: 150
                },
                dynamicAnimation: {
                    enabled: true,
                    speed: 350
                }
            }
        },
        series: [{
            name: 'Frecuencia',
            data: elementosValues
        }],
        xaxis: {
            categories: elementosCategories,
            title: {
                text: 'Elementos'
            }
        },
        yaxis: {
            title: {
                text: 'Frecuencia'
            }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded'
            },
        },
        dataLabels: {
            enabled: false
        },
        title: {
            text: '',
            align: 'center',
            style: {
                fontSize: '20px',
                fontWeight: 'bold',
                color: '#333'
            }
        },
        colors: ['#0b8f14'],
        tooltip: {
            theme: 'dark'
        }
    };

    // Crear la gráfica de elementos
    const elementosChart = new ApexCharts(document.querySelector("#chart-elementos"), elementosOptions);
    elementosChart.render();

    // Preparar los datos para la gráfica de reportes por día
    const reportesDiaCategories = <?php echo json_encode(array_column($reportes_dia_data, 'fecha')); ?>;
    const reportesDiaValues = <?php echo json_encode(array_column($reportes_dia_data, 'frecuencia')); ?>;

    // Opciones de la gráfica de reportes por día
    const reportesDiaOptions = {
        chart: {
            type: 'bar',
            height: 400,
            toolbar: {
                show: true
            },
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 800,
                animateGradually: {
                    enabled: true,
                    delay: 150
                },
                dynamicAnimation: {
                    enabled: true,
                    speed: 350
                }
            }
        },
        series: [{
            name: 'Reportes',
            data: reportesDiaValues
        }],
        xaxis: {
            categories: reportesDiaCategories,
            title: {
                text: 'Días'
            }
        },
        yaxis: {
            title: {
                text: 'Reportes'
            }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded'
            },
        },
        dataLabels: {
            enabled: false
        },
        title: {
            text: '',
            align: 'center',
            style: {
                fontSize: '20px',
                fontWeight: 'bold',
                color: '#333'
            }
        },
        colors: ['#ffc400'],
        tooltip: {
            theme: 'dark'
        }
    };

    
    // Crear la gráfica de reportes por día
    const reportesDiaChart = new ApexCharts(document.querySelector("#chart-reportes"), reportesDiaOptions);
    reportesDiaChart.render();
    


// Preparar los datos para la gráfica de áreas en alerta
const areasAlertaCategories = areasAlertaData.map(item => item.area);
    const areasAlertaValues = areasAlertaData.map(item => item.frecuencia);

    // Opciones de la gráfica de áreas en alerta
    const areasAlertaOptions = {
        chart: {
            type: 'pie',
            height: 400,
            toolbar: {
                show: true
            },
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 800,
                animateGradually: {
                    enabled: true,
                    delay: 150
                },
                dynamicAnimation: {
                    enabled: true,
                    speed: 350
                }
            }
        },
        series: [{
            name: 'Frecuencia',
            data: areasAlertaValues
        }],
        xaxis: {
            categories: areasAlertaCategories,
            title: {
                text: 'Áreas'
            }
        },
        yaxis: {
            title: {
                text: 'Frecuencia'
            }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded'
            },
        },
        dataLabels: {
            enabled: false
        },
        title: {
            text: '',
            align: 'center',
            style: {
                fontSize: '20px',
                fontWeight: 'bold',
                color: '#333'
            }
        },
        colors: ['#1E90FF'],
        tooltip: {
            theme: 'dark'
        }
    };

     // Crear la gráfica de áreas en alerta
     const areasAlertaChart = new ApexCharts(document.querySelector("#chart-areas-alerta"), areasAlertaOptions);
    areasAlertaChart.render();

 // Preparar los datos para la gráfica de áreas repetidas
const areasRepetidasCategories = <?php echo json_encode(array_column($areas_reportes2_data, 'area')); ?>;
const areasRepetidasValues = <?php echo json_encode(array_column($areas_reportes2_data, 'frecuencia')); ?>;

// Opciones de la gráfica de áreas repetidas
const areasRepetidasOptions = {
    chart: {
        type: 'line',
        height: 400,
        toolbar: {
            show: true
        },
        animations: {
            enabled: true,
            easing: 'easeinout',
            speed: 800,
            animateGradually: {
                enabled: true,
                delay: 150
            },
            dynamicAnimation: {
                enabled: true,
                speed: 350
            }
        }
    },
    series: [{
        name: 'Frecuencia',
        data: areasRepetidasValues
    }],
    xaxis: {
        categories: areasRepetidasCategories,
        title: {
            text: 'Áreas'
        }
    },
    yaxis: {
        title: {
            text: 'Frecuencia'
        }
    },
    plotOptions: {
        line: {
            curve: 'smooth'
        }
    },
    dataLabels: {
        enabled: false
    },
    title: {
        text: 'Áreas Repetidas',
        align: 'center',
        style: {
            fontSize: '20px',
            fontWeight: 'bold',
            color: '#333'
        }
    },
    colors: ['#FF5733'],
    tooltip: {
        theme: 'dark'
    }
};

// Crear la gráfica de áreas repetidas
const areasRepetidasChart = new ApexCharts(document.querySelector("#chart-areas-repetidas"), areasRepetidasOptions);
areasRepetidasChart.render();
// Preparar los datos para la gráfica de áreas repetidas en reportes2
const areasRepetidasReportes2Categories = <?php echo json_encode(array_column($areas_reportes2_data, 'area')); ?>;
const areasRepetidasReportes2Values = <?php echo json_encode(array_column($areas_reportes2_data, 'falla')); ?>;

// Opciones de la gráfica de áreas repetidas en reportes2
const areasRepetidasReportes2Options = {
    chart: {
        type: 'line',
        height: 400,
        toolbar: {
            show: true
        },
        animations: {
            enabled: true,
            easing: 'easeinout',
            speed: 800,
            animateGradually: {
                enabled: true,
                delay: 150
            },
            dynamicAnimation: {
                enabled: true,
                speed: 350
            }
        }
    },
    series: [{
        name: 'Frecuencia',
        data: areasRepetidasReportes2Values
    }],
    xaxis: {
        categories: areasRepetidasReportes2Categories,
        title: {
            text: 'Áreas'
        }
    },
    yaxis: {
        title: {
            text: 'Frecuencia'
        }
    },
    plotOptions: {
        line: {
            curve: 'smooth'
        }
    },
    dataLabels: {
        enabled: false
    },
    title: {
        text: 'Áreas Repetidas en Reportes2',
        align: 'center',
        style: {
            fontSize: '20px',
            fontWeight: 'bold',
            color: '#333'
        }
    },
    colors: ['#FF5733'],
    tooltip: {
        theme: 'dark'
    }
};

// Crear la gráfica de áreas repetidas en reportes2
const areasRepetidasReportes2Chart = new ApexCharts(document.querySelector("#chart-areas-repetidas-reportes2"), areasRepetidasReportes2Options);
areasRepetidasReportes2Chart.render();


//grafica de area más afectada 
// Convertir los datos PHP a un objeto JavaScript
const areasSemanaData = <?php echo json_encode($areas_semanal_data); ?>;

// Preparar los datos para la gráfica de líneas
const areasSemanaCategories = areasSemanaData.map(item => `Semana ${item.semana}, ${item.año}`);
const areasSemanaValues = areasSemanaData.map(item => item.frecuencia);

const areasSemanaOptions = {
    chart: {
        type: 'line',
        height: 400,
        toolbar: {
            show: true
        },
        animations: {
            enabled: true,
            easing: 'easeinout',
            speed: 800
        }
    },
    series: [{
        name: 'Frecuencia por Área',
        data: areasSemanaValues // Aquí deberías tener tu array de datos
    }],
    xaxis: {
        categories: areasSemanaCategories, // Aquí deberías tener tu array de categorías (por ejemplo, semanas)
        title: {
            text: 'Semanas'
        }
    },
    yaxis: {
        title: {
            text: 'Cantidad de Alertas'
        }
    },
    stroke: {
        curve: 'smooth',
        width: 3,
        lineCap: 'round',
        colors: ['#eb3713'], // Color inicial de la línea
        // Configuración de gradiente
        gradient: {
            shade: 'light',
            type: 'vertical',
            shadeIntensity: 0.5,
            gradientToColors: ['#FF5733', '#FFC300', '#59e314'],
            inverseColors: false,
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 50, 100]
        }
    },
    markers: {
        size: 4,
        colors: ['#1E90FF'], // Color de los marcadores
        strokeColors: '#fff',
        strokeWidth: 2
    },
    dataLabels: {
        enabled: false
    },
    title: {
        text: 'Frecuencia de Alertas por Área Semanal',
        align: 'center',
        style: {
            fontSize: '20px',
            fontWeight: 'bold',
            color: '#333'
        }
    },
    tooltip: {
        theme: 'dark'
    }
};

// Crear la gráfica de líneas
const areasSemanaChart = new ApexCharts(document.querySelector("#chart-areas-semana"), areasSemanaOptions);
areasSemanaChart.render();

     
</script>

<script>
    

    </script>

</body>

</html>
