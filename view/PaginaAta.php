<?php
echo '
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Criação de ATA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
  <div class="form-container shadow p-4 rounded bg-white">
    <h2 class="text-center mb-4">Criação de ATA</h2>

    <form id="formAta" method="post" action="model/AtaModel.php">
      
      <!-- Nome -->
      <div class="mb-3">
        <label class="form-label">Nome</label>
        <input type="text" class="form-control" name="nome" required>
      </div>

      <!-- Organização -->
      ' . $this->inputComPredef("Organização", "organizacao", ["IFSP", "SENAI", "Prefeitura"]) . '

      <!-- Curso -->
      ' . $this->inputComPredef("Curso", "curso", ["Informática", "Administração", "Logística"]) . '

      <!-- Local -->
      ' . $this->inputComPredef("Local", "local", ["Auditório", "Sala 101", "Laboratório"]) . '
      <!-- nucleo -->
      ' . $this->inputComPredef("Nucleo Institucional", "nucleo", ["Fho", "Sala 101", "Laboratório"]) . '
      <!-- Prefacio -->
      ' . $this->inputComPredef("Prefácio", "prefacio", ["Fho", "Sala 101", "Laboratório"]) . '

      <!-- Data -->
      <div class="mb-3">
        <label class="form-label">Data</label>
        <input type="date" class="form-control" name="data" required>
      </div>

      <!-- Horário -->
      ' . $this->inputComPredef("Horário", "horario", ["08:00", "10:30", "14:00"]) . '

      <!-- Informação introdutória -->
      ' . $this->inputComPredef("Informação Introdutória", "infoIntro", ["Reunião para deliberação", "Início das atividades do semestre"]) . '

      <!-- Integrantes -->
      ' . $this->inputComPredef("Integrantes", "Integrantes", []) . '

      <!-- Assunto -->
      ' . $this->inputComPredef("Assunto", "assunto", ["Apresentação de projetos", "Avaliação institucional", "Planejamento do semestre"]) . '

      <!-- Encerramento -->
      ' . $this->inputComPredef("Encerramento", "encerramento", ["Agradecimentos finais", "Encerramento às 12h"]) . '

    <div class="d-flex justify-content-between mt-3">
      <button type="submit" class="btn btn-info text-white">Gerar ATA</button>
      <a href="index.php" class="btn btn-secondary">Voltar</a>
    </div>
        </form>
      </div>
    </div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  $(document).ready(function(){
    $(".dropdown-item.predef").on("click", function(){
      const target = $(this).data("target");
      const value = $(this).text();
      $("#" + target).val(value);
    });

    $("#formAta").on("submit", function() {
      alert("Dados da ata foram guardados com sucesso");
    });
  });
</script>
</body>
</html>
';
?>