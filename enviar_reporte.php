<?php
/**require_once 'src/Exception.php';
require_once 'src/PHPMailer.php';
require_once 'src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$servername = "localhost";
$username = "root";
$password = "0084321";
$dbname = "projectroute";


$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4");
header('Content-Type: application/json; charset=utf-8');


if ($conn->connect_error) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error en la conexión a la base de datos: ' . $conn->connect_error
    ]);
    exit();
}

// Manejar el envío del reporte
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['obtener_fallas'])) {
    $id = $_POST['id'];
    $nombreElemento = $_POST['nombreElemento'];
    $areas = $_POST['areas'];
    $issue = $_POST['issue'];
    $identificador_elemento = $_POST['identificador_elemento'];
    $files = $_FILES['foto'];
    $selectedFallaDesc = $_POST['selectedFallaDesc'];

   
    error_log("Ejecutando la verificación para ID = $id, Área = $areas, Falla = $selectedFallaDesc, Elemento = $nombreElemento");

    $sqlCheck = "SELECT * FROM reportes2 WHERE elemento_id = ? AND area = ? AND falla = ? AND elemento = ?";
    $stmtCheck = $conn->prepare($sqlCheck);
    if ($stmtCheck) {
        $stmtCheck->bind_param("isss", $id, $areas, $selectedFallaDesc, $nombreElemento);
        $stmtCheck->execute();
        $result = $stmtCheck->get_result();

        if ($result->num_rows > 0) {
            error_log("Encontrado un reporte. Número de filas: " . $result->num_rows);
            $row = $result->fetch_assoc();
            error_log("Estado del reporte encontrado: " . $row['status']);
            if ($row['status'] === 'Aceptado') {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'El reporte ya ha sido aceptado previamente.'
                ]);
                $stmtCheck->close();
                exit();
            }
        } else {
            error_log("No se encontraron reportes con los parámetros dados.");
        }
        $stmtCheck->close();
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Error al preparar la declaración SQL para verificar existencia: ' . $conn->error
        ]);
        exit();
    }


    $mensaje = "La evidencia reporta una incidencia que se ha detectado:";
    $mensaje .= " del elemento $nombreElemento, en el área $areas con respecto a:  $selectedFallaDesc<br>";
    $mensaje .= "Para aceptar la alerta o incidencia ingresa al siguiente link e ingresa con tu usuario.\n <BR>";
    $mensaje .= '<a href="http://192.168.144.246:8080/terminalesproject/view_general.php">Haga clic aquí para aceptar las incidencias</a>';
    
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = "10.1.13.160";
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = "N.Kayser@kayser-automotive.com";
        $mail->Password = "Kayser2024.";
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->setFrom('N.Kayser@kayser-automotive.com', 'Reporte');
        $mail->addAddress('N.Kayser@kayser-automotive.com', 'name');
       // $mail->addAddress('oe.gonzalez@kayser-automotive.com', 'name'); 
      //  $mail->addAddress('f.gonzalez@kayser-automotive.com', 'name');
       // $mail->addAddress('a.sanchez@kayser-automotive.com', 'name');
       // $mail->addAddress('j.rosasquiroz@kayser-automotive.com', 'name');
      //  $mail->addAddress('p.it@kayser-automotive.com', 'name');
      //  $mail -> addAddress('i.duran@kayser-automotive.com', 'name');
        $mail->addAddress('A.Zarate@kayser-automotive.com', 'name');
        
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';
        $mail->isHTML(true);
        $mail->Subject = 'Evidencia';
        $mail->Body = $mensaje;
        $mail->AltBody = 'Texto como elemento de texto simple';
        
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        
        foreach ($files['tmp_name'] as $index => $tmp_name) {
            if (!empty($tmp_name)) {
                $filePath = $tmp_name;
                $fileName = $files['name'][$index];
                $mail->AddEmbeddedImage($filePath, 'img' . $index, $fileName);
                $mail->Body .= '<br><img src="cid:img' . $index . '" alt="' . $fileName . '">';
            }
        }

        if ($mail->send()) {
            $name_foto = '';
            $url_foto = '';
            if (!empty($files['name'][0])) {
                $name_foto = $files['name'][0];
                $url_foto = $files['tmp_name'][0];
            }

            // Crear la consulta SQL para insertar los datos en la tabla "reportes2"
            $sql = "INSERT INTO reportes2 (elemento_id, area, fecha, name_foto, url_foto, falla, elemento, status) VALUES (?, ?, NOW(), ?, ?, ?, ?, 'En espera...')";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("isssss", $id, $areas, $name_foto, $url_foto, $selectedFallaDesc, $nombreElemento);
                if ($stmt->execute()) {
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Correo enviado e información guardada correctamente en la base de datos.'
                    ]);
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Correo enviado, pero no se pudieron insertar los datos en la base de datos: ' . $stmt->error
                    ]);
                }
                $stmt->close();
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Correo enviado, pero error al preparar la declaración SQL: ' . $conn->error
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'No se pudo enviar el correo: ' . $mail->ErrorInfo
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Excepción al enviar el correo: ' . $e->getMessage()
        ]);
    }

    exit();
}

$conn->close();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);**/
require_once 'src/Exception.php';
require_once 'src/PHPMailer.php';
require_once 'src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$servername = "localhost";
$username = "root";
$password = "0084321";
$dbname = "projectroute";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4");
header('Content-Type: application/json; charset=utf-8');

if ($conn->connect_error) {
    error_log('Error en la conexión a la base de datos: ' . $conn->connect_error);
    echo json_encode([
        'status' => 'error',
        'message' => 'Error en la conexión a la base de datos: ' . $conn->connect_error
    ]);
    exit();
}

// Manejar el envío del reporte
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['obtener_fallas'])) {
    $id = $_POST['id'] ?? '';
    $nombreElemento = $_POST['nombreElemento'] ?? '';
    $areas = $_POST['areas'] ?? '';
    $issue = $_POST['issue'] ?? '';
    $identificador_elemento = $_POST['identificador_elemento'] ?? '';
    $selectedFallaDesc = $_POST['selectedFallaDesc'] ?? '';

    // Verificar si el archivo fue subido
    if (isset($_FILES['foto']) && $_FILES['foto']['error'][0] === UPLOAD_ERR_OK) {
        $files = $_FILES['foto'];
    } else {
        $files = [
            'tmp_name' => [],
            'name' => []
        ];
    }

    // Registra los valores recibidos en el log
    error_log("Valores recibidos: ID = $id, Elemento = $nombreElemento, Área = $areas, Falla = $selectedFallaDesc");
    error_log("Archivos recibidos: " . print_r($files, true));

    // Verificación de reporte existente
   // Verificación de reporte existente
$sqlCheck = "SELECT status FROM reportes2 WHERE elemento_id = ? AND area = ? AND falla = ? AND elemento = ?";
$stmtCheck = $conn->prepare($sqlCheck);

if ($stmtCheck) {
    $stmtCheck->bind_param("isss", $id, $areas, $selectedFallaDesc, $nombreElemento);
    $stmtCheck->execute();
    $result = $stmtCheck->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        error_log("Estado del reporte encontrado: " . $row['status']);
        if ($row['status'] === 'Aceptada') { // Verifica si el estado es "Aceptada"
            echo json_encode([
                'status' => 'Error',
                'message' => 'El reporte ya ha sido aceptado para su revisión, Nose puede enviar hasta que este resuelto por el usuario.'
            ]);
            $stmtCheck->close();
            exit();
        }
    } else {
        error_log("No se encontraron registros con los criterios proporcionados.");
    }
    $stmtCheck->close();
} else {
    error_log('Error al preparar la declaración SQL para verificar existencia: ' . $conn->error);
    echo json_encode([
        'status' => 'error',
        'message' => 'Error al preparar la declaración SQL para verificar existencia: ' . $conn->error
    ]);
    exit();
}

    $mensaje = "La evidencia reporta una incidencia que se ha detectado:";
    $mensaje .= " del elemento $nombreElemento, en el área $areas con respecto a:  $selectedFallaDesc<br>";
    $mensaje .= "Para aceptar la alerta o incidencia ingresa al siguiente link e ingresa con tu usuario.\n <BR>";
    $mensaje .= '<a href="http://192.168.144.246:8080/terminalesproject/view_general.php">Haga clic aquí para aceptar las incidencias</a>';

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = "10.1.13.160";
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = "N.Kayser@kayser-automotive.com";
        $mail->Password = "Kayser2024.";
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->setFrom('N.Kayser@kayser-automotive.com', 'Reporte');
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
        $mail->Subject = 'Evidencia';
        $mail->Body = $mensaje;
        $mail->AltBody = 'Texto como elemento de texto simple';

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        // Añadir archivos al correo
        foreach ($files['tmp_name'] as $index => $tmp_name) {
            if (!empty($tmp_name)) {
                $filePath = $tmp_name;
                $fileName = $files['name'][$index];
                $mail->AddEmbeddedImage($filePath, 'img' . $index, $fileName);
                $mail->Body .= '<br><img src="cid:img' . $index . '" alt="' . $fileName . '">';
            }
        }

        if ($mail->send()) {
            $name_foto = '';
            $url_foto = '';
            if (!empty($files['name'][0])) {
                $name_foto = $files['name'][0];
                $url_foto = $files['tmp_name'][0];
            }

            $sql = "INSERT INTO reportes2 (elemento_id, area, fecha, name_foto, url_foto, falla, elemento, status) VALUES (?, ?, NOW(), ?, ?, ?, ?, 'En espera...')";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("isssss", $id, $areas, $name_foto, $url_foto, $selectedFallaDesc, $nombreElemento);
                if ($stmt->execute()) {
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Correo enviado e información guardada correctamente en la base de datos.'
                    ]);
                } else {
                    error_log('Error al insertar datos en la base de datos: ' . $stmt->error);
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Correo enviado, pero no se pudieron insertar los datos en la base de datos: ' . $stmt->error
                    ]);
                }
                $stmt->close();
            } else {
                error_log('Error al preparar la declaración SQL para insertar datos: ' . $conn->error);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Correo enviado, pero error al preparar la declaración SQL: ' . $conn->error
                ]);
            }
        } else {
            error_log('No se pudo enviar el correo: ' . $mail->ErrorInfo);
            echo json_encode([
                'status' => 'error',
                'message' => 'No se pudo enviar el correo: ' . $mail->ErrorInfo
            ]);
        }
    } catch (Exception $e) {
        error_log('Excepción al enviar el correo: ' . $e->getMessage());
        echo json_encode([
            'status' => 'error',
            'message' => 'Excepción al enviar el correo: ' . $e->getMessage()
        ]);
    }

    exit();
}

$conn->close();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>