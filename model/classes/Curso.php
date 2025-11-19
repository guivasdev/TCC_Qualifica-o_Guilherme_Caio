<?php
class Curso{
    private $id = 0;
    private $nome = "";

    public function getCurso($id, $nome){
        require_once 'model/MySql.php';
        $pdo = MySql::connect();

        $stmt = $pdo->prepare("SELECT * FROM curso WHERE id = :id OR nome = :nome");
        $stmt->execute([':id' => $id, ':nome' => $nome]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function getALLCursos(){
        require_once 'model/MySql.php';
        $pdo = MySql::connect();

        $stmt = $pdo->query("SELECT * FROM curso");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cadastrarCurso($nome): int {
        require_once 'model/MySql.php';
        $pdo = MySql::connect();

        $stmt = $pdo->prepare("INSERT INTO curso (nome) VALUES (:nome)");
        $ok = $stmt->execute([':nome' => $nome]);

        if ($ok) {
            echo "<script type=\"text/javascript\">alert('Curso cadastrado com sucesso!');</script>";
            return 1;
        } else {
            echo "<script type=\"text/javascript\">alert('Erro durante o cadastro.');</script>";
            return 0;
        }
    }

    public function editarCurso($id, $nome):int{
        require_once 'model/MySql.php';
        $pdo = MySql::connect();

        $stmt = $pdo->prepare("UPDATE curso SET nome = :nome WHERE id = :id");
        $ok = $stmt->execute([':nome' => $nome, ':id' => $id]);

        if ($ok) {
            echo "<script type=\"text/javascript\">alert('Curso editado com sucesso!');</script>";
            return 1;
        } else {
            echo "<script type=\"text/javascript\">alert('Erro durante a edição.');</script>";
            return 0;
        }
    }

    public function excluirCurso($confirmar, $curso):int{
        require_once 'model/MySql.php';
        $pdo = MySql::connect();

        $stmt = $pdo->prepare("DELETE FROM curso WHERE id = :id");
        $ok = $stmt->execute([':id' => $curso]);

        if ($ok) {
            echo "<script type=\"text/javascript\">alert('Curso excluído com sucesso!');</script>";
            return 1;
        } else {
            echo "<script type=\"text/javascript\">alert('Erro durante a exclusão.');</script>";
            return 0;
        }
    }
}
?>
