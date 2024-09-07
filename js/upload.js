//Controle de confirmação do Upload
$(document).ready(function () {
    // Obtém a mensagem e o tipo da query string
    const urlParams = new URLSearchParams(window.location.search);
    const message = urlParams.get('message');
    const type = urlParams.get('type');
  
    if (message) {
      console.log("Message found:", message);
      console.log("Message type:", type);
      // Configura o conteúdo e a classe do alerta no modal
      $('#modalMessage').text(message).removeClass('alert-success alert-danger').addClass(`alert-${type}`);
      console.log("Modal should be shown now.");
      // Exibe o modal
      $('#messageModal').modal('show');
    } else {
      console.log("No message found.");
    }
  });