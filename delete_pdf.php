<?php
header('Content-Type: application/json');

$year = $_GET['year'] ?? '';
$month = $_GET['month'] ?? '';
$file = $_GET['file'] ?? '';

$directory = "uploads/{$year}/" . str_pad($month, 2, '0', STR_PAD_LEFT);
$filePath = "{$directory}/{$file}";
$trashDir = ".trash/{$year}/" . str_pad($month, 2, '0', STR_PAD_LEFT);

if (!is_dir($trashDir)) {
    mkdir($trashDir, 0777, true);
}

$trashFilePath = "{$trashDir}/{$file}";

if (file_exists($filePath)) {
    if (rename($filePath, $trashFilePath)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao excluir o arquivo.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Arquivo não encontrado.']);
}
?>