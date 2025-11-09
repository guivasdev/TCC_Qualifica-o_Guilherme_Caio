<?php
interface IAtaRepository {
    public function salvar(Ata $ata): bool;
    public function buscarTodas(): array;
}
?>
