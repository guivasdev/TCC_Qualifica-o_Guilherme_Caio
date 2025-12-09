<?php
require_once __DIR__ . '/IAtaView.php';
require_once __DIR__ . '/ComponentesATA/InputComponentTrait.php'; // caminho relativo
$dados = $dados ?? []; // garante que não dê erro se não vier nada

class AtaScreen implements IAtaView
{
    use InputComponentTrait;

   public function mostrarPaginaATA($resultado = null): void
{
    $dados = $resultado ?? []; // <-- aqui garantimos que $dados exista
    include __DIR__ . '/ata/criar.php';
}




    public function mostrarBuscaATA($resultado): void
    {
        include __DIR__ . '/PaginaBusca.php';
    }
}
?>