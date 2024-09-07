<?php
header('Content-Type: application/json');

$year = $_GET['year'] ?? '';
$month = $_GET['month'] ?? '';
$file = $_GET['file'] ?? '';

$directory = "uploads/{$year}/" . str_pad($month, 2, '0', STR_PAD_LEFT);
$filePath = "{$directory}/{$file}";

if (file_exists($filePath)) {
    if (unlink($filePath)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao excluir o arquivo.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Arquivo não encontrado.']);
}
?>
