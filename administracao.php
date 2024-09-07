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
                <div class="text-center">

                    <h3 class="mb-3">Sistema Plano do Dia 2 - Administração</h3>

                    <div id="upload-controls" class="mb-3">
                        <a href="upload-pd.php" class="btn btn-warning">Enviar PDF</a>
                    </div>

                    <!-- Exibição do Calendário -->
                    <div id="calendar" class="table-responsive"></div>

                    <!-- Controles de Navegação do Mês -->
                    <div id="month-controls" class="mb-3 d-flex justify-content-between">
                        <button id="prev-month" class="btn btn-primary">Mês Anterior</button>
                        <span id="current-month" class="mx-4"></span>
                        <button id="next-month" class="btn btn-primary">Próximo Mês</button>
                    </div>

                    <!-- Controles de Navegação do Ano -->
                    <div id="year-controls" class="mb-3 d-flex justify-content-between">
                        <button id="prev-year" class="btn btn-primary">Ano Anterior</button>
                        <span id="current-year" class="mx-5"></span>
                        <button id="next-year" class="btn btn-primary">Próximo Ano</button>
                    </div>

                    <!-- Botão para Ir para a Data Atual -->
                    <div id="reset-controls" class="mb-3">
                        <button id="reset-date" class="btn btn-success">
                            Data atual
                            <span class="bi bi-calendar2-check"></span>
                        </button>
                    </div>

                    <!-- Formulário para Ir para Data Específica -->
                    <div id="goto-date-controls" class="mt-3">
                        <form id="goto-date-form" class="form-inline justify-content-center">
                            <h4 class="me-3">Ir para Data Específica:</h4>
                            <div class="form-group mb-3">
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
                            <div class="form-group mx-sm-3 mb-3">
                                <input type="number" class="form-control" id="goto-year" placeholder="Ano" min="1800"
                                    max="2500">
                            </div>
                            <button type="submit" class="btn btn-info mb-3">Ir</button>
                        </form>
                    </div>
                    <div class="text-center">
                        <button class="mt-3 btn btn-danger" data-bs-toggle="modal" data-bs-target="#logoutModal">
                            Sair do Sistema
                            <span class="bi bi-box-arrow-right"></span>
                        </button>
                    </div>
                </div>
            </div>
            <div id="pdf-list" class="col-md-4 text-center">
                <h3>Arquivos PDF do Mês</h3>
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
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Não</button>
                        <button type="button" class="btn btn-success" id="logoutSistema">Sim</button>
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