<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Criar Novo Cargo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('assets/css/pages/job-position/create.css') ?>">
</head>

<body>
  <div class="container mt-5">
    <div class="card shadow-sm">
      <div class="card-body">
        <h4 class="mb-4"><i class="bi bi-plus-circle me-2"></i>Criar Novo Cargo</h4>
        <form action="<?= site_url('job_position/create') ?>" method="post">
          <div class="mb-3">
            <label for="name" class="form-label">Nome do cargo</label>
            <input type="text" name="name" id="name" class="form-control" required>
          </div>

          <div class="d-flex justify-content-between">
            <a href="<?= site_url('job_position') ?>" class="btn btn-outline-secondary">
              <i class="bi bi-arrow-left"></i> Cancelar
            </a>
            <button type="submit" class="btn btn-success">
              <i class="bi bi-save"></i> Salvar
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>