<?php
class Predefinicao{
    public $nucleoInstitucional = "";
    public $curso = "";
    public $organizacao = "";
    public $data = "";
    public $local = "";
    public $hora = "";
    public $integrantes = "";
    public $introducao = "";
    public $assunto = "";
    public $encerramento = "";
    public $prefacio = "";

    public function getPredefinicao($id, $nome){
        require_once __DIR__ ."/../MySql.php";
        $pdo = MySql::connect();

        $stmt = $pdo->prepare("SELECT * FROM predefinicoes WHERE id = :id OR nome = :nome");
        $stmt->execute([':id' => $id, ':nome' => $nome]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function getALLPredefinicoes(){
        require_once __DIR__ ."/../MySql.php";
        $pdo = MySql::connect();

        $stmt = $pdo->query("SELECT * FROM predefinicoes");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cadastrarPredefinicao($nome, $idOrganizacao, $idNucleo, $idCurso, $idLocalizacao, $idIntegrantes, $data, $hora, $prefacio, $introducao, $assunto, $encerramento){
        require_once __DIR__ ."/../MySql.php";
        $pdo = MySql::connect();

        $sql = "INSERT INTO predefinicoes (nome, organizacao_id, nucleo_id, curso_id, local_id, dia, hora, prefacio, introducao, assunto, encerramento) VALUES (:nome, :organizacao_id, :nucleo_id, :curso_id, :local_id, :dia, :hora, :prefacio, :introducao, :assunto, :encerramento)";

        $stmt = $pdo->prepare($sql);
        $ok = $stmt->execute([
            ':nome' => $nome,
            ':organizacao_id' => $idOrganizacao,
            ':nucleo_id' => $idNucleo,
            ':curso_id' => $idCurso,
            ':local_id' => $idLocalizacao,
            ':dia' => $data,
            ':hora' => $hora,
            ':prefacio' => $prefacio,
            ':introducao' => $introducao,
            ':assunto' => $assunto,
            ':encerramento' => $encerramento
        ]);

            if ($ok) {
                $newId = (int)$pdo->lastInsertId();
                // vincular integrantes ao template via predefinicao_integrante
                if (!empty($idIntegrantes)) {
                    if (is_array($idIntegrantes)) {
                        foreach ($idIntegrantes as $i) {
                            $ins = $pdo->prepare('INSERT IGNORE INTO predefinicao_integrante (predefinicao_id, integrante_id) VALUES (:predef, :integ)');
                            $ins->execute([':predef' => $newId, ':integ' => (int)$i]);
                        }
                    } else {
                        $ins = $pdo->prepare('INSERT IGNORE INTO predefinicao_integrante (predefinicao_id, integrante_id) VALUES (:predef, :integ)');
                        $ins->execute([':predef' => $newId, ':integ' => (int)$idIntegrantes]);
                    }
                }
            echo "<script type=\"text/javascript\">alert('Predefinição cadastrada com sucesso!');</script>";
            return 1;
        } else {
            echo "<script type=\"text/javascript\">alert('Erro durante o cadastro.');</script>";
            return 0;
        }
    }

    public function editarPredefinicao($id, $nome, $idOrganizacao, $idNucleo, $idCurso, $idLocalizacao, $idIntegrantes, $data, $hora, $prefacio, $introducao, $assunto, $encerramento){
        require_once __DIR__ ."/../MySql.php";
        $pdo = MySql::connect();

        $sql = "UPDATE predefinicoes SET nome = :nome, organizacao_id = :organizacao_id, nucleo_id = :nucleo_id, curso_id = :curso_id, local_id = :local_id, dia = :dia, hora = :hora, prefacio = :prefacio, introducao = :introducao, assunto = :assunto, encerramento = :encerramento WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $ok = $stmt->execute([
            ':nome' => $nome,
            ':organizacao_id' => $idOrganizacao,
            ':nucleo_id' => $idNucleo,
            ':curso_id' => $idCurso,
            ':local_id' => $idLocalizacao,
            ':dia' => $data,
            ':hora' => $hora,
            ':prefacio' => $prefacio,
            ':introducao' => $introducao,
            ':assunto' => $assunto,
            ':encerramento' => $encerramento,
            ':id' => $id
        ]);

            if ($ok) {
                // atualiza mapping de integrantes para a predefinicao
                if (!empty($idIntegrantes)) {
                    $pdo->prepare('DELETE FROM predefinicao_integrante WHERE predefinicao_id = :predef')->execute([':predef' => $id]);
                    if (is_array($idIntegrantes)) {
                        foreach ($idIntegrantes as $i) {
                            $ins = $pdo->prepare('INSERT IGNORE INTO predefinicao_integrante (predefinicao_id, integrante_id) VALUES (:predef, :integ)');
                            $ins->execute([':predef' => $id, ':integ' => (int)$i]);
                        }
                    } else {
                        $ins = $pdo->prepare('INSERT IGNORE INTO predefinicao_integrante (predefinicao_id, integrante_id) VALUES (:predef, :integ)');
                        $ins->execute([':predef' => $id, ':integ' => (int)$idIntegrantes]);
                    }
                }
            echo "<script type=\"text/javascript\">alert('Predefinição editada com sucesso!');</script>";
            return 1;
        } else {
            echo "<script type=\"text/javascript\">alert('Erro durante a edição.');</script>";
            return 0;
        }
    }

    public function excluirPredefinicao($id): int{
        require_once __DIR__ ."/../MySql.php";
        $pdo = MySql::connect();

        $stmt = $pdo->prepare("DELETE FROM predefinicoes WHERE id = :id");
        $ok = $stmt->execute([':id' => $id]);

        if ($ok) {
            echo "<script type=\"text/javascript\">alert('Predefinição excluída com sucesso!');</script>";
            return 1;
        } else {
            echo "<script type=\"text/javascript\">alert('Erro durante a exclusão.');</script>";
            return 0;
        }
    }
    // helpers para predefinicao_integrante (N:N)
    // helpers para predefinicao_integrante (N:N)
    public function adicionarIntegrante($predefinicaoId, $integranteId){
        require_once __DIR__ ."/../MySql.php";
        $pdo = MySql::connect();
        $stmt = $pdo->prepare('INSERT IGNORE INTO predefinicao_integrante (predefinicao_id, integrante_id) VALUES (:predef, :integ)');
        return $stmt->execute([':predef' => $predefinicaoId, ':integ' => $integranteId]);
    }

    public function removerIntegrante($predefinicaoId, $integranteId){
        require_once __DIR__ ."/../MySql.php";
        $pdo = MySql::connect();
        $stmt = $pdo->prepare('DELETE FROM predefinicao_integrante WHERE predefinicao_id = :predef AND integrante_id = :integ');
        return $stmt->execute([':predef' => $predefinicaoId, ':integ' => $integranteId]);
    }

    public function listarIntegrantes($predefinicaoId){
        require_once __DIR__ ."/../MySql.php";
        $pdo = MySql::connect();
        $stmt = $pdo->prepare('SELECT i.* FROM integrante i JOIN predefinicao_integrante pi ON i.id = pi.integrante_id WHERE pi.predefinicao_id = :predef');
        $stmt->execute([':predef' => $predefinicaoId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>