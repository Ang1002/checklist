<?php
session_start(); // Iniciar sesión si no se ha hecho ya
// Verificar si el usuario está autenticado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php');
    exit;
}
//Obtener el nombre de usuario y su ID de la sesión
$usuario_nombre = $_SESSION['name'];
$usuario_id = $_SESSION['id'];

$servername = "localhost";
$dbusername = "root";
$dbpassword = "0084321";
$dbname = "projectroute";

// Crear conexión
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error); 
}
// Cerrar la conexión

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport"
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">


  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Raleway|Ubuntu" rel="stylesheet">

  <!-- Estilos -->
  <link rel="stylesheet" href="style_menu_principal.css">
  <link rel="icon" href="imagenes/kayser_icon.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>Menú</title>
</head>

<header>
    <nav>
      <h2><img src="imagenes/kayser_logo2-removebg-preview (1).png" alt="Logo" width="180" height="80"></h2>
      <ul>
        <li class="main-nav__item"><a class="main-nav__link" href="menu.php" data-link-alt=""> <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-border-width" viewBox="0 0 16 16">
  <path d="M0 3.5A.5.5 0 0 1 .5 3h15a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H.5a.5.5 0 0 1-.5-.5zm0 5A.5.5 0 0 1 .5 8h15a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H.5a.5.5 0 0 1-.5-.5zm0 4a.5.5 0 0 1 .5-.5h15a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5"/>
</svg> Inicio </a></li>
       <!-- <li class="main-nav__item"><a class="main-nav__link" href="check.php" data-link-alt=""> <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
  <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"/>
</svg> Checklist</a></li>-->
       
        <!--<li class="main-nav__item"><a class="main-nav__link" href="dashboardapexchart.php" data-link-alt=""> <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-graph-up" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M0 0h1v15h15v1H0zm14.817 3.113a.5.5 0 0 1 .07.704l-4.5 5.5a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61 4.15-5.073a.5.5 0 0 1 .704-.07"/>
</svg>Reportes</a>
        </li>-->

        
        <li class="main-nav__item"><a class="main-nav__link" href="new_password.php" data-link-alt=""> <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-unlock" viewBox="0 0 16 16">
  <path d="M11 1a2 2 0 0 0-2 2v4a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h5V3a3 3 0 0 1 6 0v4a.5.5 0 0 1-1 0V3a2 2 0 0 0-2-2M3 8a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1z"/>
</svg>New Password</a>
      </li>
        <li class="main-nav__item"><a class="main-nav__link" href="index.php" data-link-alt=""> <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z"/>
  <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z"/>
</svg>Salir</a></li>

      </ul>
    </nav>
  </header>
<center>
  <div class="col-md-12 text-center">
    <h3 class="animate-charcter">Menú</h3>
    <h2><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-raised-hand" viewBox="0 0 16 16">
  <path d="M6 6.207v9.043a.75.75 0 0 0 1.5 0V10.5a.5.5 0 0 1 1 0v4.75a.75.75 0 0 0 1.5 0v-8.5a.25.25 0 1 1 .5 0v2.5a.75.75 0 0 0 1.5 0V6.5a3 3 0 0 0-3-3H6.236a1 1 0 0 1-.447-.106l-.33-.165A.83.83 0 0 1 5 2.488V.75a.75.75 0 0 0-1.5 0v2.083c0 .715.404 1.37 1.044 1.689L5.5 5c.32.32.5.754.5 1.207"/>
  <path d="M8 3a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3"/>
</svg> <?php echo $usuario_nombre; ?></h2>
  </div>
</center>


<div>        <!--<h4><?php echo $usuario_id; ?></h4>-->
            <!-- Aquí puedes agregar el contenido de tu menú... -->
        
    </div>

<div class="buttons">

<!--<button class="supmenu" onclick="window.location.href = 'qr.php';">
<i class="fa fa-qrcode" aria-hidden="true"></i>
    <span>Capturar Código</span>
  </button> -->

  <button class="supmenu" onclick="window.location.href = 'check1.php';">
  <i class="fa fa-check-square-o" aria-hidden="true"></i>
    <span>Checklist</span>
  </button>


  <button class="supmenu" onclick="window.location.href = 'view_general.php';">
  <i class="fa fa-table" aria-hidden="true"></i>
    <span>View</span>
  </button>

  <!--<button class="supmenu" onclick="window.location.href = 'internet.php';">
    <i class="fa-light fa-wifi"></i>
    <span>Internet</span>
  </button>-->

  <button class="supmenu" onclick="window.location.href = 'dashboardapexchart.php';">
  <i class="fa fa-bar-chart" aria-hidden="true"></i>
    <span>Reportes</span>
  </button>
  <button class="supmenu" onclick="window.location.href = 'picture.php';">
  <i class="fa fa-qrcode" aria-hidden="true"></i>
    <span>Capturar por QR</span>
  </button>

</div>



<script> src = "http://osvaldas.info/examples/main.js" </script>

<script src="http://osvaldas.info/examples/drop-down-navigation-touch-friendly-and-responsive/doubletaptogo.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
$(document).ready(function() {
createCheckboxSelect("#make_checkbox_select1");
createCheckboxSelect("#make_checkbox_select2");
createCheckboxSelect("#make_checkbox_select3");
});

function createCheckboxSelect(selector) {
var mySelectCheckbox = new checkbox_select({
    selector: selector,
    // Otras opciones
});
}

jQuery(document).ready(function($) {
//open popup
$('.cd-popup-trigger').on('click', function(event) {
event.preventDefault();
$('.cd-popup').addClass('is-visible');
});

//close popup
$('.cd-popup').on('click', function(event) {
if ($(event.target).is('.cd-popup-close') || $(event.target).is('.cd-popup')) {
  event.preventDefault();
  $(this).removeClass('is-visible');
}
});
//close popup when clicking the esc keyboard button
$(document).keyup(function(event) {
if (event.which == '27') {
  $('.cd-popup').removeClass('is-visible');
}
});
});



</script>

<script src="script.js"></script>
<script src="script_check.js"></script>
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
  <p>&copy; 2024 Kayser Automotive Systems. Todos los derechos reservados.(IT)</p>
</footer>

</html>