<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Lista desplegable en una tabla con checkboxes</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>

<table border="1">
  <thead>
    <tr>
      <th>Título 1</th>
      <th>Título 2</th>
      <th>Título 3</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>
        <select id="titulo1" multiple size="5">
          <option value="opcion1">Opción 1</option>
          <option value="opcion2">Opción 2</option>
          <option value="opcion3">Opción 3</option>
          <option value="opcion4">Opción 4</option>
          <option value="opcion5">Opción 5</option>
        </select>
      </td>
      <td>
        <select id="titulo2" multiple size="7">
          <option value="opcion1">Opción 1</option>
          <option value="opcion2">Opción 2</option>
          <option value="opcion3">Opción 3</option>
          <option value="opcion4">Opción 4</option>
          <option value="opcion5">Opción 5</option>
          <option value="opcion6">Opción 6</option>
          <option value="opcion7">Opción 7</option>
        </select>
      </td>
      <td>
        <select id="titulo3" multiple size="7">
          <option value="opcion1">Opción 1</option>
          <option value="opcion2">Opción 2</option>
          <option value="opcion3">Opción 3</option>
          <option value="opcion4">Opción 4</option>
          <option value="opcion5">Opción 5</option>
          <option value="opcion6">Opción 6</option>
          <option value="opcion7">Opción 7</option>
        </select>
      </td>
    </tr>
  </tbody>
</table>

<script>
// Función para obtener las opciones seleccionadas en el título 1
function obtenerSeleccionTitulo1() {
  var opciones = [];
  $("#titulo1 option:selected").each(function() {
    opciones.push($(this).val());
  });
  return opciones;
}

// Función para obtener las opciones seleccionadas en el título 2
function obtenerSeleccionTitulo2() {
  var opciones = [];
  $("#titulo2 option:selected").each(function() {
    opciones.push($(this).val());
  });
  return opciones;
}

// Función para obtener las opciones seleccionadas en el título 3
function obtenerSeleccionTitulo3() {
  var opciones = [];
  $("#titulo3 option:selected").each(function() {
    opciones.push($(this).val());
  });
  return opciones;
}

// Ejemplo de uso
$("#titulo1, #titulo2, #titulo3").change(function() {
  var idTitulo = $(this).attr("id");
  var opcionesSeleccionadas = [];
  if (idTitulo === "titulo1") {
    opcionesSeleccionadas = obtenerSeleccionTitulo1();
  } else if (idTitulo === "titulo2") {
    opcionesSeleccionadas = obtenerSeleccionTitulo2();
  } else if (idTitulo === "titulo3") {
    opcionesSeleccionadas = obtenerSeleccionTitulo3();
  }
  console.log("Opciones seleccionadas en el " + idTitulo + ":", opcionesSeleccionadas);
});
</script>

</body>
</html>
