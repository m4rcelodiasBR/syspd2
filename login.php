<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
$username = $data['username'];
$password = $data['password'];

// Lê o arquivo de configuração de usuários
$lines = file('users.conf', FILE_IGNORE_NEW_LINES);

$valid = false;
$userName = "";

foreach ($lines as $line) {
    list($fileUser, $filePass, $fileName) = explode(':', trim($line));
    if ($fileUser === $username && $filePass === $password) {
        $valid = true;
        $userName = $fileName; // Guarda o nome completo
        break;
    }
}

if ($valid) {
    session_start();
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $username;
    $_SESSION['name'] = $userName; // Adiciona o nome à sessão
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Usuário ou senha inválidos']);
}
?>

