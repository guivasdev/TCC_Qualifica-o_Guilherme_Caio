<?php
class Integrante{
    private $id = 0;
    private $nome = "";
    private $cargo = "";

    public function getIntegrantes($id, $nome){
        require_once __DIR__ ."/../MySql.php";
        $pdo = MySql::connect();

        $stmt = $pdo->prepare("SELECT * FROM integrante WHERE id = :id OR nome = :nome");
        $stmt->execute([':id' => $id, ':nome' => $nome]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function getALLIntegrantes(){
        require_once __DIR__ ."/../MySql.php";
        $pdo = MySql::connect();

        $stmt = $pdo->query("SELECT * FROM integrante ORDER BY nome ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cadastrarIntegrantes($nome, $cargo): int{
        require_once __DIR__ ."/../MySql.php";
        $pdo = MySql::connect();

        $stmt = $pdo->prepare("INSERT INTO integrante (nome, cargo) VALUES (:nome, :cargo)");
        $ok = $stmt->execute([':nome' => $nome, ':cargo' => $cargo]);

        if ($ok) {
            echo "<script type=\"text/javascript\">alert('Integrante cadastrado com sucesso!');</script>";
            return 1;
        } else {
            echo "<script type=\"text/javascript\">alert('Erro durante o cadastro.');</script>";
            return 0;
        }
    }

    public function atribuirCargo($id, $id_cargo): int{
        require_once __DIR__ ."/../MySql.php";
        $pdo = MySql::connect();

        $stmt = $pdo->prepare("UPDATE integrante SET cargo = :cargo WHERE id = :id");
        $ok = $stmt->execute([':cargo' => $id_cargo, ':id' => $id]);
        return $ok ? 1 : 0;
    }

    public function editarIntegrantes($id, $nome, $cargo): int{
        require_once __DIR__ ."/../MySql.php";
        $pdo = MySql::connect();

        $stmt = $pdo->prepare("UPDATE integrante SET nome = :nome, cargo = :cargo WHERE id = :id");
        $ok = $stmt->execute([':nome' => $nome, ':cargo' => $cargo, ':id' => $id]);

        if ($ok) {
            echo "<script type=\"text/javascript\">alert('Integrante editado com sucesso!');</script>";
            return 1;
        } else {
            echo "<script type=\"text/javascript\">alert('Erro durante a edição.');</script>";
            return 0;
        }
    }

    public function excluirIntegrante($confirmar, $id): int{
        require_once __DIR__ ."/../MySql.php";
        $pdo = MySql::connect();

        $stmt = $pdo->prepare("DELETE FROM integrante WHERE id = :id");
        $ok = $stmt->execute([':id' => $id]);

        if ($ok) {
            echo "<script type=\"text/javascript\">alert('Integrante excluído com sucesso!');</script>";
            return 1;
        } else {
            echo "<script type=\"text/javascript\">alert('Erro durante a exclusão.');</script>";
            return 0;
        }
    }
}
?>
