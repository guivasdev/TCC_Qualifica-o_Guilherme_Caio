<?php
echo '
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Criação de ATA</title>

  <!-- Bootstrap e Ícones -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background-color: #f8f9fa;
      font-family: "Inter", "Segoe UI", Roboto, sans-serif;
      color: #222;
    }

    header {
      background: #4e73df;
      color: white;
      text-align: center;
      padding: 1rem 0;
      font-weight: 500;
      border-bottom: 1px solid #e0e0e0;
    }

    main {
      max-width: 1000px;
      margin: 40px auto;
      background: white;
      border-radius: 12px;
      padding: 40px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    }

    h2 {
      text-align: center;
      margin-bottom: 35px;
      font-weight: 600;
      color: #4e73df;
    }

    h5 {
      color: #4e73df;
      font-weight: 600;
      margin-bottom: 15px;
      border-bottom: 1px solid #e0e0e0;
      padding-bottom: 6px;
    }

  .form-control {
  border-radius: 6px;
  border: 1px solid #ccc;
  transition: all 0.2s ease-in-out;
    line-height: 1.6;         /* <-- Espaçamento vertical suave */
}

.form-control:focus {
  border-color: #4e73df;
  box-shadow: 0 0 6px rgba(78,115,223,0.25);
}

/* Caso o campo seja contenteditable */[contenteditable="true"].form-control {
  width: 100%;
  min-height: 120px;
  white-space: pre-wrap;
  overflow-y: auto;
  line-height: 1.6;


}

    .form-control-Text {
      width:100%;
      border-radius: 6px;
      border: 1px solid #ccc;
      transition: all 0.2s ease-in-out;
      height:100px;
    }


    .form-section {
      margin-bottom: 1.2rem;
    }

    .split-row {
      display: flex;
      gap: 30px;
      flex-wrap: wrap;
    }

    .split-col {
      flex: 1 1 50%;
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }

    /* Linha para data, local e horário */
    .inline-row {
      display: flex;
      gap: 1rem;
    }

    .inline-row .form-section {
      flex: 1;
      margin-bottom: 0;
    }

    footer {
      text-align: center;
      margin-top: 35px;
      color: #888;
      font-size: 0.85rem;
    }

    .btn-primary {
      border-radius: 6px;
      background-color: #4e73df;
      border: none;
      transition: 0.2s;
    }
      label {
        font-size:20;
        font-weight: bold;
      }

    .btn-primary:hover {
      background-color: #3b5bdb;
    }

    .btn-secondary {
      border-radius: 6px;
      color: #ffffffff;
      border: none;
    }
      .predef:hover{
      background-color: #c2d6f3ff;
      cursor: pointer;
      
      }

    .btn-secondary:hover {
      background-color: #aaadb2ff;
    }
  </style>
</head>

<body>
<header>
  <h1>Criação de ATA</h1>
</header>

<main>
  <h2 class="fw-bold">Nova ATA</h2>

<form method="post" action="http://localhost/TCC_Qualifica-o_Guilherme_Caio/model/AtaModel.php">
  <div class="form-section">

          <label for="nome" class="form-label">Nome da ATA</label>
<input type="text" class="form-control" id="nome" name="nome" required>

<script>
(function(){
  const input = document.getElementById("nome");

  // Função de normalização: substitui 1 a → 1ª e 2 o → 2º
  function normalizeText(text) {
    return text
      .replace(/(\d+)[\s\n\r\u00A0\u200B]*a(?![\w>])/gi, "$1ª")
      .replace(/(\d+)[\s\n\r\u00A0\u200B]*o(?![\w>])/gi, "$1º");
  }

  // Atualiza o valor ao digitar
  input.addEventListener("input", () => {
    const start = input.selectionStart;
    const end = input.selectionEnd;
    const newValue = normalizeText(input.value);
    if (newValue !== input.value) {
      input.value = newValue;
      // restaura a posição do cursor
      input.setSelectionRange(start, end);
    }
  });

  // Normaliza também ao colar
  input.addEventListener("paste", (e) => {
    e.preventDefault();
    const clipboard = e.clipboardData || window.clipboardData;
    let text = clipboard.getData("text/plain");
    document.execCommand("insertText", false, normalizeText(text));
  });
})();
</script>
  </div>

    <div class="split-row">
      <!-- Coluna Esquerda -->
      <div class="split-col">
        ' . $this->inputComPredef("Organização", "organizacao", ["IFSP", "SENAI", "Prefeitura"]) . '
        ' . $this->inputComPredef("Nucleo Institucional", "nucleo", ["FHO", "Sala 202", "Núcleo de Pesquisa"]) . '
        ' . $this->inputComPredef("Curso", "curso", ["Informática", "Administração", "Logística"]) . '
        ' . $this->inputComPredef("Integrantes", "Integrantes", ["João Silva", "Maria Souza", "Carlos Pereira"]) . '

      </div>

      <!-- Coluna Direita -->
      <div class="split-col">

        <!-- Linha: Data / Local / Horário -->
        <div class="inline-row">
          <div class="form-section justify-content-center">
            <label for="data" class="form-label">Data</label>
            <input type="date" class="form-control" id="data" name="data" required>
          </div>

          <div class="form-section">
            ' . $this->inputComPredef("local", "local", ["IFSP", "SENAI", "Prefeitura"]) . '
          </div>

          <div class="form-section inline-row justify-content-center">
          <div class="flex-column">
            <label for="horario" class="form-label">Hora Início</label>
            <input type="time" class="form-control" id="horario" name="horaInicial" required>
            </div>
            <div class="flex-column">
            <label for="horario" class="form-label">Hora Final</label>
            <input type="time" class="form-control" id="horario" name="horaFinal" required>
             </div>
          </div>
        </div>

        ' . $this->inputComPredef("Informação Introdutória", "infoIntro", ["Reunião para deliberação", "Início das atividades do semestre"]) . '

        ' . $this->inputComPredef("Prefácio", "prefacio", ["Abertura de atividades", "Planejamento do semestre"]) . '

        ' . $this->inputComPredef("Assunto", "assunto", ["Apresentação de projetos", "Avaliação institucional", "Planejamento do semestre"]) . '

        ' . $this->inputComPredef("Encerramento", "encerramento", ["Agradecimentos finais", "Encerramento às 12h"]) . '
      </div>
    </div>

    <div class="d-flex justify-content-between mt-4">
      <button type="submit" class="btn btn-primary px-4 py-4 fs-5">
        <i class="bi bi-file-earmark-text"></i> Gerar ATA
      </button>
      <button class="btn btn-secondary px-4 py-4 fs-5">
        <i class="bi bi-arrow-left-circle"></i> Voltar
      </button>
    </div>

  </form>
</main>

<footer>
  © ' . date("Y") . ' Sistema de Criação de ATA — Todos os direitos reservados.
</footer>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  $(function() {
    $(".dropdown-item.predef").on("click", function() {
      const target = $(this).data("target");
      const value = $(this).text();
      $("#" + target).val(value);
    });

    $("#formAta").on("submit", function() {
      alert("✅ ATA criada com sucesso!");
    });
  });
</script>

<script>
document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll("textarea").forEach(el => {
    el.addEventListener("paste", e => {
      e.preventDefault();
      const text = (e.clipboardData || window.clipboardData).getData("text/plain");
      const start = el.selectionStart;
      const end = el.selectionEnd;

      // Insere exatamente o texto copiado (sem normalizar)
      el.value = el.value.slice(0, start) + text + el.value.slice(end);

      // Reposiciona o cursor no fim do texto colado
      el.selectionStart = el.selectionEnd = start + text.length;
    });
  });
});
</script>



</body>
</html>
';
?>