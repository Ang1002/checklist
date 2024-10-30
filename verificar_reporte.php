<?php
header('Content-Type: text/html; charset=utf-8');
// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "0084321";
$dbname = "projectroute";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

  
// Establecer el conjunto de caracteres a UTF-8
$conn->set_charset("utf8mb4");

// Obtener los valores de elemento_id y falla de los parámetros GET
$elemento_id = isset($_GET['elemento_id']) ? $conn->real_escape_string($_GET['elemento_id']) : '';
$falla = isset($_GET['falla']) ? $conn->real_escape_string($_GET['falla']) : '';

// Consulta SQL para obtener los registros con estado "Aceptada" y filtrado por falla
$sql = "SELECT elemento_id, area, elemento, falla, status
        FROM reportes2
        WHERE elemento_id = '$elemento_id'
          AND falla LIKE '%$falla%'
           AND status LIKE '%Aceptada%' 
         ";

// Ejecutar la consulta
$result = $conn->query($sql);

// Verificar si se obtuvieron resultados
if ($result->num_rows > 0) {
    // Mostrar los resultados
    echo "<table border='1'>
            <tr>
                <th>Elemento ID</th>
                <th>Área</th>
                <th>Elemento</th>
                <th>Falla</th>
                <th>Status</th>
            </tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row["elemento_id"], ENT_QUOTES, 'UTF-8') . "</td>
                <td>" . htmlspecialchars($row["area"], ENT_QUOTES, 'UTF-8') . "</td>
                <td>" . htmlspecialchars($row["elemento"], ENT_QUOTES, 'UTF-8') . "</td>
                <td>" . htmlspecialchars($row["falla"], ENT_QUOTES, 'UTF-8') . "</td>
                <td>" . htmlspecialchars($row["status"], ENT_QUOTES, 'UTF-8') . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron resultados";
}

// Cerrar la conexión
$conn->close();
?>