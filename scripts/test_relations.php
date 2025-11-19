<?php
require_once __DIR__ . '/../model/MySql.php';

$pdo = MySql::connect();

try {
    // Ajuste ids conforme seu banco; este script supõe que você criou os registros
    $organizacaoId = 1;
    $nucleoId = 1;
    $cursoId = 1;
    $integranteId = 1;
    $localId = 1;

    echo "Teste: adicionar relacionamento organizacao <-> nucleo...\n";
    $stmt = $pdo->prepare('INSERT IGNORE INTO organizacao_nucleo (organizacao_id, nucleo_id) VALUES (:org, :nuc)');
    $stmt->execute([':org' => $organizacaoId, ':nuc' => $nucleoId]);
    echo "OK\n";

    echo "Teste: adicionar organizacao <-> curso...\n";
    $stmt = $pdo->prepare('INSERT IGNORE INTO organizacao_curso (organizacao_id, curso_id) VALUES (:org, :curso)');
    $stmt->execute([':org' => $organizacaoId, ':curso' => $cursoId]);
    echo "OK\n";

    echo "Teste: adicionar organizacao <-> integrante...\n";
    $stmt = $pdo->prepare('INSERT IGNORE INTO organizacao_integrante (organizacao_id, integrante_id) VALUES (:org, :integ)');
    $stmt->execute([':org' => $organizacaoId, ':integ' => $integranteId]);
    echo "OK\n";

    echo "Teste: adicionar organizacao <-> local...\n";
    $stmt = $pdo->prepare('INSERT IGNORE INTO organizacao_local (organizacao_id, local_id) VALUES (:org, :local)');
    $stmt->execute([':org' => $organizacaoId, ':local' => $localId]);
    echo "OK\n";

    echo "Verificando entradas...\n";
    $rows = $pdo->query('SELECT * FROM organizacao_nucleo')->fetchAll(PDO::FETCH_ASSOC);
    print_r($rows);

    // Remoção teste
    echo "Removendo relacionamentos...\n";
    $pdo->prepare('DELETE FROM organizacao_nucleo WHERE organizacao_id = :org AND nucleo_id = :nuc')->execute([':org' => $organizacaoId, ':nuc' => $nucleoId]);
    $pdo->prepare('DELETE FROM organizacao_curso WHERE organizacao_id = :org AND curso_id = :curso')->execute([':org' => $organizacaoId, ':curso' => $cursoId]);
    $pdo->prepare('DELETE FROM organizacao_integrante WHERE organizacao_id = :org AND integrante_id = :integ')->execute([':org' => $organizacaoId, ':integ' => $integranteId]);
    $pdo->prepare('DELETE FROM organizacao_local WHERE organizacao_id = :org AND local_id = :local')->execute([':org' => $organizacaoId, ':local' => $localId]);
    echo "Removido\n";

} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
}


