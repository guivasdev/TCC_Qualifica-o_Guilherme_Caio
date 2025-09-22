<?php 
class AtaScreen {
  public function mostrarPaginaATA($resultado) {
    include 'PaginaAta.php';
  }

  public function mostrarBuscaATA($resultado) {
    include 'PaginaBusca.php';
  }

  private function inputComPredef(string $label, string $name, array $valores = []) {
    $id = "input-" . $name;

    // Campos que terão botão de cadastro + dropdown
    $camposComCadastro = ["Organização", "Curso", "Local", "Integrantes", "Nucleo Institucional"];

    // Se o campo não estiver na lista, é só um input simples
    if (!in_array($label, $camposComCadastro)) {
        return '
        <div class="mb-3">
            <label class="form-label">' . htmlspecialchars($label) . '</label>
            <input type="text" class="form-control" name="' . htmlspecialchars($name) . '" id="' . $id . '" required>
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
        foreach ($valores as $valor) {
            $html .= '<li><a class="dropdown-item predef" data-target="' . $id . '">' . htmlspecialchars($valor) . '</a></li>';
        }
        $html .= '</ul>';
    }

    // Botão de cadastro
    $html .= '<button class="btn btn-primary" type="button" onclick="location.href=\'index.php?acao=cadastrarComponente&campo=' . urlencode($label) . '\'">Cadastrar</button>';

    $html .= '
        </div>
      </div>';

    return $html;
  }
}
?>
