<?php
if (isset($_GET['date'])) {
    $date = $_GET['date'];
    
    // Verifica se a data está no formato correto
    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
        list($year, $month, $day) = explode('-', $date);
        // Constrói o caminho para o diretório onde os PDFs estão armazenados
        $filePath = __DIR__ . "/uploads/$year/$month/$day.pdf";
        var_dump($filePath);
        // Verifica se o arquivo existe e retorna a resposta adequada
        if (file_exists($filePath)) {
            echo 'Ver PDF'; // Indica que o PDF existe
        } else {
            echo 'Não encontrado'; // Indica que o PDF não foi encontrado
        }
    } else {
        echo 'Data inválida'; // Retorna uma mensagem de erro se a data estiver em formato inválido
    }
} else {
    echo 'Data não fornecida'; // Retorna uma mensagem de erro se a data não for fornecida
}
?>
