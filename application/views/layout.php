<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= isset($title) ? $title : 'Controle de funcionarios' ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
</head>
<body>

  <div class="sidebar">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link" href="<?= site_url('job_position') ?>">Cargos</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= site_url('person') ?>">Funcionarios</a>
      </li>
    </ul>
  </div>

  <div class="content">
    <?php $this->load->view($view, isset($view_data) ? $view_data : []); ?>
  </div>

</body>
</html>
