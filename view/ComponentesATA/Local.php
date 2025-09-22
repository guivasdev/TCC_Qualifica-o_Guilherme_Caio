<?php
echo '
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="d-flex justify-content-center align-items-center vh-100">
  <div class="card shadow-sm w-100" style="max-width: 500px;">
    <div class="card-body">
      <h3 class="card-title mb-3 text-center">Cadastro de Local</h3>
      <form method="post" action="#">
        <div class="mb-3">
          <label class="form-label">Nome do Local</label>
          <input type="text" class="form-control" name="nomeLocal" placeholder="Digite o local" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Salvar Local</button>
      </form>
    </div>
  </div>
</div>
';
?>
