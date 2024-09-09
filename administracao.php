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
    <title>CPO | Sistema Plano do Dia 2</title>
    <!-- Bootstrap CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap/icons/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <header class="banner w-100">
        <div class="container">
            <div class="text-center">
                <h3 class="py-3">Secretaria da Comissão de Promoções de Oficiais</h3>
            </div>
        </div>
    </header>
    <main class="container mt-3">
        <div class="row">
            <div class="col-sm-8">
                <div>
                    <h4 class="mb-0">Bem-vindo(a), <?php echo $_SESSION['fullname']; ?></h4>
                    <h3 class="mb-2">Sistema Plano do Dia 2 - Administração</h3>

                    <button class="mb-2 btn btn-primary btn-sm px-4 w-25" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuPrincipal" aria-controls="menuPrincipal">
                        Menu
                        <span class="bi bi-menu-button-wide-fill"></span>
                    </button>

                    <div class="controles-data">
                        <!-- Controles de Navegação do Ano -->
                        <div id="year-controls" class="controles-data d-flex justify-content-between align-items-center">
                            <button id="prev-year" class="controles-btn">
                                <span class="ps-3 fs-4 bi bi-rewind"></span>
                            </button>
                            <span id="current-year" class="fs-5 fw-bold controles-btn"></span>
                            <button id="next-year" class="controles-btn">
                                <span class="pe-3 fs-4 bi bi-fast-forward"></span>
                            </button>
                        </div>
                        <!-- Controles de Navegação do Mês -->
                        <div id="month-controls" class="d-flex justify-content-between align-items-center">
                            <button id="prev-month" class="controles-btn">
                                <span class="ps-3 fs-4 bi bi-rewind"></span>
                            </button>
                            <span id="current-month" class="fs-5 fw-bold controles-btn text-uppercase"></span>
                            <button id="next-month" class="controles-btn">
                                <span class="pe-3 fs-4 bi bi-fast-forward"></span>
                            </button>
                        </div>
                    </div>

                    <!-- Exibição do Calendário -->
                    <div id="calendar" class="table-responsive"></div>

                    <!-- Formulário para Ir para Data Específica -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <!-- Botão para Ir para a Data Atual -->
                        <div id="reset-controls">
                            <button id="reset-date" class="btn btn-success btn-sm px-4">
                                Data atual
                                <span class="bi bi-calendar2-check"></span>
                            </button>
                        </div>
                        <!-- Formulário para Ir para Data Específica -->
                        <div id="goto-date-controls">
                            <form id="goto-date-form" class="form-inline">
                                <h4 class="me-3">
                                    Ir para data específica:
                                </h4>
                                <div>
                                    <select id="goto-month" class="form-control form-control-sm">
                                        <option value="1">Janeiro</option>
                                        <option value="2">Fevereiro</option>
                                        <option value="3">Março</option>
                                        <option value="4">Abril</option>
                                        <option value="5">Maio</option>
                                        <option value="6">Junho</option>
                                        <option value="7">Julho</option>
                                        <option value="8">Agosto</option>
                                        <option value="9">Setembro</option>
                                        <option value="10">Outubro</option>
                                        <option value="11">Novembro</option>
                                        <option value="12">Dezembro</option>
                                    </select>
                                </div>
                                <div class="mx-sm-3">
                                    <input type="number" class="form-control form-control-sm" id="goto-year" placeholder="Ano" min="1900" max="2100">
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-goToDate btn-sm px-4">Ir</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-lista-pdfs col-md-4 text-center">
                <h3>Planos do Dia do Mês</h3>
                <div id="file-list" class="mt-4"></div>
            </div>
        </div>
    </main>
    <footer class="bg-primary text-light py-2">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <p class="mb-0">&copy; 2024 Comissão de Promoções de Oficiais. Todos os direitos reservados.</p>
                    <p class="mb-0">SysPD2 - Desenvolvido por Marcelo Dias</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Modal de Exclusão -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmar Exclusão</h5>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Você tem certeza que deseja excluir este arquivo?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger btn-sm" id="confirmDeleteBtn">Excluir</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmação de Exclusão -->
    <div id="confirmDeleteModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Excluído</h5>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="deleteMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de logout -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Sair do SysPD2</h5>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Deseja sair do sistema?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">
                        Não
                        <span class="bi bi-emoji-frown"></span>
                    </button>
                    <button type="button" class="btn btn-success btn-sm" id="logoutSistema">
                        Sim
                        <span class="bi bi-emoji-smile"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Principal Off-Canvas -->
    <div class="offcanvas offcanvas-end offcanvas-content" tabindex="-1" id="menuPrincipal" aria-labelledby="menuPrincipalLabel">
        <div class="text-end mt-3 me-3">
            <button class="btn btn-info btn-sm">Ajuda</button>
        </div>
        <div class="offcanvas-header">
            <span class="fs-4 bi bi-menu-button-wide-fill"></span>
            <h4 class="offcanvas-title">Menu SysPD2</h4>
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <p>Aenean urna quam, finibus vitae sem eget, dictum tincidunt est.
                Praesent suscipit ultricies justo, vitae tincidunt orci imperdiet sit amet.
                Sed ultricies eros non massa rutrum, malesuada blandit odio dictum.
            </p>
            <div id="upload-controls" class="mt-2">
                <button class="btn btn-warning btn-sm w-50" data-bs-toggle="modal" data-bs-target="#modalUpload">
                    Enviar Arquivo PDF
                    <span class="bi bi-cloud-upload"></span>
                    <span class="bi bi-file-earmark-pdf"></span>
                </button>
            </div>
            <div class="mt-2">
                <button class="btn btn-danger btn-sm w-50" data-bs-toggle="modal" data-bs-target="#logoutModal">
                    Sair do Sistema
                    <span class="bi bi-box-arrow-right"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Upload -->
    <div class="modal fade" id="modalUpload" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modalUploadLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Enviar PD</h5>
                    <button type="button" class="btn btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-sm">
                                Upload
                                <span class="bi bi-file-earmark-arrow-up"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Confirmação de Upload -->
    <div class="modal fade" id="messageModal" tabindex="-1" aria-hidden="true">
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

    <script src="js/scripts.js"></script>
    <script src="js/administracao.js"></script>
</body>

</html>