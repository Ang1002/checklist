<?php
// Establecer la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "0084321";
$dbname = "projectroute";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

require_once 'src/Exception.php';
require_once 'src/PHPMailer.php';
require_once 'src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$email = new PHPMailer(true);
// Activar o desactivar excepciones mediante variable
$debug = true;
// Recuperar los datos del URL
$id = isset($_GET['id']) ? $_GET['id'] : '';
$elemento = isset($_GET['elemento']) ? $_GET['elemento'] : '';
$area = isset($_GET['area']) ? $_GET['area'] : '';
// Recuperar la opción de falla seleccionada
$opcion_falla = isset($_GET['opcion_falla']) ? $_GET['opcion_falla'] : 'No se seleccionó una opción de falla';
// Verificar si los parámetros están presentes
if ($id && $elemento && $area) {
    // Tu lógica aquí
} else {
    echo "No se han proporcionado todos los parámetros necesarios.";
}
// Construir el mensaje
$mensaje = "¡Atención! Este elemento requiere tu revisión urgente.\n";
$mensaje .= "Elemento: \"$elemento\" en el área \"$area\", ";
$mensaje .= "con la faalla de: \"$opcion_falla\"\n";



try {
    // Crear instancia de la clase PHPMailer
    $mail = new PHPMailer($debug);
    // Autentificación con SMTP
    $mail->isSMTP();
    $mail->SMTPAuth = true;
 
    $mail->Host = "10.1.13.160";
    $mail->Port = 587;  //PUERTO SOLO SI ES TLS
    $mail->Username = "A.Zarate@kayser-automotive.com";
    $mail->Password = "Manchas_2024*";//PASWORD DEL CORREO PARA ENVIARLO 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

    $mail->setFrom('a.zarate@kayser-automotive.com', 'Alerta!');
    $mail->addAddress('marzpa3@gmail.com', 'name');

    //$mail->addAttachment("/home/user/Escritorio/imagendeejemplo.png", "imagendeejemplo.png");

    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';

    $mail->isHTML(true);
    $mail->Subject = 'Alerta';
    $mail->Body= $mensaje;

   // $mail->Body = 'El contenido de tu correo en HTML. Los elementos en <b>negrita</b> también están permitidos.';
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

?>

