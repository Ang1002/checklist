<?php
// Incluir archivo de conexión
include 'conexion.php';
// Conectar a la base de datos
$conn = connectDB();
// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
// Verificar si se recibió una solicitud AJAX para obtener las fallas
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["obtener_fallas"])) {
    // Consulta SQL para obtener las fallas
    $identificador_elemento = $_POST["identificador_elemento"];
    // Consulta SQL para obtener las fallas filtradas por el identificador_elemento
    $sql_fallas = "SELECT id, descripcion, identificador_elemento FROM fallas2 WHERE identificador_elemento = ?";
    $stmt_fallas = $conn->prepare($sql_fallas);
    $stmt_fallas->bind_param("s", $identificador_elemento);
    $stmt_fallas->execute();
    $result_fallas = $stmt_fallas->get_result();

    // Verificar si se encontraron resultados
    if ($result_fallas->num_rows > 0) {
        // Crear un array para almacenar las fallas
        $fallas = array();

        // Iterar sobre los resultados y agregarlos al array
        while ($row = $result_fallas->fetch_assoc()) {
            $falla = array(
                'id' => $row['id'],
                'descripcion' => $row['descripcion'],
                'identificador_elemento' => $row['identificador_elemento']
            );
            // Agregar el array de la falla al array de fallas
            $fallas[] = $falla;
        }
        // Devolver las fallas en formato JSON
        echo json_encode($fallas);
    } else {
        // No se encontraron fallas
        echo json_encode(array());
    }
    // Terminar la ejecución del script después de enviar la respuesta JSON
    exit;
}
// Verificar si se recibió una solicitud AJAX para actualizar el elemento
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["actualizar_elemento"])) {
    // Obtener los datos del formulario
    $id_elemento = $_POST['id_elemento'];
    $fallas = $_POST['fallas'];
    // Actualizar la tabla `elementos` con las fallas seleccionadas
    $sql_update = "UPDATE elementos SET Falla1 = ?, Falla2 = ?, Falla3 = ?, Falla4 = ?, Falla5 = ?, Falla6 = ?, Falla7 = ? , Falla8 = ?  , Falla9 = ? , Falla10 = ? , Falla11 = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("iiiiiiii", $fallas[0], $fallas[1], $fallas[2], $fallas[3], $fallas[4], $fallas[5], $fallas[6], $fallas[7], $fallas[8], $fallas[9], $fallas[10], $id_elemento);

    if ($stmt_update->execute()) {
        // Éxito al actualizar el elemento
        echo json_encode(array('status' => 'success', 'message' => 'Elemento actualizado correctamente.'));
    } else {
        // Error al actualizar el elemento
        echo json_encode(array('status' => 'error', 'message' => 'Error al actualizar el elemento.'));
    }

    // Terminar la ejecución del script después de enviar la respuesta JSON
    exit;
}
// Verificar el método de solicitud
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el texto del QR
    $qrText = isset($_POST['qrText']) ? trim($_POST['qrText']) : '';

    if (!empty($qrText)) {
        // Dividir el texto del QR en una lista de IDs
        $ids = explode(',', $qrText);
        $ids = array_map('intval', $ids); // Asegurarse de que sean enteros

        // Construir la consulta SQL con múltiples IDs
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $sql = "SELECT e.id, e.areas, e.NameElemento, e.identificador_elemento,
                        f1.id AS Falla1_id, f1.descripcion AS Falla1_desc, 
                        f2.id AS Falla2_id, f2.descripcion AS Falla2_desc, 
                        f3.id AS Falla3_id, f3.descripcion AS Falla3_desc, 
                        f4.id AS Falla4_id, f4.descripcion AS Falla4_desc,
                        f5.id AS Falla5_id, f5.descripcion AS Falla5_desc,
                        f6.id AS Falla6_id, f6.descripcion AS Falla6_desc,
                        f7.id AS Falla7_id, f7.descripcion AS Falla7_desc,
                        f8.id AS Falla8_id, f8.descripcion AS Falla8_desc,
                        f9.id AS Falla9_id, f9.descripcion AS Falla9_desc,
                        f10.id AS Falla10_id, f10.descripcion AS Falla10_desc,
                        f11.id AS Falla11_id, f11.descripcion AS Falla11_desc,
                        gc.caracteristica1,
                        gc.caracteristica2,
                        gc.caracteristica3,
                        gc.caracteristica4,
                        gc.caracteristica5,
                        gc.caracteristica6,
                        gc.caracteristica7,
                        gc.caracteristica8,
                        gc.caracteristica9,
                        gc.caracteristica10,
                        gc.caracteristica11
                FROM elementos e
                LEFT JOIN fallas f1 ON e.Falla1 = f1.id
                LEFT JOIN fallas f2 ON e.Falla2 = f2.id
                LEFT JOIN fallas f3 ON e.Falla3 = f3.id
                LEFT JOIN fallas f4 ON e.Falla4 = f4.id
                LEFT JOIN fallas f5 ON e.Falla5 = f5.id
                LEFT JOIN fallas f6 ON e.Falla6 = f6.id
                LEFT JOIN fallas f7 ON e.Falla7 = f7.id
                LEFT JOIN fallas f8 ON e.Falla8 = f8.id
                LEFT JOIN fallas f9 ON e.Falla9 = f9.id
                LEFT JOIN fallas f10 ON e.Falla10 = f10.id
                LEFT JOIN fallas f11 ON e.Falla11 = f11.id
                LEFT JOIN guardar_check gc ON e.id = gc.elemento_id
                WHERE e.id IN ($placeholders)";

        // Preparar y ejecutar la consulta
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(str_repeat('i', count($ids)), ...$ids); // Binding parameters
        $stmt->execute();
        $resultado = $stmt->get_result();
    } else {
        echo "No se recibió ningún texto del código QR.";
        exit;
    }
   
} else {
    echo "Método de solicitud no válido.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="Style_Check.css">
    <link rel="stylesheet" type="text/css" href="style_check_final.css">
    <link rel="icon" href="imagenes/kayser_icon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <title>Checklist</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/7.7.1/adapter.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<header>
    <nav style="color: white;">
        <h2><img src="imagenes/kayser_logo2-removebg-preview (1).png" alt="Logo" width="180" height="80"></h2>
        <ul>
            <li class="main-nav__item"><a class="main-nav__link" href="menu.php" data-link-alt=""> <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-border-width" viewBox="0 0 16 16">
            <path d="M0 3.5A.5.5 0 0 1 .5 3h15a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H.5a.5.5 0 0 1-.5-.5zm0 5A.5.5 0 0 1 .5 8h15a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H.5a.5.5 0 0 1-.5-.5zm0 4a.5.5 0 0 1 .5-.5h15a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5"/>
            </svg> Inicio </a>
            </li>
        </ul>
    </nav>
    <style>
       
        .modal {
    display: none; /* Ocultar el modal por defecto */
    position: fixed; /* Posición fija */
    z-index: 1; /* Hacer que el modal esté encima de todo */
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto; /* Habilitar el desplazamiento si el contenido es demasiado largo */
    background-color: rgba(0,0,0,0.4); /* Fondo negro semitransparente */
    transition: opacity 0.5s ease;
    opacity: 0;/* Fondo negro semitransparente */
    padding-top: 60px; /* Espaciado superior para la barra de navegación */
}

.modal.show {
    display: block;
    opacity: 1;
}

/* Estilos para el contenido del modal */
.modal-content {
    background-color: #fefefe;
    margin: 15% auto; /* Centrar el modal verticalmente */
    padding: 20px;
    border: 1px solid #888;
    width: 60%; /* Anchura del modal */
    border-radius: 10px;
    transform: scale(0.8);
    transition: transform 0.3s ease;
}
.modal.show .modal-content {
    transform: scale(1);
}



/* Estilos para el botón de cerrar el modal */
.close {
    color: #000000;
    float: right;
    font-size: 32px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

.custom-modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.4);
    padding-top: 60px;
}

.custom-modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border-radius: 10px;
    max-width: 400px;
    position: relative;
}

.custom-close {
    color: #aaa;
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 24px;
    cursor: pointer;
}

.modal-title {
    text-align: center;
    margin-bottom: 20px;
}

.custom-file-upload {
    background-color: #f0f0f0;
    color: #333;
    border: 1px solid #ccc;
    display: inline-block;
    padding: 6px 12px;
    cursor: pointer;
    border-radius: 5px;
    margin-bottom: 10px;
}

.custom-file-upload i {
    margin-right: 5px;
}


button {
    background-color: #990505;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    width:auto;
}

button:hover {
    background-color: #990505;
}

button:active {
    background-color: #990505;
}


.img-container {
  display: inline-block; /* Mostrar en línea uno al lado del otro */
  vertical-align: top; /* Alineación superior */
  width: 10%; /* Ancho deseado para cada contenedor */
  height: 50px; /* Altura deseada */
  background-color: white; /* Color de fondo */
  border: 1px solid white; /* Borde */
  margin: 0; /* Margen horizontal para separar los bloques */
  box-sizing: border-box; /* Incluir el borde en el tamaño total del elemento */
}

input[type="date"]{
    background-color: #8c180f;
    transform: translate(-50%,-50%);
    font-family: "Roboto Mono",monospace;
    color:#c2bcbc ;
    font-size: 16px;
    border: none;
    outline: none;
    border-radius: 5px;
}
::-webkit-calendar-picker-indicator{
    background-color: #ffffff;
    padding: 5px;
    cursor: pointer;
    border-radius: 3px;
}


.calendar {
  
      float: left;
      width: 70px;
      background: #ededef;
      background:#ededef;
      font: bold 20px/45px Arial Black, Arial, Helvetica, sans-serif;
      text-align: center;
      color: #000;
      -moz-border-radius: 3px;
      -webkit-border-radius: 3px;
      border-radius: 3px;
      position: relative;
    }

    .calendar em {
      display: block;
      font: normal bold 11px/30px Arial, Helvetica, sans-serif;
      color: #fff;
      text-shadow: #8c180f 0 -1px 0;
      background:#8c180f;
    }

    .calendar:before,
    .calendar:after {
      content: '';
      float: left;
      position: absolute;
      top: 5px;
      width: 8px;
      height: 8px;
      background: #111;
      z-index: 1;
     
      border-radius: 10px;
    
    }

    .calendar em:before,
    .calendar em:after {
      content: '';
      float: left;
      position: absolute;
      top: -5px;
      width: 4px;
      height: 14px;
      background: #dadada;
      background: #f1f1f1;
      z-index: 2;
      border-radius: 2px;
    }

    .calendar em:before {
      left: 13px;
    }

    .calendar em:after {
      right: 13px;
    }

    .calendar:before {
      left: 11px;
    }

    .calendar:after {
      right: 11px;
    }
    
    .identificador-elemento {
    display: none;
}

.popup {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .popup-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            position: relative;
        }

        .close-btn {
            position: absolute;
            right: 10px;
            top: 10px;
            color:#000000;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        /* Estilos para el formulario dentro del cuadro emergente */
        .popup-content form {
            display: flex;
            flex-direction: column;
        }

        .popup-content form label {
            margin-bottom: 8px;
        }

        .popup-content form select,
        .popup-content form button {
            margin-top: 8px;
            padding: 8px;
            font-size: 16px;
        }

        .popup-content form button {
            background-color: #690c0d;
            color: white;
            border: none;
            cursor: pointer;
        }

        .popup-content form button:hover {
            background-color:#690c0d;
        }

        /* Estilos para la vista previa de la imagen */
        #preview {
            width: 100%;
            height: auto;
            border: 1px solid #ccc;
            margin-top: 10px;
            display: none;
        }

        .modal-header {
    width: 100%; /* Ajusta el ancho de la imagen según sea necesario */
    height:140px; /* Ajusta la altura de la imagen según sea necesario */
    margin-bottom: 20px; /* Espacio entre la imagen y el contenido del modal */
}



/* Estilo para los modales */
.modalre {
    display: none; /* Por defecto, los modales están ocultos */
    position: fixed; /* Permanece en la misma posición incluso si se desplaza la página */
    z-index: 1; /* Ubica el modal por encima de otros elementos */
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto; /* Añade desplazamiento si el contenido es demasiado grande para el modal */
    background-color: rgba(0, 0, 0, 0.4); /* Fondo oscuro semi-transparente */
}

/* Contenido del modal */
.modalre-content {
    background-color: #fefefe;
    margin: 15% auto; /* Centra el modal verticalmente */
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

/* Botón de cierre (x) */
.close-btn {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close-btn:hover,
.close-btn:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

.transparent {
    opacity: 0;
}

.modal-header {
    width: 10%;
    height: 20px; /* Ajusta la altura según sea necesario */
    background-color: #690c0d; /* Color de fondo del recuadro */
    border-radius: 10px; /* Borde redondeado del recuadro */
    margin-bottom: 20px; /* Espacio entre el recuadro y el contenido del modal */
}

        #successMessage {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
            display: none;
        }

        #successMessage.success {
            background-color: #d4edda;
            color: #155724;
        }

        #successMessage.error {
            background-color: #f8d7da;
            color: #721c24;
        }


        #boton1 {
            background-color:#6e0b0b;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            padding: 10px 22px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 10px;
        }

        #boton2 {
            background-color: #6e0b0b;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            margin-top: 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 10px;
        
        
        }


     /* Contenedor de notificaciones */
     .notification-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            max-width: 300px;
        }

        /* Estilos para las notificaciones */
        .notification {
            position: relative;
            margin-bottom: 15px;
            padding: 15px;
            background-color: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .notification.show {
            opacity: 1;
        }

        .notification .close-btn {
            position: absolute;
            top: 5px;
            right: 10px;
            cursor: pointer;
            color: #aaaaaa;
        }

        .notification.info {
            border-left: 5px solid #007bff; /* azul */
        }

        .notification.error {
            border-left: 5px solid #dc3545; /* rojo */
        }

        /* Estilos para el botón de notificaciones */
        #notification-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #007bff; /* azul */
            color: #ffffff;
            font-size: 24px;
            text-align: center;
            line-height: 50px;
            cursor: pointer;
            z-index: 1000;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        #notification-btn:hover {
            background-color: #0056b3; /* azul más oscuro */
        } 
    .inline-forms {
        display: inline-block;
    }
    
    .image-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }
        .image-container .img-wrapper {
            position: relative;
            width: 150px; /* Ajusta el tamaño de la imagen */
            height: 150px; /* Ajusta el tamaño de la imagen */
            overflow: hidden;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Ajusta la imagen para que cubra el contenedor sin deformarse */
        }
        .remove-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: red;
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            font-size: 16px;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .file-count-container {
            margin-top: 10px;
        }
        .hidden-input {
            display: none;
        }
        


    </style>

<script>
// Función para abrir el modal
function openModal() {
    document.getElementById("myModal").style.display = "block";
}

// Función para cerrar el modal
function closeModal() {
    document.getElementById("myModal").style.display = "none";
}

// Cerrar el modal cuando el usuario haga clic fuera de él
window.onclick = function(event) {
    var modal = document.getElementById("myModal");
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

</header>

</head>
<body>
<center>
    <div class="col-md-12 text-center">
        <h3 class="animate-charcter">Checklist</h3>
    </div>
</center>
    <br>
    <button id="verHistorialBtn">Ver historial del checklist</button>

<script>
document.getElementById("verHistorialBtn").addEventListener("click", function() {
    window.location.href = "historial.php";
});
</script>

<br>
<br>
<br>


    <?php if ($resultado->num_rows > 0): ?>
        <table>
           
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Área</th>
                    <th>Nombre del Elemento</th>
                    <th colspan="11">Características</th>
                    <th>Alerta</th>
                    <th>Evidencia</th>
                </tr>
            </thead>
            <tbody>
            <tbody>
                    <?php while ($fila = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($fila['id']); ?></td>
                            <td><?php echo htmlspecialchars($fila['areas']); ?></td>
                            <td><?php echo htmlspecialchars($fila['NameElemento']); ?></td>
                            <?php for ($i = 1; $i <= 11; $i++): ?>
                                <?php $descripcionFalla = $fila["Falla{$i}_desc"]; ?>
                                <td>
                                    <?php if (!empty($descripcionFalla)): ?>
                                        <input type="checkbox" name="caracteristica<?php echo $i; ?>[]" value="<?php echo $fila['id']; ?>" <?php echo ($fila["caracteristica{$i}"] != null) ? 'checked' : ''; ?> onchange="checkboxChange(<?php echo $fila['id']; ?>, 'caracteristica<?php echo $i; ?>', this.checked);">
                                        <?php echo htmlspecialchars($descripcionFalla); ?>
                                        <input type="hidden" name="fecha_caracteristica<?php echo $i; ?>[]" value="<?php echo htmlspecialchars($fila["caracteristica{$i}"]); ?>">
                                    <?php endif; ?>
                                </td>
                            <?php endfor; ?>
                            <td>
    <a style="background-color:#6e0b0b; /* Rojo*/
  border: none;
  color: white;
  padding: 10px 22px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  border-radius: 10px;" href="#" class="button" onclick="openModalAndEnviarAlerta(<?php echo $fila['id']; ?>, '<?php echo($fila['NameElemento']); ?>', '<?php echo ($fila['areas']); ?>' , '<?php echo ($fila['identificador_elemento']); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
  <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.15.15 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.2.2 0 0 1-.054.06.1.1 0 0 1-.066.017H1.146a.1.1 0 0 1-.066-.017.2.2 0 0 1-.054-.06.18.18 0 0 1 .002-.183L7.884 2.073a.15.15 0 0 1 .054-.057m1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767z"/>
  <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z"/>
</svg> Alerta</a>
   
</td>


<td>  
<a style="background-color:#6e0b0b; /* Rojo*/
  border: none;
  color: white;
  padding: 10px 22px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  border-radius: 10px;"  href="#" class="button" onclick="showPopup(<?php echo $fila['id']; ?>, '<?php echo $fila['NameElemento']; ?>', '<?php echo $fila['areas']; ?>', '<?php echo $fila['identificador_elemento']; ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
  <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
</svg>Evidencia</a>
</td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
        </table>
    <?php else: ?>
        <p>No se encontraron resultados para el texto del QR proporcionado.</p>
    <?php endif; ?>

    <?php
    $stmt->close();
    $conn->close();
    ?>
    <br>
<center>
<button onclick="window.location.href='qr.php';" style="background-color:#6e0b0b; /* Rojo*/
  border: none;
  color: white;
  padding: 10px 22px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  border-radius: 10px;" >Escanear Otro Elemento</button>
  </center>
<br >

<div class="notification-container" id="notification-container">
        <!-- Aquí se insertarán las notificaciones dinámicamente -->
    </div>

<!-- Modal -->
<div id="myModal" class="modal">
    <div class="modal-content">
        
    <div class="modal-header"></div>

        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Selecciona una falla:</h2>
        <!-- Llamada a cargarFallas con el identificador_elemento correspondiente -->
       <!--<button onclick="cargarFallas('identificador_elemento_actual')">Cargar Fallas</button>-->


    <p>
    <span id="modalE"></span> del área de <span id="modalA"></span>
    <span id="modalI" class="identificador-elemento"></span>
</p>
        <select id="selectFalla" name="opcion_falla">
            
            <!-- Las opciones se cargarán aquí dinámicamente -->
        </select>
        <br>
        <br>
        <button type="submit" id="confirmBtn" onclick="confirmSelection()" style="background-color:#6e0b0b; /* Rojo*/ border: none; color: white; padding: 10px 22px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; border-radius: 10px;">Enviar Alerta</button>
        <div id="mensaje"></div>
    </div>
</div>


<!---Nuevo modal para el reporte con foto --->

<div id="popupModal" class="popup">
    <div class="popup-content">
    <div class="modal-header"></div>
        <span class="close-btn" onclick="hidePopup()">&times;</span>
        <h2>Enviar evidencia</h2>
        
        <form id="reportForm" enctype="multipart/form-data">
            <!-- Mostrar información del elemento -->
            <p><span id="element-id" class="transparent"></span><span id="element-name"></span> de <span id="element-areas"></span><span id="element-identificador" class="transparent"></span></p>


            <label for="issue-select">Seleccione la incidencia que quiere reportar en su evidencia:</label>
           <center>
            <select id="issue-select" name="issue-select"></select>
        </center>
        
            <center>
            <label for="file-upload" class="transparent">Subir imagen desde tu equipo:</label>
            <p>Agregar Fotos: 
            <input type="file" id="file-upload" accept="image/*" multiple>
        
            <img id="preview" src="#" alt="Vista previa" style="display:none;">
           <!-- <button type="submit">Enviar</button>-->
        </center>
           <br>
           <br>
<center>
           <button type="submit" onclick="alert('Mensaje enviado exitosamente!'); hidePopup();">Enviar</button>


            <div id="successMessage" style="display: none;">Reporte enviado con éxito.</div>
            <!-- Agrega un elemento para mostrar el mensaje -->
            </center>

        </form>

    </div>
    
</div>




</center>


<!---Modal para enviar emnaje de reporte enviado --->
<!-- Modal para mostrar el mensaje de correo enviado -->
<div id="correoEnviadoModal" class="modalre">
    <div class="modal-content">
        <span class="close-btn" onclick="hideCorreoEnviadoModal()">&times;</span>
        <p>¡El reporte se ha enviado correctamente!</p>
    </div>
</div>

<br>
<br>



<footer>
    <p>&copy; 2024 Kayser Automotive Systems. Todos los derechos reservados.(IT)</p>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"
        integrity="sha512-Ekhu8YElCfSmD07EoA8+e8I9tVx0S8i1d15S4u0JXeb8fOKA/LkddWe30r/0wzz8PsJVvJhFZJW2ONPac0wG5w=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        
<script>

    $(function () {
      var mySelectCheckbox = new checkbox_select(
        {
          selector: "#make_checkbox_select",
          selected_translation: "selectat",
          all_translation: "Toate marcile",
          not_found: "Nici unul gasit",

          // Event during initialization
          onApply: function (e) {
            alert("Custom Event: " + e.selected);
          }
        });

    });

  </script>
<script>
    // Función para insertar la fecha en la tabla guardar_check
    function insertarDatos(id, columna) {
        // Crear un objeto FormData y agregar los datos necesarios
        var formData = new FormData();
        formData.append('id', id); // ID del elemento
        formData.append('columna', columna); // Nombre de la columna

        // Realizar la llamada AJAX
        $.ajax({
            type: "POST",
            url: "guardar_check.php", // Archivo PHP que maneja la inserción
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
            },
            error: function(xhr, status, error) {
                // Manejar errores
                //alert("Error al insertar la fecha: " + error);
            }
        });
    }

    function insertarFecha(id, columna) {
        // Llamar a la función insertarDatos pasando los parámetros correspondientes
        insertarDatos(id, columna);
    }

    function checkboxChange(id, columna, checked) {
    if (!checked) {
        // Si el checkbox se deselecciona, llama a la función para eliminar la fecha de la base de datos
        eliminarFecha(id, columna);
    } else {
        // Si el checkbox se selecciona, llama a la función para insertar la fecha en la base de datos
        insertarFecha(id, columna);
    }
}

function eliminarFecha(id, columna) {
    // Crear un objeto FormData y agregar los datos necesarios
    var formData = new FormData();
    formData.append('id', id); // ID del elemento
    formData.append('columna', columna); // Nombre de la columna

    // Realizar la llamada AJAX
    $.ajax({
        type: "POST",
        url: "eliminar_fecha.php", // Archivo PHP que maneja la eliminación
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            // Manejar la respuesta //linea 81 de js  
            // alert("La fecha se ha eliminado correctamente.");
            // Puedes realizar otras acciones después de la eliminación si es necesario
        },
        error: function(xhr, status, error) {
            // Manejar errores
            alert("Error al eliminar la fecha: " + error);
        }
    });
}
</script>

<script src="script_check.js"></script>

<script>  
function cargarFallas(identificador_elemento) {
    // Realizar la solicitud AJAX
    $.ajax({
        url: '<?php echo $_SERVER["PHP_SELF"]; ?>', // Utiliza el mismo archivo PHP
        type: 'POST',
        data: { obtener_fallas: true, identificador_elemento: identificador_elemento }, // Envía el identificador_elemento
        dataType: 'json',
        success: function(response) {
            // Limpiar el select
            $('#selectFalla').empty();

            // Agregar una opción por cada falla recibida
            $.each(response, function(index, falla) {
                $('#selectFalla').append('<option value="' + falla.id + '">' + falla.descripcion + '</option>');
            });
        },
        error: function(xhr, status, error) {
            console.error('Error al obtener las fallas:', error);
        }
    });
}

function openModalAndEnviarAlerta(id, nombreElemento, area, identificador_elemento) {
    document.getElementById("modalE").innerText = nombreElemento;
    document.getElementById("modalA").innerText = area;
    document.getElementById("modalI").innerText = identificador_elemento;

    // Aquí se pasa el identificador_elemento a la función cargarFallas()
    cargarFallas(identificador_elemento);

    $('#confirmBtn').off('click').on('click', function() {
        var selectedFallaID = $('#selectFalla').val();
        var selectedFallaDesc = $('#selectFalla option:selected').text();
        closeModal();
        enviarAlerta(id, nombreElemento, area, selectedFallaID, selectedFallaDesc);
    });

    openModal(nombreElemento, area, identificador_elemento);
}

function enviarAlerta(id, NameElemento, area, selectedFallaID, selectedFallaDesc) {
    // Realizar la solicitud AJAX para enviar la alerta y la falla seleccionada
    if (confirm('¿Estás seguro de enviar la alerta?')) {
        $.ajax({
            url: 'enviar_alerta.php',
            type: 'GET',
            data: {
                id: id,
                NameElemento: NameElemento,
                area: area,
                selectedFallaID: selectedFallaID,
                selectedFallaDesc: selectedFallaDesc
            },
            success: function(response) {
                document.getElementById("mensaje").innerHTML = response;
            },
            error: function(xhr, status, error) {
                console.error('Error al enviar la alerta:', error);
            }
        });
    }
}

function openModal(nombreElemento, area, identificador_elemento) {
    document.getElementById("myModal").style.display = "block";
    document.getElementById("modalE").innerText = nombreElemento;
    document.getElementById("modalA").innerText = area;
    document.getElementById("modalI").innerText = identificador_elemento;
    cargarFallas(); // Llama a la función para cargar las fallas cuando se abre el modal
}

function closeModal() {
    document.getElementById("myModal").style.display = "none";
}
</script>




<script>
   
// Obtener la fecha actual
var fechaActual = new Date();

// Obtener el año, mes y día en formato YYYY-MM-DD
var year = fechaActual.getFullYear();
var month = (fechaActual.getMonth() + 1).toString().padStart(2, '0'); // Agrega cero inicial si es necesario
var day = fechaActual.getDate().toString().padStart(2, '0'); // Agrega cero inicial si es necesario

// Formatear la fecha en formato YYYY-MM-DD
var fechaFormateada = year + '-' + month + '-' + day;

// Establecer el valor del campo de entrada de fecha
document.getElementById('fechaActualizada').value = fechaFormateada;
</script>

<script>
// Función para mostrar el cuadro emergente con los datos del elemento
function showPopup(id, nombreElemento, areas, identificador_elemento) {
    var popup = document.getElementById("popupModal");
    popup.style.display = "block";
    loadIssueOptions(identificador_elemento);

    document.getElementById('element-id').textContent = id;
    document.getElementById('element-name').textContent = nombreElemento;
    document.getElementById('element-areas').textContent = areas;
    document.getElementById('element-identificador').textContent = identificador_elemento;
}

// Ocultar el cuadro emergente
function hidePopup() {
    var popup = document.getElementById("popupModal");
    popup.style.display = "none";
}

// Cargar opciones dinámicas del select desde la base de datos
// Función para cargar las opciones de fallas y manejar el cambio de selección
function loadIssueOptions(identificador_elemento) {
    $.ajax({
        url: '<?php echo $_SERVER["PHP_SELF"]; ?>', // Utiliza el mismo archivo PHP
        type: 'POST',
        data: { obtener_fallas: true, identificador_elemento: identificador_elemento },
        dataType: 'json',
        success: function(response) {
            var select = $('#issue-select');
            select.empty();

            $.each(response, function(index, falla) {
                select.append('<option value="' + falla.id + '">' + falla.descripcion + '</option>');
            });

            // Manejar el cambio de selección
            select.on('change', function() {
                var selectedFallaID = $(this).val();
                var selectedFallaDesc = $(this).find('option:selected').text();
                // Puedes realizar aquí cualquier acción necesaria con la falla seleccionada
            });
        },
        error: function(xhr, status, error) {
            console.error('Error al obtener las fallas:', error);
        }
    });
}

// Manejar la carga de archivo desde el equipo
$('#file-upload').on('change', function(event) {
    var file = event.target.files[0];
    var reader = new FileReader();

    reader.onload = function(e) {
        var preview = $('#preview');
        preview.attr('src', e.target.result);
      
        preview.show();
    }

    reader.readAsDataURL(file);
});


// Enviar el formulario al hacer clic en el botón "Enviar"
$('#reportForm').on('submit', function(event) {
    event.preventDefault();

    var id = $('#element-id').text();
    var nombreElemento = $('#element-name').text();
    var areas = $('#element-areas').text();
    var identificador_elemento = $('#element-identificador').text();
    var issue = $('#issue-select').val();
    var selectedFallaDesc = $('#issue-select option:selected').text(); // Obtener la descripción de la falla seleccionada
    var files = $('#file-upload')[0].files;

    var formData = new FormData();
    formData.append('id', id);
    formData.append('nombreElemento', nombreElemento);
    formData.append('areas', areas);
    formData.append('issue', issue);
    formData.append('identificador_elemento', identificador_elemento);
    formData.append('selectedFallaDesc', selectedFallaDesc); // Agregar la descripción de la falla al FormData


    for (var i = 0; i < files.length; i++) {
        formData.append('foto[]', files[i]);
    }


    $.ajax({
                url: 'enviar_reporte.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    try {
                        var jsonResponse = JSON.parse(response);
                        if (jsonResponse.status === 'success') {
                            $('#successMessage').text(jsonResponse.message).show();
                        } else {
                            $('#successMessage').text(jsonResponse.message).show();
                        }
                        hidePopup(); // Cierra el modal
                    } catch (e) {
                        $('#successMessage').text('Error en la respuesta del servidor.').show();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al enviar el formulario:', error);
                }
            });

        
    });

    
</script>
<script>
let lastAlertAndReportIds = new Set();

function fetchAndShowAlerts() {
    fetch('get_alerts.php?accepted_today=true')
        .then(response => {
            if (!response.ok) {
                throw new Error(`No se pudo obtener la respuesta del servidor. Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Datos recibidos:', data); // Mostrar los datos recibidos en la consola

            if (data.error) {
                throw new Error(data.error);
            }

            const { alertas } = data;

            if (alertas.length > 0) {
                alertas.forEach(alert => {
                    if (!lastAlertAndReportIds.has(alert.id)) {
                        lastAlertAndReportIds.add(alert.id);
                        const mensaje = `La alerta del elemento "${alert.elemento}" en el área "${alert.area}", con la falla "${alert.falla}", ha sido aceptada para su revisión.`;
                        showNotification(mensaje, 'info');
                    }
                });
            } else {
                // Mostrar mensaje en consola y notificación de no hay alertas aceptadas hoy
                console.log('No hay alertas aceptadas hoy para mostrar.');
                showNotification('No hay alertas aceptadas hoy para mostrar', 'info');
            }
        })
        .catch(error => {
            console.error('Error al obtener las alertas aceptadas hoy del servidor:', error);
            showNotification('Error al obtener las alertas aceptadas hoy del servidor.', 'error');
        });
}

function showNotification(message, type) {
    const icon = type === 'error' ? '⚠️' : 'ℹ️';

    const notification = document.createElement('div');
    notification.classList.add('notification', type);
    notification.innerHTML = `
        <span class="close-btn" onclick="closeNotification(this)">&times;</span>
        <div>${icon} ${message}</div>
    `;

    const container = document.getElementById('notification-container');
    container.appendChild(notification);

    setTimeout(function () {
        notification.classList.add('show');
    }, 100);

    setTimeout(function () {
        closeNotification(notification.querySelector('.close-btn'));
    }, 5000);
}

function closeNotification(element) {
    const notification = element.parentElement;
    notification.classList.remove('show');
    setTimeout(function () {
        notification.remove();
    }, 300);
}

function debounce(func, wait) {
    let timeout;
    return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}

document.addEventListener('DOMContentLoaded', function () {
    fetchAndShowAlerts();
});

setInterval(debounce(fetchAndShowAlerts, 500), 180000);
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Obtener referencia al botón "Enviar Reporte"
    const enviarReporteBtn = document.getElementById('enviarReporteBtn');
    
    // Escuchar clic en el botón "Enviar Reporte"
    enviarReporteBtn.addEventListener('click', function() {
        // Establecer el valor del campo oculto "accion"
        document.getElementById('accion').value = 'enviar';
        
        // Enviar el formulario
        document.getElementById('verReporteForm').submit();
    });
});
</script>

<script>
document.getElementById("verHistorialBtn").addEventListener("click", function() {
    // Enviar solicitud AJAX para obtener el historial
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "historial.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Procesar la respuesta y mostrar el historial
            var historial = JSON.parse(xhr.responseText);
            var historialContainer = document.getElementById("historialContainer");

            // Limpiar cualquier contenido previo
            historialContainer.innerHTML = "";

            // Verificar si hay datos
            if (historial.length > 0) {
                var table = document.createElement("table");
                var header = table.insertRow();
                header.innerHTML = "<th>ID Elemento</th><th>Nombre del Elemento</th><th>Área</th><th>Identificador del Elemento</th>";

                // Iterar sobre los datos y crear filas para la tabla
                historial.forEach(function(item) {
                    var row = table.insertRow();
                    row.innerHTML = "<td>" + item.elemento_id + "</td><td>" + item.NameElemento + "</td><td>" + item.areas + "</td><td>" + item.identificador_elemento + "</td>";
                });

                historialContainer.appendChild(table);
            } else {
                historialContainer.innerHTML = "No hay historial disponible.";
            }
        }
    };
    xhr.send("accion=ver_historial");
});
</script>

</body>
</html>
