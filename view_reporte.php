<?php
session_start(); // Iniciar sesión si no se ha hecho ya

// Verificar si el usuario está autenticado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php');
    exit;
}

// Obtener el nombre de usuario y su ID de la sesión
$usuario_nombre = $_SESSION['name'];
$usuario_id = $_SESSION['id'];

require_once 'src/Exception.php';
require_once 'src/PHPMailer.php';
require_once 'src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit_alerta'])) {
        $alerta_id = $_POST['alerta_id'];

        // Verificar que se recibe el ID de la alerta
        if (empty($alerta_id)) {
           // echo "ID de alerta no recibido.";
        } else {
            // Actualizar el estado de la alerta en la base de datos
            $sql_update = "UPDATE alerta SET estatus = 'Aceptada' WHERE id = ?";
            $stmt = $conn->prepare($sql_update);
            if ($stmt === false) {
             //   echo "Error al preparar la consulta: " . $conn->error;
            } else {
                $stmt->bind_param("i", $alerta_id);

                if ($stmt->execute()) {
                  //  echo "Alerta aceptada con éxito.";
                } else {
                   // echo "Error al aceptar la alerta: " . $stmt->error;
                }

                $stmt->close();
            }
        }
    }

    if (isset($_POST['submit_evidencia'])) {
        $evidencia_id = $_POST['evidencia_id'];
        
        // Verificar que se recibe el ID de la evidencia
        if (empty($evidencia_id)) {
         //   echo "ID de la evidencia no recibido.";
        } else {
            // Actualizar el estado de la evidencia en la base de datos
            $sql_update = "UPDATE reportes2 SET status = 'Aceptada' WHERE id = ?";
            $stmt = $conn->prepare($sql_update);
            if ($stmt === false) {
                //echo "Error al preparar la consulta: " . $conn->error;
            } else {
                $stmt->bind_param("i", $evidencia_id);

                if ($stmt->execute()) {
                   // echo "Evidencia aceptada con éxito.";
                } else {
                  //  echo "Error al aceptar la evidencia: " . $stmt->error;
                }

                $stmt->close();
            }
        }
    }
}


// Definir el mensaje del correo electrónico

$mensaje = '<div style="text-align: center;">
                <h2>Reporte General</h2>
                <p style="text-align: justify;">
                    El presente reporte documenta las fallas y alertas detectadas durante el recorrido realizado en la Planta Kayser Automotive Systems con el objetivo de identificar 
                    cualquier anomalía o fallas para tomar las medidas correctivas necesarias.
                </p>
                <p style="text-align: justify;">
                   Se presentan las incidencias y alertas reportadas el día de hoy.
                </p>
            </div>';

// Consulta a la base de datos para obtener los datos de la tabla "alerta"
$sql = "SELECT id, id_elemento, elemento, area, falla, fecha_alerta FROM alerta WHERE DATE(fecha_alerta) = CURDATE() ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $mensaje .= '<h2>Alertas</h2>';
    $mensaje .= '<table border="1" cellspacing="0" cellpadding="5">
                    <tr>
                        <th>Fecha</th>
                        <th>Area</th>
                        <th>Elemento Reportado</th>
                        <th>Falla</th>
                       <!-- <th>Aceptar Alerta</th>-->
                       <!-- <th>User</th>-->
                    </tr>';

    while ($row = $result->fetch_assoc()) {
       
        $mensaje .= "<tr>";
        $mensaje .= "<td>" . $row['fecha_alerta'] . "</td>";
        $mensaje .= "<td>" . $row['area'] . "</td>";
        $mensaje .= "<td>" . $row['elemento'] . "</td>";
        $mensaje .= "<td>" . $row['falla'] . "</td>";  
       /* $mensaje .= "<td>
        <form action='#' method='post'>
            <input type='hidden' name='evidencia_id'>  <button type='submit' id='submitButton' style='background-color: #6e0b0b;
                border: none; color: white; padding: 10px 22px;
                text-align: center; text-decoration: none; display: inline-block;
                font-size: 16px; margin: 4px 2px; cursor: pointer;
                border-radius: 10px;'>Aceptar</button>
        </form>
    </td>";
   // $mensaje .= "<td>" . $usuario_nombre . "</td>";*/
        $mensaje .= "</tr>";
    }

    $mensaje .= '</table>';
}


// Obtener la fecha actual
$currentDate = date('Y-m-d');
//echo "Fecha actual: " . $currentDate . "<br>"; // Verificar la fecha actual

$sql_reportes2 = "SELECT id, area, fecha, elemento, falla FROM reportes2 WHERE DATE(fecha) = CURDATE()";
$result_reportes2 = $conn->query($sql_reportes2);

if ($result_reportes2 === false) {
    die("Error en la consulta: " . $conn->error);
}

$alertas_texto = "";
$evidencias_texto = "";

if ($result_reportes2->num_rows > 0) {
    $mensaje .= '<h2>Evidencias</h2>';
    $mensaje .= '<table border="1" cellspacing="0" cellpadding="5">
                        <tr> 
                            <th>Área</th>
                            <th>Fecha</th>
                            <th>Elemento</th>
                            <th>Falla</th>
                            <!--<th>Aceptar Evidencia</th>-->
                           <!-- <th>User</th>-->
                        </tr>';

    while ($row_reportes2 = $result_reportes2->fetch_assoc()) {
        $mensaje .= "<tr>";
        $mensaje .= "<td>" . $row_reportes2['area'] . "</td>";
        $mensaje .= "<td>" . $row_reportes2['fecha'] . "</td>";
        $mensaje .= "<td>" . $row_reportes2['elemento'] . "</td>";
        $mensaje .= "<td>" . $row_reportes2['falla'] . "</td>";
        //$mensaje .= "<td>
        /*<form action='#' method='post'>
            <input type='hidden' name='evidencia_id'>
            <button type='submit' style='background-color:#6e0b0b; 
            border: none;
            color: white;
            padding: 10px 22px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 10px;' name='submit_button'>Aceptar</button>
        </form>
    </td>";*/
       // $mensaje .= "<td>" . $usuario_nombre . "</td>";
        $mensaje .= "</tr>";
    }

    $mensaje .= '</table>';
} else {
    $mensaje .= '<p>No se encontraron reportes para hoy.</p>';
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener comentarios y fecha del correo
    $comentarios = isset($_POST['comentarios']) ? ($_POST['comentarios']) : '';
    $fecha_correo = date("Y-m-d");

    // Agregar comentarios al mensaje
    $mensaje .= '<p><strong>Comentarios:</strong> ' . $comentarios . '</p>';



    // Procesar imagen adjunta
    if (isset($_FILES['foto'])) {
        if ($_POST['Submit'] == 'Guardar') {
            // Insertar datos en la tabla de la base de datos
            $sql_insert = "INSERT INTO reportes (comentarios, fecha_reporte , alertas) VALUES ('$comentarios', '$fecha_correo')";
            if ($conn->query($sql_insert) === TRUE) {
                $reporte_id = $conn->insert_id; // Obtener el ID del reporte recién insertado

                // Mover las fotos a la carpeta especificada y guardar la información en la base de datos
                if (!empty($_FILES['foto']['name'][0])) {
                    $targetDir = "C:/xampp/htdocs/terminalesproject/imgReportes/";
                    $total_archivos = count($_FILES['foto']['name']);
                    for ($i = 0; $i < $total_archivos; $i++) {
                        $nombre_archivo = $_FILES['foto']['name'][$i];
                        $ruta_temporal = $_FILES['foto']['tmp_name'][$i];
                        $ruta_destino = $targetDir . $nombre_archivo;
                        if (move_uploaded_file($ruta_temporal, $ruta_destino)) {
                            // Actualizar información de la foto en la base de datos
                            $sql_update = "UPDATE reportes SET foto_nombre = '$nombre_archivo', foto_url = '$ruta_destino' WHERE id = $reporte_id";
                            if ($conn->query($sql_update) === FALSE) {
                                echo "Error al actualizar la información de la foto en la base de datos: " . $conn->error;
                            }
                        } else {
                            echo "Error al mover el archivo $nombre_archivo a la carpeta de destino.";
                        }
                    }
                }

                
                // Redireccionar a check.php
                header('Location: check.php');
                exit; // Terminar el script después de la redirección
            } else {
                echo "Error al guardar los datos del correo en la base de datos: " . $conn->error;
            }
        } elseif ($_POST['Submit'] == 'Enviar') {
            // Enviar el correo electrónico
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            // Configuración SMTP
            $mail->Host = "10.1.13.160";
            $mail->Port = 587;   
            $mail->Username = "N.Kayser@kayser-automotive.com";
            $mail->Password = "Kayser2024.";
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Subject = 'Reporte General';
            $mail->setFrom('N.Kayser@kayser-automotive.com', 'Reporte!');
            $mail->addAddress('A.Zarate@kayser-automotive.com', 'name');
            $mail->addAddress('oe.gonzalez@kayser-automotive.com', 'name');
            $mail->addAddress('f.gonzalez@kayser-automotive.com', 'name');
            $mail->addAddress('a.sanchez@kayser-automotive.com', 'name');
            $mail->addAddress('j.rosasquiroz@kayser-automotive.com', 'name');
            $mail->addAddress('p.it@kayser-automotive.com', 'name');
            $mail -> addAddress('i.duran@kayser-automotive.com', 'name');
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->isHTML(true);
            $mail->Body = $mensaje;
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            $total_archivos = count($_FILES['foto']['name']);
            for ($i = 0; $i < $total_archivos; $i++) {
                if ($_FILES['foto']['error'][$i] == UPLOAD_ERR_OK) {
                    $ruta_temporal = $_FILES['foto']['tmp_name'][$i];
                    $nombre_archivo = $_FILES['foto']['name'][$i];
                    $mail->addAttachment($ruta_temporal, $nombre_archivo);
                } else {
                    //echo "Error al cargar archivo #" . ($i + 5) . ": " . $_FILES['foto']['error'][$i] . "<br>";
                }
            }

            // Enviar el correo electrónico
            if ($mail->send()) {
                // Redireccionar a check.php
                header('Location: check.php');
                exit; // Terminar el script después de la redirección
            } else {
                echo "No se ha podido enviar el correo.";
            }
        }
    }
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
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
    max-width: 1100px;
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


 /* Estilos para las notificaciones */
 .notification-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }

        .notification {
            position: relative;
            margin-bottom: 15px;
            padding: 15px;
            max-width: 300px;
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
            border-left: 5px solid #007bff;
            /* azul */
        }

        .notification.error {
            border-left: 5px solid #dc3545;
            /* rojo */
        }
    </style>
</head>
<body>
    <div class="container" >
       

        <div class="img-container" style="float: left;">
<p class="calendar"> <?php echo date('W'); ?><em>Semana</em></p>

</div>
<br>

        <!--<p class="week-label">Semana: <?php echo date('W'); ?></p>-->

        <!-- Aquí se mostrará la tabla -->
       
<br>
<br>

<div style="text-align: center;">

                <p style="text-align: justify;">
                <h1>Reporte General </h1>
                    El presente reporte documenta las fallas y alertas detectadas durante el recorrido realizado en la Planta Kayser Automotive Systems con el objetivo de identificar 
                    cualquier anomalía o fallas para tomar las medidas correctivas necesarias.
                </p>
                <p style="text-align: justify;">
                   Se presentan las incidencias y alertas reportadas el día de hoy.
                </p>
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

            // Consulta SQL para obtener alertas sin evidencia
            $sql = "SELECT id, id_elemento, elemento, area, falla, fecha_alerta, estatus FROM alerta WHERE DATE(fecha_alerta) = CURDATE() ";
            $result = $conn->query($sql);
           ?>
            <tr>
                <!--<th>Date </th>
                <th>ID</th>-->

                <th>Fecha</th>
                <th>Area </th>
                <th>Elemento Reportado</th>
                <th>Falla</th>
                <th>Aceptar Alerta</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($fila = $result->fetch_assoc()) {
                    ?>
                    <tr>
                    <td><?php echo htmlspecialchars($fila['fecha_alerta'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($fila['area'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($fila['elemento'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($fila['falla'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>
                                    <form action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>' method='post'>
                                        <input type='hidden' name='alerta_id' value="<?php echo $fila['id']; ?>">
                                        <input type='hidden' name='submit_alerta' value='1'>
                                        <button type='submit' style="background-color:#6e0b0b; /* Rojo*/
  border: none;
  color: white;
  padding: 10px 22px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  border-radius: 10px;">Aceptar</button>

                                    </form>
                                </td>
                                <td><?php echo $fila['estatus']; ?></td>
    </tr>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='6'>0 resultados</td></tr>";
            }
            ?>
            </tbody>
        </table>
        </center>
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

            $sql_reportes2 = "SELECT id, area, fecha, status,  elemento, falla  FROM reportes2 WHERE DATE(fecha) = CURDATE()";
            $result_reportes2 = $conn->query($sql_reportes2);
      
           ?>
            <tr>
                <!--<th>Date </th>
                <th>ID</th>-->
                <th>Area </th>
                <th>Fecha</th>
                <th>Elemento </th>
                <th>Falla</th>

                <!--<th>Semana Actual</th>-->
               <!-- <th>Aceptar Evidencia</th>
                <th>Status</th>-->
            </tr>
            </thead>
            <tbody>
            <?php
            if ($result_reportes2->num_rows > 0) {
                while ($fila = $result_reportes2->fetch_assoc()) {
                    ?>
                    <tr>
                    <td><?php echo htmlspecialchars($fila['area'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($fila['fecha'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($fila['elemento'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($fila['falla'], ENT_QUOTES, 'UTF-8'); ?></td>
                       <!-- <td>
                        <form action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>' method='post'>
                                        <input type='hidden' name='evidencia_id' value="<?php echo $fila['id']; ?>">
                                        <input type='hidden' name='submit_evidencia' value='1'>
                                        <button type='submit' style="background-color:#6e0b0b; /* Rojo*/
  border: none;
  color: white;
  padding: 10px 22px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  border-radius: 10px;">Aceptar</button>
                                    </form>
                        </td>-->
                       <!-- <td><?php echo $fila['status']; ?></td>-->
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='6'>0 resultados</td></tr>";
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
          
            <br</form>
            <center>
                <p style="font-size: 16px;">Agregar comentarios extras:<br> <input type="text" name="comentarios" style="width: 800px; height: 50px; font-size: 14px;"></p>
                <p>Agregar Fotos: <input type="file" accept="image/*" name="foto[]" multiple></p>
                <input type="hidden" name="subject" value="Reporte de Terminales">
                
                <p></p>
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
  border-radius: 10px;" class="buttom" type="button" value="Volver" onclick="window.location.href='check.php'">
                    <!--<input style="background-color:#6e0b0b; /* Rojo*/
  border: none;
  color: white;
  padding: 10px 22px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  border-radius: 10px;"  class="buttom" type="submit" name="Submit" value="Guardar">-->

                     
                     <input  style="background-color:#6e0b0b; /* Rojo*/
  border: none;
  color: white;
  padding: 10px 22px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  border-radius: 10px;" class="buttom" type="submit" name="Submit" value="Enviar"  onclick="showAlert()">
  
                </p>
            <br>
            </center>
        </form>
    </div>

    <script>
document.addEventListener("DOMContentLoaded", function () {
            const boton2 = document.getElementById("boton2");

            boton2.addEventListener("click", function () {
                // Almacenar el nuevo color en localStorage
                localStorage.setItem("boton1Color", "red");
                alert("Ha aceptado la evidencia");
            });
        });
   
    document.addEventListener("DOMContentLoaded", function () {
        // Obtener todos los botones de alerta
        const botonesAlerta = document.querySelectorAll('[id^="aceptar_alerta_"]');
        botonesAlerta.forEach(boton => {
            boton.addEventListener("click", function () {
                boton.style.backgroundColor = "#ccc";
                boton.style.color = "#666";
                boton.disabled = true;
                const id = boton.id.split('_')[2];
                document.getElementById('status_alerta_' + id).innerHTML = 'Aceptado';
            });
        });

        // Obtener todos los botones de evidencia
        const botonesEvidencia = document.querySelectorAll('[id^="aceptar_evidencia_"]');
        botonesEvidencia.forEach(boton => {
            boton.addEventListener("click", function () {
                boton.style.backgroundColor = "#ccc";
                boton.style.color = "#666";
                boton.disabled = true;
                const id = boton.id.split('_')[2];
                document.getElementById('status_evidencia_' + id).innerHTML = 'Aceptado';
            });
        });
    });
</script>

<script>
    // Función para mostrar la alerta
    function showAlert() {
        alert("¡El correo ha sido enviado exitosamente!");
        // Agrega la redirección después de mostrar la alerta
        window.location.href = 'check.php';
    }
</script>

<script>
    function enviarCorreo() {
      alert("El correo ha sido enviado exitosamente.");
      // Aquí rediriges a la otra página
      window.location.href = "check.php";
    }
  </script>



<!-- Modal para mostrar mensajes de aceptación -->
<div id="myModal" class="modal">
  <!-- Contenido del modal -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <p id="modal-message"></p>
  </div>
</div>


</body>
</html>