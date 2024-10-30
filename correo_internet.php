<?php
header('Content-Type: text/html; charset=UTF-8');
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
    $email = new PHPMailer(true);
    // Activar o desactivar excepciones mediante variable
    $debug = true;

    try {
        // Crear instancia de la clase PHPMailer
        $mail = new PHPMailer($debug);

        // Autentificación con SMTP
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        // Configuración SMTP
        $mail->Host = "10.1.13.160";
        $mail->Port = 587;
        $mail->Username = "N.Kayser@kayser-automotive.com";
        $mail->Password = "Kayser2024.";
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Subject = 'Reporte de Internet';
        $mail->setFrom('N.Kayser@kayser-automotive.com', 'Reporte!');
        $mail->addAddress('A.Zarate@kayser-automotive.com', 'name');
        //$mail->addAddress('oe.gonzalez@kayser-automotive.com', 'name');
        //$mail->addAddress('f.gonzalez@kayser-automotive.com', 'name');
       // $mail->addAddress('a.sanchez@kayser-automotive.com', 'name');
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';
        // Procesar campo de comentarios
        $comentarios = isset($_POST['comentarios']) ? utf8_encode($_POST['comentarios']) : '';

        // Consulta a la base de datos para obtener los datos de la tabla "alerta"
        $sql = "SELECT id, id_elemento, elemento, area, falla, fecha_alerta FROM alerta WHERE DATE(fecha_alerta) = CURDATE() AND area IN ('planta', 'bodega')";
        $result = $conn->query($sql);


        // Construir cuerpo del mensaje
        $mensaje = '<p>Comentarios extras: ' . $comentarios . '</p>';
        if ($result->num_rows > 0) {
            $mensaje .= '<p>Alertas de hoy:</p>';
            while($row = $result->fetch_assoc()) {
                $mensaje .= utf8_decode($row["elemento"]) . ',  Area: ' . utf8_decode($row["area"]) . ',  Falla: ' . utf8_decode($row["falla"]) . ', Fecha: ' . utf8_decode($row["fecha_alerta"]) . '</p>';
            }
        }

        // Procesar imagen adjunta
        if (isset($_FILES['foto'])) {
            $total_archivos = count($_FILES['foto']['name']);
            for ($i = 0; $i < $total_archivos; $i++) {
                if ($_FILES['foto']['error'][$i] == UPLOAD_ERR_OK) {
                    $ruta_temporal = $_FILES['foto']['tmp_name'][$i];
                    $nombre_archivo = $_FILES['foto']['name'][$i];
                    $mail->addAttachment($ruta_temporal, $nombre_archivo);
                } else {
                    echo "Error al cargar archivo #" . ($i + 5) . ": " . $_FILES['foto']['error'][$i] . "<br>";
                }
            }
        }

        $mail->Body = utf8_encode($mensaje);
        $mail->AltBody = 'Texto como elemento de texto simple';
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        if ($mail->send()) {
            // Redireccionar a areass.php
            header('Location: internet.php');
            exit; // Terminar el script después de la redirección
        } else {
            echo "No se ha podido enviar el correo.";
        }

    } catch (Exception $e) {
        echo "No se ha podido enviar la alerta. Error del remitente: ".$e->getMessage();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="imagenes/kayser_icon.ico" type="image/x-icon">
    <link rel="stylesheet" href="style_correo.css">
    <title>correo</title>
</head>

<body>
    <br>

    <!-- Contenido del formulario -->
    <form name="form1" method="post" enctype="multipart/form-data">
        <center>
            <h2>Generar Reporte</h2>
        </center>

        <p>Agregar comentarios extras:<br> <input type="text" name="comentarios" class="textarea-custom"></p>

        <p>Tomar fotos: <input type="file" accept="image/*" name="foto[]" multiple></p>

        <input type="hidden" name="subject" value="Reporte de Terminales">
        <p align="center">
            <input class="buttom " type="reset" name="Reset" value="Borrar">
            <input class="buttom" type="submit" name="Submit" value="Enviar">
        </p>
    </form>

</body>

</html>
