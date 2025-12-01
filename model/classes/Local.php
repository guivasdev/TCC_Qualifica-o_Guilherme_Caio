<?php
class Local{
    private $id=0;
    private $nome="";

    public function getLocalizacao($id, $nome){
        require_once 'model/MySql.php';
        $pdo = MySql::connect();

        $stmt = $pdo->prepare("SELECT * FROM localizacao WHERE id = :id OR nome = :nome");
        $stmt->execute([':id' => $id, ':nome' => $nome]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function getALLLocalizacao(){
        require_once 'model/MySql.php';
        $pdo = MySql::connect();

        $stmt = $pdo->query("SELECT * FROM localizacao ORDER BY nome ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cadastrarLocal($nome): int{
        require_once 'model/MySql.php';
        $pdo = MySql::connect();

        $stmt = $pdo->prepare("INSERT INTO localizacao (nome) VALUES (:nome)");
        $ok = $stmt->execute([':nome' => $nome]);

        if ($ok) {
            echo "<script type=\"text/javascript\">alert('Localização cadastrado com sucesso!');</script>";
            return 1;
        } else {
            echo "<script type=\"text/javascript\">alert('Erro durante o cadastro.');</script>";
            return 0;
        }
    }

    public function editarLocal($id, $nome): int{
        require_once 'model/MySql.php';
        $pdo = MySql::connect();

        $stmt = $pdo->prepare("UPDATE localizacao SET nome = :nome WHERE id = :id");
        $ok = $stmt->execute([':nome' => $nome, ':id' => $id]);

        if ($ok) {
            echo "<script type=\"text/javascript\">alert('Localização editada com sucesso!');</script>";
            return 1;
        } else {
            echo "<script type=\"text/javascript\">alert('Erro durante a edição.');</script>";
            return 0;
        }
    }

    public function excluirLocal($confirmar, $id): int{
        require_once 'model/MySql.php';
        $pdo = MySql::connect();

        $stmt = $pdo->prepare("DELETE FROM localizacao WHERE id = :id");
        $ok = $stmt->execute([':id' => $id]);

        if ($ok) {
            echo "<script type=\"text/javascript\">alert('Localização excluída com sucesso!');</script>";
            return 1;
        } else {
            echo "<script type=\"text/javascript\">alert('Erro durante a exclusão.');</script>";
            return 0;
        }
    }
}
?>
