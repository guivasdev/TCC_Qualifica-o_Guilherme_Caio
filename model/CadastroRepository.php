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
        if (!$this->isValidTableName($tabela)) {
            return false;
        }
        $campos = implode(', ', array_keys($dados));
        $placeholders = ':' . implode(', :', array_keys($dados));

        $sql = "INSERT INTO {$tabela} ({$campos}) VALUES ({$placeholders})";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute($dados);
    }

    public function documento_integrante(int $documento_id): array
{
    $sql = "SELECT integrante_id FROM documento_integrante WHERE documento_id = :doc_id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['doc_id' => $documento_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function buscarTodas(string $tabela): array
    {
        if (!$this->isValidTableName($tabela)) {
            return [];
        }
        $stmt = $this->pdo->query("SELECT * FROM {$tabela} ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function buscarPorId(string $tabela, int $id): ?array
    {
        if (!$this->isValidTableName($tabela)) {
            return null;
        }
        $sql = "SELECT * FROM {$tabela} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ?: null;
    }


    public function buscarUltimo(string $tabela): ?array
    {
        if (!$this->isValidTableName($tabela)) {
            return null;
        }
        $sql = "SELECT * FROM {$tabela} ORDER BY id DESC LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    private function isValidTableName(string $tabela): bool
    {
        return (bool) preg_match('/^[a-zA-Z0-9_]+$/', $tabela);
    }

}
