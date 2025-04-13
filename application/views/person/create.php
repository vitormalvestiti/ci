<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Adicionar Funcionário</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('assets/css/pages/person/create.css') ?>">
</head>

<body>
  <div class="container mt-5">
    <div class="card shadow-sm">
      <div class="card-body">
        <h4 class="mb-4"><i class="bi bi-person-plus me-2"></i>Adicionar novo funcionário</h4>

        <form action="<?= site_url('person/store') ?>" method="post">
          <div class="mb-3">
            <label for="name" class="form-label">Nome completo</label>
            <input type="text" name="name" id="name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="job_position_id" class="form-label">Cargo</label>
            <select name="job_position_id" id="job_position_id" class="form-select" required>
              <option value="">Selecione o cargo atual</option>
              <?php foreach ($job_positions as $job): ?>
                <option value="<?= $job->id ?>"><?= htmlspecialchars($job->name) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="start_date" class="form-label">Data de início</label>
            <input type="date" name="start_date" id="start_date" class="form-control" required>
          </div>
          <div class="d-flex justify-content-between">
            <a href="<?= site_url('person') ?>" class="btn btn-outline-secondary">
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