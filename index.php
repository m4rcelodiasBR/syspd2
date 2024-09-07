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
    <div class="container mt-3">
        <div class="row">
            <div class="col text-center">
                <h3 class="mb-3">Plano do Dia</h3>

                <div class="mb-3">
                    <span class="mx-2">Para enviar os arquivos de PD, faça o</span>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">
                        Login
                        <span class="bi bi-box-arrow-in-right"></span>
                    </button>
                </div>

                <!-- Exibição do Calendário -->
                <div id="calendar" class="table-responsive index-calendar"></div>

                <!-- Controles de Navegação do Mês -->
                <div class="controles-data">
                    <div id="month-controls" class="mb-3 d-flex justify-content-between">
                        <button id="prev-month" class="btn btn-primary">Mês Anterior</button>
                        <span id="current-month" class="mx-3"></span>
                        <button id="next-month" class="btn btn-primary">Próximo Mês</button>
                    </div>

                    <!-- Controles de Navegação do Ano -->
                    <div id="year-controls" class="mb-3 d-flex justify-content-between">
                        <button id="prev-year" class="btn btn-primary">Ano Anterior</button>
                        <span id="current-year" class="mx-3"></span>
                        <button id="next-year" class="btn btn-primary">Próximo Ano</button>
                    </div>
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
                        <h4 class="me-3">
                            Ir para data específica:
                        </h4>
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
                            <input type="number" class="form-control" id="goto-year" placeholder="Ano" min="1900"
                                max="2100">
                        </div>
                        <button type="submit" class="btn btn-info mb-2">Ir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

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