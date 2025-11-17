<?php include 'header.php'; ?>

<?php
$base = '/TCC_Qualifica-o_Guilherme_Caio-master';


require_once __DIR__ . "/../../model/OrganizacaoRepository.php";
require_once __DIR__ . "/../../model/NucleoRepository.php";
require_once __DIR__ . "/../../model/CursoRepository.php";
require_once __DIR__ . "/../../model/CargoRepository.php";


/* ============================
   INSTANCIA OS REPOS
================================*/
$repoOrg = new OrganizacaoRepository();
$repoNuc = new NucleoRepository();
$repoCurso = new CursoRepository();
$repoCargo = new CargoRepository();

/* ============================
   BUSCA DO BANCO
================================*/
$organizacao = $repoOrg->buscarTodas();
$nucleos = $repoNuc->buscarTodas();
$cursos = $repoCurso->buscarTodas();
$cargos = $repoCargo->buscarTodas();

/* COMPONENTES */
require_once 'componentes.php';
?>

<link rel="stylesheet" href="<?php echo $base; ?>/externo/CriarAta.css">
<form id="formAta" method="post" action="/TCC_Qualifica-o_Guilherme_Caio-master/index.php?acao=gerarAta">

  <!-- TABELA QUE SERÁ SALVA -->
  <input type="hidden" name="tabela" value="documento">

  <div class="form-section">
    <label for="titulo" class="form-label">Nome da ATA</label>
    <input type="text" class="form-control" id="titulo" name="titulo" required>
  </div>

  <div class="split-row">
    <div class="split-col">

      <?php
      // ALTERADO: nomes iguais aos da tabela
      echo inputSelectEInput("Organização", "organizacao", $organizacao);
      echo inputSelectEInput("Núcleo Institucional", "nucleo", $nucleos);
      echo inputSelectEInput("Curso", "curso", $cursos);
      echo inputSelectEInput("Integrante", "integrante", $cargos);
      ?>

    </div>

    <div class="split-col">

      <div class="inline-row">
        <div class="form-section">
          <label for="data" class="form-label">Data</label>
          <input type="date" class="form-control" name="data" required>
        </div>

        <div class="form-section">
          <label for="Local" class="form-label">Local</label>
          <input type="text" class="form-control" name="local" required>
        </div>

        <div class="form-section inline-row">
          <div class="flex-column">
            <label class="form-label">Hora Início</label>
            <input type="time" class="form-control" name="hora_inicial" required>
          </div>
          <div class="flex-column">
            <label class="form-label">Hora Final</label>
            <input type="time" class="form-control" name="hora_final" required>
          </div>
        </div>
      </div>

      <div class="campos-ata">
        <?php
        // ALTERADOS para bate com o banco
        echo inputTextarea("Informação Introdutória", "informacao_introdutoria");
        echo inputTextarea("Prefácio", "prefacio");
        echo inputTextarea("Assunto", "assunto"); // esse você decide se vai salvar ou gerar apenas no PDF
        echo inputTextarea("Encerramento", "encerramento");
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