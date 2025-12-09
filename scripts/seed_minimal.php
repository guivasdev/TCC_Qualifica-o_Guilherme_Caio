<?php
require_once __DIR__ . '/../model/MySql.php';

$pdo = MySql::connect();
try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare('INSERT INTO organizacao (nome) VALUES (:nome)');
    $stmt->execute([':nome' => 'Org Exemplo']);
    $orgId = (int)$pdo->lastInsertId();

    $stmt = $pdo->prepare('INSERT INTO nucleo_institucional (nome, sigla) VALUES (:nome, :sigla)');
    $stmt->execute([':nome' => 'Núcleo Exemplo', ':sigla' => 'NEX']);
    $nucleoId = (int)$pdo->lastInsertId();

    $stmt = $pdo->prepare('INSERT INTO curso (nome) VALUES (:nome)');
    $stmt->execute([':nome' => 'Curso Exemplo']);
    $cursoId = (int)$pdo->lastInsertId();

    $stmt = $pdo->prepare('INSERT INTO integrante (nome, cargo_id) VALUES (:nome, NULL)');
    $stmt->execute([':nome' => 'Integrante Exemplo']);
    $integId = (int)$pdo->lastInsertId();

    $stmt = $pdo->prepare('INSERT INTO localizacao (nome) VALUES (:nome)');
    $stmt->execute([':nome' => 'Sala 100']);
    $localId = (int)$pdo->lastInsertId();

    $stmt = $pdo->prepare('INSERT INTO predefinicoes (nome, organizacao_id, dia, hora, prefacio, introducao, assunto, encerramento) VALUES (:nome, :org, CURDATE(), :hora, :prefacio, :introducao, :assunto, :encerramento)');
    $stmt->execute([':nome' => 'Template Padrão', ':org' => $orgId, ':hora' => '09:00:00', ':prefacio' => 'Prefácio', ':introducao' => 'Introdução', ':assunto' => 'Assuntos', ':encerramento' => 'Encerramento']);
    $predefId = (int)$pdo->lastInsertId();

    // vincular integrante ao template (predefinicao_integrante)
    $stmt = $pdo->prepare('INSERT IGNORE INTO predefinicao_integrante (predefinicao_id, integrante_id) VALUES (:predef, :integ)');
    $stmt->execute([':predef' => $predefId, ':integ' => $integId]);

    $stmt = $pdo->prepare('INSERT INTO documento (nome, data, hora_inicio, hora_final, prefacio, introducao, assunto, encerramento, organizacao_id, nucleo_id, curso_id, local_id, conteudo, predefinicao_id) VALUES (:nome, CURDATE(), :hini, :hfin, :prefacio, :introducao, :assunto, :encerramento, :org, :nucleo, :curso, :local, :conteudo, :predef)');
    $stmt->execute([':nome' => 'ATA Exemplo', ':hini' => '09:00:00', ':hfin' => '10:00:00', ':prefacio' => 'Prefácio ATA', ':introducao' => 'Introdução ATA', ':assunto' => 'Assuntos ATA', ':encerramento' => 'Encerramento ATA', ':org' => $orgId, ':nucleo' => $nucleoId, ':curso' => $cursoId, ':local' => $localId, ':integ' => $integId, ':conteudo' => 'Conteúdo de teste', ':predef' => $predefId]);
    $docId = (int)$pdo->lastInsertId();

    // vincular participante(s) ao documento
    $stmt = $pdo->prepare('INSERT IGNORE INTO documento_integrante (documento_id, integrante_id) VALUES (:doc, :integ)');
    $stmt->execute([':doc' => $docId, ':integ' => $integId]);

    $pdo->commit();

    echo "Seed concluído:\n";
    echo "organizacao_id = $orgId\n";
    echo "nucleo_id = $nucleoId\n";
    echo "curso_id = $cursoId\n";
    echo "integrante_id = $integId\n";
    echo "local_id = $localId\n";
    echo "predefinicao_id = $predefId\n";
    echo "documento_id = $docId\n";

} catch (Exception $e) {
    $pdo->rollBack();
    echo 'Erro no seed: ' . $e->getMessage() . PHP_EOL;
}
