<?php
require_once __DIR__ . '/../entity/Ata.php';
require_once __DIR__ . '/IAtaRepository.php';

class AtaRepository implements IAtaRepository {

    private PDO $pdo;

    public function __construct() {
        $this->pdo = new PDO(
            "mysql:host=localhost;dbname=tcc;charset=utf8",
            "root",
            "",
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }

    // ---------------------------------------------------------
    // SALVAR
    // ---------------------------------------------------------
    public function salvar(Ata $ata): bool
    {
        $sql = "INSERT INTO atas (titulo, data, tipo, assuntos, palavras_chave, resumo)
                VALUES (:titulo, :data, :tipo, :assuntos, :palavras_chave, :resumo)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':titulo'         => $ata->titulo,
            ':data'           => $ata->data,
            ':tipo'           => $ata->tipo,
            ':assuntos'       => $ata->assuntos,
            ':palavras_chave' => $ata->palavras_chave,
            ':resumo'         => $ata->resumo
        ]);
    }

    // ---------------------------------------------------------
    // BUSCAR TODAS
    // ---------------------------------------------------------
    public function buscarTodas(): array 
    {
        $sql = "SELECT * FROM atas ORDER BY data DESC";
        $stmt = $this->pdo->query($sql);

        $resultados = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultados[] = Ata::fromArray($row);
        }

        return $resultados;
    }

    // ---------------------------------------------------------
    // BUSCA COM FILTRO
    // Exemplo: buscar("titulo", "horário")
    // ---------------------------------------------------------
    public function buscar(string $filtro, string $texto): ?Ata
    {
        $sql = "SELECT * FROM atas WHERE $filtro LIKE :texto LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':texto' => "%$texto%"]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return Ata::fromArray($row);
    }
}
?>
