<?php
header('Content-Type: application/json');

$year = $_GET['year'] ?? '';
$month = $_GET['month'] ?? '';

// Diretório de uploads
$directory = "uploads/{$year}/" . str_pad($month, 2, '0', STR_PAD_LEFT);

// Verifica se o diretório existe
if (is_dir($directory)) {
    // Abre o diretório e lê os arquivos
    $files = array_diff(scandir($directory), array('..', '.'));
    $pdfFiles = [];

    // Filtra apenas arquivos PDF
    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'pdf') {
            $pdfFiles[] = $file; // Adiciona à lista de arquivos PDF
        }
    }

    if (!empty($pdfFiles)) {
        echo json_encode(['status' => 'success', 'files' => $pdfFiles]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Nenhum PDF encontrado.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Diretório não encontrado.']);
}
?>