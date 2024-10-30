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


$conn->close();
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="graficas.css">
    <link rel="icon" href="imagenes/kayser_icon.ico" type="image/x-icon">
    <script src="apexcharts.js-main/dist/apexcharts.min.js"></script>
    <title>Dashboard</title>
    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
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
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .section {
            margin-bottom: 40px;
        }

        .section-title {
            text-align: center;
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #800416;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 18px;
            border: 2px solid #800416;
            transition: all 0.3s ease;
            margin-right: 10px;
        }

        .btn:hover {
            background-color: #800416;
            color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transform: translateY(-2px);
        }

        .charts-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            grid-gap: 20px;
        }

        .chart-container {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background: linear-gradient(to bottom, #ffffff, #f2f2f2);
        }

        .chart-container h2 {
            text-align: center;
            margin-bottom: 10px;
            font-size: 20px;
            color: #333;
        }

        .row {
    display: flex;
    flex-wrap: wrap;
}

.col-md-6 {
    width: 50%;
}


    </style>
</head>
<body>

    <div class="sidebar">
        <button onclick="window.location.href='menu.php'"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-reply-fill" viewBox="0 0 16 16">
  <path d="M5.921 11.9 1.353 8.62a.72.72 0 0 1 0-1.238L5.921 4.1A.716.716 0 0 1 7 4.719V6c1.5 0 6 0 7 8-2.5-4.5-7-4-7-4v1.281c0 .56-.606.898-1.079.62z"/>
</svg></button>
    </div>


    <div class="content">
       <center> <h1>Reporte General</h1></center>
       
       <div class="button-container">
        <button class="btn" onclick="updateChart('week')">Mostrar por Semana</button>
        <button class="btn" onclick="updateChart('month')">Mostrar por Mes</button>
   
    </div>

<br>
<br>

    <!-- Agregar la gráfica circular aquí -->

    <div class="row">
    <div class="col-md-6">
        <div id="chart-alertas-semana"></div>
    </div>
    <div class="col-md-6">
        <div id="chart-tablas"></div>
    </div>
</div>

  

    <div class="charts-row">
        <div class="chart-container" style="border: none;">
            <h2>Áreas con más problemas</h2>
            <div id="chart-areas"></div>
        </div>

        <div class="chart-container" style="border: none;">
            <h2>Fallas con más frecuencia</h2>
            <div id="chart-fallas"></div>
        </div>
    </div>

    <div class="charts-row">
        <div class="chart-container" style="border: none;">
            <h2>Elementos con Más Fallas</h2>
            <div id="chart-elementos"></div>
        </div>

        <div class="chart-container" style="border: none;">
            <h2>Día con más reportes</h2>
            <div id="chart-reportes"></div>
        </div>
    </div>
    <br</div>
   <!-- <div class="button-container">
        <a href="menu.php" class="btn">Volver al Menú</a>
    </div>-->
</div>
<br>
<br>

<script>
// Convertir los datos PHP a un objeto JavaScript
const alertasSemanaData = <?php echo json_encode($alertas_semana_data); ?>;

// Preparar los datos para la gráfica de líneas
const alertasSemanaCategories = alertasSemanaData.map(item => `Semana ${item.semana}, ${item.año}`);
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
        categories: alertasSemanaCategories, // Aquí deberías tener tu array de categorías (por ejemplo, semanas)
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
        text: 'Evolución Semanal de Alertas',
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
                colors: ['#000000'],
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
    function updateChart(period) {
        fetch(`get_data.php?period=${period}`)
            .then(response => response.json())
            .then(data => {
                // Actualizar las gráficas con los datos obtenidos
                chart.updateSeries(data.donut.series);
                chart.updateOptions({ labels: data.donut.labels });

                areasChart.updateSeries([{ data: data.areas.series }]);
                areasChart.updateOptions({ xaxis: { categories: data.areas.categories } });

                fallasChart.updateSeries([{ data: data.fallas.series }]);
                fallasChart.updateOptions({ xaxis: { categories: data.fallas.categories } });

                elementosChart.updateSeries([{ data: data.elementos.series }]);
                elementosChart.updateOptions({ xaxis: { categories: data.elementos.categories } });

                reportesDiaChart.updateSeries([{ data: data.reportes.series }]);
                reportesDiaChart.updateOptions({ xaxis: { categories: data.reportes.categories } });
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    // Función para actualizar las gráficas inicialmente con datos sin filtrar
    updateChart('none');
</script>


</div>
    </div>
</body>
</html>
