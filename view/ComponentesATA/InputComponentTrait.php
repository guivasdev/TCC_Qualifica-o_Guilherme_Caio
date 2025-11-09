<?php
// view/components/InputComponentTrait.php
// Trait que fornece o método inputComPredef usado pelas views

trait InputComponentTrait
{
    /**
     * Gera o HTML do campo com predefinições.
     * @param string $label
     * @param string $name
     * @param array  $valores
     * @return string
     */
    public function inputComPredef(string $label, string $name, array $valores = []): string
    {
        $id = "input-" . $name;
        $camposComCadastro = ["Curso", "Organização", "Integrantes", "Nucleo Institucional", "local"];

        $labelEsc = htmlspecialchars($label, ENT_QUOTES, 'UTF-8');
        $nameEsc  = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
        $idEsc    = htmlspecialchars($id, ENT_QUOTES, 'UTF-8');

        // Campo com editor de texto (rich)
        if (!in_array($label, $camposComCadastro)) {
            return <<<HTML
<div class="mb-3">
  <label class="form-label">{$labelEsc}</label>
  <div id="editor-{$idEsc}" class="form-control" contenteditable="true"
       style="width:100%; min-height:120px; white-space:pre-wrap; overflow-y:auto;"
       autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"></div>
  <input type="hidden" name="{$nameEsc}" id="{$idEsc}" required value="">
  <script>
  (function(){
    const editor = document.getElementById("editor-{$idEsc}");
    const hidden = document.getElementById("{$idEsc}");
    editor.innerHTML = "";
    hidden.value = "";

    function normalizeText(html) {
      return html
        .replace(/(\\d+)[\\s\\n\\r\\u00A0\\u200B]*a(?![\\w>])/gi, "\$1ª")
        .replace(/(\\d+)[\\s\\n\\r\\u00A0\\u200B]*o(?![\\w>])/gi, "\$1º");
    }

    function cleanPastedHTML(input) {
      if (!input) return "";
      return input
        .replace(/<script[^>]*>[\\s\\S]*?<\\/script>/gi, "")
        .replace(/<style[^>]*>[\\s\\S]*?<\\/style>/gi, "")
        .replace(/<\\/?(?!\\b(b|i|u|strong|em|p|br)\\b)[^>]*>/gi, "")
        .replace(/\\s{2,}/g, " ")
        .replace(/&nbsp;/g, " ")
        .trim();
    }

    editor.addEventListener("input", () => {
      hidden.value = normalizeText(editor.innerHTML.trim());
    });

    editor.addEventListener("paste", (e) => {
      e.preventDefault();
      const clipboard = e.clipboardData || window.clipboardData;
      let html = clipboard.getData("text/html");
      let text = clipboard.getData("text/plain");
      let cleaned = html && html.trim() !== "" ? cleanPastedHTML(html) : cleanPastedHTML(text);
      cleaned = normalizeText(cleaned);
      cleaned = cleaned.replace(/^(<[^>]+>|&nbsp;|\\s)+/g, "");
      cleaned = cleaned.replace(/(<[^>]+>|&nbsp;|\\s)+\$/g, "");
      cleaned = cleaned.trim();
      document.execCommand("insertHTML", false, cleaned);
      editor.innerHTML = editor.innerHTML.trimStart().trimEnd();
      hidden.value = normalizeText(editor.innerHTML);
    });

    editor.addEventListener("blur", () => {
      editor.innerHTML = editor.innerHTML.trimStart().trimEnd();
      hidden.value = normalizeText(editor.innerHTML);
    });
  })();
  </script>
</div>
HTML;
        }

        // Campo com dropdown e botão
        $html = '
<div class="mb-3">
  <label class="form-label">' . $labelEsc . '</label>
  <div class="input-group">
    <input type="text" class="form-control" name="' . $nameEsc . '" id="' . $idEsc . '" required value="" autocomplete="off">';

        if (!empty($valores)) {
            $html .= '<button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">▼</button>
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
                $html .= '<li><a class="dropdown-item predef" data-target="' . $idEsc . '">' . htmlspecialchars($valor, ENT_QUOTES, 'UTF-8') . '</a></li>';
            }
            $html .= '</ul>';
        }

        $html .= '
  </div>
</div>';

        return $html;
    }
}
