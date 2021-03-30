<!doctype html>
<html lang="en">

<head>
  <title>Admin | Change Password</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- Material Kit CSS -->
  <link href="<?= base_url('assets/css/material-dashboard.css?v=2.1.2') ?>" rel="stylesheet" />

  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" />
  <link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'>
  <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js'></script>

</head>

<body>
  <div class="wrapper ">

    <!-- Sidebar started -->
    <?php require_once('common/nav.php'); ?>
    <!-- Sidebar ended -->

    <div class="main-panel">
      <!-- Navbar -->
      <?php require_once('common/navbar.php'); ?>
      <!-- End Navbar -->

      <div class="content">
        <!-- Button trigger modal -->
        <!-- <button type="button" class="btn btn-primary mb-4" data-toggle="modal" data-target="#basicExampleModal">
          Add class
        </button> -->
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <b class="text-left" style="font-size: 30px">Cambiar la contraseña</b>
            </div>
            <div class="col-md-6 offset-md-3">
              <br />
              <br />
              <?php
              $attributes = array(
                'class' => 'form',
                'id' => 'change_password_form',
                'name' => 'change_password_form',
                'enctype' => 'multipart/form-data',
              );
              echo validation_errors();
              echo form_open('users/change_password', $attributes);
              ?>
              <!--<form method="post" name="" action="">-->

              <input type="hidden" name="email" value="<?= $this->session->userdata('email') ?>" />

              <div class="form-group">
                <label class="lead text-dark">Correo electrónico de la cuenta</label>
                <input type="email" name="email" class="form-control" value="" placeholder="Email of the account" />
              </div>
              <div class="form-group">
                <label class="lead text-dark">Nueva contraseña</label>
                <input type="text" name="new_pass" class="form-control" value="" placeholder="New password" />
              </div>
              <div class="form-group">
                <label class="lead text-dark">Confirmar nueva contraseñad</label>
                <input type="text" name="con_new_pass" class="form-control" value="" placeholder="Confirm New password" />
              </div>
              <div class="form-group" align="right">
                <input type="submit" name="sbmt" class="btn btn-outline-success" value="Cambiar la contraseña" />
                <input type="reset" class="btn btn-outline-danger" value="Clear" />
              </div>
              </form>
              <div class="col-md-12 alert-mute p-2">
                <?= $this->session->flashdata('message') ?>
              </div>
              <br /><br />
            </div>
          </div>
        </div>
      </div>

      <?php require_once('common/footer.php') ?>

    </div>
  </div>
</body>

</html>