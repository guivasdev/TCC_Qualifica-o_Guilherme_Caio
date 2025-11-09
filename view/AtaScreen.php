<?php
require_once __DIR__ . '/IAtaView.php';
require_once __DIR__ . '/ComponentesATA/InputComponentTrait.php'; // caminho relativo

class AtaScreen implements IAtaView
{
    use InputComponentTrait;

    public function mostrarPaginaATA($resultado = null): void
    {
        echo "<pre>DEBUG: Entrou na View</pre>";
        include __DIR__ . '/PaginaAta.php';
    }


    public function mostrarBuscaATA($resultado): void
    {
        include __DIR__ . '/PaginaBusca.php';
    }
}
?>