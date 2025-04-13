<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Lista de Funcionários</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('assets/css/pages/person/index.css') ?>">
</head>

<body>
  <div class="container mt-5">
    <div class="card shadow-sm">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h3 class="mb-0">Funcionários</h3>
          <a href="<?= site_url('person/create') ?>" class="btn btn-primary">
            <i class="bi bi-person-plus-fill"></i> Adicionar Funcionário
          </a>
        </div>

        <form method="get" class="mb-3">
          <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Pesquisar por nome..." value="<?= htmlspecialchars($search ?? '') ?>">
            <button class="btn btn-outline-secondary" type="submit">
              <i class="bi bi-search"></i>
            </button>
          </div>
        </form>

        <div class="table-responsive">
          <table class="table table-hover table-bordered align-middle">
            <thead class="table-primary text-center">
              <tr>
                <th>Nome</th>
                <th>Cargo Atual</th>
                <th>Data de Início</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($people as $person): ?>
                <tr>
                  <td><?= htmlspecialchars($person->name) ?></td>
                  <td><?= htmlspecialchars($person->job_position_name ?? '—') ?></td>
                  <td><?= $person->start_date ? date('d/m/Y', strtotime($person->start_date)) : '—' ?></td>
                  <td class="text-center">
                    <a href="<?= site_url('person/edit/' . $person->id) ?>" class="btn btn-sm btn-outline-warning me-1">
                      <i class="bi bi-pencil-square"></i>
                    </a>
                    <a href="<?= site_url('job_history/index/' . $person->id) ?>" class="btn btn-sm btn-outline-info me-1">
                      <i class="bi bi-clock-history"></i>
                    </a>
                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-id="<?= $person->id ?>">
                      <i class="bi bi-trash3-fill"></i>
                    </button>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <div class="mt-3">
          <?= $this->pagination->create_links(); ?>
        </div>
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
          Tem certeza que deseja excluir este funcionário? Essa ação não poderá ser desfeita.
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
      confirmBtn.href = `<?= site_url('person/delete/') ?>${id}`;
    });
  </script>
</body>

</html>