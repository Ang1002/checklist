<?php
// actualizar_estado.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_elemento = $_POST['id_elemento'];

    //actualizar el estado
    
    $sql = "UPDATE reportes2 SET status = 'Aceptado' WHERE id = $id_elemento";
    // Ejecutar la consulta y verificar si se ejecutó correctamente

    echo "Estado actualizado correctamente";
} else {
    echo "Error: Método de solicitud incorrecto";
}
?>

