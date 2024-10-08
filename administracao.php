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
                <h3 class="py-2 octin-font">Secretaria da Comissão de Promoções de Oficiais</h3>
            </div>
        </div>
    </header>
    <main class="container mt-3">
        <div class="row">
            <div class="col-sm-8">
                <div>
                    <h6 class="mb-0">Bem-vindo(a), <?php echo $_SESSION['fullname']; ?></h6>
                    <h3 class="mb-2 octin-font fw-bold">Sistema Plano do Dia 2 - Administração</h3>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <button class="btn btn-primary btn-sm px-3 btn-size-custom" type="button"
                                data-bs-toggle="offcanvas" data-bs-target="#menuPrincipal"
                                aria-controls="menuPrincipal">
                                Menu
                                <span class="bi bi-menu-button-wide-fill"></span>
                            </button>
                        </div>
                        <div id="clock" class="fw-bold btn btn-outline-primary btn-sm px-5"></div>
                    </div>

                    <div class="controles-data">
                        <!-- Controles de Navegação do Ano -->
                        <div id="year-controls" class="d-flex justify-content-between align-items-center">
                            <button id="prev-year" class="controles-btn">
                                <span class="controles-btn-arrows ps-3 fs-4 bi bi-rewind"></span>
                            </button>
                            <span id="current-year" class="fs-4 octin-font fw-bold controles-btn"></span>
                            <button id="next-year" class="controles-btn">
                                <span class="controles-btn-arrows pe-3 fs-4 bi bi-fast-forward"></span>
                            </button>
                        </div>
                        <!-- Controles de Navegação do Mês -->
                        <div id="month-controls" class="d-flex justify-content-between align-items-center">
                            <button id="prev-month" class="controles-btn">
                                <span class="controles-btn-arrows ps-3 fs-4 bi bi-rewind"></span>
                            </button>
                            <span id="current-month" class="fs-5 octin-font controles-btn"></span>
                            <button id="next-month" class="controles-btn">
                                <span class="controles-btn-arrows pe-3 fs-4 bi bi-fast-forward"></span>
                            </button>
                        </div>
                    </div>

                    <!-- Exibição do Calendário -->
                    <div id="calendar" class="table-responsive"></div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <!-- Botão para Ir para a Data Atual -->
                        <div id="reset-controls">
                            <button id="reset-date" class="btn btn-primary btn-sm px-3 btn-size-custom">
                                Hoje
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
                                    <input type="number" class="form-control form-control-sm" id="goto-year"
                                        placeholder="Ano" min="1900" max="2100">
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary btn-sm px-3">Ir</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-lista-pdfs col-sm-4 text-center">
                <div class="container-lista-pdfs-title position-sticky text-dark top-0 py-1">
                    <h4>Planos do Dia do Mês</h4>
                    <hr>
                </div>
                <div id="spinner" class="spinner-border text-primary mx-auto" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div id="file-list"></div>
            </div>
        </div>
    </main>
    <footer class="py-2">
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
            <div class="modal-content bg-danger">
                <div class="modal-header text-light">
                    <h5 class="modal-title" id="deleteModalLabel">ATENÇÃO</h5>
                    <button type="button" class="btn bg-light btn-close btn-sm" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body fw-bold text-light">
                    Você tem certeza que deseja excluir este arquivo?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-warning btn-sm" id="confirmDeleteBtn">Excluir</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmação de Exclusão -->
    <div id="confirmDeleteModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Excluído</h5>
                    <button type="button" class="btn bg-light btn-close btn-sm" data-bs-dismiss="modal"
                        aria-label="Close"></button>
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
                <div class="modal-header bg-danger text-light">
                    <h5 class="modal-title" id="logoutModalLabel">Sair do SysPD2</h5>
                    <button type="button" class="btn bg-light btn-close btn-sm" data-bs-dismiss="modal"
                        aria-label="Close"></button>
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
    <div class="offcanvas offcanvas-end offcanvas-content" tabindex="-1" id="menuPrincipal"
        aria-labelledby="menuPrincipalLabel">
        <div class="offcanvas-header">
            <span class="fs-4 bi bi-menu-button-wide-fill me-2"></span>
            <h4 class="offcanvas-title">Menu SysPD2</h4>
            <button type="button" class="btn bg-light btn-close btn-sm" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <p class="pb-2">Aenean urna quam, finibus vitae sem eget, dictum tincidunt est.
                Praesent suscipit ultricies justo, vitae tincidunt orci imperdiet sit amet.
                Sed ultricies eros non massa rutrum, malesuada blandit odio dictum.
            </p>
            <div id="upload-controls" class="mt-2">
                <button class="btn btn-primary btn-sm w-50" data-bs-toggle="modal" data-bs-target="#modalUpload">
                    Enviar Arquivo PDF
                    <span class="bi bi-cloud-upload"></span>
                    <span class="bi bi-file-earmark-pdf"></span>
                </button>
            </div>
            <div class="mt-2">
                <button class="btn btn-primary btn-sm px-3 w-50" type="button" data-bs-toggle="modal"
                    data-bs-target="#modalSobre" aria-controls="modalSobre">
                    Sobre
                    <span class="bi bi-three-dots"></span>
                </button>
            </div>
            <div class="mt-2">
                <button class="btn btn-warning btn-sm px-3 w-50" type="button" data-bs-toggle="modal"
                    data-bs-target="#modalAjuda" aria-controls="modalAjuda">
                    Ajuda
                    <span class="bi bi-patch-question"></span>
                </button>
            </div>
        </div>
        <div class="offcanvas-footer">
            <div class="ms-3 mb-3">
                <button class="btn btn-danger btn-sm px-3" data-bs-toggle="modal" data-bs-target="#logoutModal">
                    Sair do Sistema
                    <span class="bi bi-box-arrow-right"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Upload -->
    <div class="modal fade" id="modalUpload" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="modalUploadLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-light">
                    <h5 class="modal-title" id="logoutModalLabel">Enviar PD</h5>
                    <button type="button" class="btn bg-light btn-close btn-sm" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <form action="upload.php" method="post" enctype="multipart/form-data">
                        <div class="form-group mb-3 mx-5 px-5">
                            <label for="pdf-date">Selecione a Data:</label>
                            <input type="date" id="pdf-date" name="date" class="form-control" required>
                        </div>
                        <div class="form-group mb-3 mx-5 px-5">
                            <label for="pdf-file">Selecione o Arquivo PDF:</label>
                            <input type="file" id="pdf-file" name="pdf-file" class="form-control"
                                accept="application/pdf" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit " class="btn btn-primary btn-sm">
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
            <div class="modal-content" id="modal-content">
                <div id="modal-header" class="modal-header text-light">
                    <h5 class="modal-title" id="messageModalLabel">Mensagem</h5>
                    <button type="button" class="btn bg-light btn-close btn-sm" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div id="modal-body" class="modal-body">
                    <div id="modalMessage"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Sobre -->
    <div class="modal fade" id="modalSobre" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSobreLabel">Sobre o SysPD2</h5>
                    <button type="button" class="btn btn-close bg-light btn-sm" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-dark">
                        Este sistema foi desenvolvido para facilitar o gerenciamento de arquivos PDF,
                        utilizando Bootstrap 5 e as mais recentes tecnologias web. Ele permite o upload,
                        visualização e exclusão de documentos de forma simples e segura, com navegação por
                        meio de um calendário intuitivo. Além disso, conta com um sistema de autenticação para
                        garantir que apenas usuários autorizados acessem funcionalidades críticas.
                    </p>
                </div>
                <div class="modal-footer pt-0">
                    <p class="fw-bolder">Versão da Build: <span>2.0</span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ajuda -->
    <div class="modal fade" id="modalAjuda" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="modalSobreLabel">Ajuda do Sistema Plano do Dia 2</h5>
                    <button type="button" class="btn btn-close bg-light btn-sm" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-2">
                        <h5>1. Administrando o Sistema</h5>
                        <ol>
                            <li>
                                <strong>Login:</strong>
                                <p>Na página inicial, clique no botão <em>Login</em>. Uma tela aparecerá solicitando
                                    suas credenciais.</p>
                                <ul>
                                    <li><strong>Usuário:</strong> Insira seu nome de usuário, conforme registrado pelo
                                        administrador.</li>
                                    <li><strong>Senha:</strong> Digite a senha associada ao seu usuário.</li>
                                </ul>
                            </li>
                            <li>
                                <strong>Acessando a Área Administrativa:</strong>
                                <p>Após inserir as credenciais corretamente, você será redirecionado para a área
                                    administrativa, onde poderá gerenciar os arquivos PDF dos Planos do Dia.</p>
                            </li>
                        </ol>
                        <h5>2. Upload dos Arquivos PDF</h5>
                        <ol>
                            <li>
                                <strong>Acesse a Seção de Upload:</strong>
                                <p>No menu principal, clique no botão <em>Enviar Arquivo PDF</em>. Uma janela será exibida
                                    para que você selecione o arquivo.</p>
                            </li>
                            <li>
                                <strong>Defina a data:</strong>
                                <p>Clique no campo <em>Data</em> e escolha o dia a qual será associado o PD.</p>
                            </li>
                            <li>
                                <strong>Escolha o Arquivo:</strong>
                                <p>Clique no botão <em>Selecionar Arquivo</em>, procure e selecione o PDF desejado em seu
                                    computador.</p>
                            </li>
                            <li>
                                <strong>Confirme o Upload:</strong>
                                <p>Após selecionar o arquivo, clique no botão <em>Upload</em>. Uma mensagem de
                                    confirmação será exibida, indicando que o arquivo foi enviado com sucesso.</p>
                                <p>Caso uma mensagem de erro apareça, consulte o Administrador do Sistema (CPO-20).</p>
                                <strong><em>Nota:</em></strong>
                                <p>Cuidado com o tamanho do arquivo a ser enviado. Máximo é de 6MB.</p>
                            </li>
                        </ol>
                        <h5>3. Gerenciar Arquivos PDF</h5>
                        <ol>
                            <li>
                                <strong>Visualizando PDFs enviados:</strong>
                                <p>Todos os PDFs serão listados ao lado de acordo com o mês exibido em tela. Clique no
                                    nome do arquivo para visualizar.</p>
                            </li>
                            <li>
                                <strong>Excluindo Arquivos:</strong>
                                <p>Para excluir um arquivo:</p>
                                <ul>
                                    <li>Clique no ícone da lixeira ao lado do PDF.</li>
                                    <li>Uma confirmação será exibida.</li>
                                    <li>Após confirmar a exclusão, o arquivo será removido e não será mais
                                        visível na lista <em>Plano do Dia do Mês</em>.</li>
                                </ul>
                            </li>
                        </ol>
                        <h5>4. Navegando para uma Data Específica</h5>
                        <ol>
                            <li>
                                <strong>Selecione a Data:</strong>
                                <p>Use o seletor de mês e ano no forumlário localizado abaixo do calendário para escolher a data desejada.
                                </p>
                            </li>
                            <li>
                                <strong>Clique em Ir:</strong>
                                <p>O sistema listará automaticamente os PDFs enviados naquele mês específico.</p>
                            </li>
                        </ol>
                        <h5>5. Contas de Usuário</h5>
                        <ol>
                            <li>
                                <p>Para cadastro e exclusão dos usuários, deve-se enviar um e-mail para o Administrador do Sistema,
                                    solicitando as mudanças necessárias.</p>
                            </li>
                        </ol>
                        <h5>6. Efetuando Logout</h5>
                        <ol>
                            <li>
                                <strong>Clique em Sair do Sistema:</strong>
                                <p>No canto superior direito, clique no botão <em>Logout</em>.</p>
                            </li>
                            <li>
                                <strong>Confirmação:</strong>
                                <p>Após clicar, você será redirecionado para a página inicial do sistema e precisará
                                    fazer login novamente para ter acesso à área administrativa.</p>
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="modal-footer bg-warning">
                    <button type="button" class="btn btn-primary btn-sm px-5" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery e Bootstrap JS -->
    <script src="js/jquery-3.7.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <script src="js/scripts.js"></script>
    <script src="js/administracao.js"></script>
</body>

</html>