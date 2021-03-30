
<div class="sidebar" data-color="azure" data-background-color="white">

  <div class="logo bckgrnd">

    <a href="<?= site_url('dashboard') ?>" class="simple-text logo-mini">

      WELCOME

    </a>
    <a href="<?= site_url('dashboard') ?>" class="simple-text logo-normal">
      Fresh On the Go
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
         <?php if (($this->session->userdata('type') == 1) || ($this->session->userdata('type') == 4)) { ?>
      <li class="nav-item <?= basename($_SERVER['PHP_SELF']) == 'dashboard' ? 'active' : ''; ?>">
        <a class="nav-link" href="<?= site_url('dashboard') ?>">
          <i class="material-icons">dashboard</i>
          <p>Tablero</p>
        </a>
      </li>

      <li class="nav-item <?= basename($_SERVER['PHP_SELF']) == 'catagories' ? 'active' : ''; ?>">
        <a class="nav-link" href="<?= site_url('catagories') ?>">
          <i class="material-icons">category</i>
          <p>Categorías</p>
        </a>
      </li>

      <li class="nav-item <?= basename($_SERVER['PHP_SELF']) == 'products' ? 'active' : ''; ?>">
        <a class="nav-link" href="<?= site_url('products') ?>">
          <i class="material-icons">eco</i>
          <p>Productos</p>
        </a>
      </li>

      <li class="nav-item <?= basename($_SERVER['PHP_SELF']) == 'gallery' ? 'active' : ''; ?>">
        <a class="nav-link" href="<?= site_url('gallery') ?>">
          <i class="material-icons">add_photo_alternate</i>
          <p>Galería de productos</p>
        </a>
      </li>
<?php } ?>
      <!--<li class="nav-item <?= basename($_SERVER['PHP_SELF']) == 'stocks' ? 'active' : ''; ?>">-->
      <!--  <a class="nav-link" href="<?= site_url('stocks') ?>">-->
      <!--    <i class="material-icons">fact_check</i>-->
      <!--    <p>Stocks</p>-->
      <!--  </a>-->
      <!--</li>-->

      <li class="nav-item <?= basename($_SERVER['PHP_SELF']) == 'orders' ? 'active' : ''; ?>">
        <a class="nav-link" href="<?= site_url('orders') ?>">
          <i class="material-icons">shopping_cart</i>
          <p>Pedidos</p>
        </a>
      </li>
 <?php if ($this->session->userdata('type') == 1) { ?>
      <li class="nav-item <?= basename($_SERVER['PHP_SELF']) == 'users' ? 'active' : ''; ?>">
        <a class="nav-link" href="<?= site_url('users') ?>">
          <i class="material-icons">group</i>
          <p>Clientes</p>
        </a>
      </li>
<?php } ?>
<?php if (($this->session->userdata('type') == 1) || ($this->session->userdata('type') == 4)) { ?>
      <li class="nav-item <?= basename($_SERVER['PHP_SELF']) == 'farmers' ? 'active' : ''; ?>">
        <a class="nav-link" href="<?= site_url('farmers') ?>">
          <i class="material-icons">agriculture</i>
          <p>Agricultores</p>
        </a>
      </li>
   

      <li class="nav-item <?= basename($_SERVER['PHP_SELF']) == 'store_add' ? 'active' : ''; ?>">
        <a class="nav-link" href="<?= site_url('store_add') ?>">
          <i class="material-icons">location_on</i>
          <p>Direcciones de tiendas</p>
        </a>
      </li>
       <?php } ?>
      <!--  <li class="nav-item <?= basename($_SERVER['PHP_SELF']) == 'newfarmers' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= site_url('newfarmers') ?>">
              <i class="material-icons">receipt</i>
              <p>Disable Farmers</p>
            </a>
          </li> -->
          <?php if ($this->session->userdata('type') == 1) { ?>
      <li class="nav-item <?= basename($_SERVER['PHP_SELF']) == 'change_pass' ? 'active' : ''; ?>">
        <a class="nav-link" href="<?= site_url('change_pass') ?>">
          <i class="material-icons">fingerprint</i>
          <p>Cambiar la contraseña</p>
        </a>
      </li>
    <?php } ?>
      <!-- your sidebar here -->
    </ul>
  </div>
</div>
<!-- ALOK HERE -->