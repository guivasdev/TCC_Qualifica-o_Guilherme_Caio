<?php
header('Content-Type: text/html; charset=utf-8');

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

    $labelEsc = htmlspecialchars($label, ENT_QUOTES, 'UTF-8');
    $nameEsc  = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    $idEsc    = htmlspecialchars($id, ENT_QUOTES, 'UTF-8');

    // Campo com editor de texto
    if (!in_array($label, $camposComCadastro)) {
      return <<<HTML
      <div class="mb-3">
        <label class="form-label">{$labelEsc}</label>

        <!-- Campo de texto com formatação -->
        <div id="editor-{$idEsc}"
             class="form-control"
             contenteditable="true"
             style="width: 100%; min-height: 120px; white-space: pre-wrap; overflow-y: auto;"
             autocomplete="off"
             autocorrect="off"
             autocapitalize="off"
             spellcheck="false"></div>

        <!-- Campo oculto que guarda o HTML formatado -->
        <input type="hidden" name="{$nameEsc}" id="{$idEsc}" required value="">

        <script>
        (function(){
          const editor = document.getElementById("editor-{$idEsc}");
          const hidden = document.getElementById("{$idEsc}");

          // Garante que ambos comecem vazios
          editor.innerHTML = "";
          hidden.value = "";

          // Normaliza "1 a" → "1ª" e "2 o" → "2º"
          function normalizeText(html) {
            return html
              .replace(/(\\d+)[\\s\\n\\r\\u00A0\\u200B]*a(?![\\w>])/gi, "\$1ª")
              .replace(/(\\d+)[\\s\\n\\r\\u00A0\\u200B]*o(?![\\w>])/gi, "\$1º");
          }

          // Limpa HTML colado: remove scripts, estilos e espaços desnecessários
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

          // Atualiza o campo oculto sempre que digitar
          editor.addEventListener("input", () => {
            hidden.value = normalizeText(editor.innerHTML.trim());
          });

          // Remove espaços extras ao colar
          editor.addEventListener("paste", (e) => {
            e.preventDefault();
            const clipboard = e.clipboardData || window.clipboardData;
            let html = clipboard.getData("text/html");
            let text = clipboard.getData("text/plain");

            let cleaned = html && html.trim() !== "" ? cleanPastedHTML(html) : cleanPastedHTML(text);
            cleaned = normalizeText(cleaned);

            // Remove espaços, quebras e &nbsp; no início e fim
            cleaned = cleaned.replace(/^(<[^>]+>|&nbsp;|\\s)+/g, "");
            cleaned = cleaned.replace(/(<[^>]+>|&nbsp;|\\s)+\$/g, "");
            cleaned = cleaned.trim();

            // Insere texto limpo
            document.execCommand("insertHTML", false, cleaned);

            // Atualiza o hidden com o conteúdo final
            editor.innerHTML = editor.innerHTML.trimStart().trimEnd();
            hidden.value = normalizeText(editor.innerHTML);
          });

          // Limpa ao perder foco
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
?>

<!-- Script global: limpa todos os campos ao carregar a página -->
<script>
window.addEventListener("DOMContentLoaded", () => {
  // limpa todos os inputs
  document.querySelectorAll('input[type="text"], input[type="hidden"]').forEach(el => {
    el.value = "";
  });

  // limpa todos os editores contenteditable
  document.querySelectorAll('[contenteditable="true"]').forEach(el => {
    el.innerHTML = "";
  });
});
</script>
