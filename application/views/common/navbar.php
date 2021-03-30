<?php
if ($this->session->userdata('type') == 1) {
  $role = 'Admin';
} elseif ($this->session->userdata('type') == 4) {
  $role = 'Coordinator';
}
else{
  $role = 'Associate Coordinator';
}

?>

<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
  <div class="container-fluid">
    <div class="navbar-wrapper">
      <?php
      $urlPart = $this->uri->segment(1);
if($this->uri->segment(3) == 0){

}
else{

}
       ?>
        <a href="<?= site_url('dashboard') ?>" class="nav-back-button"><i class="material-icons">arrow_back</i> Tablero</a>
      <a class="navbar-brand" href="javascript:;"><?= $role . ' | ' . $urlPart ?></a>
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
      <span class="sr-only">Toggle navigation</span>
      <span class="navbar-toggler-icon icon-bar"></span>
      <span class="navbar-toggler-icon icon-bar"></span>
      <span class="navbar-toggler-icon icon-bar"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav">
        <?php if ($this->session->userdata('type') == 1) { ?>
          <li class="nav-item logout-btn">
            <a class="nav-link logout-btn" href="<?= site_url('add_cordinator') ?>">
              <i class="material-icons">account_circle</i> Agregar Coordinador
            </a>
          </li>
        <?php } ?>
        <li class="nav-item logout-btn">
          <a class="nav-link logout-btn" href="<?= site_url('logout') ?>">
            <i class="material-icons">settings_power</i> Salir
          </a>
        </li>
        <!-- your navbar here -->
      </ul>
    </div>
  </div>
</nav>