<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lector de Códigos QR</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f0;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
        }


        .header {
            margin-bottom: 20px;
        }

        .header img {
            width: 120px;
            height: auto;
        }

        .header h1 {
            margin: 10px 0;
            font-size: 24px;
            color: #4CAF50;
        }

        #fileInput {
            margin: 20px 0;
        }

        #result {
            margin-top: 20px;
            font-size: 1.2em;
            font-weight: bold;
            color: #333;
        }

        #imageContainer {
            margin-top: 20px;
        }

        #imageContainer img {
            max-width: 100%;
            height: auto;
            border: 1px solid #ddd;
            padding: 10px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<div class="header">
    <?php
        $logoPath = "imagenes/kayser_logo2-removebg-preview (1).png";
        if (file_exists($logoPath)) {
            echo "<img src='$logoPath' alt='Logo'>";
        } else {
            echo "<img src='https://via.placeholder.com/150x100?text=Tu+Logo' alt='Logo'>";
        }
    ?>
    <h1>Escanea tu Código QR</h1>
</div>

<!-- Input para cargar un archivo de imagen -->
<input type="file" id="fileInput" accept="image/*">
<div id="imageContainer"></div>
<div id="result">Resultado: <span id="result-span"></span></div>

<!-- Cargar la librería -->
<script src="https://unpkg.com/html5-qrcode@2.1.4/minified/html5-qrcode.min.js"></script>
<script>
    document.getElementById('fileInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (!file) {
            return;
        }

        const reader = new FileReader();
        reader.onload = function(event) {
            const img = new Image();
            img.src = event.target.result;
            img.onload = function() {
                // Mostrar la imagen cargada
                const imageContainer = document.getElementById('imageContainer');
                imageContainer.innerHTML = '';
                imageContainer.appendChild(img);

                // Crear un canvas para obtener ImageData
                const canvas = document.createElement('canvas');
                canvas.width = img.width;
                canvas.height = img.height;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, img.width, img.height);

                const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);

                Html5Qrcode.scanImage(imageData, { singleImage: true })
                    .then(decodedText => {
                        document.getElementById('result-span').innerText = decodedText;
                    })
                    .catch(err => {
                        document.getElementById('result-span').innerText = "No se pudo leer el código QR.";
                    });
            };
        };
        reader.readAsDataURL(file);
    });
</script>

</body>
</html>
