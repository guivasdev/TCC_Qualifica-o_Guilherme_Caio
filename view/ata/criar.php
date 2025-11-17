<?php include 'header.php'; ?>

<?php
$base = '/TCC_Qualifica-o_Guilherme_Caio';


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

<form id="formAta" method="post" action="/TCC_Qualifica-o_Guilherme_Caio/index.php?acao=gerar2">

  <div class="form-section">
    <label for="nome" class="form-label">Nome da ATA</label>
    <input type="text" class="form-control" id="nome" name="nome" required>
  </div>

  <div class="split-row">
    <div class="split-col">

      <?php
      echo inputSelectEInput("Organização", "organizacao", $organizacao);
      echo inputSelectEInput("Núcleo Institucional", "nucleo", $nucleos);
      echo inputSelectEInput("Curso", "curso", $cursos);
      echo inputSelectEInput("Integrantes", "integrante", $cargos);
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
          <input type="Local" class="form-control" name="local" required>
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
        echo inputTextarea("Informação Introdutória", "infoIntro");
        echo inputTextarea("Prefácio", "prefacio");
        echo inputTextarea("Assunto", "assunto");
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