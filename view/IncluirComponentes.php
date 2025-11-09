
<?php


trait IncluirComponentes {
    public function inputComPredef(string $label, string $id, array $opcoes): string {
        $dropdown = '';
        foreach ($opcoes as $opcao) {
            $dropdown .= "<li><a class='dropdown-item predef' data-target='$id'>$opcao</a></li>";
        }

        return "
        <div class='form-section'>
          <label for='$id' class='form-label'>$label</label>
          <div class='input-group'>
            <input type='text' class='form-control' id='$id' name='$id'>
            <button class='btn btn-outline-secondary dropdown-toggle' type='button' data-bs-toggle='dropdown'>
              <i class='bi bi-list'></i>
            </button>
            <ul class='dropdown-menu'>$dropdown</ul>
          </div>
        </div>";
    }



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

