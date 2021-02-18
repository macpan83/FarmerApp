<?php 
  if($this->session->userdata('type') == 1){
    $role = 'Admin';
  }
  else if($this->session->userdata('type') == 2){
    $role = 'Farmer';
  }
  else if($this->session->userdata('type') == 3){
    $role = 'Customer';
  }
  else{
    $role = 'Coordinator';
  }

?>

<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
    <div class="container-fluid">
        <div class="navbar-wrapper">
        <a class="navbar-brand" href="javascript:;"><?=$role.' | '.ucfirst(basename($_SERVER['PHP_SELF']))?></a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
        <span class="sr-only">Toggle navigation</span>
        <span class="navbar-toggler-icon icon-bar"></span>
        <span class="navbar-toggler-icon icon-bar"></span>
        <span class="navbar-toggler-icon icon-bar"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end">
        <ul class="navbar-nav">
            <li class="nav-item">
            <a class="nav-link" href="<?= site_url('logout') ?>">
                <i class="material-icons">settings_power</i> Logout
            </a>
            </li>
            <!-- your navbar here -->
        </ul>
        </div>
    </div>
</nav>