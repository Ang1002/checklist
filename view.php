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
    // Verificar si se han enviado los checkboxes para cada día y actualizar la base de datos en consecuencia
    if(isset($_POST['lunes'])) {
      foreach ($_POST['lunes'] as $id) {
          $sql = "UPDATE areas SET lunes = CURRENT_DATE WHERE id = $id";
          $conn->query($sql);
          echo '<script>mostrarMensaje();</script>';
      }
    }
    if(isset($_POST['martes'])) {
      foreach ($_POST['martes'] as $id) {
          $sql = "UPDATE areas SET martes = CURRENT_DATE WHERE id = $id";
          $conn->query($sql);
          echo '<script>mostrarMensaje();</script>';
      }
    }
    if(isset($_POST['miercoles'])) {
      foreach ($_POST['miercoles'] as $id) {
          $sql = "UPDATE areas SET miercoles = CURRENT_DATE WHERE id = $id";
          $conn->query($sql);
          echo '<script>mostrarMensaje();</script>';
      }
    }
    if(isset($_POST['jueves'])) {
      foreach ($_POST['jueves'] as $id) {
          $sql = "UPDATE areas SET jueves = CURRENT_DATE WHERE id = $id";
          $conn->query($sql);
          echo '<script>mostrarMensaje();</script>';
      }
    }
    if(isset($_POST['viernes'])) {
      foreach ($_POST['viernes'] as $id) {
          $sql = "UPDATE areas SET viernes = CURRENT_DATE WHERE id = $id";
          $conn->query($sql);
          echo '<script>mostrarMensaje();</script>';
      }
    }
}
// Consulta SQL para obtener los datos de la tabla 'internet'
$sql = "SELECT id, area, elemento, descripcion, lunes, martes, miercoles, jueves, viernes FROM areas";
$resultado = $conn->query($sql);

$sql = "SELECT id, area, elemento, descripcion, lunes, martes, miercoles, jueves, viernes FROM servidores";

$resultado1 = $conn->query($sql);

// Obtener la semana actual
$weekNumber = obtenerSemanaActualA();

// Actualizar el valor en la base de datos para todas las filas
$sql = "UPDATE areas SET semana_actual = $weekNumber"; // Actualizar todas las filas


// Verificar si la consulta arrojó resultados
if ($resultado1 === FALSE) {
  echo "Error al ejecutar la consulta: " . $conn->error;
}

// Mostrar los resultados (si los hay)
if ($resultado1->num_rows > 0) {
  // Procesar los resultados aquí
} else {
  echo "0 resultados";
}

$sql = "UPDATE servidores SET semana_actual = $weekNumber"; // Actualizar todas las filas


// Función para obtener la semana actual
function obtenerSemanaActualA() {
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
  <title>Servidores</title>
</head>

<body>
<header>
    <nav>
      <h2><img src="imagenes/kayser_logo2-removebg-preview (1).png" alt="Logo" width="180" height="80"></h2>
      <ul>
        <li class="main-nav__item"><a class="main-nav__link" href="menu.php" data-link-alt=""> <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-border-width" viewBox="0 0 16 16">
  <path d="M0 3.5A.5.5 0 0 1 .5 3h15a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H.5a.5.5 0 0 1-.5-.5zm0 5A.5.5 0 0 1 .5 8h15a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H.5a.5.5 0 0 1-.5-.5zm0 4a.5.5 0 0 1 .5-.5h15a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5"/>
</svg> Inicio </a></li>
    

      </ul>
    </nav>
  </header>
  <center>
    <div class="col-md-12 text-center">
      <h3 class="animate-charcter">View checklist</h3>
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
      <th>Areas</th>
        <th>Elemento</th>
        <th>Descripciones</th>
        <th>Lunes</th>
        <th>Martes</th>
        <th>Miércoles</th>
        <th>Jueves</th>
        <th>Viernes</th>
        
       
      </tr>
    </thead>
    <tbody>

    <?php
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
    ?>

<tr>
          
              <td><?php echo $fila['area']; ?></td>
              <td><?php echo $fila['elemento']; ?></td>
              <td><?php echo $fila['descripcion']; ?></td>
              <!-- Añade tus campos de checkbox con la verificación de si deben estar marcados -->
              <td><input type="checkbox" name="lunes[]" class="areas" value="<?php echo $fila['id']; ?>" data-day="lunes" <?php if($fila['lunes'] != null) echo 'checked'; ?>></td>
              <td><input type="checkbox" name="martes[]" class="areas" value="<?php echo $fila['id']; ?>" data-day="martes" <?php if($fila['martes'] != null) echo 'checked'; ?>></td>
              <td><input type="checkbox" name="miercoles[]" class="areas" value="<?php echo $fila['id']; ?>" data-day="miercoles" <?php if($fila['miercoles'] != null) echo 'checked'; ?>></td>
              <td><input type="checkbox" name="jueves[]" class="areas" value="<?php echo $fila['id']; ?>" data-day="jueves" <?php if($fila['jueves'] != null) echo 'checked'; ?>></td>
              <td><input type="checkbox" name="viernes[]" class="areas" value="<?php echo $fila['id']; ?>" data-day="viernes" <?php if($fila['viernes'] != null) echo 'checked'; ?>></td>
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

<center>
    <div class="col-md-12 text-center">
      <h3 class="animate-charcter">Servidores</h3>
    </div>
  </center>
  <center>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
  <table>
    <thead>
      <tr>
      <th>Area</th>
        <th>Elemento</th>
        <th>Descripciones</th>
        <th>Lunes</th>
        <th>Martes</th>
        <th>Miércoles</th>
        <th>Jueves</th>
        <th>Viernes</th>
       
      </tr>
    </thead>
    <tbody>

    <?php
        if ($resultado1->num_rows > 0) {
            while ($fila = $resultado1->fetch_assoc()) {
    ?>

<tr>
              <td><?php echo $fila['area']; ?></td>
              <td><?php echo $fila['elemento']; ?></td>
              <td><?php echo $fila['descripcion']; ?></td>
             
              <td><input type="checkbox" name="lunes[]" class="servidores" value="<?php echo $fila['id']; ?>" data-day="lunes" <?php if($fila['lunes'] != null) echo 'checked'; ?>></td>
              <td><input type="checkbox" name="martes[]" class="servidores" value="<?php echo $fila['id']; ?>" data-day="martes" <?php if($fila['martes'] != null) echo 'checked'; ?>></td>
              <td><input type="checkbox" name="miercoles[]" class="servidores" value="<?php echo $fila['id']; ?>" data-day="miercoles" <?php if($fila['miercoles'] != null) echo 'checked'; ?>></td>
              <td><input type="checkbox" name="jueves[]" class="servidores" value="<?php echo $fila['id']; ?>" data-day="jueves" <?php if($fila['jueves'] != null) echo 'checked'; ?>></td>
              <td><input type="checkbox" name="viernes[]" class="servidores" value="<?php echo $fila['id']; ?>" data-day="viernes" <?php if($fila['viernes'] != null) echo 'checked'; ?>></td>
          
            </tr>

        <?php
            }
        } else {
            echo "0 resultados";
        }
        
        ?>

    </tbody>
    </tbody>
  </table>
</form>

<br>
  <br>



</center>
<script src="script.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var checkboxes = document.querySelectorAll('.areas');
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            var id = this.value;
            var day = this.dataset.day; // Obtener el día desde el atributo data-day del checkbox
            var isChecked = this.checked; // Verificar si el checkbox está marcado o no

            // Hacer una solicitud AJAX para actualizar el estado del checkbox en la base de datos
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'guardar_areas.php', true);
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
document.addEventListener("DOMContentLoaded", function() {
    var checkboxes = document.querySelectorAll('.servidores');
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            var id = this.value;
            var day = this.dataset.day; // Obtener el día desde el atributo data-day del checkbox
            var isChecked = this.checked; // Verificar si el checkbox está marcado o no

            // Hacer una solicitud AJAX para actualizar el estado del checkbox en la base de datos
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'actualizar_estado_checkbox_server.php', true);
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
        xhttp.open("GET", "enviar_alerta.php?id=" + id + "&elemento=" + (elemento) + "&area=" +(area), true);
        xhttp.send();
    }
}
</script>


</body>
<br>

<footer>
  <p>&copy; 2024 Kayser Aumotive Systems. Todos los derechos reservados.(IT)</p>
</footer> 

</html>

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

// Obtener la fecha y hora actual
$currentDateTime = date('Y-m-d H:i:s');

// Verificar si hoy es viernes y la hora actual es después de las 3:00 pm
if (date('N') == 5 && date('H') >= 13) {
    // Guardar los datos de la tabla 'areas' en una nueva tabla
    $sqlGuardar = "INSERT INTO datos_semana_anterior (area, elemento,lunes, martes, miercoles, jueves, viernes, semana_actual) 
               SELECT area, elemento, lunes, martes, miercoles, jueves, viernes, semana_actual 
               FROM areas";

    if ($conn->query($sqlGuardar) === TRUE) {
       // echo "Datos guardados exitosamente en la tabla 'datos_semana_anterior'.<br>";
    } else {
       // echo "Error al guardar datos: " . $conn->error . "<br>";
    }

    // Borrar las fechas de las columnas de lunes a viernes en la tabla 'areas'
    $sqlBorrar = "UPDATE areas SET lunes = NULL, martes = NULL, miercoles = NULL, jueves = NULL, viernes = NULL";
    if ($conn->query($sqlBorrar) === TRUE) {
       // echo "Fechas borradas correctamente en la tabla 'servidores'.<br>";
    } else {
        //echo "Error al borrar fechas: " . $conn->error . "<br>";
    }
}
if (date('N') == 5 && date('H') >= 13) {
  // Guardar los datos de la tabla 'areas' en una nueva tabla
  $sqlGuardar = "INSERT INTO datos_semana_anterior (area, elemento,lunes, martes, miercoles, jueves, viernes, semana_actual) 
             SELECT area, elemento, lunes, martes, miercoles, jueves, viernes, semana_actual 
             FROM servidores";

  if ($conn->query($sqlGuardar) === TRUE) {
     // echo "Datos guardados exitosamente en la tabla 'datos_semana_anterior'.<br>";
  } else {
     // echo "Error al guardar datos: " . $conn->error . "<br>";
  }

  // Borrar las fechas de las columnas de lunes a viernes en la tabla 'areas'
  $sqlBorrar = "UPDATE servidores SET lunes = NULL, martes = NULL, miercoles = NULL, jueves = NULL, viernes = NULL";
  if ($conn->query($sqlBorrar) === TRUE) {
     // echo "Fechas borradas correctamente en la tabla 'servidores'.<br>";
  } else {
      //echo "Error al borrar fechas: " . $conn->error . "<br>";
  }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

