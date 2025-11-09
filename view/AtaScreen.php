<?php
require_once __DIR__ . '/IAtaView.php';
require_once __DIR__ . '/ComponentesATA/InputComponentTrait.php'; // caminho relativo

class AtaScreen implements IAtaView
{
    use InputComponentTrait;

    public function mostrarPaginaATA($resultado = null): void
    {
        include __DIR__ . '/ata/criar.php';
    }


    public function mostrarBuscaATA($resultado): void
    {
        include __DIR__ . '/PaginaBusca.php';
    }
}
?>