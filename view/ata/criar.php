<?php include 'header.php'; ?>

<?php
$base = '/TCC_Qualifica-o_Guilherme_Caio-master';


require_once __DIR__ . "/../../model/classes/Cargo.php";
require_once __DIR__ . "/../../model/classes/Curso.php";
require_once __DIR__ . "/../../model/classes/Integrante.php";
require_once __DIR__ . "/../../model/classes/NucleoInstitucional.php";
require_once __DIR__ . "/../../model/classes/Organizacao.php";
require_once __DIR__ . "/../../model/classes/Local.php";


/* ============================
   INSTANCIA OS REPOS
================================*/
$repoCurso = new Curso();
$repoCargo = new Cargo();
$repoIntegrante = new Integrante();
$repoNucleo = new NucleoInstitucional();
$repoOrganizacao = new Organizacao();
$repoLocal = new Local();

/* ============================
   BUSCA DO BANCO
================================*/
$cursos = $repoCurso->getALLCursos();
$cargos = $repoCargo->getALLCargos();
$integrantes = $repoIntegrante->getALLIntegrantes();
$nucleos = $repoNucleo->getALLNucleoInstitucional();
$organizacao = $repoOrganizacao->getALLOrganizacoes();
$locais = $repoLocal->getALLLocalizacao();

/* COMPONENTES */
require_once 'componentes.php';
?>
<style>
#bloco_integrantes {
    background: #f0f0f0;               /* Fundo suave */
    border: 1px solid #ccc;            /* Borda leve */
    border-radius: 10px;               /* Bordas arredondadas */
    padding: 12px;
    width: 280px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);  /* Sombra elegante */
    animation: fadeIn 0.2s ease-in-out;
}

/* Título do bloco */
#bloco_integrantes strong {
    font-size: 15px;
    color: #333;
    margin-bottom: 8px;
    display: block;
}

/* Cada opção (checkbox com label) */
#bloco_integrantes label {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.2s, transform 0.1s;
}

/* Hover bonito */
#bloco_integrantes label:hover {
    background: #e0e0e0;
    transform: translateX(3px);
}

/* Checkbox maior e mais bonito */
#bloco_integrantes input[type="checkbox"] {
    width: 18px;
    height: 18px;
}

/* Animação quando o bloco abre */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-6px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
<link rel="stylesheet" href="<?php echo $base; ?>/externo/CriarAta.css">
<form  id="formAta" method="post" action="/TCC_Qualifica-o_Guilherme_Caio-master/index.php?acao=gerarAta">

  <!-- TABELA QUE SERÁ SALVA -->
  <input type="hidden" name="tabela" value="documento">

  <div class="form-section">
    <label for="nome" class="form-label">Nome da ATA</label>
    <input type="text" class="form-control" id="nome" name="nome" required>
  </div>

  <div class="split-row">
    <div class="split-col">
  
      <?php
$integrantesSelecionados = $dados['integrantes'] ?? []; // array de IDs
echo inputSelectEInput("Curso", "curso", $cursos, $dados['curso_id'] ?? '');
echo inputSelectEInput("Cargo", "cargo", $cargos, $dados['cargo_id'] ?? '');
echo inputSelectEInput("Integrante", "integrante", $integrantes, '', $integrantesSelecionados); // <-- aqui
echo inputSelectEInput("Núcleo Institucional", "nucleo", $nucleos, $dados['nucleo_id'] ?? '');
echo inputSelectEInput("Organização", "organizacao", $organizacao, $dados['organizacao_id'] ?? '');
echo inputSelectEInput("Local", "local", $locais, $dados['local_id'] ?? '');

      
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
       echo inputTextarea("Informação Introdutória", "introducao", $dados['introducao'] ?? '');
echo inputTextarea("Prefácio", "prefacio", $dados['prefacio'] ?? '');
echo inputTextarea("Assunto", "assunto", $dados['assunto'] ?? '');
echo inputTextarea("Encerramento", "encerramento", $dados['encerramento'] ?? '');

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
<script>
document.addEventListener("DOMContentLoaded", function () {

    const selectIntegrante = document.getElementById("select_integrante");
    const blocoIntegrantes = document.getElementById("bloco_integrantes");
    const inputNovo = document.getElementById("input_integrante_novo");

    // Abre/fecha quando o select muda
    selectIntegrante.addEventListener("change", function () {

        if (this.value === "mostrar") {
            blocoIntegrantes.style.display = "block";
            inputNovo.style.display = "none"; // esconder input no modo lista
        } else {
            blocoIntegrantes.style.display = "none";
            inputNovo.style.display = "block";
        }
    });

    // FECHAR AO CLICAR FORA
    document.addEventListener("click", function (event) {

        const clicouForaDoSelect =
            !selectIntegrante.contains(event.target);

        const clicouForaDoBloco =
            !blocoIntegrantes.contains(event.target);

        // só fecha se estiver aberto e clicou fora dos dois
        if (blocoIntegrantes.style.display === "block" &&
            clicouForaDoSelect &&
            clicouForaDoBloco) {

            blocoIntegrantes.style.display = "none";
            selectIntegrante.value = ""; // volta select para "Selecionar"
            inputNovo.style.display = "block"; // volta input
        }
    });
});
</script>
