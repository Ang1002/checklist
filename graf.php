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

// Consulta SQL para contar la frecuencia de cada área
$sql_areas = "SELECT area, COUNT(*) as frecuencia FROM alerta GROUP BY area";
$result_areas = $conn->query($sql_areas);

$areas_data = array();
if ($result_areas->num_rows > 0) {
    while($row = $result_areas->fetch_assoc()) {
        $areas_data[] = $row;
    }
}

// Consulta SQL para contar la frecuencia de cada falla
$sql_fallas = "SELECT falla, COUNT(*) as frecuencia FROM alerta GROUP BY falla HAVING COUNT(*) > 1";
$result_fallas = $conn->query($sql_fallas);

$fallas_data = array();
if ($result_fallas->num_rows > 0) {
    while($row = $result_fallas->fetch_assoc()) {
        $fallas_data[] = $row;
    }
}

// Consulta SQL para contar la frecuencia de fallas por elemento
$sql_elementos = "SELECT elemento, COUNT(*) as frecuencia FROM alerta GROUP BY elemento HAVING COUNT(*) > 1";
$result_elementos = $conn->query($sql_elementos);

$elementos_data = array();
if ($result_elementos->num_rows > 0) {
    while($row = $result_elementos->fetch_assoc()) {
        $elementos_data[] = $row;
    }
}

// Consulta SQL para contar la frecuencia de reportes por día
$sql_reportes_dia = "SELECT DATE(fecha_alerta) as fecha, COUNT(*) as frecuencia FROM alerta GROUP BY DATE(fecha_alerta) HAVING COUNT(*) > 1";
$result_reportes_dia = $conn->query($sql_reportes_dia);

$reportes_dia_data = array();
if ($result_reportes_dia->num_rows > 0) {
    while($row = $result_reportes_dia->fetch_assoc()) {
        $reportes_dia_data[] = $row;
    }
}

// Consulta SQL para contar los elementos en la tabla alerta
$sql_alerta = "SELECT COUNT(*) as count_alerta FROM alerta";
$result_alerta = $conn->query($sql_alerta);
$row_alerta = $result_alerta->fetch_assoc();
$count_alerta = $row_alerta['count_alerta'];

// Consulta SQL para contar los elementos en la tabla reportes2
$sql_reportes2 = "SELECT area,COUNT(*) as count_reportes2 FROM reportes2";
$result_reportes2 = $conn->query($sql_reportes2);
$row_reportes2 = $result_reportes2->fetch_assoc();
$count_reportes2 = $row_reportes2['count_reportes2'];

// Consulta SQL para contar la frecuencia de cada área en reportes2
$sql_areas_reportes2 = "SELECT area, COUNT(*) as frecuencia FROM reportes2 GROUP BY area";
$result_areas_reportes2 = $conn->query($sql_areas_reportes2);

$areas_reportes2_data = array();
if ($result_areas_reportes2->num_rows > 0) {
    while($row = $result_areas_reportes2->fetch_assoc()) {
        $areas_reportes2_data[] = $row;
    }
}


// Consulta SQL para contar la frecuencia de reportes por día en reportes2
$sql_reportes_dia_reportes2 = "SELECT DATE(fecha) as fecha, COUNT(*) as frecuencia FROM reportes2 GROUP BY DATE(fecha) HAVING COUNT(*) > 1";
$result_reportes_dia_reportes2 = $conn->query($sql_reportes_dia_reportes2);

$reportes_dia_reportes2_data = array();
if ($result_reportes_dia_reportes2->num_rows > 0) {
    while($row = $result_reportes_dia_reportes2->fetch_assoc()) {
        $reportes_dia_reportes2_data[] = $row;
    }
}

// Consulta SQL para contar la frecuencia de cada área en reportes2
$sql_areas_reportes2 = "SELECT area, COUNT(*) AS falla FROM reportes2 GROUP BY area ORDER BY falla DESC";
$result_areas_reportes2 = $conn->query($sql_areas_reportes2);

$areas_reportes2_data = array();
if ($result_areas_reportes2->num_rows > 0) {
    while ($row = $result_areas_reportes2->fetch_assoc()) {
        $areas_reportes2_data[] = $row;
    }
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráficas de Áreas, Fallas y Reportes con ApexCharts</title>
    <link rel="stylesheet" href="graficas.css">
    <link rel="icon" href="imagenes/kayser_icon.ico" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <style>
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
    </style>
</head>
<body>
  

<div class="container">
   <center><h2>Reporte General</h2></center> 
<br>
<div class="button-container">
    <button class="btn" onclick="updateChart('week')">Mostrar por Semana</button>
    <button class="btn" onclick="updateChart('month')">Mostrar por Mes</button>
   
</div>

<br>
<br>

    <!-- Agregar la gráfica circular aquí -->
    <center>
    <div class="chart-container" style="border: none;">
        <div id="chart-tablas"></div>
    </div>
    </center>

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

    <div class="button-container">
        <a href="menu.php" class="btn">Volver al Menú</a>
    </div>
</div>



<br>
<br>

<script>
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
        }]
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
     // Crear la gráfica de áreas en alerta
     const areasAlertaChart = new ApexCharts(document.querySelector("#chart-areas-alerta"), areasAlertaOptions);
    areasAlertaChart.render();



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
</script>
<script>
    function updateChart(period) {
        fetch(`get_data.php?period=${period}`)
            .then(response => response.json())
            .then(data => {
                // Actualizar la gráfica circular
                chart.updateSeries(data.donut.series);
                chart.updateOptions({ labels: data.donut.labels });

                // Actualizar la gráfica de áreas
                areasChart.updateSeries([{ data: data.areas.series }]);
                areasChart.updateOptions({ xaxis: { categories: data.areas.categories } });

                // Actualizar la gráfica de fallas
                fallasChart.updateSeries([{ data: data.fallas.series }]);
                fallasChart.updateOptions({ xaxis: { categories: data.fallas.categories } });

                // Actualizar la gráfica de elementos
                elementosChart.updateSeries([{ data: data.elementos.series }]);
                elementosChart.updateOptions({ xaxis: { categories: data.elementos.categories } });

                // Actualizar la gráfica de reportes por día
                reportesDiaChart.updateSeries([{ data: data.reportes.series }]);
                reportesDiaChart.updateOptions({ xaxis: { categories: data.reportes.categories } });
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    // Función para actualizar las gráficas inicialmente con datos sin filtrar
    updateChart('none');
</script>


</div>

</body>
</html>
