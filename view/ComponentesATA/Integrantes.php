<?php
echo '
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="d-flex justify-content-center align-items-center vh-100">
  <div class="card shadow-sm w-100" style="max-width: 500px;">
    <div class="card-body">
      <h3 class="card-title mb-4 text-center">Cadastro de Integrante</h3>

      <form method="post" action="model/IntegranteModel.php">
        <div class="mb-3">
          <label class="form-label">Nome do Integrante</label>
          <input type="text" class="form-control" name="nomeIntegrante" placeholder="Digite o nome do integrante" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Função / Cargo</label>
          <input type="text" class="form-control" name="funcaoIntegrante" placeholder="Digite a função do integrante">
        </div>

        <button type="submit" class="btn btn-primary w-100">Salvar Integrante</button>
      </form>
    </div>
  </div>
</div>
';
?>
