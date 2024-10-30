<!-- historial.php -->
<?php
// Incluir archivo de conexión
include 'conexion.php';

// Conectar a la base de datos
$conn = connectDB();

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta SQL para obtener todo el historial
$sql_historial = "SELECT elemento_id, NameElemento, areas, identificador_elemento, descripcion_falla FROM historial_escaneos";
$result_historial = $conn->query($sql_historial);
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Style_Check.css">
    <link rel="icon" href="imagenes/kayser_icon.ico" type="image/x-icon">
    <title>Checklist historial </title>
</head>
<body>
 <br>
 <br>
 <nav style="color: white;">
        <h2><img src="imagenes/kayser_logo2-removebg-preview (1).png" alt="Logo" width="180" height="80"></h2>
        <ul>
            <li class="main-nav__item"><a class="main-nav__link" href="menu.php" data-link-alt=""> <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-border-width" viewBox="0 0 16 16">
            <path d="M0 3.5A.5.5 0 0 1 .5 3h15a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H.5a.5.5 0 0 1-.5-.5zm0 5A.5.5 0 0 1 .5 8h15a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H.5a.5.5 0 0 1-.5-.5zm0 4a.5.5 0 0 1 .5-.5h15a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5"/>
            </svg> Inicio </a>
            </li>
        </ul>
    </nav>

    </header>
<br>
<br>
<br>

<center>
    <div id="historialContainer">
        <?php if ($result_historial->num_rows > 0): ?>
            <table border="1">
                <thead>
                    <tr>
                        <th>ID Elemento</th>
                        <th>Área</th>
                        <th>Nombre del Elemento</th>
                        <th>Identificador del Elemento</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result_historial->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['elemento_id']; ?></td>
                            <td><?php echo $row['areas']; ?></td>
                            <td><?php echo $row['NameElemento']; ?></td>
                            <td><?php echo $row['identificador_elemento']; ?></td>
                        
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay historial disponible.</p>
        <?php endif; ?>
    </div>
    </center>
</body>
</html>
