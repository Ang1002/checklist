<?php
/*sesión iniciada*/ 
session_start();
$servername = 'localhost';
$username = 'root';
$password = '0084321';
$database = 'projectroute'; 

$conn = new mysqli($servername, $username, $password, $database); 

if (mysqli_connect_error()) {
    exit('Fallo en la conexión de MySQL:' . mysqli_connect_error()); 
}

if (!isset($_POST['username'], $_POST['password'])) {  
    header('Location:index.php');
}

if ($stmt = $conn->prepare('SELECT id, username, password FROM usuarios WHERE username = ?')) { //manda a traer el id, usuario y password de la tabla usuarios 
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) { //veriica la información que entra y que coincida con la bd 
        $stmt->bind_result($id, $username, $password);
        $stmt->fetch();

        if ($_POST['password'] === $password) { 
            session_regenerate_id();  
            $_SESSION['loggedin'] = TRUE;  
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;
            $_SESSION['password'] = $password; 
            header('Location: menu.php'); 
            exit; 
        } else {
            $mostrar_alerta = true;
        }
    } else {
        $mostrar_alerta = true;
    }

    $stmt->close();
} else {
    $mostrar_alerta = true;
}

$conn->close();

if ($mostrar_alerta) {
    echo "<script type='text/javascript'>
            alert('Usuario o contraseña incorrectos');
            window.location.href = 'index.php';  // Cambia 'otra_pagina.php' por la URL a la que quieras redirigir
          </script>";
    exit;
}
?>

 