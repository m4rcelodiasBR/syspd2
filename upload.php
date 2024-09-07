<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['pdf-file']) && $_FILES['pdf-file']['error'] === UPLOAD_ERR_OK) {
        // Dados do arquivo
        $fileTmpPath = $_FILES['pdf-file']['tmp_name'];
        $fileName = $_FILES['pdf-file']['name'];
        $fileSize = $_FILES['pdf-file']['size'];
        $fileType = $_FILES['pdf-file']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        if ($fileExtension !== 'pdf' || $fileType !== 'application/pdf') {
            $message = "Apenas arquivos PDF são permitidos.";
            $type = "danger";
            header("Location: upload-pd.php?message=" . urlencode($message) . "&type=" . urlencode($type));
            exit;
        }

        // Dados da data
        if (isset($_POST['date']) && !empty($_POST['date'])) {
            $date = $_POST['date'];
            $fileDate = DateTime::createFromFormat('Y-m-d', $date);
            
            if ($fileDate === false) {
                $message = "Data inválida.";
                $messageType = "danger";
            }

            // Formata o ano, mês e dia
            $year = $fileDate->format('Y');
            $month = $fileDate->format('m');
            $day = $fileDate->format('d');

            // Diretório baseado em ano/mês
            $uploadDir = __DIR__ . "/uploads/$year/$month/";

            // Cria o diretório se não existir
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Nome do arquivo baseado no dia, ex: "19.pdf"
            $newFileName = "$day.pdf";

            $targetPath = $uploadDir . $newFileName;

            // Move o arquivo para o diretório de uploads
            if (move_uploaded_file($fileTmpPath, $targetPath)) {
                $message = "Arquivo carregado com sucesso.";
                $messageType = "success";
            } else {
                $message = "Erro ao mover o arquivo para o diretório de uploads.";
                $messageType = "danger";
            }
        } else {
            $message = "Data não fornecida.";
            $messageType = "danger";
        }
    } else {
        $message = "Nenhum arquivo carregado ou erro no upload.";
        $messageType = "danger";
    }
    header("Location: upload-pd.php?message=" . urlencode($message) . "&type=" . urlencode($messageType));
    exit();
} else {
    header("Location: upload-pd.php");
    exit();
}
?>
