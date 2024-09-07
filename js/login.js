// Controle de Login
document.getElementById("login-form").addEventListener("submit", function (e) {
  e.preventDefault();

  const username = document.getElementById("username").value;
  const password = document.getElementById("password").value;

  fetch('login.php', {
    method: 'POST',
    headers: {
      'Content-Type':'application/json'
    },
    body: JSON.stringify({ username, password }),
  })
    .then(response => response.json())
    .then(data => {
      if (data.status === 'success') {
        window.location.href = "administracao.php"; // Redireciona para a página de Administração
      } else {
        alert('Login inválido');
      }
    })
    .catch(error => {
      console.error('Erro ao efetuar login:', error);
    });
});