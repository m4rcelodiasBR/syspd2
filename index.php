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
    <header class="banner w-100">
        <div class="container">
            <div class="text-center">
                <h3 class="py-3 octin-font">Secretaria da Comissão de Promoções de Oficiais</h3>
            </div>
        </div>
    </header>
    <main class="container">
        <div class="row">
            <div class="col index-calendar">
                <div class="text-center">
                    <h3>Plano do Dia</h3>
                    <div id="frase-do-dia" class="text-success fw-bold text-center mb-1"></div>
                </div>
                <div class="controles-data">
                    <!-- Controles de Navegação do Ano -->
                    <div id="year-controls" class="controles-data d-flex justify-content-between align-items-center">
                        <button id="prev-year" class="controles-btn">
                            <span class="ps-3 fs-4 bi bi-rewind"></span>
                        </button>
                        <span id="current-year" class="octin-font controles-btn"></span>
                        <button id="next-year" class="controles-btn">
                            <span class="pe-3 fs-4 bi bi-fast-forward"></span>
                        </button>
                    </div>
                    <!-- Controles de Navegação do Mês -->
                    <div id="month-controls" class="d-flex justify-content-between align-items-center">
                        <button id="prev-month" class="controles-btn">
                            <span class="ps-3 fs-4 bi bi-rewind"></span>
                        </button>
                        <span id="current-month" class="octin-font controles-btn"></span>
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
                        <button id="reset-date" class="btn btn-warning btn-sm">
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
                                <button type="submit" class="btn btn-goToDate btn-sm px-5">Ir</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Login no sistema -->
                <hr class="bg-dark">
                <div class="text-center mb-3">
                    <div class="mt-3">
                        <span class="me-2">Acesso para os administradores: </span>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#loginModal">
                            Login
                            <span class="bi bi-box-arrow-in-right"></span>
                        </button>
                    </div>
                </div>
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


    <!-- Modal de Login -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-light">
                    <h5 class="modal-title" id="loginModalLabel">Efetuar login no SysPD2</h5>
                    <button type="button" class="btn btn-close bg-light btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-success text-center">
                    <form id="login-form">
                        <div class="mb-3 form-floating">
                            <input type="text" class="form-control" id="username" required placeholder="Usuário">
                            <label for="username" class="form-label">Usuário</label>
                        </div>
                        <div class="mb-3 form-floating">
                            <input type="password" class="form-control" id="password" required placeholder="Senha">
                            <label for="password" class="form-label">Senha</label>
                        </div>
                        <button type="submit" class="px-5 btn btn-light">
                            Login
                            <span class="bi bi-box-arrow-in-right"></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery e Bootstrap JS -->
    <script src="js/jquery-3.7.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <script src="js/scripts.js"></script>
    <script src="js/login.js"></script>
</body>

</html>