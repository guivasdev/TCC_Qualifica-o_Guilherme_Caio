<?php
$base = '/TCC_Qualifica-o_Guilherme_Caio-master';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="<?php echo $base; ?>/externo/BuscaScreen.css">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Busca de Atas</title>


  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="container-fluid px-5">
    <div id="sidebar" class="sidebar">
      <ul>
        <li><a href="<?php echo $base; ?>/index.php?acao=gerar">Gerar ATA</a></li>
        <li><a href="<?php echo $base; ?>/index.php?acao=buscar">Buscar ATA</a></li>
        <li><a href="<?php echo $base; ?>/index.php?acao=form">Cadastrar Componente</a></li>


      </ul>
    </div>

    <div class="d-flex justify-content-between align-items-center py-3">
      <div class="menu-icon">☰</div>
      <h6 class="text-center">Utilize o buscador para encontrar o que deseja</h6>
    </div>

    <div class="row mb-3">
      <div class="col-md-3">
        <select id="filtro" class="form-select">
          <option value="tudo">Tudo</option>
          <option value="nome">Título</option>
          <option value="data">Data</option>
          <option value="prefacio">Prefácio</option>
          <option value="assunto">Assunto</option>
          <option value="conteudo">Conteúdo</option>
          <option value="autor">Autor</option>
          <option value="recents">Recentes</option>
        </select>
      </div>

      <div class="col-md-7">
        <input type="text" id="pesquisa" class="form-control" placeholder="Digite Aqui…">
      </div>

      <div class="col-md-2">
        <button id="buscar" class="btn btn-info w-100 text-white">Buscar</button>
      </div>
    </div>

    <div id="resultado" class="overlay"></div>
  </div>
  <?php
  $path = '/TCC_Qualifica-o_Guilherme_Caio-master/js/';
  ?>

  <script src="<?php echo $path; ?>jquery-3.7.1.min.js"></script>
  <script src="<?php echo $path; ?>menu.js"></script>
  <script src="<?php echo $path; ?>buscar.js"></script>

</body>

</html>