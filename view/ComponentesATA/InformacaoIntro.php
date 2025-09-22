<?php
echo '
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="d-flex justify-content-center align-items-center vh-100">
  <div class="card shadow-sm w-100" style="max-width: 500px;">
    <div class="card-body">
      <h3 class="card-title mb-3 text-center">Informação Introdutória</h3>
      <form method="post" action="#">
        <div class="mb-3">
          <label class="form-label">Informação Introdutória</label>
          <textarea class="form-control" name="infoIntro" rows="3" placeholder="Digite a informação introdutória" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary w-100">Salvar Informação</button>
      </form>
    </div>
  </div>
</div>
';
?>
