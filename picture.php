<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escanear Código de Barras</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 100%;
            max-width: 800px;
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 15px;
            width: 100%;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        .btn-submit {
            background-color: #750606;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-submit:hover {
            background-color: #a1030b;
        }

        .codigo-escaneado {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
            color: #750606;
        }

        .container img {
            max-width: 300px;
            margin-bottom: 20px;
        }

        .qr-image {
            max-width: 150px;
            margin-bottom: 20px;
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
    <div class="container">
        <form action="procesar_codigo.php" method="post" id="barcodeForm">
            <center>
                <img src="imagenes/kayser_logo2-removebg-preview (1).png" alt="Logo">
                <h3>Escanea el código QR</h3>
                <img src="http://dab1nmslvvntp.cloudfront.net/wp-content/uploads/2017/07/1499401426qr_icon.svg" alt="Icono" class="qr-image">
            </center>
            <div class="form-group">
                <input type="text" id="barcodeInput" name="barcode" placeholder="Escanea el código" oninput="handleInput(event)" autofocus>
            </div>
            <center>
                <button type="submit" class="btn-submit"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
  <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
</svg> Buscar</button>
            </center>
        </form>
        <div class="codigo-escaneado" id="codigoEscaneado"></div>
    </div>

    <script>
    function handleInput(event) {
        const codigo = event.target.value;
        const codigoEscaneadoDiv = document.getElementById('codigoEscaneado');

        // Muestra el código escaneado en la pantalla
        codigoEscaneadoDiv.textContent = `Código QR escaneado: ${codigo}`;

        // Extraer el ID del formato "id:89"
        const match = codigo.match(/id:(\d+)/);
        if (match) {
            const id = match[1];
            
            // Verifica si el input oculto ya existe
            let hiddenInput = document.querySelector('input[name="elemento_id"]');
            if (!hiddenInput) {
                // Si no existe, créalo
                hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'elemento_id';
                document.getElementById('barcodeForm').appendChild(hiddenInput);
            }
            
            // Asigna el ID extraído al campo oculto
            hiddenInput.value = id;

            // Mostrar el ID en la consola
            console.log("ID extraído:", id);

            // Enviar automáticamente el formulario si la longitud es adecuada
            if (codigo.length > 5) {
                document.getElementById('barcodeForm').submit();
            }
        }
    }
</script>

</body>
</html>
