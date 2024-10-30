<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php');
    exit;
}

// Incluir archivo de conexión
include 'conexion.php';

// Conectar a la base de datos
$conn = connectDB();

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['area'])) {
    $area = $_POST['area'];
    
    $sql = "SELECT identificador_elemento, name_identificador FROM elementos WHERE area = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $area);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $elementos = array();
        while ($row = $result->fetch_assoc()) {
            $elementos[$row['identificador_elemento']] = $row['name_identificador'];
        }
        echo json_encode(array('success' => true, 'elementos' => $elementos));
    } else {
        echo json_encode(array('success' => false));
    }
    $stmt->close();
}
?>
