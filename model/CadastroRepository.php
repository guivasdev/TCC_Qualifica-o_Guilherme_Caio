<?php

require_once __DIR__ . '/MySql.php';

class CadastroRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = MySql::connect();
    }

    public function salvar(array $dados): bool
    {
        $sql = "INSERT INTO cadastro (campo, valor) VALUES (:campo, :valor)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':campo' => $dados['campo'],
            ':valor' => $dados['valor'],
        ]);
    }

    public function buscarTodas(): array
    {
        $sql = "SELECT * FROM documentos ORDER BY id DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id): ?array
    {
        $sql = "SELECT * FROM documentos WHERE id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return $resultado !== false ? $resultado : null;
    }
}
