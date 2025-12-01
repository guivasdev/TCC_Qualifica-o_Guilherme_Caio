<?php
class Organizacao{
    private $id = 0;
    private $nome = "";
    private $nucleoInstitucional = [];
    private $curso =[];
    private $integrantes = [];

    public function getOrganizacao($id, $nome){
        require_once 'model/MySql.php';
        $pdo = MySql::connect();

        $stmt = $pdo->prepare("SELECT * FROM organizacao WHERE id = :id OR nome = :nome");
        $stmt->execute([':id' => $id, ':nome' => $nome]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function getALLOrganizacoes(){
        require_once 'model/MySql.php';
        $pdo = MySql::connect();

        $stmt = $pdo->query("SELECT * FROM organizacao ORDER BY nome ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cadastrarOrganizacao($nome){
        require_once 'model/MySql.php';
        $pdo = MySql::connect();

        $stmt = $pdo->prepare("INSERT INTO organizacao (nome) VALUES (:nome)");
        $ok = $stmt->execute([':nome' => $nome]);

        return $ok ? 1 : 0;
    }

    public function adicionarNucleo($id, $idNucleo){
        require_once 'model/MySql.php';
        $pdo = MySql::connect();

        // Usa tabela de junção organizacao_nucleo (N:N)
        $sql = "INSERT IGNORE INTO organizacao_nucleo (organizacao_id, nucleo_id) VALUES (:org_id, :nucleo_id)";
        $stmt = $pdo->prepare($sql);
        $ok = $stmt->execute([':org_id' => $id, ':nucleo_id' => $idNucleo]);
        return $ok ? 1 : 0;
    }

    public function removerNucleo($id, $idNucleo){
        require_once 'model/MySql.php';
        $pdo = MySql::connect();

        $sql = "DELETE FROM organizacao_nucleo WHERE organizacao_id = :org_id AND nucleo_id = :nucleo_id";
        $stmt = $pdo->prepare($sql);
        $ok = $stmt->execute([':org_id' => $id, ':nucleo_id' => $idNucleo]);
        return $ok ? 1 : 0;
    }

    public function adicionarCurso($id, $idCurso){
        require_once 'model/MySql.php';
        $pdo = MySql::connect();

        // Usa tabela de junção organizacao_curso
        $sql = "INSERT IGNORE INTO organizacao_curso (organizacao_id, curso_id) VALUES (:org_id, :curso_id)";
        $stmt = $pdo->prepare($sql);
        $ok = $stmt->execute([':org_id' => $id, ':curso_id' => $idCurso]);
        return $ok ? 1 : 0;
    }

    public function removerCurso($id, $idCurso){
        require_once 'model/MySql.php';
        $pdo = MySql::connect();

        $sql = "DELETE FROM organizacao_curso WHERE organizacao_id = :org_id AND curso_id = :curso_id";
        $stmt = $pdo->prepare($sql);
        $ok = $stmt->execute([':org_id' => $id, ':curso_id' => $idCurso]);
        return $ok ? 1 : 0;
    }

    public function adicionarIntegrantes($id, $idIntegrantes){
        require_once 'model/MySql.php';
        $pdo = MySql::connect();

        // Usa tabela de junção organizacao_integrante
        $sql = "INSERT IGNORE INTO organizacao_integrante (organizacao_id, integrante_id) VALUES (:org_id, :integ_id)";
        $stmt = $pdo->prepare($sql);
        $ok = $stmt->execute([':org_id' => $id, ':integ_id' => $idIntegrantes]);
        return $ok ? 1 : 0;
    }

    public function removerIntegrante($id, $idIntegrante){
        require_once 'model/MySql.php';
        $pdo = MySql::connect();

        $sql = "DELETE FROM organizacao_integrante WHERE organizacao_id = :org_id AND integrante_id = :integ_id";
        $stmt = $pdo->prepare($sql);
        $ok = $stmt->execute([':org_id' => $id, ':integ_id' => $idIntegrante]);
        return $ok ? 1 : 0;
    }

    public function adicionarLocalizacao($id, $idLocalizacao){
        require_once 'model/MySql.php';
        $pdo = MySql::connect();

        // Usa tabela de junção organizacao_local
        $sql = "INSERT IGNORE INTO organizacao_local (organizacao_id, local_id) VALUES (:org_id, :local_id)";
        $stmt = $pdo->prepare($sql);
        $ok = $stmt->execute([':org_id' => $id, ':local_id' => $idLocalizacao]);
        return $ok ? 1 : 0;
    }

    public function removerLocalizacao($id, $idLocalizacao){
        require_once 'model/MySql.php';
        $pdo = MySql::connect();

        $sql = "DELETE FROM organizacao_local WHERE organizacao_id = :org_id AND local_id = :local_id";
        $stmt = $pdo->prepare($sql);
        $ok = $stmt->execute([':org_id' => $id, ':local_id' => $idLocalizacao]);
        return $ok ? 1 : 0;
    }

    public function editarOrganizacao($id, $nome){
        require_once 'model/MySql.php';
        $pdo = MySql::connect();

        $stmt = $pdo->prepare("UPDATE organizacao SET nome = :nome WHERE id = :id");
        $ok = $stmt->execute([':nome' => $nome, ':id' => $id]);
        return $ok ? 1 : 0;
    }

    public function excluirOrganizacao($confirmar, $id){
        require_once 'model/MySql.php';
        $pdo = MySql::connect();

        $stmt = $pdo->prepare("DELETE FROM organizacao WHERE id = :id");
        $ok = $stmt->execute([':id' => $id]);
        return $ok ? 1 : 0;
    }
}
?>