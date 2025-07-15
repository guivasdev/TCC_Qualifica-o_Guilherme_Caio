<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Busca de Atas</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Estilo personalizado -->
  <link rel="stylesheet" href="../externo/BuscaScreen.css">
</head>

<body>
  <div class="container-fluid px-5">

    <!-- Sidebar -->
    <div id="sidebar" class="sidebar">
      <ul>
        <li><a href="CreateAtaScreen.php">Gerar ATA</a></li>
       
      </ul>
    </div>

    <!-- Cabeçalho -->
    <div class="d-flex justify-content-between align-items-center py-3">
      <div class="menu-icon">☰</div>
      <h6 class="text-center flex-grow-1">Utilize o buscador para encontrar o que deseja</h6>
    </div>

    <!-- Filtro e busca -->
    <div class="row mb-3">
      <div class="col-md-3">
        <select class="form-select" id="filtro">
          <option value="tudo">Tudo</option>
          <option value="titulo">Título</option>
          <option value="data">Data</option>
          <option value="palavras_chave">Palavras Chave</option>
          <option value="resumo">Resumo</option>
          <option value="conteudo">Conteúdo</option>
          <option value="autor">Autor</option>
          <option value="recents">Recentes</option>
        </select>
      </div>
      <div class="col-md-7">
        <input type="text" id="pesquisa" class="form-control" placeholder="Digite Aqui..." />
      </div>
      <div class="col-md-2">
        <button id="buscar" class="btn btn-info w-100 text-white">Buscar</button>
      </div>
    </div>

    <!-- Resultado -->
    <div id="resultado" class="overlay">
      <!-- Preenchido dinamicamente -->
    </div>
  </div>

  <!-- jQuery -->
  <script src="../js/jquery-3.7.1.min.js"></script>
  
  <!-- JS para menu -->
  <script src="../js/menu.js"></script>

  <!-- Script de busca -->
  <script>
    $(document).ready(function () {
      $('#buscar').click(function () {
        const filtro = $('#filtro').val();
        const pesquisa = $('#pesquisa').val();

        // Simulação de resultado
        const mockData = {
          titulo: "ATA sobre gerenciamento de horário noturno - 2025",
          data: "25/10/2025",
          tipo: "online/presencial",
          assuntos: "ass 01, ass 02, ass03",
          palavras_chave: "",
          resumo: ""
        };

        $('#resultado').html(`
          <h4 class="header-title">${mockData.titulo}</h4>
          <div class="row mt-3">
            <div class="col-md-4"><div class="label-box"><strong>data:</strong> ${mockData.data}</div></div>
            <div class="col-md-4"><div class="label-box"><strong>tipo:</strong> ${mockData.tipo}</div></div>
            <div class="col-md-4"><div class="label-box"><strong>assuntos:</strong> ${mockData.assuntos}</div></div>
            <div class="col-md-6"><div class="label-box"><strong>palavras chaves:</strong> ${mockData.palavras_chave}</div></div>
            <div class="col-md-12"><div class="label-box"><strong>resumo:</strong> ${mockData.resumo}</div></div>
          </div>
        `);
      });
    });
  </script>
</body>

</html>
