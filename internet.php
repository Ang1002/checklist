<?php
// Establecer la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "0084321";
$dbname = "projectroute";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    //$fecha = $_POST['fecha'];
    
    // Insertar los datos de los checkboxes en la tabla 'internet'
    
    // Verificar si se han enviado los checkboxes para cada día y actualizar la base de datos en consecuencia
    if(isset($_POST['lunes'])) {
      foreach ($_POST['lunes'] as $id) {
          $sql = "UPDATE internet SET lunes = CURRENT_DATE WHERE id = $id";
          $conn->query($sql);
          echo '<script>mostrarMensaje();</script>';
      }
    }
    if(isset($_POST['martes'])) {
      foreach ($_POST['martes'] as $id) {
          $sql = "UPDATE internet SET martes = CURRENT_DATE WHERE id = $id";
          $conn->query($sql);
          echo '<script>mostrarMensaje();</script>';
      }
    }
    if(isset($_POST['miercoles'])) {
      foreach ($_POST['miercoles'] as $id) {
          $sql = "UPDATE internet SET miercoles = CURRENT_DATE WHERE id = $id";
          $conn->query($sql);
          echo '<script>mostrarMensaje();</script>';
      }
    }
    if(isset($_POST['jueves'])) {
      foreach ($_POST['jueves'] as $id) {
          $sql = "UPDATE internet SET jueves = CURRENT_DATE WHERE id = $id";
          $conn->query($sql);
          echo '<script>mostrarMensaje();</script>';
      }
    }
    if(isset($_POST['viernes'])) {
      foreach ($_POST['viernes'] as $id) {
          $sql = "UPDATE internet SET viernes = CURRENT_DATE WHERE id = $id";
          $conn->query($sql);
          echo '<script>mostrarMensaje();</script>';
      }
    }
}
// Consulta SQL para obtener los datos de la tabla 'internet'
$sql = "SELECT id, area, elemento, descripcion, lunes, martes, miercoles, jueves, viernes FROM internet";
$resultado = $conn->query($sql);


// Obtener la semana actual
$weekNumber = obtenerSemanaActual();

// Actualizar el valor en la base de datos para todas las filas
$sql = "UPDATE internet SET semana_actual = $weekNumber"; // Actualizar todas las filas
if ($conn->query($sql) === TRUE) {
    echo "";
} else {
    echo "Error al actualizar los registros: " . $conn->error;
}

// Función para obtener la semana actual
function obtenerSemanaActual() {
    // Obtener la fecha actual
    $currentDate = date('Y-m-d');
    // Obtener el número de la semana actual
    $weekNumber = date('W', strtotime($currentDate));
    return $weekNumber;
}

?>



<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="style-recepcion.css">
  <link rel="icon" href="imagenes/kayser_icon.ico" type="image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Internet</title>
</head>

<body>
<header>
    <nav>
      <h2><img src="imagenes/kayser_logo2-removebg-preview (1).png" alt="Logo" width="180" height="80"></h2>
      <ul>
        <li class="main-nav__item"><a class="main-nav__link" href="menu.php" data-link-alt=""> <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-border-width" viewBox="0 0 16 16">
  <path d="M0 3.5A.5.5 0 0 1 .5 3h15a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H.5a.5.5 0 0 1-.5-.5zm0 5A.5.5 0 0 1 .5 8h15a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H.5a.5.5 0 0 1-.5-.5zm0 4a.5.5 0 0 1 .5-.5h15a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5"/>
</svg> Inicio </a></li>
        <li class="main-nav__item"><a class="main-nav__link" href="areass.php" data-link-alt=""> <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
  <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"/>
</svg> Areas</a></li>
        <li class="main-nav__item"><a class="main-nav__link" href="servidores.php" data-link-alt=""> <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-hdd-stack" viewBox="0 0 16 16">
  <path d="M14 10a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-1a1 1 0 0 1 1-1zM2 9a2 2 0 0 0-2 2v1a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-1a2 2 0 0 0-2-2z"/>
  <path d="M5 11.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m-2 0a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0M14 3a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1zM2 2a2 2 0 0 0-2 2v1a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2z"/>
  <path d="M5 4.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m-2 0a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0"/>
</svg> Servidores</a></li>
        <li class="main-nav__item"><a class="main-nav__link" href="internet.php" data-link-alt=""> <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-wifi" viewBox="0 0 16 16">
  <path d="M15.384 6.115a.485.485 0 0 0-.047-.736A12.44 12.44 0 0 0 8 3C5.259 3 2.723 3.882.663 5.379a.485.485 0 0 0-.048.736.52.52 0 0 0 .668.05A11.45 11.45 0 0 1 8 4c2.507 0 4.827.802 6.716 2.164.205.148.49.13.668-.049"/>
  <path d="M13.229 8.271a.482.482 0 0 0-.063-.745A9.46 9.46 0 0 0 8 6c-1.905 0-3.68.56-5.166 1.526a.48.48 0 0 0-.063.745.525.525 0 0 0 .652.065A8.46 8.46 0 0 1 8 7a8.46 8.46 0 0 1 4.576 1.336c.206.132.48.108.653-.065m-2.183 2.183c.226-.226.185-.605-.1-.75A6.5 6.5 0 0 0 8 9c-1.06 0-2.062.254-2.946.704-.285.145-.326.524-.1.75l.015.015c.16.16.407.19.611.09A5.5 5.5 0 0 1 8 10c.868 0 1.69.201 2.42.56.203.1.45.07.61-.091zM9.06 12.44c.196-.196.198-.52-.04-.66A2 2 0 0 0 8 11.5a2 2 0 0 0-1.02.28c-.238.14-.236.464-.04.66l.706.706a.5.5 0 0 0 .707 0l.707-.707z"/>
</svg> Internet</a>
        </li>

        <li class="main-nav__item"><a class="main-nav__link" href="graficas.php" data-link-alt=""> <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-graph-up" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M0 0h1v15h15v1H0zm14.817 3.113a.5.5 0 0 1 .07.704l-4.5 5.5a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61 4.15-5.073a.5.5 0 0 1 .704-.07"/>
</svg>Reporte</a>
        </li>

        <li class="main-nav__item"><a class="main-nav__link" href="new_password.php" data-link-alt=""> <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-unlock" viewBox="0 0 16 16">
  <path d="M11 1a2 2 0 0 0-2 2v4a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h5V3a3 3 0 0 1 6 0v4a.5.5 0 0 1-1 0V3a2 2 0 0 0-2-2M3 8a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1z"/>
</svg>Cambiar Contraseña</a>
      </li>
        <li class="main-nav__item"><a class="main-nav__link" href="index.php" data-link-alt=""> <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
  <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
  <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
</svg>Salir</a></li>

      </ul>
    </nav>
  </header>
  <center>
    <div class="col-md-12 text-center">
      <h3 class="animate-charcter">Internet</h3>
    </div>
  </center>
  <center>
  <?php
        
        // Definir la variable $currentDate con la fecha actual
$currentDate = date("Y-m-d"); // Formato YYYY-MM-DD

// Calcular el número de semana actual
$weekNumber = date("W", strtotime($currentDate));
?>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
  <table>
    <thead>
      <tr>
        <th>Date </th>
        <th>ID</th>
        <th>Area </th>
        <th>Elemento</th>
        <th>Descripciones</th>
        <th>Lunes</th>
        <th>Martes</th>
        <th>Miércoles</th>
        <th>Jueves</th>
        <th>Viernes</th>
        <th>Semana Actual</th>
        <th>Alerta</th>
       
      </tr>
    </thead>
    <tbody>

    <?php
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
    ?>

<tr>
              <!-- Aquí se muestran los datos de cada fila -->
              <td class="fecha-hora" id="fechaHora"></td>
              <td><?php echo $fila['id']; ?></td>
              <td><?php echo $fila['area']; ?></td>
              <td><?php echo $fila['elemento']; ?></td>
              <td><?php echo $fila['descripcion']; ?></td>
              <!-- Añade tus campos de checkbox con la verificación de si deben estar marcados -->
              <td><input type="checkbox" name="lunes[]" class="internet" value="<?php echo $fila['id']; ?>" data-day="lunes" <?php if($fila['lunes'] != null) echo 'checked'; ?>></td>
              <td><input type="checkbox" name="martes[]" class="internet" value="<?php echo $fila['id']; ?>" data-day="martes" <?php if($fila['martes'] != null) echo 'checked'; ?>></td>
              <td><input type="checkbox" name="miercoles[]" class="internet" value="<?php echo $fila['id']; ?>" data-day="miercoles" <?php if($fila['miercoles'] != null) echo 'checked'; ?>></td>
              <td><input type="checkbox" name="jueves[]" class="internet" value="<?php echo $fila['id']; ?>" data-day="jueves" <?php if($fila['jueves'] != null) echo 'checked'; ?>></td>
              <td><input type="checkbox" name="viernes[]" class="internet" value="<?php echo $fila['id']; ?>" data-day="viernes" <?php if($fila['viernes'] != null) echo 'checked'; ?>></td>
             <!-- <td><button type="submit" class="button">Guardar</button></td>-->
             <td><?php echo $weekNumber; ?></td>
            <!-- <td><button type="submit" class="button">Guardar</button></td> -->
            <td>
            <a href="#" class="button" onclick="enviarAlerta(<?php echo $fila['id']; ?>, '<?php echo utf8_encode($fila['elemento']); ?>', '<?php echo utf8_encode($fila['area']); ?>')">Alerta</a>
            <div id="mensaje"></div>
            <!--
            <a href="enviar_alerta.php?id=<?php echo $fila['id']; ?>&elemento=<?php echo urlencode($fila['elemento']); ?>&area=<?php echo urlencode($fila['area']); ?>" class="button" onclick="return confirm('¿Estás seguro de enviar la alerta?')">Alerta</a>
            -->
            <!--<a href="enviar_alerta.php?id=<?php echo $fila['id']; ?>&elemento=<?php echo urlencode($fila['elemento']); ?>&area=<?php echo urlencode($fila['area']); ?>" class="button">Alerta</a>-->
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
    </tbody>
  </table>
</form>
<br>
  <br>

<form action="correo_internet.php" method="GET">
    <button type="submit" class="button" name="reportarTodo">Reportar</button>
  </form>
</center>
<script src="script.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var checkboxes = document.querySelectorAll('.internet');
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            var id = this.value;
            var day = this.dataset.day; // Obtener el día desde el atributo data-day del checkbox
            var isChecked = this.checked; // Verificar si el checkbox está marcado o no

            // Hacer una solicitud AJAX para actualizar el estado del checkbox en la base de datos
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'actualizar_estado_checkbox_internet.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Manejar la respuesta del servidor
                    console.log(xhr.responseText);
                    // Puedes agregar aquí lógica adicional según sea necesario
                }
            };
            xhr.send('fecha=' + getCurrentDate() + '&isChecked=' + id + '&day=' + day);
        });
    });
});

function getCurrentDate() {
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); // Enero es 0!
    var yyyy = today.getFullYear();

    return yyyy + '-' + mm + '-' + dd;
}

</script>
<script>
function enviarAlerta(id, elemento, area) {
    if (confirm('¿Estás seguro de enviar la alerta?')) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("mensaje").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "enviar_alerta.php?id=" + id + "&elemento=" + encodeURIComponent(elemento) + "&area=" + encodeURIComponent(area), true);
        xhttp.send();
    }
}
</script>



</body>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
<br>


<footer>
  <p>&copy; 2024 Kayser Aumotive Systems. Todos los derechos reservados.(IT)</p>
</footer>

</html>

<?php
// Establecer la conexión a la base de datos
$servername = "localhost";
$username = "zarate";
$password = "Manchas_2024";
$dbname = "projectroute";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener la fecha y hora actual
$currentDateTime = date('Y-m-d H:i:s');

// Verificar si hoy es viernes y la hora actual es después de las 4:00 pm
if (date('N') == 5 && date('H') >= 16) {
    // Guardar los datos de la tabla 'areas' en una nueva tabla
    $sqlGuardar = "INSERT INTO datos_semana_anterior (area, elemento, lunes, martes, miercoles, jueves, viernes, semana_actual) 
    SELECT area, elemento, lunes, martes, miercoles, jueves, viernes, semana_actual 
    FROM internet";
    if ($conn->query($sqlGuardar) === TRUE) {
       // echo "Datos guardados exitosamente en la tabla 'datos_semana_anterior'.<br>";
    } else {
       // echo "Error al guardar datos: " . $conn->error . "<br>";
    }

    // Borrar las fechas de las columnas de lunes a viernes en la tabla 'areas'
    $sqlBorrar = "UPDATE internet SET lunes = NULL, martes = NULL, miercoles = NULL, jueves = NULL, viernes = NULL";
    if ($conn->query($sqlBorrar) === TRUE) {
        //echo "Fechas borradas correctamente en la tabla 'internet'.<br>";
    } else {
        echo "Error al borrar fechas: " . $conn->error . "<br>";
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
