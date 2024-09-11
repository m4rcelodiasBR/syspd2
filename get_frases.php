<?php
// Carrega o conteúdo do arquivo JSON
$frasesJson = file_get_contents('frases.json');
$frasesData = json_decode($frasesJson, true);

// Verifica se o JSON foi decodificado corretamente e contém a chave 'frases'
if (isset($frasesData['frases']) && is_array($frasesData['frases'])) {
    $frases = $frasesData['frases'];

    // Obtém o dia atual (baseado no índice 0 para o primeiro dia do mês)
    $diaAtual = date('j') - 1; // `j` retorna o dia sem o zero à esquerda

    // Seleciona a frase do dia
    $fraseDoDia = $frases[$diaAtual % count($frases)]; // Garantindo que o índice não exceda o tamanho do array

    // Retorna a frase como JSON
    echo json_encode(['frase' => $fraseDoDia]);
} else {
    echo json_encode(['frase' => 'Não foi possível carregar a frase do dia.']);
}
?>
