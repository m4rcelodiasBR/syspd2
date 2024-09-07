<?php
header('Content-Type: application/json');

$year = $_GET['year'] ?? '';
$month = $_GET['month'] ?? '';

if (empty($year) || empty($month)) {
    echo json_encode(['status' => 'error', 'message' => 'Ano ou mês não fornecidos.']);
    exit;
}

$directory = "uploads/{$year}/" . str_pad($month, 2, '0', STR_PAD_LEFT);

if (!is_dir($directory)) {
    echo json_encode(['status' => 'success', 'files' => []]);
    exit;
}

$files = array_diff(scandir($directory), ['.', '..']);
$pdfFiles = array_filter($files, function($file) {
    return pathinfo($file, PATHINFO_EXTENSION) === 'pdf';
});

echo json_encode(['status' => 'success', 'files' => array_values($pdfFiles)]);
?>
