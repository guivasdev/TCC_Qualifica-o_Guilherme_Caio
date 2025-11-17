<?php include 'header.php'; ?>

<?php
$base = '/TCC_Qualifica-o_Guilherme_Caio';
?>
<link rel="stylesheet" href="<?php echo $base; ?>/externo/CriarAta.css">

<form id="formAta" method="post" action="/TCC_Qualifica-o_Guilherme_Caio/index.php">
  <div class="form-section">
    <label for="nome" class="form-label">Nome da ATA</label>
    <input type="text" class="form-control" id="nome" name="nome" required>
  </div>

  <div class="split-row">
    <div class="split-col">
      <?php
      include 'componentes.php';

      echo inputComPredef("Organização", "organizacao", ["IFSP", "SENAI", "Prefeitura"]);
      echo inputComPredef("Nucleo Institucional", "nucleo", ["FHO", "Sala 202", "Núcleo de Pesquisa"]);
      echo inputComPredef("Curso", "curso", ["Informática", "Administração", "Logística"]);
      echo inputComPredef("Integrantes", "integrantes", ["João Silva", "Maria Souza", "Carlos Pereira"]);
      ?>
    </div>

    <div class="split-col">
      <div class="inline-row">
        <div class="form-section">
          <label for="data" class="form-label">Data</label>
          <input type="date" class="form-control" name="data" required>
        </div>
        <div class="form-section">
          <?php echo inputComPredef("Local", "local", ["IFSP", "SENAI", "Prefeitura"]); ?>
        </div>
        <div class="form-section inline-row">
          <div class="flex-column">
            <label class="form-label">Hora Início</label>
            <input type="time" class="form-control" name="horaInicial" required>
          </div>
          <div class="flex-column">
            <label class="form-label">Hora Final</label>
            <input type="time" class="form-control" name="horaFinal" required>
          </div>
        </div>
      </div>
      <div class="campos-ata">

        <?php
        echo inputComPredef("Informação Introdutória", "infoIntro", ["Reunião para deliberação", "Início das atividades do semestre"]);
        echo inputComPredef("Prefácio", "prefacio", ["Abertura de atividades", "Planejamento do semestre"]);
        echo inputComPredef("Assunto", "assunto", ["Apresentação de projetos", "Avaliação institucional", "Planejamento do semestre"]);
        echo inputComPredef("Encerramento", "encerramento", ["Agradecimentos finais", "Encerramento às 12h"]);
        ?>
      </div>
    </div>
  </div>

  <div class="d-flex justify-content-between mt-4">
    <button type="submit" class="btn btn-primary px-4 py-4 fs-5">
      <i class="bi bi-file-earmark-text"></i> Gerar ATA
    </button>

    <a href="<?php echo $base; ?>/index.php?acao=buscar" class="btn btn-secondary px-4 py-4 fs-5">
      <i class="bi bi-arrow-left-circle"></i> Voltar
    </a>

  </div>
</form>
<?php include 'footer.php'; ?>