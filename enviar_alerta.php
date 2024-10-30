<?php
require_once 'src/Exception.php';
require_once 'src/PHPMailer.php';
require_once 'src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Establecer la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "0084321";
$dbname = "projectroute";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");
ini_set('default_charset', 'UTF-8');
header('Content-Type: text/html; charset=UTF-8');
header('Content-Type: application/json; charset=utf-8');
// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Recuperar los parámetros de la URL de manera segura
$id = $_GET['id'] ?? '';
$NameElemento = $_GET['NameElemento'] ?? '';
$area = $_GET['area'] ?? '';
$selectedFallaID = $_GET['selectedFallaID'] ?? '';
$selectedFallaDesc_Falla = $_GET['selectedFallaDesc_Falla'] ?? '';
$reportarTodo = $_GET['reportarTodo'] ?? ''; // Manejo seguro del parámetro

// Verificar si se han proporcionado los parámetros necesarios
if (!$id || !$NameElemento || !$area || !$selectedFallaDesc_Falla) {
    echo "No se han proporcionado todos los parámetros necesarios.";
    exit;
}

// Consulta para verificar el estado de la alerta
$sql = "SELECT estatus FROM alerta WHERE id_elemento = '$id' AND elemento = '$NameElemento' AND area = '$area'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['estatus'] == 'Aceptada') {
        // Alerta ya ha sido aceptada
        echo "La alerta ya ha sido aceptada";
        exit;
    }
}

// Construir el mensaje
$mensaje = "Atención!🚨\n Este elemento requiere tu revisión urgente.⚠️\n <BR>";
$mensaje .= "\"" . htmlspecialchars($NameElemento) . "\" en el área \"" . htmlspecialchars($area) . "\", ";
$mensaje .= "\"" . htmlspecialchars($selectedFallaDesc_Falla) . "\"\n";
$mensaje .= "Para aceptar la alerta o incidencia ingresa al siguiente link e ingresa con tu usuario.\n <BR>";
$mensaje .= '<a href="http://192.168.144.246:8080/terminalesproject/view_general.php' . htmlspecialchars($reportarTodo) . '">Haga clic aquí para aceptar las alertas</a>';

// Agregar los comentarios al mensaje si existen
if (!empty($_GET['comentarios'])) {
    $mensaje .= "\n\n" . htmlspecialchars($_GET['comentarios']);
}

// Enviar el correo electrónico y guardar en la base de datos
try {
    // Crear instancia de la clase PHPMailer
    $mail = new PHPMailer(true);
    // Autentificación con SMTP
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    // Login
    $mail->Host = "10.1.13.160";
    $mail->Port = 587;
    $mail->Username = "N.Kayser@kayser-automotive.com";
    $mail->Password = "Kayser2024.";
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Subject = 'Alerta!';
    $mail->setFrom('N.Kayser@kayser-automotive.com', 'Reporte!');
    $mail->addAddress('N.Kayser@kayser-automotive.com', 'name');
        $mail->addAddress('oe.gonzalez@kayser-automotive.com', 'name'); 
        $mail->addAddress('f.gonzalez@kayser-automotive.com', 'name');
        $mail->addAddress('a.sanchez@kayser-automotive.com', 'name');
        $mail->addAddress('j.rosasquiroz@kayser-automotive.com', 'name');
        $mail->addAddress('p.it@kayser-automotive.com', 'name');
        $mail -> addAddress('i.duran@kayser-automotive.com', 'name');
    $mail->addAddress('A.Zarate@kayser-automotive.com', 'name');
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';

    $mail->isHTML(true);
    $mail->ContentType = 'text/html; charset=UTF-8';
    $mail->Subject = 'Alerta';
    $mail->Body = $mensaje;
    $mail->AltBody = 'Texto como elemento de texto simple';

    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    
    $mail->send();
} catch (Exception $e) {
    echo "No se ha podido enviar la alerta. Error del remitente: ".$e->getMessage();
}

// Crear la consulta SQL para insertar los datos en la tabla "alerta"
$sql = "INSERT INTO alerta (id_elemento, elemento, area, falla, fecha_alerta, estatus) 
        VALUES ('$id', '$NameElemento', '$area', '$selectedFallaDesc_Falla', NOW(), 'En espera...')";

// Ejecutar la consulta
if ($conn->query($sql) === TRUE) {
    echo "Datos insertados correctamente.";
} else {
    echo "Error al guardar los datos: " . $conn->error;
}

?>
