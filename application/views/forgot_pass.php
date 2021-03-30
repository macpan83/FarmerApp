<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
   <link rel="icon" href="<?=base_url()?>uploads/favicon.png" type="image/gif">
  <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url(); ?>assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="<?= base_url(); ?>assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>
    Forgot Password
  </title>
  <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <!-- <link href="<?= base_url(); ?>assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" /> -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <!-- <link href="<?= base_url(); ?>assets/demo/demo.css" rel="stylesheet" /> -->
  <style type="text/css">
    body {
      background: url("<?= base_url('assets/img/bg3.jpg'); ?>") no-repeat center center fixed;
      background-size: cover;
      width: 100%;
    }

    div#reg_form {
      margin-top: 200px;
      border-radius: 5px;
      color: white;
      /* opacity: 0.1; */
    }

    div#reg_form_child {
      /* opacity: 0.8; */
    }

    /* #upass upass:hover, upass:focus, upass:active{
      background: transparent;
      border: 0;
      border-style: none;
      border-color: transparent;
      outline: none;
      outline-offset: 0;
      box-shadow: none;
    } */

    #warning-message {
      display: none;
    }

    @media only screen and (orientation:portrait) {
      #wrapper {
        display: none;
      }

      #warning-message {
        display: block;
        color: white;
      }

      body {
        background: url("<?= base_url('assets/img/bg3.jpg'); ?>") no-repeat center center fixed;
        background-size: cover;
        height: 100%;
      }

      div#reg_form {
        margin-top: 20%;
        border-radius: 5px;
      }
    }
  </style>
</head>

<body class="">
  <div class="container-fluid mb-5">
    <div class="row ml-3 mr-3 mb-5" id="reg_form">

      <div class="col-md-4 offset-md-4 rounded bg-dark" id="reg_form_child">
        <?php
        $attributes = array(
          'class' => 'form',
          'id' => 'login_form',
          'name' => 'login_form',
          'enctype' => 'multipart/form-data',
        );
        echo form_open('farmers/forgot_change_pass_web', $attributes);
        ?>

        <div class="row">
          <h1 class="card card-body bg-dark font-weight-bold">Se te olvidó tu contraseña</h1>
          <input type="hidden" name="utype" id="utype" value="2" />

          <!--<div class="col-md-12">-->
          <!--  <div class="form-group">-->
          <!--    <label class="bmd-label-floating">User Type</label>-->
          <!--    <select class="form-control border-bottom" name="utype" id="utype">-->
          <!--      <option value="1">Admin</option>-->
          <!--      <option value="2">Farmer</option>-->
          <!--      <option value="3">Customer</option>-->
          <!--      <option value="4">Coordinator</option>-->
          <!--    </select>-->
          <!--  </div>-->
          <!--</div>-->
        </div>


        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label class="bmd-label-floating">Correo electrónico</label>
              <input type="email" class="form-control" name="email" id="email" placeholder="username" />
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label class="bmd-label-floating">Código</label>
              <input type="text" class="form-control" name="code" id="code" placeholder="Code" />
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label class="bmd-label-floating">Contraseña</label>
              <input type="password" class="form-control" name="new_pass" id="upass" placeholder="New password" />
            </div>
          </div>
        </div>


        <div class="row">
          <div class="col-md-12">
            <button type="submit" name="sbmt" value="login" class="btn btn-primary pull-right mt-2 mb-2">Cambiar la contraseña</button>
          </div>
        </div>

        <?php
        if ($this->session->flashdata('status')) {
          if ($this->session->flashdata('flag') == 1) {
        ?>
            <div class="row">
              <div class="col-md-8 offset-md-2 alert alert-success">
                <strong>Success!</strong>
                <p><?= $this->session->flashdata('message') ?></p>
              </div>
            </div>
          <?php
          } else {
          ?>
            <div class="row">
              <div class="col-md-8 offset-md-2 alert alert-danger">
                <strong>Failed!</strong>
                <p><?= $this->session->flashdata('message') ?></p>
              </div>
            </div>
        <?php
          }
        }
        ?>


        <?php echo
        form_close();
        ?>
      </div>
    </div>
  </div>
</body>

</html>