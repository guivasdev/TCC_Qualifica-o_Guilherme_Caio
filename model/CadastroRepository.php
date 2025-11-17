<?php
require_once __DIR__ . '/MySql.php';

class CadastroRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = MySql::connect();
    }

    public function salvar(string $tabela, array $dados): bool
    {
        $campos = implode(', ', array_keys($dados));
        $placeholders = ':' . implode(', :', array_keys($dados));

        $sql = "INSERT INTO {$tabela} ({$campos}) VALUES ({$placeholders})";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute($dados);
    }

    public function buscarTodas(string $tabela): array
    {
        $stmt = $this->pdo->query("SELECT * FROM {$tabela} ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId(string $tabela, int $id): ?array
    {
        $sql = "SELECT * FROM {$tabela} WHERE id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ?: null;
    }


    public function buscarUltimo(string $tabela): ?array
    {
        $sql = "SELECT * FROM {$tabela} ORDER BY id DESC LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

}
