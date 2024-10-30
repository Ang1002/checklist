<?php
session_start(); // Iniciar sesión si no se ha hecho ya

// Verificar si el usuario está autenticado
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

// Obtener el ID de la sesión
$usuario_id = $_SESSION['id'];

// Incluir tu archivo de conexión a la base de datos aquí
$servername = "localhost";
$username = "root";
$password = "0084321";
$database = "projectroute";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$error_message = '';
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se ha enviado el formulario
    if (isset($_POST['submit'])) {
        
        // Obtener los datos del formulario
        $contrasena_actual = $_POST['contrasena_actual'];
        $nueva_contrasena = $_POST['nueva_contrasena'];
        $confirmar_contrasena = $_POST['confirmar_contrasena'];

        // Verificar si la nueva contraseña y la confirmación coinciden
        if ($nueva_contrasena !== $confirmar_contrasena) {
            $error_message = "Las contraseñas no coinciden.";
        } else {
            // Obtener la contraseña actual almacenada en la base de datos
            $sql = "SELECT password FROM usuarios WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $usuario_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $hashed_password = $row['password'];

                // Verificar si la contraseña actual es correcta
                if (!password_verify($contrasena_actual, $hashed_password)) {
                    $error_message = "La contraseña actual es incorrecta.";
                } else {
                    // Actualizar la contraseña en la base de datos
                    $nueva_contrasena_hash = password_hash($nueva_contrasena, PASSWORD_DEFAULT);

                    $update_sql = "UPDATE usuarios SET password = ? WHERE id = ?";
                    $stmt_update = $conn->prepare($update_sql);
                    $stmt_update->bind_param("si", $nueva_contrasena_hash, $usuario_id);

                    if ($stmt_update->execute()) {
                        $success_message = "¡La contraseña se ha actualizado correctamente!";
                    } else {
                        $error_message = "Error al actualizar la contraseña: " . $conn->error;
                    }
                }
            } else {
                $error_message = "Usuario no encontrado.";
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url("imagenes/fondo.png");
            margin: 0;
            padding: 0;
        }
        .contenido-tab {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .contenido-tab img {
            width: 300px;
            display: block;
            margin: 0 auto;
        }
        .contenido-tab h2 {
            text-align: center;
            color: #333;
        }
        .contenedor-input {
            margin-bottom: 15px;
        }
        .contenedor-input label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
        }
        .contenedor-input input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }
        .contenedor-input input[type="submit"] {
            background-color: #870c14;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .contenedor-input input[type="submit"]:hover {
            background-color: #870c14;
        }
        .mensaje {
            text-align: center;
            margin-top: 10px;
        }
        .mensaje p {
            padding: 10px;
            border-radius: 4px;
        }
        .mensaje .error {
            background-color: #f44336;
            color: white;
        }
        .mensaje .exito {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
<div class="contenido-tab">
    <center>
        <img src="imagenes/kayser_logo2-removebg-preview (1).png" alt="Logo">
    </center>

    <h2>Cambiar Contraseña</h2>
    <div class="mensaje">
        <?php if (!empty($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <?php if (!empty($success_message)): ?>
            <p class="exito"><?php echo $success_message; ?></p>
        <?php endif; ?>
    </div>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="contenedor-input">
            <label for="contrasena_actual">Contraseña Actual:</label>
            <input type="password" id="contrasena_actual" name="contrasena_actual" required>
        </div>
        <div class="contenedor-input">
            <label for="nueva_contrasena">Nueva Contraseña:</label>
            <input type="password" id="nueva_contrasena" name="nueva_contrasena" required>
        </div>
        <div class="contenedor-input">
            <label for="confirmar_contrasena">Confirmar Contraseña:</label>
            <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" required>
        </div>
        <div class="contenedor-input">
            <input type="submit" name="submit" value="Cambiar Contraseña">
        </div>
    </form>
</div>
</body>
</html>
