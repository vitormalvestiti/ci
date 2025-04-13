<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Editar Cargo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('assets/css/pages/job-position/edit.css') ?>">
</head>

<body>
  <div class="container mt-5">
    <div class="card shadow-sm">
      <div class="card-body">
        <h4 class="mb-4"><i class="bi bi-pencil-square me-2"></i>Editar Cargo</h4>

        <form method="post" action="<?= site_url('job_position/edit/' . $job_position->id) ?>">
          <div class="mb-3">
            <label for="name" class="form-label">Nome do cargo</label>
            <input type="text" name="name" id="name" class="form-control"
              value="<?= htmlspecialchars($job_position->name) ?>" required>
          </div>

          <div class="d-flex justify-content-between">
            <a href="<?= site_url('job_position') ?>" class="btn btn-outline-secondary">
              <i class="bi bi-arrow-left"></i> Voltar
            </a>
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-check-circle"></i> Atualizar
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php if ($this->session->flashdata('success')): ?>
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-success">
          <div class="modal-header bg-success text-white">
            <h5 class="modal-title" id="successModalLabel"><i class="bi bi-check-circle me-2"></i>Sucesso</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
          </div>
          <div class="modal-body">
            <?= $this->session->flashdata('success') ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">Fechar</button>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <?php if ($this->session->flashdata('success')): ?>
    <script>
      window.addEventListener('load', () => {
        const modal = new bootstrap.Modal(document.getElementById('successModal'));
        modal.show();
      });
    </script>
  <?php endif; ?>
</body>

</html>