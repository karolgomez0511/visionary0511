

  document.getElementById('btnGenerarQR').addEventListener('click', function () {
    var codigoBarras = document.getElementById('codigo').value; // Puedes cambiar esto según tu necesidad
    generarQR(codigoBarras);
  });

  function generarQR(codigo) {
    var qrContainer = document.getElementById('qrContainer');
    qrContainer.innerHTML = ''; // Limpiar contenido anterior

    var qr = new QRCode(qrContainer, {
      text: codigo,
      width: 128,
      height: 128,
    });
  }




    
