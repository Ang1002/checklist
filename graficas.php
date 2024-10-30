<?php
$servername = "localhost";
$username = "root";
$password = "0084321";
$dbname = "projectroute";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta SQL
$sql = "SELECT id, elemento, area, falla , fecha_alerta  FROM alerta";
$result = $conn->query($sql);

$data = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}


$conn->close();
?>


<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">


  <link rel="stylesheet" href="style_graficas.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="icon" href="imagenes/kayser_icon.ico" type="image/x-icon">

  <title>Reporte Semanal</title>
</head>
<header>
  <nav>
    <h2><img src="imagenes/kayser_logo2-removebg-preview (1).png" alt="Logo" width="180" height="80"></h2>
    <ul>
      <li class="main-nav__item"><a class="main-nav__link" href="menu.php" data-link-alt=""> <svg
            xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-border-width"
            viewBox="0 0 16 16">
            <path
              d="M0 3.5A.5.5 0 0 1 .5 3h15a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H.5a.5.5 0 0 1-.5-.5zm0 5A.5.5 0 0 1 .5 8h15a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H.5a.5.5 0 0 1-.5-.5zm0 4a.5.5 0 0 1 .5-.5h15a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5" />
          </svg> Inicio </a></li>
      
      
      


      <!--<li class="main-nav__item"><a class="main-nav__link" href="graficas.php" data-link-alt=""> <svg
            xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-graph-up"
            viewBox="0 0 16 16">
            <path fill-rule="evenodd"
              d="M0 0h1v15h15v1H0zm14.817 3.113a.5.5 0 0 1 .07.704l-4.5 5.5a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61 4.15-5.073a.5.5 0 0 1 .704-.07" />
          </svg>Reporte</a>
      </li>-->

     

    </ul>
  </nav>

</header>
|
<body>
  <center>
    <div class="col-md-12 text-center">
      <!--<h3 class="animate-charcter">Reporte Semanal</h3>-->
    </div>
  </center>



  <section>


<article>
<center><p style="color: white;" >Area con más problemas </p></center>
  <div class="grafico">
    <div id="hueco">
     
      <div class="mes" style="color: white;">Mayo</div>
      <center><div class="anio" style="color: white;">2024</div></center>
    </div>
    <div id="porcion1" class="recorte">
      <div class="quesito"></div>
    </div>
    <div id="porcion2" class="recorte">
      <div class="quesito"></div>
    </div>
    <div id="porcion3" class="recorte">
      <div class="quesito"></div>
    </div>
  </div>
</article>

  </section>

  <section>
    

    <div class="example-row">
      <div class="example">
        <h3>áreas</h3>
       
        <div class="js-radial counter radial" data-finish="100" data-speed="26" data-append="%" data-color="#04d91a">
          <div class="display">
            <span class="count">0</span>
            <span class="decorator">%</span>
          </div>
        </div>
      </div>


      <div class="example">
        <h3>Número de fallas servidores</h3>
        <div class="js-radial counter radial" data-finish="100" data-speed="26" data-append="%" data-color="#0609cc">
          <div class="display">
            <span class="count">0</span>
            <span class="decorator">%</span>
          </div>
        </div>
      </div>


      <div class="example">
        <h3>Estado de internet</h3>
        <div class="js-radial counter radial" data-finish="100" data-speed="26" data-append="% " data-color="#a807b0">
          <div class="display">
            <span class="count">0</span>
            <span class="decorator">% Funcionando </span>
            
          </div>
        </div>
      </div>




      <div class="example">
        <h3>Número de fallas en elementos</h3>
        <div class="js-radial counter radial" data-finish="10" data-speed="26" data-append="% fallas" data-color="#a10505">
          <div class="display">
            <span class="count">0</span>
            <span class="decorator">%</span>
          </div>
        </div>
      </div>
</section>

<section>
      <div class="example">
        <h3>Area más afectada</h3>
        <div class="js-radial counter radial" data-finish="90" data-speed="26" data-countanim="false"
          data-color="#2cbae6">
          <div class="display"><span class="count"></span><span class="decorator">stepp</span></div>
        </div>
      </div>



    <!-- <div class="example">
        <h3></h3>
        <div class="js-radial counter radial" data-finish="50" data-speed="50" data-cclockwise="true"
          data-color="#d6cd13">
          <div class="display">
            <span class="count">0</span>
            <span class="decorator">%</span>
          </div>
        </div>
      </div>
</section>
<section> 
      <div class="example">
        <h3>Número de fallas en elementos</h3>
        <div class="js-radial counter radial" data-finish="10" data-speed="63" data-color="#FF9999"
          data-endcolor="#FF4C4C" >
          <div class="display">
          
          </div>
        </div>
      </div>-->
   
    
</div>
   
  </section>
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

  <script src="graficas.js"></script>
  <script>
   google.load("visualization", "1", {packages:["corechart"]});
   google.setOnLoadCallback(dibujarGrafico);
   function dibujarGrafico() {
     // Tabla de datos: valores y etiquetas de la gráfica
     var data = google.visualization.arrayToDataTable([
       ['Texto', 'Valor numérico'],
       ['Texto1', 20.21],
       ['Texto2', 4.28],
       ['Texto3', 17.26],
       ['Texto4', 10.25]    
     ]);
     var options = {
       title: 'Nuestro primer ejemplo con Google Charts'
     }
     // Dibujar el gráfico
     new google.visualization.ColumnChart( 
     //ColumnChart sería el tipo de gráfico a dibujar
       document.getElementById('GraficoGoogleChart-ejemplo-1')
     ).draw(data, options);
   }
 </script> 
</body>

<footer>
  <p>&copy; 2024 Kayser Aumotive Systems. Todos los derechos reservados.(IT)</p>
</footer>

</html>
