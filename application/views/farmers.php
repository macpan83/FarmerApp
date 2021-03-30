<!doctype html>
<html lang="en">

<head>
  <title>Admin | Farmers</title>
   <link rel="icon" href="<?=base_url()?>uploads/favicon.png" type="image/gif">
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
    <?php require_once('common/nav.php') ?>
    <!-- Sidebar ended -->

    <div class="main-panel">
      <!-- Navbar -->
      <?php require_once('common/navbar.php'); ?>
      <!-- End Navbar -->
      <div class="content">
        <!-- Button trigger modal -->
        <!-- <button type="button" class="btn btn-primary mb-4" data-toggle="modal" data-target="#basicExampleModal">
          Add stocks
        </button> -->

        <div class="container-fluid">
          <!-- your content here -->

          <table id="example" class="display farmer-table" style="width:100%">
            <thead>
              <tr>
                <th width="5%">SlNo</th>
                <th width="8%">Fotografía</th>
                <th>Nombre</th>
                <th width="5%">Edad</th>
                <th width="6%">Género</th>
                <th>Correo electrónico</th>
                <th>teléfono</th>
                <th width="10%">Dirección</th>
                <th width="10%">Compañía</th>
                <th width="15%">Estado de agricultor</th>
                <th>Acción</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $rr = json_encode($data['data']);
              $d = json_decode($rr, true);
              ?>

              <?php foreach ($d as $key => $value) {
                $acturl = 'activatefarmer/' . $value["uid"];
                $deacturl = 'deactivatefarmer/' . $value["uid"];
              ?>
                <tr>
                  <td><?= $key + 1 ?></td>
                  <td>
                     <?php if($value['profile_img'] != null){?>
                        <img src="<?= base_url('uploads/') . $value['profile_img'] ?>" alt="" width="50px" height="50px" />
                  <?php   }else{?>
                    <img src="<?= base_url('uploads/user.png') ?>" alt="" width="50px" height="50px" />
                    <?}?>
                  </td>
                  <td><?= $value['name'] ?></td>
                  <td><?= $value['age'] ?></td>
                  <td><?= $value['gender'] ?></td>
                  <td><?= $value['email'] ?></td>
                  <td><?= $value['phone'] ?></td>
                  <td><?= $value['address'] . ', ' . $value['town'] . '<br/>' . $value['town'] ?></td>
                  <td><?= $value['cname'] ?></td>
                  <td><?= $value['status'] == 0 ? "Rejected" : "Approved" ?></td>
                  <?php if ($value['status'] == 0) { ?>
                    <td><a href="<?= site_url() . $acturl ?>" class="btn  actbtn ">Activar</a></td>
                  <?php } else { ?>
                    <td><a href="<?= site_url() . $deacturl ?>" class="btn dctbtn ">Desactivar</a></td>
                  <?php } ?>
                </tr>

              <?php } ?>

            </tbody>
            <tfoot>
              <tr>
                <th>SlNo</th>
                <th>Picture</th>
                <th>Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Company</th>
                <th>Farmer Status</th>
                <th>Action</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>

      <?php require_once('common/footer.php') ?>

    </div>
  </div>
</body>

<script type="text/javascript">
  $(document).ready(function() {
    $('#example').DataTable({
      "pagingType": "full_numbers"
    });
  });
</script>

</html>