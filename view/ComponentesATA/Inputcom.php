<?php
class InputComponent
{
    public function render(string $label, string $name, array $valores = []): string
    {
        $id = "input-" . $name;
        $camposComCadastro = ["Curso", "Organização", "Integrantes", "Nucleo Institucional", "local"];

        $labelEsc = htmlspecialchars($label, ENT_QUOTES, 'UTF-8');
        $nameEsc  = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
        $idEsc    = htmlspecialchars($id, ENT_QUOTES, 'UTF-8');

        // Campo com editor de texto
        if (!in_array($label, $camposComCadastro)) {
            return $this->renderRichText($labelEsc, $nameEsc, $idEsc);
        }

        // Campo com dropdown
        return $this->renderDropdown($labelEsc, $nameEsc, $idEsc, $valores);
    }

    private function renderRichText(string $label, string $name, string $id): string
    {
        return <<<HTML
        <div class="mb-3">
            <label class="form-label">{$label}</label>
            <div id="editor-{$id}"
                 class="form-control"
                 contenteditable="true"
                 style="width: 100%; min-height: 120px; white-space: pre-wrap; overflow-y: auto;"></div>
            <input type="hidden" name="{$name}" id="{$id}" required value="">
        </div>
        <script>
            (function(){
                const editor = document.getElementById("editor-{$id}");
                const hidden = document.getElementById("{$id}");
                editor.addEventListener("input", () => hidden.value = editor.innerHTML.trim());
            })();
        </script>
HTML;
    }

    private function renderDropdown(string $label, string $name, string $id, array $valores): string
    {
        $html = '
        <div class="mb-3">
            <label class="form-label">' . $label . '</label>
            <div class="input-group">
                <input type="text" class="form-control" name="' . $name . '" id="' . $id . '" required>';

        if (!empty($valores)) {
            $html .= '<button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">▼</button>
                      <ul class="dropdown-menu">';
            foreach ($valores as $index => $valor) {
                if ($index === 0) {
                    $html .= '
                    <div class="d-flex flex-column align-items-center mt-2">
                        <button class="btn btn-primary w-100" type="button"
                            onclick="location.href=\'index.php?acao=cadastrarComponente&campo=' . urlencode($label) . '\'">
                            Cadastrar
                        </button>
                    </div>';
                }
                $html .= '<li><a class="dropdown-item predef" data-target="' . $id . '">' .
                         htmlspecialchars($valor, ENT_QUOTES, 'UTF-8') . '</a></li>';
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
