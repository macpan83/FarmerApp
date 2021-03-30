<!doctype html>
<html lang="en">

<head>
  <title>Admin | Store Addresses</title>
   <link rel="icon" href="<?=base_url()?>uploads/favicon.png" type="image/gif">
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <!-- Material Kit CSS -->
  <link href="<?= base_url('assets/css/material-dashboard.css?v=2.1.2') ?>" rel="stylesheet" />

  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" />
  <link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'>
  <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js'></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

  <style type="text/css">
    .th_1 {
      font-size: 12px;
    }
  </style>
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
        <div class="row">
          <div class="col-md-12">
            <a href="#" class="btn btn-primary addstorebtn mb-3" data-toggle="modal" data-target="#productModal">Agregar dirección de tienda</a>
            <div class="container-fluid">
              <!-- your content here -->
              <table id="example" class="display" style="width:100%">
                <thead>
                  <tr>
                    <th class="th_1">SlNo</th>
                    <th class="th_1">Dirección de la tienda</th>
                    <th class="th_1">Tipo de tienda</th>
                    <th class="th_1">Acción</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($data['data'] as  $value) { ?>
                    <tr>
                      <td><?= $value['add_id'] ?></td>
                      <td><?= $value['store_addresses'] ?></td>
                      <td><?= $value['address_type'] ?></td>
                      <td>
                        <a href="#" class="btn btn-sm btn-info editbtn" data-toggle="modal" data-target="#updProductModal">
                          <i class="fas fa-edit"></i>
                        </a>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th class="th_1">SlNo</th>
                    <th class="th_1">Store Address</th>
                    <th class="th_1">Home Delivery Timings</th>
                    <th class="th_1">Action</th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>

        </div>
      </div>
      <?php require_once('common/footer.php') ?>
    </div>
  </div>

  <!-- ADD PRODUCT Modal -->
  <div class="modal fade" id="productModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <!-- <form method="post" action="<?= site_url('products/addProducts'); ?>"> -->
        <?php
        $attributes = array(
          'class' => 'form',
          'id' => 'login_form',
          'name' => 'login_form',
          'enctype' => 'multipart/form-data',
        );
        echo form_open_multipart('store_address/add_store_address', $attributes);
        ?>
        <div class="modal-header">
          <h5 class="lead font-weight-bold">Dirección de la tienda y tiempo de entrega a domicilio</h5>
        </div>

        <!-- Body started -->
        <div class="modal-body">

          <input type="hidden" id="created_by" name="created_by" class="form-control" value="<?= $this->session->userdata('id') ?>" />
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label for="name">Dirección de la tienda</label>
                <input type="text" id="add_store_address" name="add_store_address" class="form-control" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="name">Tipo de tienda</label>
                <select id="add_store_type" name="add_store_type" class="form-control">
                  <?php $cats = ['Oficina', 'Caribbean'];
                  foreach ($cats as $val) { ?>
                    <option value="<?= $val ?>"><?= $val ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
          <!--  <div class="col-md-2">
                <div class="form-group">
                  <label for="cid">Start time</label>
                  <select id="start-hr" name="start-hr" class="form-control">
                  <?php $sthr = ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
                  foreach ($sthr as $val) { ?>
                    <option value="<?= $val ?>"><?= $val ?></option>
                  <?php } ?>
                  </select>
                  <select id="start-am-pm" name="start-am-pm" class="form-control">
                  <?php $stampm = ['am', 'pm'];
                  foreach ($stampm as  $val) { ?>
                    <option value="<?= $val ?>"><?= $val ?></option>
                  <?php } ?>
                  </select>
                </div>
              </div> 
              <div class="col-md-2">
                <div class="form-group">
                  <label for="cid">End time</label>
                  <select id="end-hr" name="end-hr" class="form-control">
                  <?php $endhr = ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
                  foreach ($endhr as $key => $val) { ?>
                    <option value="<?= $val ?>"><?= $val ?></option>
                  <?php } ?>
                  </select>
                  <select id="end-am-pm" name="end-am-pm" class="form-control">
                  <?php $endampm = ['am', 'pm'];
                  foreach ($endampm as $key => $val) { ?>
                    <option value="<?= $val ?>"><?= $val ?></option>
                  <?php } ?>
                  </select>
                </div>
              </div> -->
        </div>


        <!-- Body ended -->

        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-success">Salvar</button>
          <!--<button type="reset" class="btn btn-sm btn-success">Clara</button>-->
          <a href="#" class="btn btn-sm btn-danger" data-dismiss="modal">Cerrar</a>
        </div>

        <?php echo
        form_close();
        ?>
      </div>
    </div>
  </div>
  </div>
  <!-- EDIT/UPDATE PRODUCT Modal -->
  <div class="modal fade" id="updProductModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <!-- <form method="post" action="<?= site_url('products/addProducts'); ?>"> -->
        <?php
        $attributes = array(
          'class' => 'form',
          'id' => 'login_form',
          'name' => 'login_form',
          'enctype' => 'multipart/form-data',
        );
        echo form_open('store_address/update_store_address', $attributes);
        ?>
        <div class="modal-header">
          <h5>Actualizar detalles de la dirección</h5>
        </div>

        <!-- Body started -->
        <div class="modal-body">
          <!--<input type="hidden" id="updated_by" name="created_by" class="form-control" value="<?//=$this->session->userdata('id')?>" />-->
          <input type="hidden" id="add_id" name="add_id" class="form-control" value="" />
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label for="name">Dirección de la tienda</label>
                <input type="text" id="up_store_address" name="up_store_address" class="form-control" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="name">Tipo de tienda</label>
                <select id="up_store_type" name="up_store_type" class="form-control">
                  <?php $cats = ['Oficina', 'Caribbean'];
                  foreach ($cats as $val) { ?>
                    <option value="<?= $val ?>"><?= $val ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
          <!-- <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="cid">Start time</label>
                  <select id="start-hr" name="start-hr" class="form-control">
                  <?php $sthr = ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
                  foreach ($sthr as $val) { ?>
                    <option value="<?= $val ?>"><?= $val ?></option>
                  <?php } ?>
                  </select>
                  <select id="start-am-pm" name="start-am-pm" class="form-control">
                  <?php $stampm = ['am', 'pm'];
                  foreach ($stampm as  $val) { ?>
                    <option value="<?= $val ?>"><?= $val ?></option>
                  <?php } ?>
                  </select>
                </div>
              </div> 
              <div class="col-md-2">
                <div class="form-group">
                  <label for="cid">End time</label>
                  <select id="end-hr" name="end-hr" class="form-control">
                  <?php $endhr = ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
                  foreach ($endhr as $key => $val) { ?>
                    <option value="<?= $val ?>"><?= $val ?></option>
                  <?php } ?>
                  </select>
                  <select id="end-am-pm" name="end-am-pm" class="form-control">
                  <?php $endampm = ['am', 'pm'];
                  foreach ($endampm as $key => $val) { ?>
                    <option value="<?= $val ?>"><?= $val ?></option>
                  <?php } ?>
                  </select>
                </div>
              </div> -->
        </div>
        <!-- Body ended -->

        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-success">Actualizar</button>
          <!--<button type="reset" class="btn btn-sm btn-success">Clara</button>-->
          <a href="#" class="btn btn-sm btn-danger" data-dismiss="modal">Cerrar</a>
        </div>

        <?php echo
        form_close();
        ?>
      </div>
    </div>
  </div>

  <!-- DELETE PRODUCT Modal -->


</body>

<script type="text/javascript">
  $(document).ready(function() {
    $('#example').DataTable({
      "pagingType": "full_numbers"
    });

    $('#deliveryDate').DataTable({
      "pagingType": "full_numbers"
    });

  });




  $(document).ready(function() {
    $('.editbtn').on('click', function() {

      $('#updProductModal').modal('show');

      $tr = $(this).closest('tr');

      var data = $tr.children('td').map(function() {
        return $(this).text();
      }).get();

      console.log(data);
      $('#add_id').val(data[0]);
      $('#up_store_address').val(data[1]);
      // $('#upd_pid').val(data[1]);
      //  $('#fid').val(data[1]);
      // $('#upd_name').val(data[5]);
      // $('#upd_cost_price').val(data[7]);
      // $('#upd_sell_price').val(data[8]);
      // $('#upd_description').val(data[6]);
      // $('#upd_cid').val(data[2]);
      // $('#upd_unit').val(data[9]);
      // $('#upd_total_qty').val(data[10]);

    });
  });


  $(document).ready(function() {
    $('.delbtn').on('click', function() {
      $('#delProductModal').modal('show');
      $tr = $(this).closest('tr');
      var data = $tr.children('td').map(function() {
        return $(this).text();
      }).get();

      console.log(data);

      // $('#updated_by').val(data[0]);
      $('#del_pid').val(data[1]);
      // $('#upd_name').val(data[5]);
      // $('#upd_cost_price').val(data[7]);
      // $('#upd_sell_price').val(data[8]);
      // $('#upd_description').val(data[6]);
      // $('#upd_cid').val(data[2]);
      // $('#upd_unit').val(data[9]);
      // $('#upd_total_qty').val(data[10]);

    });
  });
</script>

</html>