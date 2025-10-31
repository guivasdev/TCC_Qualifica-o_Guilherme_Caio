<?php
class AtaScreen
{
  public function mostrarPaginaATA($resultado)
  {
    include 'PaginaAta.php';
  }

  public function mostrarBuscaATA($resultado)
  {
    include 'PaginaBusca.php';
  }

  private function inputComPredef(string $label, string $name, array $valores = [])
  {
    $id = "input-" . $name;

    $camposComCadastro = ["Curso", "Organização", "Integrantes", "Nucleo Institucional", "local"];


    // Se o campo não estiver na lista, é só um input simples
    if (!in_array($label, $camposComCadastro)) {
      return '
        <div class="mb-3">
            <label class="form-label">' . htmlspecialchars($label) . '</label>
            <textarea style="width: 100%; height: auto;" class="form-control" placeholder="Digite algo..." name="' . htmlspecialchars($name) . '" id="' . $id . '" required rows="5"wrap="soft"></textarea>

        </div>';
    }

    // Campo com dropdown e botão
    $html = '
      <div class="mb-3">
        <label class="form-label">' . htmlspecialchars($label) . '</label>
        <div class="input-group">
          <input type="text" class="form-control" name="' . htmlspecialchars($name) . '" id="' . $id . '" required>';

    // Dropdown apenas se houver valores
    if (!empty($valores)) {
      $html .= '<button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">▼</button>
                  <ul class="dropdown-menu">';
      foreach ($valores as $index => $valor) {
        // Adiciona o botão apenas no primeiro item
        if ($index === 0) {
          $html .= '
<div class="d-flex flex-column align-items-center mt-2">
  <button class="btn btn-primary w-100" type="button" onclick="location.href=\'index.php?acao=cadastrarComponente&campo=' . urlencode($label) . '\'">
    Cadastrar
  </button>
</div>';
        }

        // Adiciona os itens do dropdown normalmente
        $html .= '<li><a class="dropdown-item predef" data-target="' . $id . '">' . htmlspecialchars($valor) . '</a></li>';
      }
      $html .= '</ul>';
    }

    $html .= '
        </div>
      </div>';

    return $html;
  }
}
?>