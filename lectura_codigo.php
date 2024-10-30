<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Código QR</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://unpkg.com/qr-scanner@1.2.0/qr-scanner.umd.min.js"></script>
</head>

<body>
  <div class="row justify-content-center mt-5">
    <div class="col-sm-4 shadow p-3">
      <h5 class="text-center">Escanear código QR</h5>
      <div class="row text-center">
        <a id="btn-scan-qr" href="#">
          <img src="https://dab1nmslvvntp.cloudfront.net/wp-content/uploads/2017/07/1499401426qr_icon.svg"
            class="img-fluid text-center" width="175">
        </a>
        <canvas hidden="" id="qr-canvas" class="img-fluid"></canvas>
      </div>
      <div class="row mx-5 my-3">
        <button class="btn btn-success btn-sm rounded-3 mb-2" onclick="encenderCamara()">Encender cámara</button>
        <button class="btn btn-danger btn-sm rounded-3" onclick="cerrarCamara()">Detener cámara</button>
      </div>

    </div>
  </div>

  <div class="text-center mt-3">
    <h5>Tomar una foto</h5>
    <input type="file" accept="image/*" capture="camera" id="camera-input">
    <img id="captured-image" src="" alt="Imagen capturada" class="img-fluid mt-2" style="display:none;">
  </div>
  
  <audio id="audioScaner" src="sonido.mp3"></audio>

  <script>
    let scanner;
    let isScanning = false;

    function encenderCamara() {
      if (isScanning) return;

      scanner = new QrScanner(
        document.getElementById('qr-canvas'),
        result => {
          console.log(result);
          Swal.fire('Código QR detectado!', result, 'success');
          document.getElementById('audioScaner').play();
          cerrarCamara();
        }
      );

      scanner.start().then(() => {
        document.getElementById('qr-canvas').removeAttribute('hidden');
        isScanning = true;
      }).catch(err => {
        console.error(err);
        Swal.fire('Error', `No se pudo acceder a la cámara: ${err.message}`, 'error');
      });
    }

    function cerrarCamara() {
      if (scanner) {
        scanner.stop();
        document.getElementById('qr-canvas').setAttribute('hidden', true);
        isScanning = false;
      }
    }

    // Mostrar la imagen capturada
    document.getElementById('camera-input').addEventListener('change', function(event) {
      const file = event.target.files[0];
      if (file) {
        const img = document.getElementById('captured-image');
        img.src = URL.createObjectURL(file);
        img.style.display = 'block'; // Mostrar la imagen
      }
    });
  </script>

</body>
</html>
