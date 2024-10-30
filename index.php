<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Raleway|Ubuntu" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="icon" href="imagenes/kayser_icon.ico" type="image/x-icon">
  <!-- Estilos -->
  <style>
    /* Estilos generales */
    * {
      padding: 0;
      margin: 0;
      box-sizing: border-box;
    }

    body {
      background: url("imagenes/fondo.png") no-repeat center center fixed; 
      background-size: cover;
      font-family: "Ubuntu", helvetica, sans-serif;
    }

    .contenedor-formularios {
      max-width: 500px;
      margin: 50px auto;
      left: 50%;
      background: #ffffff77;
      padding: 30px; /* Aumentado el padding para más espacio interno */
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .contenedor-tabs {
      list-style-type: none;
      padding: 0;
      margin-bottom: 20px;
    }

    .contenedor-tabs li {
      display: inline-block;
      margin-right: 10px;
    }

    .contenido-tab {
      padding: 20px;
    }

    h1 {
      text-align: center;
      margin-bottom: 30px;
    }

    .contenedor-input {
      margin-bottom: 20px; /* Aumentado el espacio entre inputs */
    }

    .contenedor-input label {
      display: block;
      margin-bottom: 5px;
    }

    .contenedor-input input {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      background-color: rgba(0,0,0,0.1);
      border: 4px black;
      border-radius: 5px;
    }


    .button {
      width: 40%;
      padding: 10px;
      font-size: 16px;
      background-color: #7a0808;
      color: white;
      border: none;
      border-radius: 10px;
      cursor: pointer;
    }

    .button:hover {
      background-color: #e91818;
    }

    /* Estilos específicos para el formulario de inicio de sesión */
    form {
      text-align: left;
    }

    form img {
      display: block;
      margin: 0 auto;
      margin-bottom: 20px; /* Espacio inferior del logo */
    }

    /* Media queries para responsive design */
    @media (max-width: 800px) {
      .contenedor-formularios {
        margin: 20px;
        padding: 15px;
      }
    }
  </style>

  <title>Login</title>
</head>
<body>
  <!-- Formularios -->
  <div class="contenedor-formularios">
    <!-- Contenido de los Formularios -->
    <div class="contenido-tab">
      <!-- Iniciar Sesion -->
      <div>
        <center>
          <img src="imagenes/kayser_logo2-removebg-preview (1).png" alt="Logo" style="width: 100%; max-width: 450px; height: auto;">
        </center>
        <br>
        <h1>LOG IN</h1>
        <br>
        
        <form action="autenticación.php" method="post">
          <div class="contenedor-input">
            <label for="username"><i class="fas fa-user"></i> User <span class="req">*</span></label>
            <input type="text" id="username" name="username" required>
          </div>
          <br>
          <div class="contenedor-input">
            <label for="password"><i class="fas fa-lock"></i> Password <span class="req">*</span></label>
            <input type="password" id="password" name="password" required>
          </div>
          <br>
          <center>
          <button class="button" type="submit">LOG IN</button>
          </center>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
