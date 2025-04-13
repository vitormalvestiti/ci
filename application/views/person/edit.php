<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Editar Funcionário</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('assets/css/pages/person/edit.css') ?>">
</head>

<body>
  <div class="container mt-5">
    <div class="card shadow-sm mb-4">
      <div class="card-body">
        <h4 class="mb-4"><i class="bi bi-person-gear me-2"></i>Editar Funcionário: <?= htmlspecialchars($person->name) ?></h4>

        <?php
        $last_job = $this->Job_history_model->get_active_by_person($person->id);
        $is_dismissed = $last_job && strtolower($last_job->job_position_name) === 'desligado';

        $min_start_date = '';
        if ($is_dismissed && !empty($last_job->start_date)) {
          $min_start_date = date('Y-m-d', strtotime($last_job->start_date . ' +1 day'));
        }
        ?>

        <div class="alert <?= $is_dismissed ? 'alert-danger' : 'alert-success' ?>">
          <strong>Status:</strong> <?= $is_dismissed ? 'Desligado' : 'Ativo' ?>
        </div>

        <form action="<?= site_url('person/update/' . $person->id) ?>" method="post" class="mb-4">
          <div class="mb-3">
            <label for="name" class="form-label">Nome completo</label>
            <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($person->name) ?>" required>
          </div>
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-save"></i> Atualizar nome
          </button>
        </form>
        <hr>

        <h5 class="mb-3"><i class="bi bi-briefcase me-2"></i>Adicionar novo cargo</h5>
        <form action="<?= site_url('person/assign_job/' . $person->id) ?>" method="post">
          <div class="mb-3">
            <label for="job_position_id" class="form-label">Novo cargo</label>
            <select name="job_position_id" id="job_position_id" class="form-select" required>
              <option value="">Selecione o cargo</option>
              <?php foreach ($job_positions as $job): ?>
                <option value="<?= $job->id ?>"><?= htmlspecialchars($job->name) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label for="start_date" class="form-label">Data de Início</label>
            <?php $max_today = date('Y-m-d');
            $min_attr = $min_start_date ? 'min="' . $min_start_date . '"' : ''; ?>
            <input type="date" name="start_date" id="start_date" class="form-control"
              <?= $min_attr ?> max="<?= $max_today ?>" required>
            <?php if ($min_start_date): ?>
              <small class="form-text text-muted">
                Funcionário foi desligado. Só pode ser recontratado a partir de <?= date('d/m/Y', strtotime($min_start_date)) ?>.
              </small>
            <?php endif; ?>
          </div>

          <button type="submit" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Adicionar novo cargo
          </button>
        </form>

        <?php if (!$is_dismissed): ?>
          <hr>
          <h5 class="mb-3"><i class="bi bi-person-x me-2"></i>Desligar funcionário</h5>
          <form action="<?= site_url('person/dismiss/' . $person->id) ?>" method="post">
            <div class="mb-3">
              <label for="dismiss_date" class="form-label">Data de desligamento</label>
              <input type="date" name="dismiss_date" id="dismiss_date" class="form-control" max="<?= date('Y-m-d') ?>" required>
            </div>
            <button type="submit" class="btn btn-danger">
              <i class="bi bi-person-x"></i> Confirmar desligamento
            </button>
          </form>
        <?php endif; ?>

        <div class="d-flex justify-content-between mt-4">
          <a href="<?= site_url('person') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Voltar
          </a>
          <a href="<?= site_url('job_history/index/' . $person->id) ?>" class="btn btn-info">
            <i class="bi bi-clock-history"></i> Ver histórico de cargos
          </a>
        </div>
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

  <?php if ($this->session->flashdata('conflict')): ?>
    <div class="modal fade" id="conflictModal" tabindex="-1" aria-labelledby="conflictModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-danger">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title" id="conflictModalLabel"><i class="bi bi-exclamation-triangle me-2"></i>Conflito de datas</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
          </div>
          <div class="modal-body">
            <?= $this->session->flashdata('conflict') ?>
          </div>
          <div class="modal-footer">
            <a href="<?= site_url('job_history/index/' . $person->id) ?>" class="btn btn-outline-danger">
              Ver histórico de cargos
            </a>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    window.addEventListener('load', () => {
      <?php if ($this->session->flashdata('success')): ?>
        new bootstrap.Modal(document.getElementById('successModal')).show();
      <?php endif; ?>

      <?php if ($this->session->flashdata('conflict')): ?>
        new bootstrap.Modal(document.getElementById('conflictModal')).show();
      <?php endif; ?>
    });
  </script>
</body>

</html>