var ctrlQR = Runner.getControl(pageid, 'text');
ctrlQR.makeReadonly();
var scanner = new Instascan.Scanner({
  video: document.getElementById('preview'),
  scanPeriod: 5,
  mirror: false
});
scanner.addListener('scan', function (content) {
  // alert(content);
  ctrlQR.setValue(content);
  var audio = new Audio('MyCode/beep.mp3');
  audio.play();
});
Instascan.Camera.getCameras().then(function (cameras) {
  if (cameras.length > 0) {
    // alert('Camaras: '+ cameras.length);
     scanner.start(cameras[0]);
     $('[name="options"]').on('change', function () {
        if ($(this).val() == 1) {
          if (cameras[0] != "") {
             scanner.start(cameras[0]);
          } else {
             alert('No Front camera found!');
          }
        } else if ($(this).val() == 2) {
          if (cameras[1] != "") {
             scanner.start(cameras[1]);
          } else {
             alert('No Back camera 1 found!');
          }
        } else if ($(this).val() == 3) {
          if (cameras[2] != "") {
             scanner.start(cameras[2]);
          } else {
             alert('No Back camera 2 found!');
          }
        }
     });
  } else {
     console.error('No cameras found.');
     alert('No cameras found.');
  }
}).catch(function (e) {
  console.error(e);
  alert(e);
});