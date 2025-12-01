<?php

class CursoRepository {

    private PDO $pdo;

    public function __construct() {
        $this->pdo = new PDO(
            "mysql:host=localhost;dbname=outrora;charset=utf8",
            "root",
            "",
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }

    public function buscarTodas(): array {
        $sql = "SELECT id, nome FROM curso ORDER BY nome";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
