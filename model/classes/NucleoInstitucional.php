<?php
class NucleoInstitucional{
    private $id = 0;
    private $nome = "";
    private $integrantes = [];
    private $sigla = "";

    public function getNucleoInstitucional($id, $nome){
        require_once 'model/MySql.php';
        $pdo = MySql::connect();

        $stmt = $pdo->prepare("SELECT * FROM nucleo_institucional WHERE id = :id OR nome = :nome");
        $stmt->execute([':id' => $id, ':nome' => $nome]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    public function getALLNucleoInstitucional(){
        require_once 'model/MySql.php';
        $pdo = MySql::connect();

        $stmt = $pdo->query("SELECT * FROM nucleo_institucional");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cadastrarNucleo($nome){
        require_once 'model/MySql.php';
        $pdo = MySql::connect();

        $stmt = $pdo->prepare("INSERT INTO nucleo_institucional (nome) VALUES (:nome)");
        $ok = $stmt->execute([':nome' => $nome]);

        if ($ok) {
            echo "<script type=\"text/javascript\">alert('Núcleo Institucional cadastrado com sucesso!');</script>";
            return 1;
        } else {
            echo "<script type=\"text/javascript\">alert('Erro durante o cadastro.');</script>";
            return 0;
        }
    }

    public function adicionarIntegrante($id, $idInteg){
        require_once 'model/MySql.php';
        $pdo = MySql::connect();

        // Usa tabela de junção nucleo_integrante
        $sql = "INSERT IGNORE INTO nucleo_integrante (nucleo_id, integrante_id) VALUES (:nucleo_id, :integ_id)";
        $stmt = $pdo->prepare($sql);
        $ok = $stmt->execute([':nucleo_id' => $id, ':integ_id' => $idInteg]);
        return $ok ? 1 : 0;
    }

    public function removerIntegrante($id, $idInteg){
        require_once 'model/MySql.php';
        $pdo = MySql::connect();

        $sql = "DELETE FROM nucleo_integrante WHERE nucleo_id = :nucleo_id AND integrante_id = :integ_id";
        $stmt = $pdo->prepare($sql);
        $ok = $stmt->execute([':nucleo_id' => $id, ':integ_id' => $idInteg]);
        return $ok ? 1 : 0;
    }

    public function editarNucleo($id){
        require_once 'model/MySql.php';
        $pdo = MySql::connect();

        $stmt = $pdo->prepare("UPDATE nucleo_institucional SET nome = :nome WHERE id = :id");
        $ok = $stmt->execute([':nome' => $this->nome, ':id' => $id]);
        return $ok ? 1 : 0;
    }

    public function excluirNucleo($confirmar, $id){
        require_once 'model/MySql.php';
        $pdo = MySql::connect();

        $stmt = $pdo->prepare("DELETE FROM nucleo_institucional WHERE id = :id");
        $ok = $stmt->execute([':id' => $id]);
        return $ok ? 1 : 0;
    }
}
?>