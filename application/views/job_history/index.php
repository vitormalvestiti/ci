<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Histórico de Cargos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= base_url('assets/css/pages/job-history/index.css') ?>" rel="stylesheet">
</head>

<body>

  <div class="container mt-5">
    <div class="card shadow-sm">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h3 class="mb-0">Histórico de Cargos — <?= htmlspecialchars($person->name) ?></h3>
          <a href="<?= site_url('person/edit/' . $person->id) ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Voltar para Funcionário
          </a>
        </div>

        <div class="table-responsive">
          <table class="table table-hover table-bordered align-middle">
            <thead class="table-primary text-center">
              <tr>
                <th>Cargo</th>
                <th>Data de Início</th>
                <th>Data Final</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($job_history as $history): ?>
                <tr>
                  <td><?= htmlspecialchars($history->job_position_name) ?></td>
                  <td><?= date('d/m/Y', strtotime($history->start_date)) ?></td>
                  <td><?= $history->end_date ? date('d/m/Y', strtotime($history->end_date)) : 'Atual' ?></td>
                  <td class="text-center">
                    <a href="<?= site_url('job_history/edit/' . $history->id) ?>" class="btn btn-sm btn-outline-warning me-1">
                      <i class="bi bi-pencil-square"></i>
                    </a>
                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-id="<?= $history->id ?>">
                      <i class="bi bi-trash3-fill"></i>
                    </button>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <?php if (isset($pagination)): ?>
          <div class="mt-3">
            <?= $pagination ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-4">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title" id="confirmDeleteLabel"><i class="bi bi-exclamation-triangle-fill me-2"></i>Confirmação de Exclusão</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body text-center">
          Tem certeza que deseja apagar este histórico? Essa ação não poderá ser desfeita.
        </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <a id="confirmDeleteBtn" href="#" class="btn btn-danger">Sim, excluir</a>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const confirmModal = document.getElementById('confirmDeleteModal');
    const confirmBtn = document.getElementById('confirmDeleteBtn');

    confirmModal.addEventListener('show.bs.modal', function(event) {
      const button = event.relatedTarget;
      const id = button.getAttribute('data-id');
      confirmBtn.href = `<?= site_url('job_history/delete/') ?>${id}`;
    });
  </script>

</body>

</html>