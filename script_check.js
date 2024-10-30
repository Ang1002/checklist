$(document).ready(function() {
    $('#miTabla').DataTable({
        "order": [], // Desactiva el ordenamiento inicial
        "columnDefs": [
            { "orderable": true, "targets": "_all" } // Permite ordenar todas las columnas
        ]
    });
});


//funcion para mandar la alerta 
function enviarAlerta(id, NameElemento, area) {
  // Pedir al usuario que ingrese comentarios adicionales
  var comentarios = prompt("Por favor ingresa comentarios adicionales:");

  // Verificar si el usuario ingresó comentarios
  if (comentarios !== null) {
      // Crear el mensaje de confirmación incluyendo los comentarios
      var confirmacionMensaje = '¿Estás seguro de enviar la alerta con los siguientes comentarios adicionales?\n\n';
      confirmacionMensaje += comentarios + '\n\n';
      confirmacionMensaje += 'Presiona OK para enviar la alerta o Cancelar para cancelar el envío.';

      // Mostrar ventana emergente de confirmación con los comentarios
      if (confirm(confirmacionMensaje)) {
          // Si el usuario confirma, proceder con el envío de la alerta
          var xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                  document.getElementById("mensaje").innerHTML = this.responseText;
              }
          };
          xhttp.open("GET", "enviar_alerta.php?id=" + id + "&NameElemento=" + encodeURIComponent(NameElemento) + "&area=" + encodeURIComponent(area) + "&comentarios=" + encodeURIComponent(comentarios), true);
          xhttp.send();
      }
  }
}

