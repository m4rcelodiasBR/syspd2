<?php
session_start();
session_destroy();

// Retornar uma resposta JSON
echo json_encode(['status' => 'success']);
exit;
?>
