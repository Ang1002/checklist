<?php
header('Content-Type: text/html; charset=utf-8'); // Asegúrate de que la codificación es UTF-8

// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "0084321";
$dbname = "projectroute";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener parámetros de la solicitud
$id = isset($_GET['id']) ? $_GET['id'] : '';
$NameElemento = isset($_GET['NameElemento']) ? $_GET['NameElemento'] : '';
$area = isset($_GET['area']) ? $_GET['area'] : '';
$selectedFallaID = isset($_GET['selectedFallaID']) ? $_GET['selectedFallaID'] : '';
$selectedFallaDesc_Falla = isset($_GET['selectedFallaDesc_Falla']) ? $_GET['selectedFallaDesc_Falla'] : '';

// Verificar si los parámetros están presentes
if (empty($id) || empty($NameElemento) || empty($area) || empty($selectedFallaID) || empty($selectedFallaDesc_Falla)) {
    die("Error: Parámetros no proporcionados.");
}

// Consulta para verificar el estado de la alerta
$sql = "
    SELECT * FROM alerta
    WHERE id_elemento = ?
      AND falla = ?
      AND estatus = 'Aceptada'
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $id, $selectedFallaDesc_Falla); // Asegúrate de que el tipo de dato es correcto
$stmt->execute();
$result = $stmt->get_result();

// Verificar si hay resultados
if ($result->num_rows > 0) {
    echo "La alerta ya ha sido aceptada.";
} else {
    echo "La alerta está en espera.";
}

$stmt->close();
$conn->close();
?>
