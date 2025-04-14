<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Vincular Cargo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="<?= base_url('assets/css/pages/job-position/assign.css') ?>">
</head>

<body>
  <div class="container mt-5">
    <div class="card shadow-sm">
      <div class="card-body">
        <h4 class="mb-4">
          <i class="bi bi-link-45deg me-2"></i>Vincular Cargo: <?= htmlspecialchars($job_position->name) ?>
        </h4>

        <form method="post" action="<?= site_url('job_position/assign_store') ?>">
          <input type="hidden" name="job_position_id" value="<?= $job_position->id ?>">

          <div class="mb-3">
            <label for="person_id" class="form-label">Funcionário</label>
            <select name="person_id" id="person_id" class="form-select" required></select>
          </div>

          <div class="mb-3">
            <label for="start_date" class="form-label">Data de Início</label>
            <input type="date" name="start_date" id="start_date" class="form-control" required>
          </div>

          <div class="d-flex justify-content-between">
            <a href="<?= site_url('job_position') ?>" class="btn btn-outline-secondary">
              <i class="bi bi-arrow-left"></i> Voltar
            </a>
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-save"></i> Salvar
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

  <?php if (isset($conflict)): ?>
    <div class="modal fade" id="conflictModal" tabindex="-1" aria-labelledby="conflictModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-danger">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title" id="conflictModalLabel">
              <i class="bi bi-exclamation-triangle me-2"></i>Conflito de datas
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
          </div>
          <div class="modal-body">
            <?= $conflict ?>
          </div>
          <div class="modal-footer">
            <a href="<?= site_url('person') ?>" class="btn btn-outline-danger">
              Ir para funcionários
            </a>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#person_id').select2({
        placeholder: "Digite o nome do funcionário",
        minimumInputLength: 2,
        ajax: {
          url: '<?= site_url('person/search_ajax') ?>',
          dataType: 'json',
          delay: 250,
          data: function(params) {
            return {
              term: params.term
            };
          },
          processResults: function(data) {
            return {
              results: data
            };
          },
          cache: true
        }
      });

      <?php if (isset($success)): ?>
        new bootstrap.Modal(document.getElementById('successModal')).show();
      <?php endif; ?>

      <?php if (isset($conflict)): ?>
        new bootstrap.Modal(document.getElementById('conflictModal')).show();
      <?php endif; ?>
    });
  </script>
</body>

</html>