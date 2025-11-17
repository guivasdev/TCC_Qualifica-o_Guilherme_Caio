<?php
require_once __DIR__ . '/../entity/Ata.php';
require_once __DIR__ . '/IAtaRepository.php';

class AtaRepository implements IAtaRepository {
    private string $path = __DIR__ . '/../atas.json';

    public function salvar(Ata $ata): bool {
        $atas = $this->buscarTodas();
        $atas[] = $ata->toArray();
        return file_put_contents($this->path, json_encode($atas, JSON_PRETTY_PRINT)) !== false;
    }

    public function buscarTodas(): array {
        if (!file_exists($this->path)) return [];
        $json = file_get_contents($this->path);
        return json_decode($json, true) ?? [];
    }

       public function buscar(string $filtro, string $texto): ?Ata
    {
        // MOCK — substitua por SELECT no banco futuramente
        $ata = new Ata();
        $ata->titulo = "ATA sobre gerenciamento de horário noturno - 2025";
        $ata->data   = "25/10/2025";
        $ata->tipo   = "online/presencial";
        $ata->assuntos = "ass 01, ass 02, ass 03";
        $ata->palavras_chave = "";
        $ata->resumo = "";

        return $ata;
    }
}
?>
