<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Editar Histórico</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('assets/css/pages/job-history/edit.css') ?>">
</head>

<body>
  <div class="container mt-5">
    <div class="card shadow-sm">
      <div class="card-body">
        <h4 class="mb-4">
          <i class="bi bi-pencil-square me-2"></i>Editar histórico do funcionário <?= htmlspecialchars($person->name) ?>
        </h4>
        <form action="<?= site_url('job_history/update/' . $history->id) ?>" method="post">
          <div class="mb-3">
            <label for="job_position_id" class="form-label">Cargo</label>
            <select name="job_position_id" id="job_position_id" class="form-select" required>
              <option value="">Selecione o cargo</option>
              <?php foreach ($job_positions as $job): ?>
                <option value="<?= $job->id ?>" <?= $job->id == $history->job_position_id ? 'selected' : '' ?>>
                  <?= htmlspecialchars($job->name) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label for="start_date" class="form-label">Data inicial</label>
            <input type="date" name="start_date" id="start_date" class="form-control"
              value="<?= htmlspecialchars($history->start_date) ?>" required>
          </div>

          <div class="mb-3">
            <label for="end_date" class="form-label">Data final</label>
            <input type="date" name="end_date" id="end_date" class="form-control"
              value="<?= htmlspecialchars($history->end_date) ?>">
            <small class="form-text text-muted">Deixe em branco se ainda estiver neste cargo.</small>
          </div>

          <div class="d-flex justify-content-between">
            <a href="<?= site_url('job_history/index/' . $person->id) ?>" class="btn btn-outline-secondary">
              <i class="bi bi-arrow-left"></i> Cancelar
            </a>
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-save"></i> Atualizar histórico
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php if (isset($success)): ?>
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-success">
          <div class="modal-header bg-success text-white">
            <h5 class="modal-title" id="successModalLabel">
              <i class="bi bi-check-circle me-2"></i>Sucesso
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
          </div>
          <div class="modal-body">
            <?= $success ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">Fechar</button>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    <?php if (isset($success)): ?>
      const successModal = new bootstrap.Modal(document.getElementById('successModal'));
      window.addEventListener('load', () => successModal.show());
    <?php endif; ?>
  </script>

</body>

</html>