<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR</title>

    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0; 
            position: relative;
        }

        .navbar {
            background-color: rgba(155, 3, 3, 1.0);
            overflow: hidden;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            padding: 10px;
        }

        .navbar a {
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        .navbar img {
            height: 30px; /* Ajusta la altura del ícono según sea necesario */
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 700px; /* Aumenta el ancho máximo del contenedor */
            width: 100%;
            margin-top: 70px; /* Ajusta el margen superior para evitar que se solape con la barra de navegación */
        }

        .container img {
            max-width: 300px;
            margin-bottom: 20px;
        }

        .qr-image {
            max-width: 150px;
            margin-bottom: 20px;
        }

        input[type="file"] {
            display: block;
            margin: 20px auto;
        }

        #qr-result {
            margin: 20px 0;
            font-weight: bold;
            color: #333;
            border: 2px solid #ffffff;
            padding: 10px;
            border-radius: 5px;
        }

        #error-message {
            color: red;
            font-weight: bold;
            margin: 20px 0;
        }

        button {
            background-color: #6e0b0b; /* Rojo más oscuro */
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 10px;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #a1030b; /* Rojo más claro */
        }

        @media (max-width: 500px) {
            .container {
                padding: 15px;
            }

            .container img {
                max-width: 80px;
            }
        }
    </style>
</head>

<body>
    <div class="navbar">
        <a href="menu.php">
            <img src="https://cdn-icons-png.flaticon.com/512/25/25694.png" alt="Home Icon" /> <!-- Icono de casita -->
        </a>

        
    </div>


    <div class="container">
        <img src="imagenes/kayser_logo2-removebg-preview (1).png" alt="Logo">
        <h1>Scannea QR</h1>
        <img src="http://dab1nmslvvntp.cloudfront.net/wp-content/uploads/2017/07/1499401426qr_icon.svg" alt="Icono" class="qr-image"> 
        <input type="file" id="qr-image" accept="image/*" />
        <div id="qr-result"><span id="outputData"></span></div>
        <div id="error-message"></div>
        <form id="qrForm" action="process.php" method="POST" onsubmit="return validateForm()">
            <input type="hidden" id="qrText" name="qrText" value="" />
            <button type="submit">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search-heart" viewBox="0 0 16 16">
                    <path d="M6.5 4.482c1.664-1.673 5.825 1.254 0 5.018-5.825-3.764-1.664-6.69 0-5.018"/>
                    <path d="M13 6.5a6.47 6.47 0 0 1-1.258 3.844q.06.044.115.098l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1-.1-.115h.002A6.5 6.5 0 1 1 13 6.5M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11"/>
                </svg>
                Buscar
            </button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>
    <script>
        let qrCodeData = "";

        document.getElementById('qr-image').addEventListener('change', function() {
            const file = this.files[0];
            const reader = new FileReader();

            reader.onload = function() {
                const img = new Image();
                img.src = reader.result;

                img.onload = function() {
                    const canvas = document.createElement('canvas');
                    const context = canvas.getContext('2d');
                    canvas.width = img.width;
                    canvas.height = img.height;
                    context.drawImage(img, 0, 0, canvas.width, canvas.height);

                    const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
                    const code = jsQR(imageData.data, canvas.width, canvas.height);

                    if (code) {
                        qrCodeData = code.data;
                        document.getElementById('outputData').textContent = qrCodeData;
                        document.getElementById('qrText').value = qrCodeData;
                        document.getElementById('error-message').textContent = ""; // Limpia el mensaje de error
                    } else {
                        qrCodeData = "";
                        document.getElementById('outputData').textContent = "No se pudo leer el código QR.";
                        document.getElementById('error-message').textContent = "No se pudo detectar un código QR válido. Por favor, sube otra imagen.";
                    }
                };
            };

            reader.readAsDataURL(file);
        });

        function validateForm() {
            if (!qrCodeData) {
                document.getElementById('error-message').textContent = "¡Inserta un Qr valido!";
                return false; // Evita el envío del formulario
            }
            return true; // Permite el envío del formulario
        }
    </script>




</body>
</html>
 