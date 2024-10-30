document.addEventListener("DOMContentLoaded", () => {
  const qrCodeReader = new Html5Qrcode("qr-reader");

  function onScanSuccess(decodedText, decodedResult) {
      document.getElementById('result').innerText = `QR Code Detected: ${decodedText}`;
  }

  function onScanError(errorMessage) {
      console.log(`QR Code Scan Error: ${errorMessage}`);
  }

  qrCodeReader.start(
      { facingMode: "environment" },
      {
          fps: 10,
          qrbox: { width: 250, height: 250 }
      },
      onScanSuccess,
      onScanError
  ).catch(err => {
      console.error(`Error starting the QR code scanner: ${err}`);
      // Provide user feedback or retry logic here
      document.getElementById('result').innerText = `Error starting the scanner: ${err.message}`;
  });
});


console.log(typeof Html5Qrcode);
