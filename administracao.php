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
    <div class="container mt-3">
        <div class="row">
            <div class="col-sm-8">
                <div>
                    <h4 class="mb-0">Bem-vindo(a), <?php echo $_SESSION['fullname']; ?></h4>
                    <h3 class="mb-2">Sistema Plano do Dia 2 - Administração</h3>

                    <button class="mb-2 btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuPrincipal" aria-controls="menuPrincipal">
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

                    <!-- Botão para Ir para a Data Atual -->
                    <div id="reset-controls" class="text-center mb-2">
                        <button id="reset-date" class="btn btn-success">
                            Data atual
                            <span class="bi bi-calendar2-check"></span>
                        </button>
                    </div>

                    <!-- Formulário para Ir para Data Específica -->
                    <div id="goto-date-controls" class="mt-3">
                        <form id="goto-date-form" class="form-inline justify-content-center">
                            <h4 class="me-3">Ir para Data Específica:</h4>
                            <div class="form-group mb-2">
                                <select id="goto-month" class="form-control">
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
                            <div class="form-group mx-sm-3 mb-2">
                                <input type="number" class="form-control" id="goto-year" placeholder="Ano" min="1800"
                                    max="2500">
                            </div>
                            <button type="submit" class="btn btn-goToDate mb-2">Ir</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <h3>Planos do Dia do Mês</h3>
                <div id="file-list" class="mt-4"></div>
            </div>
        </div>

        <!-- Modal de Exclusão -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Confirmar Exclusão</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Você tem certeza que deseja excluir este arquivo?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Excluir</button>
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
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="deleteMessage"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Fechar</button>
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
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Deseja sair do sistema?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                            Não
                            <span class="bi bi-emoji-frown"></span>
                        </button>
                        <button type="button" class="btn btn-success" id="logoutSistema">
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
                <button class="btn btn-info">Ajuda</button>
            </div>
            <div class="offcanvas-header">
                <h4 class="offcanvas-title">Menu SysPD2</h4>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <p>Aenean urna quam, finibus vitae sem eget, dictum tincidunt est.
                    Praesent suscipit ultricies justo, vitae tincidunt orci imperdiet sit amet.
                    Sed ultricies eros non massa rutrum, malesuada blandit odio dictum.
                </p>
                <div id="upload-controls" class="mt-2">
                    <a href="upload-pd.php" class="btn btn-warning">
                        Enviar Arquivo PDF
                        <span class="bi bi-cloud-upload"></span>
                        <span class="bi bi-file-earmark-pdf"></span>
                    </a>
                </div>
                <div class="mt-2">
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#logoutModal">
                        Sair do Sistema
                        <span class="bi bi-box-arrow-right"></span>
                    </button>
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