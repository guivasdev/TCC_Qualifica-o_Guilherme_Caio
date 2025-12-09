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
//var_dump($resultados);
// Exibir resultados
foreach ($resultados as $r) {
    echo "<div class='p-3 mb-3 bg-dark text-white rounded' style='font-size: 1.05rem;'>";

    echo "<h4 style='font-size: 1.3rem;'>{$r['nome']}</h4>";

    // --- LINHA 1: Data + Horas ---
    echo "<div>
            <small><b>Data:</b> {$r['data']}</small>
            <small class='ms-3'><b>Hora Inicial:</b> " . substr($r['hora_inicio'], 0, 5) . "</small>
            <small class='ms-3'><b>Hora Final:</b> " . substr($r['hora_final'], 0, 5) . "</small>
          </div>";

    // --- LINHA 2: Organização / Local / Núcleo / Curso ---
    echo "<div class='mt-1'>
            <small><b>Organização:</b> {$r['organizacao_nome']}</small>
            <small class='ms-3'><b>Local:</b> {$r['local_nome']}</small>
            <small class='ms-3'><b>Núcleo:</b> {$r['nucleo_nome']}</small>
            <small class='ms-3'><b>Curso:</b> {$r['curso_nome']}</small>
          </div>";

    echo "<div class='mt-1'>
            <small><b>Integrantes:</b> {$r['integrante_nome']}</small>
          </div>";

    echo "<hr class='border-secondary'>";

    echo "<p>{$r['prefacio']}</p>";

    echo "
        <div class='d-flex gap-2 mt-3'>
            <a href='{$base}/index.php?acao=buscar' class='btn btn-secondary w-50 py-2'>
                <i class='bi bi-arrow-repeat'></i> Atualizar
            </a>

            <a href='{$base}/index.php?acao=buscar' class='btn btn-primary w-50 py-2'>
                <i class='bi bi-eye'></i> Visualizar
            </a>
        </div>
    ";

    echo "</div>";
}
