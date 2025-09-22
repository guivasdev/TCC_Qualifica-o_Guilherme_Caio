
<?php
class IncluirComponentes
{

    public function mostrarPaginaOrganizacao($resultado)
    {
        include __DIR__ . '/ComponentesATA/OrganizacaoView.php';
    }

    public function mostrarPaginaCurso($resultado)
    {
        include __DIR__ . '/ComponentesATA/CursoView.php';
    }

    public function mostrarPaginaLocal($resultado)
    {
        include __DIR__ . '/ComponentesATA/Local.php';
    }

   public function mostrarPaginaIntegrante($resultado){
    include __DIR__ . '/ComponentesATA/Integrantes.php';
   }
}

