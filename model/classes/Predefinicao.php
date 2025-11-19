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
        require_once 'model/MySql.php';
        $pdo = MySql::connect();

        $stmt = $pdo->prepare("SELECT * FROM predefinicoes WHERE id = :id OR nome = :nome");
        $stmt->execute([':id' => $id, ':nome' => $nome]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function getALLPredefinicoes(){
        require_once 'model/MySql.php';
        $pdo = MySql::connect();

        $stmt = $pdo->query("SELECT * FROM predefinicoes");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cadastrarPredefinicao($nome, $idOrganizacao, $idNucleo, $idCurso, $idLocalizacao, $idIntegrantes, $data, $hora, $prefacio, $introducao, $assunto, $encerramento){
        require_once 'model/MySql.php';
        $pdo = MySql::connect();

        $sql = "INSERT INTO predefinicoes (nome, organizacao_id, nucleo_id, curso_id, local_id, integrante_id, dia, hora, prefacio, introducao, assunto, encerramento) VALUES (:nome, :organizacao_id, :nucleo_id, :curso_id, :local_id, :integrante_id, :dia, :hora, :prefacio, :introducao, :assunto, :encerramento)";

        $stmt = $pdo->prepare($sql);
        $ok = $stmt->execute([
            ':nome' => $nome,
            ':organizacao_id' => $idOrganizacao,
            ':nucleo_id' => $idNucleo,
            ':curso_id' => $idCurso,
            ':local_id' => $idLocalizacao,
            ':integrante_id' => $idIntegrantes,
            ':dia' => $data,
            ':hora' => $hora,
            ':prefacio' => $prefacio,
            ':introducao' => $introducao,
            ':assunto' => $assunto,
            ':encerramento' => $encerramento
        ]);

        if ($ok) {
            echo "<script type=\"text/javascript\">alert('Predefinição cadastrada com sucesso!');</script>";
            return 1;
        } else {
            echo "<script type=\"text/javascript\">alert('Erro durante o cadastro.');</script>";
            return 0;
        }
    }

    public function editarPredefinicao($id, $nome, $idOrganizacao, $idNucleo, $idCurso, $idLocalizacao, $idIntegrantes, $data, $hora, $prefacio, $introducao, $assunto, $encerramento){
        require_once 'model/MySql.php';
        $pdo = MySql::connect();

        $sql = "UPDATE predefinicoes SET nome = :nome, organizacao_id = :organizacao_id, nucleo_id = :nucleo_id, curso_id = :curso_id, local_id = :local_id, integrante_id = :integrante_id, dia = :dia, hora = :hora, prefacio = :prefacio, introducao = :introducao, assunto = :assunto, encerramento = :encerramento WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $ok = $stmt->execute([
            ':nome' => $nome,
            ':organizacao_id' => $idOrganizacao,
            ':nucleo_id' => $idNucleo,
            ':curso_id' => $idCurso,
            ':local_id' => $idLocalizacao,
            ':integrante_id' => $idIntegrantes,
            ':dia' => $data,
            ':hora' => $hora,
            ':prefacio' => $prefacio,
            ':introducao' => $introducao,
            ':assunto' => $assunto,
            ':encerramento' => $encerramento,
            ':id' => $id
        ]);

        if ($ok) {
            echo "<script type=\"text/javascript\">alert('Predefinição editada com sucesso!');</script>";
            return 1;
        } else {
            echo "<script type=\"text/javascript\">alert('Erro durante a edição.');</script>";
            return 0;
        }
    }

    public function excluirPredefinicao($id): int{
        require_once 'model/MySql.php';
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
}
?>