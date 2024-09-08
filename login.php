<?php
$data = json_decode(file_get_contents('php://input'), true);
$username = $data['username'];
$password = $data['password'];

// Lê o arquivo de configuração de usuários
$lines = file('users.conf', FILE_IGNORE_NEW_LINES);

$valid = false;
$userFullName = '';

foreach ($lines as $line) {
    list($fileUser, $filePass, $fileName) = explode(':', trim($line));
    if ($fileUser === $username && $filePass === $password) {
        $valid = true;
        $userFullName = $fileName;
        break;
    }
}
if ($valid) {
    session_start();
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $username;
    $_SESSION['fullname'] = $userFullName;
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Usuário ou senha inválidos']);
}
?>