<?php
require_once __DIR__ . '/../model/Pesquisa.php';

$filtro = $_POST['filtro'] ?? 'tudo';
$termo  = $_POST['termo'] ?? '';

$pesq = new Pesquisa();
$resultados = $pesq->Pesquisar($filtro, $termo);

// Se não achar nada
if (empty($resultados)) {
    echo "<div class='alert alert-warning'>Nenhum resultado encontrado.</div>";
    exit;
}

// Exibir resultados
foreach ($resultados as $r) {

    echo "<div class='p-3 mb-3 bg-dark text-white rounded'>";
    echo "<h4>" . $r['titulo'] . "</h4>";
    echo "<small><b>Data:</b> " . $r['data'] . "</small><br>";
    echo "<small><b>Autor:</b> " . $r['autor'] . "</small>";
    echo "<hr class='border-secondary'>";
    echo "<p>" . $r['prefacio'] . "</p>";
    echo "</div>";
}
