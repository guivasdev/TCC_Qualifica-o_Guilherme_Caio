<?php
class Cargo{
    private $id = 0;
    private $nome ="";
    private $sigla = "";

    public function getCargo($id, $nome){
        require_once __DIR__ ."/../MySql.php";
        $pdo = MySql::connect();

        $stmt = $pdo->prepare("SELECT * FROM cargo WHERE id = :id OR nome = :nome");
        $stmt->execute([':id' => $id, ':nome' => $nome]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    public function getALLCargos(){
        require_once __DIR__ ."/../MySql.php";
        $pdo = MySql::connect();

        $stmt = $pdo->query("SELECT * FROM cargo ORDER BY nome ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cadastrarCargo($nome, $sigla):int{
        require_once __DIR__ ."/../MySql.php";
        $pdo = MySql::connect();

        $stmt = $pdo->prepare("INSERT INTO cargo (nome, sigla) VALUES (:nome, :sigla)");
        $ok = $stmt->execute([':nome' => $nome, ':sigla' => $sigla]);

        if ($ok) {
            echo "<script type=\"text/javascript\">alert('Cargo cadastrado com sucesso!');</script>";
            return 1;
        } else {
            echo "<script type=\"text/javascript\">alert('Erro durante o cadastro.');</script>";
            return 0;
        }
    }

    public function editarCargo($id, $nome, $sigla):int{
        require_once __DIR__ ."/../MySql.php";
        $pdo = MySql::connect();

        $stmt = $pdo->prepare("UPDATE cargo SET nome = :nome, sigla = :sigla WHERE id = :id");
        $ok = $stmt->execute([':nome' => $nome, ':sigla' => $sigla, ':id' => $id]);

        if ($ok) {
            echo "<script type=\"text/javascript\">alert('Cargo editado com sucesso!');</script>";
            return 1;
        } else {
            echo "<script type=\"text/javascript\">alert('Erro durante a edição.');</script>";
            return 0;
        }
    }

    public function excluriarCargo($confirmar, $cargo):int{
        require_once __DIR__ ."/../MySql.php";
        $pdo = MySql::connect();

        $stmt = $pdo->prepare("DELETE FROM cargo WHERE id = :id");
        $ok = $stmt->execute([':id' => $cargo->id]);

        if ($ok) {
            echo "<script type=\"text/javascript\">alert('Cargo excluído com sucesso!');</script>";
            return 1;
        } else {
            echo "<script type=\"text/javascript\">alert('Erro durante a exclusão.');</script>";
            return 0;
        }
    }
}
?>
