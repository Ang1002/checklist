<?php
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reportarTodo'])) {
    // Consulta a la base de datos para obtener los datos relevantes (alertas y evidencias)
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

    // Consulta a la base de datos para obtener las alertas del día
    $sql = "SELECT id, area, elemento, falla, fecha_alerta FROM alerta WHERE DATE(fecha_alerta) = CURDATE() ";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $mensaje .= '<h2>Alertas</h2>';
        $mensaje .= '<table border="1" cellspacing="0" cellpadding="5">
                        <tr>
                            <th>Fecha</th>
                            <th>Area</th>
                            <th>Elemento Reportado</th>
                            <th>Falla</th>
                        </tr>';

        while ($row = $result->fetch_assoc()) {
            $mensaje .= "<tr>";
            $mensaje .= "<td>" . $row['fecha_alerta'] . "</td>";
            $mensaje .= "<td>" . $row['area'] . "</td>";
            $mensaje .= "<td>" . $row['elemento'] . "</td>";
            $mensaje .= "<td>" . $row['falla'] . "</td>";
            $mensaje .= "</tr>";
        }

        $mensaje .= '</table>';
    }

    // Consulta a la base de datos para obtener las evidencias del día
    $sql_reportes2 = "SELECT area, fecha, elemento, falla FROM reportes2 WHERE DATE(fecha) = CURDATE()";
    $result_reportes2 = $conn->query($sql_reportes2);

    if ($result_reportes2 === false) {
        die("Error en la consulta: " . $conn->error);
    }

    if ($result_reportes2->num_rows > 0) {
        $mensaje .= '<h2>Evidencias</h2>';
        $mensaje .= '<table border="1" cellspacing="0" cellpadding="5">
                            <tr> 
                                <th>Área</th>
                                <th>Fecha</th>
                                <th>Elemento</th>
                                <th>Falla</th>
                            </tr>';

        while ($row_reportes2 = $result_reportes2->fetch_assoc()) {
            $mensaje .= "<tr>";
            $mensaje .= "<td>" . $row_reportes2['area'] . "</td>";
            $mensaje .= "<td>" . $row_reportes2['fecha'] . "</td>";
            $mensaje .= "<td>" . $row_reportes2['elemento'] . "</td>";
            $mensaje .= "<td>" . $row_reportes2['falla'] . "</td>";
            $mensaje .= "</tr>";
        }

        $mensaje .= '</table>';
    } else {
        $mensaje .= '<p>No se encontraron reportes para hoy.</p>';
    }

    // Enviar correo electrónico
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = "10.1.13.160";
    $mail->Port = 587;   
    $mail->Username = "N.Kayser@kayser-automotive.com";
    $mail->Password = "Kayser2024.";
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Subject = 'Reporte General';
    $mail->setFrom('N.Kayser@kayser-automotive.com', 'Reporte!');
    $mail->addAddress('A.Zarate@kayser-automotive.com', 'name');
        $mail->addAddress('N.Kayser@kayser-automotive.com', 'name');
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

    if ($mail->send()) {
        // Redireccionar a check.php después de enviar el correo
        header('Location: check.php');
        exit; // Terminar el script después de la redirección
    } else {
        echo "No se ha podido enviar el correo.";
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar Reporte</title>
</head>
<body>

<!-- Formulario para enviar el reporte -->
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <button style="background-color:#6e0b0b; /* Rojo*/
      border: none;
      color: white;
      padding: 10px 50px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      margin: 4px 2px;
      cursor: pointer;
      border-radius: 10px;" type="submit" name="reportarTodo">Enviar Reporte</button>
</form>

</body>
</html>
