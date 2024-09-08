<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CPO | Plano do Dia</title>
    <!-- Bootstrap CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap/icons/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <div class="banner">
        <div class="container">
            <div class="text-center">
                <h3 class="">
                    Secretaria da Comissão de Promoções de Oficiais
                </h3>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col index-calendar">
                <div class="text-center">
                    <h3>Plano do Dia</h3>
                    <p class="mb-2"> Os dias com Plano do Dia disponíveis estão
                        marcados com o ícone <span class="fs-5 bi bi-file-earmark-pdf-fill pdf-icon"></span>
                    </p>
                </div>
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

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <!-- Botão para Ir para a Data Atual -->
                    <div id="reset-controls">
                        <button id="reset-date" class="btn btn-success btn-sm">
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
                                <button type="submit" class="btn btn-goToDate btn-sm">Ir</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Login no sistema -->
                <div class="text-center acesso-login">
                    <div class="mt-3">
                        <span class="me-2">Acesso para os administradores: </span>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#loginModal">
                            Login
                            <span class="bi bi-box-arrow-in-right"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Login -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Efetuar login no SysPD2</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <form id="login-form">
                        <div class="mb-3 form-floating">
                            <input type="text" class="form-control" id="username" required placeholder="Usuário">
                            <label for="username" class="form-label">Usuário</label>
                        </div>
                        <div class="mb-3 form-floating">
                            <input type="password" class="form-control" id="password" required placeholder="Senha">
                            <label for="password" class="form-label">Senha</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery e Bootstrap JS -->
    <script src="js/jquery-3.7.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <script src="js/scripts.js"></script>
    <script src="js/login.js"></script>
</body>

</html>