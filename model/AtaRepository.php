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
}
?>
