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
        // Salva ATA na tabela `documento` (campos de conteúdo separados)
        $sql = "INSERT INTO documento (titulo, data, prefacio, introducao, assunto, encerramento)
                VALUES (:titulo, :data, :prefacio, :introducao, :assunto, :encerramento)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':titulo' => $ata->titulo ?? null,
            ':data' => $ata->data ?? null,
            ':prefacio' => $ata->prefacio ?? ($ata->infoIntro ?? null),
            ':introducao' => $ata->introducao ?? ($ata->infoIntro ?? null),
            ':assunto' => $ata->assuntos ?? ($ata->assunto ?? null),
            ':encerramento' => $ata->encerramento ?? null
        ]);
    }

    // ---------------------------------------------------------
    // BUSCAR TODAS
    // ---------------------------------------------------------
    public function buscarTodas(): array 
    {
        $sql = "SELECT * FROM documento ORDER BY data DESC";
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
        // Protege contra filtro inválido/injeção esquerda: whitelist de colunas
        $allowed = ['titulo','data','conteudo','prefacio','introducao','assunto','encerramento'];
        if (!in_array($filtro, $allowed)) {
            $filtro = 'titulo';
        }

        $sql = "SELECT * FROM documento WHERE $filtro LIKE :texto LIMIT 1";
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
