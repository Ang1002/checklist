<?php
// Incluir archivo de conexión
include 'conexion.php';

// Conectar a la base de datos
$conn = connectDB();

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Inicializar la variable para el área seleccionada
$selected_area = isset($_POST['Areas']) ? $_POST['Areas'] : 'todas';

// Consulta SQL para obtener áreas únicas
$sql_areas = "SELECT DISTINCT areas FROM elementos ORDER BY areas";
$resultado_areas = $conn->query($sql_areas);

// Consulta SQL para obtener elementos según el área seleccionada
if ($selected_area == 'todas') {
    $sql_elementos = "SELECT identificador_elemento, name_identificador FROM elementos ORDER BY name_identificador";
    $resultado_elementos = $conn->query($sql_elementos);
} else {
    $sql_elementos = "SELECT identificador_elemento, name_identificador FROM elementos WHERE areas = ? ORDER BY name_identificador";
    $stmt_elementos = $conn->prepare($sql_elementos);
    $stmt_elementos->bind_param("s", $selected_area);
    $stmt_elementos->execute();
    $resultado_elementos = $stmt_elementos->get_result();
}

// Consulta SQL principal para mostrar los elementos y sus fallas
$sql = "SELECT e.id, e.areas, e.NameElemento, e.identificador_elemento,
f1.id AS Falla1_id, f1.descripcion AS Falla1_desc, f1.identificador_caract AS Falla1_identificador_caract,
f2.id AS Falla2_id, f2.descripcion AS Falla2_desc, f2.identificador_caract AS Falla2_identificador_caract,
f3.id AS Falla3_id, f3.descripcion AS Falla3_desc, f3.identificador_caract AS Falla3_identificador_caract,
f4.id AS Falla4_id, f4.descripcion AS Falla4_desc, f4.identificador_caract AS Falla4_identificador_caract,
f5.id AS Falla5_id, f5.descripcion AS Falla5_desc, f5.identificador_caract AS Falla5_identificador_caract,
f6.id AS Falla6_id, f6.descripcion AS Falla6_desc, f6.identificador_caract AS Falla6_identificador_caract,
f7.id AS Falla7_id, f7.descripcion AS Falla7_desc, f7.identificador_caract AS Falla7_identificador_caract,
f8.id AS Falla8_id, f8.descripcion AS Falla8_desc, f8.identificador_caract AS Falla8_identificador_caract,
gc.caracteristica1,
gc.caracteristica2,
gc.caracteristica3,
gc.caracteristica4,
gc.caracteristica5,
gc.caracteristica6,
gc.caracteristica7,
gc.caracteristica8
FROM elementos e
LEFT JOIN fallas f1 ON e.Falla1 = f1.id
LEFT JOIN fallas f2 ON e.Falla2 = f2.id
LEFT JOIN fallas f3 ON e.Falla3 = f3.id
LEFT JOIN fallas f4 ON e.Falla4 = f4.id
LEFT JOIN fallas f5 ON e.Falla5 = f5.id
LEFT JOIN fallas f6 ON e.Falla6 = f6.id
LEFT JOIN fallas f7 ON e.Falla7 = f7.id
LEFT JOIN fallas f8 ON e.Falla8 = f8.id
LEFT JOIN guardar_check gc ON e.id = gc.elemento_id
WHERE ";

// Añadimos la condición para filtrar por área si no son todas las áreas
if ($selected_area == 'todas') {
    $sql .= "1"; // No se agrega ninguna condición adicional
} else {
    $sql .= "e.areas = ?";
}

// Si se seleccionó un elemento específico, ajustar la consulta
if (isset($_POST['Elementos']) && $_POST['Elementos'] != 'todas') {
    $elemento_seleccionado = $_POST['Elementos'];
    $sql .= " AND e.identificador_elemento = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $selected_area, $elemento_seleccionado);
    $stmt->execute();
    $resultado = $stmt->get_result();
} else {
    $stmt = $conn->prepare($sql);
    if ($selected_area != 'todas') {
        $stmt->bind_param("s", $selected_area);
    }
    $stmt->execute();
    $resultado = $stmt->get_result();
}

// Verificar si se recibió una solicitud AJAX para obtener las fallas
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["obtener_fallas"])) {
    // Código para obtener las fallas
}

// Verificar si se recibió una solicitud AJAX para actualizar el elemento
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["actualizar_elemento"])) {
    // Código para actualizar el elemento
}




// Verificar si se recibió una solicitud AJAX para obtener las fallas
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["obtener_fallas"])) {
    // Consulta SQL para obtener las fallas
    $identificador_elemento = $_POST["identificador_elemento"];

    // Consulta SQL para obtener las fallas filtradas por el identificador_elemento
    $sql_fallas = "SELECT id, falla_id, fallaname , identificador_caract ,  identificador_elemento FROM check_fallas WHERE identificador_elemento = ?";
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
                'fallaname' => $row['fallaname'],
                'identificador_elemento' => $row['identificador_elemento'], 
                'identificador_caract' =>  $row['identificador_caract']);
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
    $fallas = $_POST['fallas'];  // Array de IDs de fallas seleccionadas

    // Actualizar la tabla `elementos` con las fallas seleccionadas
    // Esto es un ejemplo básico, debes adaptarlo según la estructura de tu base de datos
    $sql_update = "UPDATE elementos SET Falla1 = ?, Falla2 = ?, Falla3 = ?, Falla4 = ?, Falla5 = ?, Falla6 = ?, Falla7 = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("iiiiiiii", $fallas[0], $fallas[1], $fallas[2], $fallas[3], $fallas[4], $fallas[5], $fallas[6], $id_elemento);

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
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="Style_Check.css">
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
/* Estilos para el modal */
.modal {
    display: none; /* Ocultar el modal por defecto */
    position: fixed; /* Posición fija */
    z-index: 1; /* Hacer que el modal esté encima de todo */
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto; /* Habilitar el desplazamiento si el contenido es demasiado largo */
    background-color: rgb(0,0,0); /* Fondo negro semitransparente */
    background-color: rgba(0,0,0,0.4); /* Fondo negro semitransparente */
    padding-top: 60px; /* Espaciado superior para la barra de navegación */
}

/* Estilos para el contenido del modal */
.modal-content {
    background-color: #fefefe;
    margin: 5% auto; /* Centrar el modal verticalmente */
    padding: 15px;
    border: 1px solid #888;
    width: 60%; /* Anchura del modal */
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
    

    /* Estilo para el modal de alerta aceptada */
.alerta-aceptada-modal {
    display: none; /* Oculto por defecto */
    position: fixed; /* Fijo al viewport */
    z-index: 1; /* Encima de otros contenidos */
    left: 0;
    top: 0;
    width: 100%; /* Ancho completo */
    height: 100%; /* Alto completo */
    overflow: auto; /* Agregar scroll si es necesario */
    background-color: rgb(0,0,0); /* Color de fondo */
    background-color: rgba(0,0,0,0.4); /* Color de fondo con opacidad */
}

/* Estilo para el modal de alerta aceptada */
.modal-alerta-aceptada {
    display: none; /* Oculto por defecto */
    position: fixed;
    z-index: 1000; /* Alto valor para asegurarse de que esté encima de otros elementos */
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.5); /* Asegurar que el fondo sea semi-transparente */
}

/* Estilo para el contenido del modal de alerta aceptada */
.modal-alerta-aceptada-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    border-radius: 10px;
}

/* Estilo para el botón de cerrar */
.cerrar-modal-alerta-aceptada {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.cerrar-modal-alerta-aceptada:hover,
.cerrar-modal-alerta-aceptada:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
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

<center>
    <div class="col-md-12 text-center">
        <h3 class="animate-charcter">Checklist</h3>

    </div>
</center>
<?php
// Definir la variable $currentDate con la fecha actual
$currentDate = date("Y-m-d"); // Formato YYYY-MM-DD

?>
<center>
<div class="img-container" style="float: left;">
<p class="calendar"> <?php echo date('W'); ?><em>Semana</em></p>

</div>

<div class="img-container" style="float: right;"><br><br>
<input type="date" id="fechaActualizada" style="border: 1px solid #ccc; border-radius: 4px;">
<br>

   
<!-- Botón para mostrar notificación -->
<div id="notification-btn">🔔</div>

<!-- Botón para mostrar notificación (invisible) -->
<button id="btnShowNotification" style="display: none;">Mostrar Notificación</button>
</div>


<center>

<!-- Select de Áreas -->
<div class="container">
    <h3>Selecciona el área</h3>
    <form id="form_areas" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <select name="Areas" onchange="document.getElementById('form_areas').submit()">
            <option value="todas" <?php echo $selected_area == 'todas' ? 'selected' : ''; ?>>Todas las Áreas</option>
            <?php
            if ($resultado_areas->num_rows > 0) {
                while ($fila_area = $resultado_areas->fetch_assoc()) {
                    $area = $fila_area['areas'];
                    $selected = $area == $selected_area ? 'selected' : '';
                    echo "<option value='$area' $selected>$area</option>";
                }
            } else {
                echo "<option value='' disabled>No se encontraron áreas</option>";
            }
            ?>
        </select>
    </form>
</div> 
<br>
<div class="container">
    <form id="form_elementos" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <select name="Elementos" onchange="this.form.submit()">
            <option value="todas">Todos los Elementos</option>
            <?php
            $tipos_elementos = array();
            if ($resultado_elementos->num_rows > 0) {
                while ($fila_elementos = $resultado_elementos->fetch_assoc()) {
                    $name_identificador = $fila_elementos['name_identificador'];
                    $identificador_elemento = $fila_elementos['identificador_elemento'];
                    $selected = isset($_POST['Elementos']) && $_POST['Elementos'] == $identificador_elemento ? 'selected' : '';

                    // Agrupar por tipo de elemento
                    if (!isset($tipos_elementos[$selected_area])) {
                        $tipos_elementos[$selected_area] = array();
                    }

                    // Verificar si el elemento ya ha sido agregado al grupo
                    $elemento_agregado = false;
                    foreach ($tipos_elementos[$selected_area] as $elemento) {
                        if ($elemento['identificador'] == $identificador_elemento) {
                            $elemento_agregado = true;
                            break;
                        }
                    }

                    // Si no ha sido agregado, lo agregamos
                    if (!$elemento_agregado) {
                        $tipos_elementos[$selected_area][] = array(
                            'identificador' => $identificador_elemento,
                            'nombre' => $name_identificador,
                            'selected' => $selected,
                        );
                    }
                }

                // Mostrar opciones agrupadas
                foreach ($tipos_elementos as $area => $elementos) {
                    echo "<optgroup label='$area'>";
                    foreach ($elementos as $elemento) {
                        echo "<option value='{$elemento['identificador']}' {$elemento['selected']}>{$elemento['nombre']}</option>";
                    }
                    echo "</optgroup>";
                }
            } else {
                echo "<option value='' disabled>No se encontraron elementos</option>";
            }
            ?>
        </select>
        <input type="hidden" name="Areas" value="<?php echo $selected_area; ?>">
    </form>
</div>


    <!---Select Areas------>
    <!--<div class="container">
    <h3>Selecciona el área</h3>
    <form id="form_areas" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <select name="Areas" onchange="this.form.submit()">
            <option value="todas" <?php echo $selected_area == 'todas' ? 'selected' : ''; ?>>Todas las Áreas</option>
            <?php
            if ($resultado_areas->num_rows > 0) {
                while ($fila_area = $resultado_areas->fetch_assoc()) {
                    $area = $fila_area['areas'];
                    $selected = $area == $selected_area ? 'selected' : '';
                    echo "<option value='$area' $selected>$area</option>";
                }
            } else {
                echo "<option value='' disabled>No se encontraron áreas</option>";
            }
            ?>
        </select>
    </form>
</div>-->

<br>
     <!-- Select de Elementos -->
     <!--<div class="container">
    <form id="form_elementos" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <select name="Elementos" onchange="this.form.submit()">
            <option value="todas">Todos los Elementos</option>
            <?php
            $tipos_elementos = array();
            if ($resultado_elementos->num_rows > 0) {
                while ($fila_elementos = $resultado_elementos->fetch_assoc()) {
                    $name_identificador = $fila_elementos['name_identificador'];
                    $identificador_elemento = $fila_elementos['identificador_elemento'];
                    $selected = isset($_POST['Elementos']) && $_POST['Elementos'] == $identificador_elemento ? 'selected' : '';

                    // Agrupar por tipo de elemento
                    if (!isset($tipos_elementos[$selected_area])) {
                        $tipos_elementos[$selected_area] = array();
                    }

                    // Verificar si el elemento ya ha sido agregado al grupo
                    $elemento_agregado = false;
                    foreach ($tipos_elementos[$selected_area] as $elemento) {
                        if ($elemento['identificador'] == $identificador_elemento) {
                            $elemento_agregado = true;
                            break;
                        }
                    }

                    // Si no ha sido agregado, lo agregamos
                    if (!$elemento_agregado) {
                        $tipos_elementos[$selected_area][] = array(
                            'identificador' => $identificador_elemento,
                            'nombre' => $name_identificador,
                            'selected' => $selected,
                        );
                    }
                }

                // Mostrar opciones agrupadas
                foreach ($tipos_elementos as $area => $elementos) {
                    echo "<optgroup label='$area'>";
                    foreach ($elementos as $elemento) {
                        echo "<option value='{$elemento['identificador']}' {$elemento['selected']}>{$elemento['nombre']}</option>";
                    }
                    echo "</optgroup>";
                }
            } else {
                echo "<option value='' disabled>No se encontraron elementos</option>";
            }
            ?>
        </select>
        <input type="hidden" name="Areas" value="<?php echo $selected_area; ?>">
    </form>
</div>-->




<!-- Select de Áreas -->
<!--<div class="container" >
    <h3>Selecciona el área</h3>
    <form id="form_areas" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <select name="Areas" onchange="this.form.submit()">
            <option value="todas" <?php echo $selected_area == 'todas' ? 'selected' : ''; ?>>Todas las Áreas</option>
            <?php
            if ($resultado_areas->num_rows > 0) {
                while ($fila_area = $resultado_areas->fetch_assoc()) {
                    $area = $fila_area['areas'];
                    $selected = $area == $selected_area ? 'selected' : '';
                    echo "<option value='$area' $selected>$area</option>";
                }
            } else {
                echo "<option value='' disabled>No se encontraron áreas</option>";
            }
            ?>
        </select>
    </form>
</div>-->

<!--Nuevo div para los elementos  --->

<br>
    
<!-- Select de Elementos -->
<!--<div class="container">
    <form id="form_elementos" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <select name="Elementos">
            <option value="todas">Todos los Elementos</option>
            <?php
            if ($resultado_elementos->num_rows > 0) {
                while ($fila_elementos = $resultado_elementos->fetch_assoc()) {
                    $name_identificador = $fila_elementos['name_identificador'];
                    $identificador_elemento = $fila_elementos['identificador_elemento'];
                    echo "<option value='$identificador_elemento'>$name_identificador</option>";
                }
            } else {
                echo "<option value='' disabled>No se encontraron elementos</option>";
            }
            ?>
        </select>
        <input type="hidden" name="selected_area" value="<?php echo $selected_area; ?>">
        
    </form>
</div>-->



</center>

<script>
    // Manejo del envío de formularios para evitar conflictos
    document.getElementById('form_areas').addEventListener('submit', function(event) {
       
        event.preventDefault();  // Evitar el envío del formulario por defecto
        this.submit();  // Enviar el formulario
    });

    document.getElementById('form_elementos').addEventListener('submit', function(event) {
        
        event.preventDefault();  // Evitar el envío del formulario por defecto
        this.submit();  // Enviar el formulario
    });
</script>



        <!--- Nueva tabla para manejar áreas ------>
      <!-- <div class="container">
            <h3>Seleccionar Área</h3>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <select name="Areas">
                    <option value="todas">Todas las Áreas</option>
                    <?php
                    // Inicializar un array para almacenar las áreas ya mostradas
                    $areas_mostradas = array();

                    // Mostrar las áreas únicas en el menú desplegable
                    if ($resultado_areas->num_rows > 0) {
                        while ($fila_area = $resultado_areas->fetch_assoc()) {
                            $area = $fila_area['areas'];
                            // Verificar si el área ya ha sido mostrada
                            if (!in_array($area, $areas_mostradas)) {
                                // Agregar el área al menú desplegable
                                echo "<option value='$area'>$area</option>";
                                // Agregar el área al array de áreas mostradas
                                $areas_mostradas[] = $area;
                            }
                        }
                    }
                    ?>
                </select>
                <input type="submit" value="Aplicar" />
            </form>
        </div>-->

<br>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
  

        <table id="miTabla">
            <thead>
            <tr>
                <!--<th>Date </th>
                <th>ID</th>-->
                <th>Area </th>
                <th>Elemento</th>
                <th colspan="7">Características</th>
                <!--<th>Semana Actual</th>-->
                <th>Alerta</th>
                <th>Reportar</th>
            </tr>
            </thead>
            <tbody>

            <?php
            if ($resultado->num_rows > 0) {
                while ($fila = $resultado->fetch_assoc()) {
                    ?>

                    <tr>
                        <!-- Aquí se muestran los datos de cada fila -->
                        <!--<td class="fecha-hora" id="fechaHora"></td>-->
                        <!--<td><?php echo $fila['id']; ?></td>-->

                        <td><?php echo $fila['areas']; ?></td>
                        <td><?php echo $fila['NameElemento']; ?></td>
                        <!-- Añade tus campos de checkbox con la verificación de si deben estar marcados -->

                        <td>
    <?php if (!empty($fila['Falla1_desc'])): ?>
        <input type="checkbox" name="caracteristica1[]" value="<?php echo $fila['id']; ?>" 
            data-identificador-caract="<?php echo $fila['Falla1_identificador_caract']; ?>"
            <?php echo ($fila['caracteristica1'] != null) ? 'checked' : ''; ?>
            onchange="checkboxChange(<?php echo $fila['id']; ?>, 'caracteristica1', this.checked, this);">
        <?php echo $fila['Falla1_desc']; ?>
        <input type="hidden" name="fecha_caracteristica1[]" value="<?php echo $fila['caracteristica1']; ?>">
    <?php endif; ?>
</td>

<td>
    <?php if (!empty($fila['Falla2_desc'])): ?>
        <input type="checkbox" name="caracteristica2[]" value="<?php echo $fila['id']; ?>" 
            data-identificador-caract="<?php echo $fila['Falla2_identificador_caract']; ?>"
            <?php echo ($fila['caracteristica2'] != null) ? 'checked' : ''; ?>
            onchange="checkboxChange(<?php echo $fila['id']; ?>, 'caracteristica2', this.checked, this);">
        <?php echo $fila['Falla2_desc']; ?>
        <input type="hidden" name="fecha_caracteristica2[]" value="<?php echo $fila['caracteristica2']; ?>">
    <?php endif; ?>
</td>

<td>
    <?php if (!empty($fila['Falla3_desc'])): ?>
        <input type="checkbox" name="caracteristica3[]" value="<?php echo $fila['id']; ?>" 
            data-identificador-caract="<?php echo $fila['Falla3_identificador_caract']; ?>"
            <?php echo ($fila['caracteristica3'] != null) ? 'checked' : ''; ?>
            onchange="checkboxChange(<?php echo $fila['id']; ?>, 'caracteristica3', this.checked, this);">
        <?php echo $fila['Falla3_desc']; ?>
        <input type="hidden" name="fecha_caracteristica3[]" value="<?php echo $fila['caracteristica3']; ?>">
    <?php endif; ?>
</td>

<td>
    <?php if (!empty($fila['Falla4_desc'])): ?>
        <input type="checkbox" name="caracteristica4[]" value="<?php echo $fila['id']; ?>" 
            data-identificador-caract="<?php echo $fila['Falla4_identificador_caract']; ?>"
            <?php echo ($fila['caracteristica4'] != null) ? 'checked' : ''; ?>
            onchange="checkboxChange(<?php echo $fila['id']; ?>, 'caracteristica4', this.checked, this);">
        <?php echo $fila['Falla4_desc']; ?>
        <input type="hidden" name="fecha_caracteristica4[]" value="<?php echo $fila['caracteristica4']; ?>">
    <?php endif; ?>
</td>

<td>
    <?php if (!empty($fila['Falla5_desc'])): ?>
        <input type="checkbox" name="caracteristica5[]" value="<?php echo $fila['id']; ?>" 
            data-identificador-caract="<?php echo $fila['Falla5_identificador_caract']; ?>"
            <?php echo ($fila['caracteristica5'] != null) ? 'checked' : ''; ?>
            onchange="checkboxChange(<?php echo $fila['id']; ?>, 'caracteristica5', this.checked, this);">
        <?php echo $fila['Falla5_desc']; ?>
        <input type="hidden" name="fecha_caracteristica5[]" value="<?php echo $fila['caracteristica5']; ?>">
    <?php endif; ?>
</td>

<td>
    <?php if (!empty($fila['Falla6_desc'])): ?>
        <input type="checkbox" name="caracteristica6[]" value="<?php echo $fila['id']; ?>" 
            data-identificador-caract="<?php echo $fila['Falla6_identificador_caract']; ?>"
            <?php echo ($fila['caracteristica6'] != null) ? 'checked' : ''; ?>
            onchange="checkboxChange(<?php echo $fila['id']; ?>, 'caracteristica6', this.checked, this);">
        <?php echo $fila['Falla6_desc']; ?>
        <input type="hidden" name="fecha_caracteristica6[]" value="<?php echo $fila['caracteristica6']; ?>">
    <?php endif; ?>
</td>

<td>
    <?php if (!empty($fila['Falla7_desc'])): ?>
        <input type="checkbox" name="caracteristica7[]" value="<?php echo $fila['id']; ?>" 
            data-identificador-caract="<?php echo $fila['Falla7_identificador_caract']; ?>"
            <?php echo ($fila['caracteristica7'] != null) ? 'checked' : ''; ?>
            onchange="checkboxChange(<?php echo $fila['id']; ?>, 'caracteristica7', this.checked, this);">
        <?php echo $fila['Falla7_desc']; ?>
        <input type="hidden" name="fecha_caracteristica7[]" value="<?php echo $fila['caracteristica7']; ?>">
    <?php endif; ?>
</td>


                      <!--<td>
    <?php if (!empty($fila['Falla1_desc'])): ?>
        <input type="checkbox" name="caracteristica1[]" value="<?php echo $fila['id']; ?>" <?php echo ($fila['caracteristica1'] != null) ? 'checked' : ''; ?> onchange="checkboxChange(<?php echo $fila['id']; ?>, 'caracteristica1', this.checked);">
        <?php echo $fila['Falla1_desc']; ?>
        <input type="hidden" name="fecha_caracteristica1[]" value="<?php echo $fila['caracteristica1']; ?>">
    <?php endif; ?>
</td>

<td>
    <?php if (!empty($fila['Falla2_desc'])): ?>
        <input type="checkbox" name="caracteristica2[]" value="<?php echo $fila['id']; ?>" <?php echo ($fila['caracteristica2'] != null) ? 'checked' : ''; ?> onchange="checkboxChange(<?php echo $fila['id']; ?>, 'caracteristica2', this.checked);">
        <?php echo $fila['Falla2_desc']; ?>
        <input type="hidden" name="fecha_caracteristica2[]" value="<?php echo $fila['caracteristica2']; ?>">
    <?php endif; ?>
</td>

<td>
    <?php if (!empty($fila['Falla3_desc'])): ?>
        <input type="checkbox" name="caracteristica3[]" value="<?php echo $fila['id']; ?>" <?php echo ($fila['caracteristica3'] != null) ? 'checked' : ''; ?> onchange="checkboxChange(<?php echo $fila['id']; ?>, 'caracteristica3', this.checked);">
        <?php echo $fila['Falla3_desc']; ?>
        <input type="hidden" name="fecha_caracteristica3[]" value="<?php echo $fila['caracteristica3']; ?>">
    <?php endif; ?>
</td>

<td>
    <?php if (!empty($fila['Falla4_desc'])): ?>
        <input type="checkbox" name="caracteristica4[]" value="<?php echo $fila['id']; ?>" <?php echo ($fila['caracteristica4'] != null) ? 'checked' : ''; ?> onchange="checkboxChange(<?php echo $fila['id']; ?>, 'caracteristica4', this.checked);">
        <?php echo $fila['Falla4_desc']; ?>
        <input type="hidden" name="fecha_caracteristica4[]" value="<?php echo $fila['caracteristica4']; ?>">
    <?php endif; ?>
</td>
<td>
    <?php if (!empty($fila['Falla5_desc'])): ?>
        <input type="checkbox" name="caracteristica5[]" value="<?php echo $fila['id']; ?>" <?php echo ($fila['caracteristica5'] != null) ? 'checked' : ''; ?> onchange="checkboxChange(<?php echo $fila['id']; ?>, 'caracteristica5', this.checked);">
        <?php echo $fila['Falla5_desc']; ?>
        <input type="hidden" name="fecha_caracteristica5[]" value="<?php echo $fila['caracteristica5']; ?>">
    <?php endif; ?>
</td>


<td>
    <?php if (!empty($fila['Falla6_desc'])): ?>
        <input type="checkbox" name="caracteristica6[]" value="<?php echo $fila['id']; ?>" <?php echo ($fila['caracteristica6'] != null) ? 'checked' : ''; ?> onchange="checkboxChange(<?php echo $fila['id']; ?>, 'caracteristica6', this.checked);">
        <?php echo $fila['Falla6_desc']; ?>
        <input type="hidden" name="fecha_caracteristica6[]" value="<?php echo $fila['caracteristica6']; ?>">
    <?php endif; ?>
</td>


<td>
    <?php if (!empty($fila['Falla7_desc'])): ?>
        <input type="checkbox" name="caracteristica7[]" value="<?php echo $fila['id']; ?>" <?php echo ($fila['caracteristica7'] != null) ? 'checked' : ''; ?> onchange="checkboxChange(<?php echo $fila['id']; ?>, 'caracteristica7', this.checked);">
        <?php echo $fila['Falla7_desc']; ?>
        <input type="hidden" name="fecha_caracteristica6[]" value="<?php echo $fila['caracteristica7']; ?>">
    <?php endif; ?>
</td>-->


<!--<td>
    <?php if (!empty($fila['Falla8_desc'])): ?>
        <input type="checkbox" name="caracteristica8[]" value="<?php echo $fila['id']; ?>" <?php echo ($fila['caracteristica8'] != null) ? 'checked' : ''; ?> onchange="checkboxChange(<?php echo $fila['id']; ?>, 'caracteristica8', this.checked);">
        <?php echo $fila['Falla8_desc']; ?>
        <input type="hidden" name="fecha_caracteristica8[]" value="<?php echo $fila['caracteristica8']; ?>">
    <?php endif; ?>
</td>
<td>
    <?php if (!empty($fila['Falla9_desc'])): ?>
        <input type="checkbox" name="caracteristica5[]" value="<?php echo $fila['id']; ?>" <?php echo ($fila['caracteristica9'] != null) ? 'checked' : ''; ?> onchange="checkboxChange(<?php echo $fila['id']; ?>, 'caracteristica9', this.checked);">
        <?php echo $fila['Falla9_desc']; ?>
        <input type="hidden" name="fecha_caracteristica9[]" value="<?php echo $fila['caracteristica9']; ?>">
    <?php endif; ?>
</td>


<td>
    <?php if (!empty($fila['Falla10_desc'])): ?>
        <input type="checkbox" name="caracteristica10[]" value="<?php echo $fila['id']; ?>" <?php echo ($fila['caracteristica10'] != null) ? 'checked' : ''; ?> onchange="checkboxChange(<?php echo $fila['id']; ?>, 'caracteristica10', this.checked);">
        <?php echo $fila['Falla10_desc']; ?>
        <input type="hidden" name="fecha_caracteristica10[]" value="<?php echo $fila['caracteristica10']; ?>">
    <?php endif; ?>
</td>


<td>
    <?php if (!empty($fila['Falla11_desc'])): ?>
        <input type="checkbox" name="caracteristica7[]" value="<?php echo $fila['id']; ?>" <?php echo ($fila['caracteristica11'] != null) ? 'checked' : ''; ?> onchange="checkboxChange(<?php echo $fila['id']; ?>, 'caracteristica11', this.checked);">
        <?php echo $fila['Falla11_desc']; ?>
        <input type="hidden" name="fecha_caracteristica11[]" value="<?php echo $fila['caracteristica11']; ?>">
    <?php endif; ?>
</td>-->

<!--<td>
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
   
</td>-->
<td>
    <a style="background-color:#6e0b0b; /* Rojo */
              border: none;
              color: white;
              padding: 10px 22px;
              text-align: center;
              text-decoration: none;
              display: inline-block;
              font-size: 16px;
              margin: 4px 2px;
              cursor: pointer;
              border-radius: 10px;" 
       href="#" class="button" 
       onclick="openModalAndEnviarAlerta(<?php echo $fila['id']; ?>, '<?php echo $fila['NameElemento']; ?>', '<?php echo $fila['areas']; ?>', '<?php echo $fila['identificador_elemento']; ?>');">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
            <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.15.15 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.2.2 0 0 1-.054.06.1.1 0 0 1-.066.017H1.146a.1.1 0 0 1-.066-.017.2.2 0 0 1-.054-.06.18.18 0 0 1 .002-.183L7.884 2.073a.15.15 0 0 1 .054-.057m1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767z"/>
            <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z"/>
        </svg> Alerta
    </a>
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

                    <?php
                }
            } else {
                echo "0 resultados";
            }
            $conn->close();
            ?>

            </tbody>
        </table>
    </form>

    <div class="notification-container" id="notification-container">
        <!-- Aquí se insertarán las notificaciones dinámicamente -->
    </div>

<!-- Modal -->
<div id="myModal" class="modal">
    <div class="modal-content">
        
    <div class="modal-header"></div>

        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Selecciona una falla:</h2>


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

<!-- Modal de Alerta Aceptada -->
<!---<div id="alertaAceptadaModal" class="modal-alerta">
    <div class="modal-alerta-content">
        <span class="close-alerta" onclick="closeAlertaAceptadaModal()">&times;</span>
        <h2>Alerta ya aceptada</h2>
        <p>Esta alerta ya ha sido aceptada y no se puede enviar nuevamente.</p>
    </div>
</div>

<!-Nuevo modal para el reporte con foto --->

<!--<div id="popupModal" class="popup">
    <div class="popup-content">
    <div class="modal-header"></div>
        <span class="close-btn" onclick="hidePopup()">&times;</span>
        <h2>Enviar evidencia</h2>
        
        <form id="reportForm" enctype="multipart/form-data">
          
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
          
        </center>
           <br>
           <br>
<center>
           <button type="submit" onclick="alert('Mensaje enviado exitosamente!'); hidePopup();">Enviar</button>


            <div id="successMessage" style="display: none;">Reporte enviado con éxito.</div>
     
            </center>

        </form>

    </div>
    
</div>-->

<div id="popupModal" class="popup">
    <div class="popup-content">
        <div class="modal-header"></div>
        <span class="close-btn" onclick="hidePopup()">&times;</span>
        <h2>Enviar evidencia</h2>
        
        <form id="reportForm" enctype="multipart/form-data">
            <!-- Mostrar información del elemento -->
            <p>
                <span id="element-id" class="transparent"></span>
                <span id="element-name"></span> de <span id="element-areas"></span>
                <span id="element-identificador" class="transparent"></span>
            </p>

            <label for="issue-select">Seleccione la incidencia que quiere reportar en su evidencia:</label>
            <center>
                <select id="issue-select" name="issue-select"></select>
            </center>

            <center>
                <label for="file-upload" class="transparent">Subir imagen desde tu equipo:</label>
                <p>Agregar Fotos: 
                <input type="file" id="file-upload" accept="image/*" multiple onchange="handleFileSelect(event)">
                
                <div id="preview-container"></div>
            </center>

            <br><br>
            <center>
                <button type="submit" onclick="alert('¡Mensaje enviado exitosamente!'); hidePopup();">Enviar</button>
                <div id="successMessage" style="display: none;">Reporte enviado con éxito.</div>
            </center>
        </form>
    </div>
</div>

<br>
<br>
<br>
<br>

<center>
<div style="display: inline-block;" class="inline-forms" >
    <form id="verReporteForm" action="view_reporte.php" method="GET">
        <button style="background-color:#6e0b0b; /* Rojo*/
          border: none;
          color: white;
          padding: 10px 50px;
          text-align: center;
          text-decoration: none;
          display: inline-block;
          font-size: 16px;
          margin: 4px 2px;
          cursor: pointer;
          border-radius: 10px;" type="submit" class="button" name="reportarTodo">Ver Reporte</button>
    </form>

    <!-- Formulario para enviar el reporte -->
    <form action="reporte_final.php" method="post">
        <button style="background-color:#6e0b0b; /* Rojo*/
          border: none;
          color: white;
          padding: 10px 50px;
          text-align: center;
          text-decoration: none;
          display: inline-block;
          font-size: 16px;
          margin: 4px 2px;
          cursor: pointer;
          border-radius: 10px;" type="submit" name="reportarTodo">Enviar Reporte</button>
    </form>
</div>



  </center>
<br>
<!--<button class="button" onclick="location.href='generar_pdf.php'">Descargar PDF</button>-->
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
function cargarFallas(identificador_elemento , identificador_caract) {
    // Realizar la solicitud AJAX
    $.ajax({
        url: '<?php echo $_SERVER["PHP_SELF"]; ?>', // Utiliza el mismo archivo PHP
        type: 'POST',
        data: { obtener_fallas: true, identificador_elemento: identificador_elemento, identificador_caract: identificador_caract }, // Envía el identificador_elemento con el de caracteristicas
        dataType: 'json',
        success: function(response) {
            // Limpiar el select
            $('#selectFalla').empty();

            // Agregar una opción por cada falla recibida
            $.each(response, function(index, falla) {
                $('#selectFalla').append('<option value="' + falla.id + '">' + falla.fallaname + '</option>');
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

// Función para abrir el modal de advertencia (alerta aceptada)
function abrirModalAlertaAceptada() {
    document.getElementById('alertaAceptadaModal').style.display = 'block';
}

// Función para cerrar el modal de advertencia (alerta aceptada)
function closeAlertaAceptadaModal() {
    document.getElementById('alertaAceptadaModal').style.display = 'none';
}


function enviarAlerta(id, NameElemento, area, selectedFallaID, selectedFallaDesc) {
    console.log("Enviando parámetros:", {
        id: id,
        NameElemento: NameElemento,
        area: area,
        selectedFallaID: selectedFallaID,
        selectedFallaDesc_Falla: selectedFallaDesc
    });

    $.ajax({
        url: 'verificar.php',
        type: 'GET',
        data: {
            id: id,
            NameElemento: NameElemento,
            area: area,
            selectedFallaID: selectedFallaID,
            selectedFallaDesc_Falla: selectedFallaDesc
        },
        success: function(response) {
            console.log("Respuesta de verificación:", response);

            if (response.includes("La alerta ya ha sido aceptada")) {
                alert("Esta alerta ya está aceptada.");
            } else if (response.includes("La alerta está en espera.")) {
                // Confirmar si desea enviar la alerta
                if (confirm('¿Estás seguro de enviar la alerta?')) {
                    $.ajax({
                        url: 'enviar_alerta.php',
                        type: 'GET',
                        data: {
                            id: id,
                            NameElemento: NameElemento,
                            area: area,
                            selectedFallaID: selectedFallaID,
                            selectedFallaDesc_Falla: selectedFallaDesc
                        },
                        success: function(response) {
                            console.log("Respuesta de envío:", response);
                            if (response.includes("La alerta ya ha sido aceptada")) {
                                closeModal(); // Cierra el modal principal
                                abrirModalAlertaAceptada(); // Abre el modal de alerta aceptada
                            } else {
                                document.getElementById("mensaje").innerHTML = response;
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error al enviar la alerta:', error);
                            document.getElementById("mensaje").innerHTML = "Hubo un problema al enviar la alerta. Por favor, inténtalo de nuevo.";
                        }
                    });
                }
            } else {
                alert("El estado de la alerta es: " + response);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al verificar la alerta:', error);
        }
    });
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
<!-------------------------------------------------------------------enviar reporte----------------------------------------------------------------------------------------------------------------------------->



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
                select.append('<option value="' + falla.id + '">' + falla.fallaname + '</option>');
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


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


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
//enviar reporte 


// Enviar el formulario al hacer clic en el botón "Enviar"
/**$('#reportForm').on('submit', function(event) {
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
});**/

// Manejar la carga de archivo desde el equipo
/**$('#file-upload').on('change', function(event) {
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

        
    });**/


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
                        const mensaje = `La alerta del elemento "${alert.elemento}" en el área "${alert.area}", con la falla "${alert.falla}", ha sido Aceptada para su revisión.`;
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
/**function checkboxChange(idElemento, nombreCaracteristica, isChecked) {
    var checkboxes = document.querySelectorAll('input[name="' + nombreCaracteristica + '[]"]');
    var identificadoresCaract = [];

    checkboxes.forEach(function(checkbox) {
        if (checkbox.checked) {
            identificadoresCaract.push(checkbox.getAttribute('data-identificador-caract'));
        }
    });

    openModalAndEnviarAlerta(idElemento, identificadoresCaract);
}**/
</script>

</body>
</html>

