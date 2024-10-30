<?php
session_start(); // Iniciar sesión si no se ha hecho ya

// Verificar si el usuario está autenticado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php');
    exit;
}

// Obtener el nombre de usuario de la sesión
$usuario_nombre = $_SESSION['name'];

date_default_timezone_set('America/Mexico_City'); // Cambia 'America/Mexico_City' por tu zona horaria adecuada

// Conexión a la base de datos (debes completar estos datos con los de tu base de datos)
$servername = "localhost";
$username = "root";
$password = "0084321";
$database = "projectroute";

$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Establecer la codificación de caracteres a UTF-8
$conn->set_charset("utf8");

if (isset($_POST['submit_alerta'])) {
    $alerta_id = $_POST['alerta_id'];

    // Verificar que se recibe el ID de la alerta
    if (empty($alerta_id)) {
       // echo "ID de alerta no recibido.";
    } else {
        // Obtener la hora actual
        $hora_aceptada = date('Y-m-d H:i:s');

        // Actualizar el estado de la alerta en la base de datos
        $sql_update = "UPDATE alerta SET estatus = 'Aceptada', hora_alerta = ?, user_alert = ? WHERE id = ?";
        $stmt = $conn->prepare($sql_update);
        if ($stmt === false) {
           // echo "Error al preparar la consulta: " . $conn->error;
        } else {
            $stmt->bind_param("ssi", $hora_aceptada, $usuario_nombre, $alerta_id);

            if ($stmt->execute()) {
               // echo "Alerta aceptada con éxito.";
            } else {
               // echo "Error al aceptar la alerta: " . $stmt->error;
            }

            $stmt->close();
        }
    }
}


if (isset($_POST['submit_reporte'])) {
    // Verificar si 'evidencia_id' está presente en $_POST
    if (isset($_POST['evidencia_id'])) {
        $id = $_POST['evidencia_id'];

        // Verificar que se recibe el ID de la alerta
        if (empty($id)) {
           echo "ID de alerta no recibido.";
        } else {
            // Obtener la hora actual
            $hora_acept = date('Y-m-d H:i:s');

            // Actualizar el estado de la alerta en la base de datos
            $sql_update = "UPDATE reportes2 SET status = 'Aceptada', hora_acept = ?, user_report = ? WHERE id = ?";
            $stmt = $conn->prepare($sql_update);
            if ($stmt === false) {
              // echo "Error al preparar la consulta: " . $conn->error;
            } else {
                $stmt->bind_param("ssi", $hora_acept, $usuario_nombre, $id);

                if ($stmt->execute()) {
                   //echo "Reporte aceptado con éxito.";
                } else {
                  // echo "Error al aceptar el reporte: " . $stmt->error;
                }

                $stmt->close();
            }
        }
    } else {
        echo "El campo 'evidencia_id' no está definido en el POST.";
    }
}


if (isset($_POST['submit_desbloquear'])) {
    if (isset($_POST['desbloquear_id'])) {
        $id = $_POST['desbloquear_id'];

        if (empty($id)) {
            echo "ID de alerta no recibido.";
        } else {
            $hora_acept = date('Y-m-d H:i:s');

            // Obtener el nombre del usuario logueado
            $usuario_logueado = $_SESSION['name'] ?? '';

            // Actualizar el estado de la alerta en la base de datos
            $sql_update = "UPDATE reportes2 SET status = 'Resuelto', hora_acept = ? WHERE id = ? AND user_report = ?";
            $stmt = $conn->prepare($sql_update);

            if ($stmt === false) {
                echo "Error al preparar la consulta: " . $conn->error;
            } else {
                $stmt->bind_param("sis", $hora_acept, $id, $usuario_logueado);

                if ($stmt->execute()) {
                    echo "Reporte aceptado con éxito.";
                } else {
                    echo "Error al aceptar el reporte: " . $stmt->error;
                }

                $stmt->close();
            }
        }
    } else {
        echo "El campo 'desbloquear_id' no está definido en el POST.";
    }
}



$conn->close();
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="imagenes/kayser_icon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="icon" href="imagenes/kayser_icon.ico" type="image/x-icon">
    <link rel="stylesheet" href="style_viewCorreo.css">
    <title>Reporte General</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-image: url("imagenes/Fondo_simple.png");
    opacity: 0.9; 
}

.container {
    max-width: 1200px;
    margin: 20px auto;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    opacity: 1; 
}


.img-container {
  display: inline-block; /* Mostrar en línea uno al lado del otro */
  vertical-align: top; /* Alineación superior */
  width: 10%; /* Ancho deseado para cada contenedor */
  height: 50px; /* Altura deseada */
  background-color: white; /* Color de fondo */
  border: 1px solid white; /* Borde */
  margin: 0; /* Margen horizontal para separar los bloques */
  box-sizing: border-box; /* Incluir el borde en el tamaño total del elemento */
}

input[type="date"]{
    background-color: #8c180f;
    transform: translate(-50%,-50%);
    font-family: "Roboto Mono",monospace;
    color:#c2bcbc ;
    font-size: 16px;
    border: none;
    outline: none;
    border-radius: 5px;
}
::-webkit-calendar-picker-indicator{
    background-color: #ffffff;
    padding: 5px;
    cursor: pointer;
    border-radius: 3px;
}


.calendar {
  
      float: left;
      width: 70px;
      background: #ededef;
      background:#ededef;
      font: bold 20px/45px Arial Black, Arial, Helvetica, sans-serif;
      text-align: center;
      color: #000;
      -moz-border-radius: 3px;
      -webkit-border-radius: 3px;
      border-radius: 3px;
      position: relative;
    }

    .calendar em {
      display: block;
      font: normal bold 11px/30px Arial, Helvetica, sans-serif;
      color: #fff;
      text-shadow: #8c180f 0 -1px 0;
      background:#8c180f;
    }

    .calendar:before,
    .calendar:after {
      content: '';
      float: left;
      position: absolute;
      top: 5px;
      width: 8px;
      height: 8px;
      background: #111;
      z-index: 1;
     
      border-radius: 10px;
    
    }

    .calendar em:before,
    .calendar em:after {
      content: '';
      float: left;
      position: absolute;
      top: -5px;
      width: 4px;
      height: 14px;
      background: #dadada;
      background: #f1f1f1;
      z-index: 2;
      border-radius: 2px;
    }

    .calendar em:before {
      left: 13px;
    }

    .calendar em:after {
      right: 13px;
    }

    .calendar:before {
      left: 11px;
    }

    .calendar:after {
      right: 11px;
    }
    
    .identificador-elemento {
    display: none;
}


#boton1 {
            background-color: #6e0b0b;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            padding: 10px 22px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 10px;
        }

        #boton2 {
            background-color: #6e0b0b;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            margin-top: 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 10px;
        }

        .gray-button {
            background-color: #ccc;
            color: #666;
            cursor: not-allowed;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            margin-top: 10px;
        }


        .modal {
  display: none; /* Ocultar el modal por defecto */
  position: fixed;
  z-index: 1000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.5); /* Fondo semi-transparente */
}

.modal-content {
  background-color: #fefefe;
  margin: 15% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
  max-width: 600px;
  text-align: center;
  border-radius: 10px;
  position: relative;
}

.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}

/* Contenedor de notificaciones */
.notification-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            max-width: 300px;
        }

        /* Estilos para las notificaciones */
        .notification {
            position: relative;
            margin-bottom: 15px;
            padding: 15px;
            background-color: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .notification.show {
            opacity: 1;
        }

        .notification .close-btn {
            position: absolute;
            top: 5px;
            right: 10px;
            cursor: pointer;
            color: #aaaaaa;
        }

        .notification.info {
            border-left: 5px solid #007bff; /* azul */
        }

        .notification.error {
            border-left: 5px solid #dc3545; /* rojo */
        }

        /* Estilos para el botón de notificaciones */
        #notification-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #007bff; /* azul */
            color: #ffffff;
            font-size: 24px;
            text-align: center;
            line-height: 50px;
            cursor: pointer;
            z-index: 1000;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        #notification-btn:hover {
            background-color: #0056b3; /* azul más oscuro */
        } 
    .inline-forms {
        display: inline-block;
    }
    


    </style>
</head>
<body>
    <div class="container" >
       

        <div class="img-container" style="float: left;">
<p class="calendar"> <?php echo date('W'); ?><em>Semana</em></p>

</div>


       
<br>


<div style="text-align: center;">

                <p style="text-align: justify;">
            </div>
            <br>
            <center>


            <table>
    <h2>Alertas</h2>
    <thead>
        <?php
        // Aquí deberías tener tu conexión a la base de datos y tu consulta SQL
        $servername = "localhost";
        $username = "root";
        $password = "0084321";
        $dbname = "projectroute";

        // Crear conexión
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verificar conexión
        if ($conn->connect_error) {
            die("Error en la conexión: " . $conn->connect_error);
        }

        // Establecer el conjunto de caracteres en UTF-8
        $conn->set_charset("utf8mb4");

        // Consulta SQL para obtener alertas ordenadas por fecha más reciente
        $sql = "SELECT id, id_elemento, elemento, area, falla, fecha_alerta, estatus, user_alert, hora_alerta
                FROM alerta
                WHERE DATE(fecha_alerta) = CURDATE()
                ORDER BY fecha_alerta DESC";
        $result = $conn->query($sql);
        ?>

        <tr>
            <th>Icono</th>
            <th>Fecha</th>
            <th>Área</th>
            <th>Elemento Reportado</th>
            <th>Falla</th>
            <th>Aceptar Alerta</th>
            <th>Status</th>
            <th>Usuario</th>
            <th>Hora</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($fila = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td>
                        <img src="imagenes/alert_r.png" alt="icono" width="20" height="20" title="Título de la imagen">
                    </td>
                    <td><?php echo htmlspecialchars($fila['fecha_alerta']); ?></td>
                    <td><?php echo htmlspecialchars($fila['area']); ?></td>
                    <td><?php echo htmlspecialchars($fila['elemento']); ?></td>
                    <td><?php echo htmlspecialchars($fila['falla']); ?></td>
                    <td>
                        <form action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>' method='post'>
                            <input type='hidden' name='alerta_id' value="<?php echo htmlspecialchars($fila['id']); ?>">
                            <input type='hidden' name='submit_alerta' value='1'>
                            <button type='submit' style="
                                background-color: #6e0b0b; /* Rojo */
                                border: none;
                                color: white;
                                padding: 10px 22px;
                                text-align: center;
                                text-decoration: none;
                                display: inline-block;
                                font-size: 16px;
                                margin: 4px 2px;
                                cursor: pointer;
                                border-radius: 10px;
                            ">Aceptar</button>
                        </form>
                    </td>
                    <td><?php echo htmlspecialchars($fila['estatus']); ?></td>
                    <td><?php echo htmlspecialchars($fila['user_alert']); ?></td>
                    <td><?php echo htmlspecialchars($fila['hora_alerta']); ?></td>
                </tr>
                <?php
            }
        } else {
            echo "<tr><td colspan='9' style='text-align: center;'>No hay alertas por aceptar el día de hoy</td></tr>";
        }
        $conn->close();
        ?>
    </tbody>
</table>

            

                    </center>
                    <br>
                    <br>
                    <br>
                    
                    <center>
                    <table>
    <h2>Evidencias</h2>
    <thead>
        <?php
        // Aquí deberías tener tu conexión a la base de datos y tu consulta SQL
        $servername = "localhost";
        $username = "root";
        $password = "0084321";
        $dbname = "projectroute";

        // Crear conexión
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verificar conexión
        if ($conn->connect_error) {
            die("Error en la conexión: " . $conn->connect_error);
        }

        // Establecer el conjunto de caracteres en UTF-8
        $conn->set_charset("utf8mb4");

        $sql_reportes2 = "SELECT id, elemento_id, area, fecha, falla, elemento, status, user_report, hora_acept
                          FROM reportes2
                          WHERE DATE(fecha) = CURDATE()
                          ORDER BY fecha DESC";
        $result_reportes2 = $conn->query($sql_reportes2);
        ?>

        <tr>
            <th>Icono</th>
            <th>Fecha</th>
            <th>Área</th>
            <th>Elemento</th>
            <th>Falla</th>
            <th>Aceptar</th>
            <th>Status</th>
            <th>Usuario</th>
            <th>Hora</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result_reportes2->num_rows > 0) {
            while ($fila = $result_reportes2->fetch_assoc()) {
                ?>
                <tr>
                    <td>
                        <img src="imagenes/alert_r.png" alt="icono" width="20" height="20" title="Título de la imagen">
                    </td>
                    <td><?php echo htmlspecialchars($fila['fecha']); ?></td>
                    <td><?php echo htmlspecialchars($fila['area']); ?></td>
                    <td><?php echo htmlspecialchars($fila['elemento']); ?></td>
                    <td><?php echo htmlspecialchars($fila['falla']); ?></td>
                    <td>
                        <form action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>' method='post'>
                            <input type='hidden' name='evidencia_id' value="<?php echo htmlspecialchars($fila['id']); ?>">
                            <input type='hidden' name='submit_reporte' value='1'>
                            <button type='submit' style="
                                background-color: #6e0b0b; /* Rojo */
                                border: none;
                                color: white;
                                padding: 10px 22px;
                                text-align: center;
                                text-decoration: none;
                                display: inline-block;
                                font-size: 16px;
                                margin: 4px 2px;
                                cursor: pointer;
                                border-radius: 10px;
                            ">Aceptar</button>
                        </form>
                    </td>
                    <td><?php echo htmlspecialchars($fila['status']); ?></td>
                    <td><?php echo htmlspecialchars($fila['user_report']); ?></td>
                    <td><?php echo htmlspecialchars($fila['hora_acept']); ?></td>
                </tr>
                <?php
            }
        } else {
            echo "<tr><td colspan='9' style='text-align: center;'>No hay incidencias por aceptar del día de hoy</td></tr>";
        }
        $conn->close();
        ?>
    </tbody>
</table>


                    </center>


                    <br>
                    <br>
                    <br>
                    <center>
                    <?php
// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

// Consulta SQL para obtener todas las alertas y reportes, ordenadas por fecha más reciente
$sql_all_alerts = "
    SELECT id, id_elemento AS elemento_id, area, fecha_alerta AS fecha, 
           CONVERT(falla USING utf8) AS falla, 
           CONVERT(elemento USING utf8) AS elemento, 
           estatus AS status, user_alert AS user_report, hora_alerta AS hora,
           'alerta' AS tipo
    FROM alerta
    UNION ALL
    SELECT id, elemento_id, area, fecha, 
           CONVERT(falla USING utf8) AS falla, 
           CONVERT(elemento USING utf8) AS elemento, 
           status, user_report, hora_acept AS hora,
           'incidencia' AS tipo
    FROM reportes2
    ORDER BY fecha DESC, hora DESC";


$result_all_alerts = $conn->query($sql_all_alerts);
?>

<table>
    <h2>Historial de Alertas y Reportes</h2>
    <thead>
        <tr>
            <th>...</th>
            <th>Fecha</th>
            <th>Area</th>
            <th>Elemento</th>
            <th>Falla</th>
            <th>Status</th>
            <th>Tipo</th>
            <th>Usuario</th>
            <th>Hora</th>
            <th>Desbloquear</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result_all_alerts->num_rows > 0) {
            while ($fila = $result_all_alerts->fetch_assoc()) {
                ?>
                <tr>
                    <td><img src="imagenes/check.png" alt="icono" width="20" height="20" title="Título de la imagen"></td>
                    <td><?php echo htmlspecialchars($fila['fecha']); ?></td>
                    <td><?php echo htmlspecialchars($fila['area']); ?></td>
                    <td><?php echo htmlspecialchars($fila['elemento']); ?></td>
                    <td><?php echo htmlspecialchars($fila['falla']); ?></td>
                    <td><?php echo htmlspecialchars($fila['status']); ?></td>
                    <td><?php echo htmlspecialchars($fila['tipo']); ?></td>
                    <td><?php echo htmlspecialchars($fila['user_report']); ?></td>
                    <td><?php echo htmlspecialchars($fila['hora']); ?></td>
                    <td>
                        <?php if ($usuario_nombre === htmlspecialchars($fila['user_report'])): ?>
                            <form action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>' method='post'>
                                <input type='hidden' name='desbloquear_id' value="<?php echo htmlspecialchars($fila['id']); ?>">
                                <input type='hidden' name='submit_desbloquear' value='1'>
                                <button type='submit' style="background-color:#23a80c; /* Rojo*/
        border: none;
        color: white;
        padding: 10px 22px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
        border-radius: 10px;">Desbloquear</button>
                            </form>
                        <?php else: ?>
                           
                        <?php endif; ?>
                    </td>
                </tr>
                <?php
            }
        } else {
            echo "<center><tr><td colspan='10'>No hay alertas ni reportes disponibles.</td></tr></center>";
        }
        $conn->close();
        ?>
    </tbody>
</table>


                    </center>
                    <br>
                    <!-- Formulario para enviar el correo electrónico -->
                    <form method="post" enctype="multipart/form-data">
                        <br>
                        <br>
                        <center>
                            <!--<p style="font-size: 16px;">Agregar comentarios extras:<br> <input type="text" name="comentarios" style="width: 800px; height: 50px; font-size: 14px;"></p>
                            <p>Agregar Fotos: <input type="file" accept="image/*" name="foto[]" multiple></p>
                            <input type="hidden" name="subject" value="Reporte de Terminales">
                            
                            <p></p>-->
                            <p align="center">
                                <input style="background-color:#6e0b0b; /* Rojo*/
            border: none;
            color: white;
            padding: 10px 22px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 10px;" class="buttom" type="button" value="Volver" onclick="window.location.href='menu.php'">        
                        <br>
                        </center>
                    </form>
                </div>



            <div id="notification-btn">🔔</div>
            <button id="btnShowNotification" style="display: none;">Mostrar Notificación</button>
            <div class="notification-container" id="notification-container"></div>







<!-- Modal para mostrar mensajes de aceptación -->
<div id="myModal" class="modal">
  <!-- Contenido del modal -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <p id="modal-message"></p>
  </div>
</div>

<script>
let lastAlertAndReportIds = new Set();

function fetchAndShowAlerts() {
    fetch('get_alerts.php?accepted_today=true')
        .then(response => {
            if (!response.ok) {
                throw new Error(`No se pudo obtener la respuesta del servidor. Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Datos recibidos:', data); // Mostrar los datos recibidos en la consola

            if (data.error) {
                throw new Error(data.error);
            }

            const { alertas } = data;

            if (alertas.length > 0) {
                alertas.forEach(alert => {
                    if (!lastAlertAndReportIds.has(alert.id)) {
                        lastAlertAndReportIds.add(alert.id);
                        const mensaje = `La alerta del elemento "${alert.elemento}" en el área "${alert.area}", con la falla "${alert.falla}", ha sido aceptada para su revisión.`;
                        showNotification(mensaje, 'info');
                    }
                });
            } else {
                // Mostrar mensaje en consola y notificación de no hay alertas aceptadas hoy
                console.log('No hay alertas aceptadas hoy para mostrar.');
                showNotification('No hay alertas aceptadas hoy para mostrar', 'info');
            }
        })
        .catch(error => {
            console.error('Error al obtener las alertas aceptadas hoy del servidor:', error);
            showNotification('Error al obtener las alertas aceptadas hoy del servidor.', 'error');
        });
}

function showNotification(message, type) {
    const icon = type === 'error' ? '⚠️' : 'ℹ️';

    const notification = document.createElement('div');
    notification.classList.add('notification', type);
    notification.innerHTML = `
        <span class="close-btn" onclick="closeNotification(this)">&times;</span>
        <div>${icon} ${message}</div>
    `;

    const container = document.getElementById('notification-container');
    container.appendChild(notification);

    setTimeout(function () {
        notification.classList.add('show');
    }, 100);

    setTimeout(function () {
        closeNotification(notification.querySelector('.close-btn'));
    }, 5000);
}

function closeNotification(element) {
    const notification = element.parentElement;
    notification.classList.remove('show');
    setTimeout(function () {
        notification.remove();
    }, 300);
}

function debounce(func, wait) {
    let timeout;
    return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}

document.addEventListener('DOMContentLoaded', function () {
    fetchAndShowAlerts();
});

setInterval(debounce(fetchAndShowAlerts, 500), 180000);
</script>


<script>
        // Recargar la página cada 10 segundos
        setTimeout(function(){
            window.location.reload(1);
        }, 180000); // 10000 milisegundos = 10 segundos
    </script>

</body>
</html>
