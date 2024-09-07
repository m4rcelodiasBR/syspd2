<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: /syspd2');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CPO | Enviar PDF</title>
    <!-- Bootstrap CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap/icons/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <div class="container mt-3">
        <div class="row">
            <div class="col text-center upload-page">
                <h3 class="mb-3">Enviar PDF para o Plano do Dia</h3>

                <!-- Formulário de Upload -->
                <form action="upload.php" method="post" enctype="multipart/form-data">
                    <div class="form-group mb-3 mx-5 px-5">
                        <label for="pdf-date">Selecione a Data:</label>
                        <input type="date" id="pdf-date" name="date" class="form-control" required>
                    </div>
                    <div class="form-group mb-3 mx-5 px-5">
                        <label for="pdf-file">Selecione o Arquivo PDF:</label>
                        <input type="file" id="pdf-file" name="pdf-file" class="form-control" accept="application/pdf"
                            required>
                    </div>
                    <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary mx-3">
                        Upload
                        <span class="bi bi-file-earmark-arrow-up"></span>
                    </button>
                    <a href="administracao.php" class="btn btn-danger mx-3">
                        Voltar
                        <span class="bi bi-skip-backward"></span>
                    </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal do Bootstrap -->
    <div class="modal fade" id="messageModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="messageModalLabel">Informação</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="modalMessage" class="alert"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery e Bootstrap JS -->
    <script src="js/jquery-3.7.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <script src="js/upload.js"></script>
  
</body>

</html>