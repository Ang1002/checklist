
/*******script para hora y fecha en tiempo real de cada elemento */

function obtenerFechaHoraActual() {
  var ahora = new Date();
  var fechaHora = rellenarCeros(ahora.getDate()) + '/' +
    rellenarCeros(ahora.getMonth() + 1) + '/' +
    ahora.getFullYear() + ' ' +
    rellenarCeros(ahora.getHours()) + ':' +
    rellenarCeros(ahora.getMinutes()) + ':' +
    rellenarCeros(ahora.getSeconds());
  return fechaHora;
}

function rellenarCeros(numero) {
  return (numero < 10 ? '0' : '') + numero;
}

// Obtener todas las celdas con la clase "fecha-hora"
var celdasFechaHora = document.querySelectorAll(".fecha-hora");

// Asignar la fecha y hora actual a todas las celdas con la clase "fecha-hora"
celdasFechaHora.forEach(function(celda) {
  celda.textContent = obtenerFechaHoraActual();
})

/*******Fin***** */

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
