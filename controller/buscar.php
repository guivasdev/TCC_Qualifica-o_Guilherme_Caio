<?php
require_once __DIR__ . '/../model/Pesquisa.php';
$base = '/TCC_Qualifica-o_Guilherme_Caio-master';

$filtro = $_POST['filtro'] ?? 'tudo';
$termo = $_POST['termo'] ?? '';

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

    echo "<h4>{$r['nome']}</h4>";
    echo "<small><b>Data:</b> {$r['data']}</small><br>";
    echo "<small><b>Integrantes:</b> {$r['integrante_nome']}</small>";
    echo "<hr class='border-secondary'>";
    echo "<p>{$r['prefacio']}</p>";

    // --- BOTÕES ALINHADOS E DO MESMO TAMANHO ---
    echo "
        <div class='d-flex gap-2 mt-3'>

            <a href='{$base}/index.php?acao=buscar' 
               class='btn btn-secondary w-50 py-2'>
               <i class='bi bi-arrow-repeat'></i> Atualizar
            </a>

            <a href='{$base}/index.php?acao=buscar'
               class='btn btn-primary w-50 py-2'>
               <i class='bi bi-eye'></i> Visualizar
            </a>

        </div>
    ";

    echo "</div>";
}

