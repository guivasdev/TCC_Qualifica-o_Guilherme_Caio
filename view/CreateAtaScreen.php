<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Criação de ATA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: url('Frame 5.png') no-repeat center center fixed;
      background-size: cover;
      backdrop-filter: blur(5px);
      min-height: 100vh;
    }

    .form-container {
      background-color: rgba(255, 255, 255, 0.95);
      max-width: 600px;
      margin: 50px auto;
      padding: 30px;
      border-radius: 12px;
    }

    .form-label {
      font-weight: bold;
    }

    .form-title {
      color: #00778B;
      text-align: center;
      margin-bottom: 30px;
      font-weight: bold;
      font-size: 24px;
    }

    .form-section-title {
      font-weight: bold;
      color: #666;
      margin-top: 25px;
    }
  </style>
</head>
<body>

  <div class="form-container shadow">
    <div class="form-title">Criação de ATA</div>

    <form id="formAta">
      <!-- Seção 1 -->
      <div class="mb-3">
        <label class="form-label">Organização</label>
        <input type="text" class="form-control" name="organizacao">
      </div>

      <div class="mb-3">
        <label class="form-label">Curso</label>
        <input type="text" class="form-control" name="curso">
      </div>

      <div class="mb-3">
        <label class="form-label">Local</label>
        <input type="text" class="form-control" name="local">
      </div>

      <div class="mb-3">
        <label class="form-label">Data</label>
        <input type="date" class="form-control" name="data">
      </div>

      <div class="mb-3">
        <label class="form-label">Local</label>
        <input type="text" class="form-control" name="local2">
      </div>

      <div class="mb-3">
        <label class="form-label">Horário</label>
        <input type="text" class="form-control" name="horario">
      </div>

      <!-- Seção 2 -->
      <div class="form-section-title">Informação introdutória</div>

      <div class="mb-3">
        <input type="text" class="form-control" name="infoIntro">
      </div>

      <!-- Seção 3 -->
      <div class="mb-3">
        <label class="form-label">Organização</label>
        <input type="text" class="form-control" name="organizacao2">
      </div>

      <div class="mb-3">
        <label class="form-label">Assunto</label>
        <input type="text" class="form-control" name="assunto">
      </div>

      <div class="mb-3">
        <label class="form-label">Encerramento</label>
        <input type="text" class="form-control" name="encerramento">
      </div>

      <button type="submit" class="btn btn-info w-100 text-white">Gerar ATA</button>
    </form>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script>
    $('#formAta').on('submit', function (e) {
      e.preventDefault();

      const dados = $(this).serializeArray();
      console.log("Dados do formulário:", dados);

      // Aqui você pode usar $.ajax para enviar para o backend se desejar
    });
  </script>
</body>
</html>
