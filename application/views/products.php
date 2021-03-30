<!doctype html>
<html lang="en">

<head>
  <title>Admin | Productos</title>
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
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" />
  <link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>

  <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
  <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js'></script>
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
          <b class="breadcrumb" style=" font-size:30px">Productos</b>
 <?php if($status){?>
              <div class="alert alert-success"><?php echo $message ?></div>
      <?php }else{ ?>
              <div class="alert alert-danger"><?php echo $message ?></div>
      <?php } ?>
        <!-- Button trigger modal -->
       <!--  <a href="#" class="btn btn-primary porductbtn mb-3" data-toggle="modal" data-target="#productModal">Agregar producto</a> -->

        <div class="container-fluid">
          <!-- your content here -->

          <table id="example" class="display table2" style="width:100%">
            <thead>
              <tr>
                <th class="th_1">SlNo</th>
                <td style="display: none;"></td>
                <td style="display: none;"></td>
                <th class="th_1">Categoría</th>
                <th class="th_1" width="8%">Imagen</th>
                <th width="8%" class="th_1">Nombre</th>
                <th width="14%" class="th_1">Descripción</th>
                <th width="7%" class="th_1">Costo</th>
                <th width="7%" class="th_1">Precio de venta</th>
                <th class="th_1">Unidad</th>
                <th width="7%" class="th_1">Cantidad restante</th>
                <th >correo electrónico del agricultor</th>
                <th class="th_1">Estado</th>
                <?php if ($this->session->userdata('type') == 1) { ?>
                  <th class="th_1">Editar</th>
                  <th class="th_1">Borrar</th>
                <?php } ?>
                <td style="display: none;"></td>
              </tr>
            </thead>
            <tbody>

              <?php foreach ($data['data'] as $key => $value) { ?>
                <tr>
                  <td><?= $key + 1 ?></td>
                  <td style="display: none;"><?= $value['pid'] ?></td>
                  <td style="display: none;"><?= $value['cid'] ?></td>
                  <td><a href="<?= site_url('catagories') ?>" style="text-decoration: none;"><?= $value['category'] ?></a></td>
                  <td>
                    <img class="productimg" src="<?= $value['image'] ?>" alt="" width="50px" height="50px" />
                  </td>
                  <td><?= $value['name'] ?></td>
                  <td><?= $value['description'] ?></td>
                  <td>$ <?= $value['cost_price'] ?></td>
                  <td>$ <?= $value['sell_price'] ?></td>
                  <td><?= $value['unit'] ?></td>
                  <td><?= $value['total_qty'] ?></td>
                  <td><?= $value['email'] ?></td>
                  <td><?= $value['approve'] == 0 ? "Rechazado" : "Aprovado" ?></td>
                  <?php if ($this->session->userdata('type') == 1) { ?>
                    <td>
                      <a href="<?= site_url() . $value['pid'] ?>" class="btn btn-sm editbtn" data-toggle="modal" data-target="#updProductModal">
                        <i class="fas fa-edit"></i>
                      </a>
                    </td>
                    <td>
                      <a href="#" class="btn btn-sm delbtn" data-toggle="modal" data-target="#delProductModal">
                        <i class="fas fa-trash-alt"></i>
                      </a>
                    </td>
                  <?php } ?>
                  <td style="display: none;"><?= $value['created_by'] ?></td>
                </tr>

              <?php } ?>

            </tbody>
            <tfoot>
              <tr>
                <th class="th_1">SlNo</th>
                <td style="display: none;"></td>
                <td style="display: none;"></td>
                <th class="th_1">Category</th>
                <!--  <th class="th_1" style="display:none">farmerId</th> -->
                <th width="5" class="th_1">Image</th>
                <th class="th_1">Name</th>
                <th class="th_1">Description</th>
                <th class="th_1">Cost Price</th>
                <th class="th_1">Sell Price</th>
                <th class="th_1">Unit</th>
                <th class="th_1">Remaining Qty</th>
                <th >Farmer Email</th>
                <th class="th_1">Status</th>
                <?php if ($this->session->userdata('type') == 1) { ?>
                  <th class="th_1">Edit</th>
                  <th class="th_1">Delete</th>
                <?php } ?>
                <td style="display: none;"></td>
                <!-- <th class="th_1">Created At</th> -->
                <!-- <th class="th_1">Created By</th> -->
              </tr>
            </tfoot>
          </table>
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
        echo form_open_multipart('products/addProducts', $attributes);
        ?>
        <div class="modal-header">
          <h5 class="lead font-weight-bold">Detalles de producto</h5>
        </div>

        <!-- Body started -->
        <div class="modal-body">

          <input type="hidden" id="created_by" name="created_by" class="form-control" value="<?= $this->session->userdata('id') ?>" />
          <div class="row">
            <div class="col-md-5">
              <div class="form-group">
                <label for="name">Nombre del producto</label>
                <input type="text" id="name" name="name" class="form-control">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="cost_price">Costo</label>
                <input type="text" id="cost_price" name="cost_price" class="form-control">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="sell_price">Precio de venta</label>
                <input type="text" id="sell_price" name="sell_price" class="form-control">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="total_qty">Cantidad total</label>
                <input type="text" id="total_qty" name="total_qty" class="form-control">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="description">Descripción</label>
                <textarea id="description" name="description" class="form-control"></textarea>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="cid">Categoría</label>
                <select id="cid" name="cid" class="form-control">
                  <?php $cats = ['none', 'Frutas', 'Vegetables', 'Lácteos', 'Farináceos', 'Provisiones'];
                  foreach ($cats as $key => $val) { ?>
                    <option value="<?= $key ?>"><?= $val ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="unit">Unidad</label>
                <select id="unit" name="unit" class="form-control">
                  <?php $units = ['none', 'Pcs', 'Lbs', 'Cases'];
                  foreach ($units as $key) { ?>
                    <option value="<?= $key ?>"><?= $key ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="">
                <input type="file" class="form form-control" name="image" />
              </div>
            </div>
          </div>

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
        echo form_open('products/updProducts', $attributes);
        ?>
        <div class="modal-header">
          <h5>Update Product Details</h5>
        </div>

        <!-- Body started -->
        <div class="modal-body">

          <!--<input type="hidden" id="updated_by" name="created_by" class="form-control" value="<?//=$this->session->userdata('id')?>" />-->
          <input type="hidden" id="upd_pid" name="pid" class="form-control" value="" />
          <input type="hidden" id=farm_id name="created_by" class="form-control" value="" />
          <input type="hidden" id="upd_pid" name="updated_at" class="form-control" value="<?= date('Y-m-d H:i:s') ?>" />
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label for="name">Nombre del producto</label>
                <input type="text" id="upd_name" name="name" class="form-control">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="cost_price">Precio de coste</label>
                <input type="text" id="upd_cost_price" name="cost_price" class="form-control">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="sell_price">Precio de venta</label>
                <input type="text" id="upd_sell_price" name="sell_price" class="form-control">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label for="description">Descripción</label>
                <textarea id="upd_description" name="description" class="form-control"></textarea>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="cid">Categoría</label>
                <select id="upd_cid" name="cid" class="form-control">
                  <?php $cats = ['none', 'Frutas', 'Vegetables', 'Lácteos', 'Farináceos', 'Provisiones'];
                  foreach ($cats as $key => $val) { ?>
                    <option value="<?= $key ?>"><?= $val ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="unit">Unidad</label>
                <select id="upd_unit" name="unit" class="form-control">
                  <?php $units = ['none', 'Pcs', 'Lbs', 'Cases'];
                  foreach ($units as $key) { ?>
                    <option value="<?= $key ?>"><?= $key ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="total_qty">Cantidad total</label>
                <input type="text" id="upd_total_qty" name="total_qty" class="form-control">
              </div>
            </div>

            <div class="col-md-2">
              <div class="form-group">
                <label for="approve">Estado</label>
                <select id="upd_unit" name="approve" class="form-control">
                  <option value="none">None</option>
                  <?php $appr = [0, 1];
                  foreach ($appr as $key) { ?>
                    <option value="<?= $key ?>"><?= $key == 0 ? "Reject" : "Approve" ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>

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
  <div class="modal fade" id="delProductModal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <!-- <form method="post" action="<?= site_url('products/addProducts'); ?>"> -->
        <?php
        $attributes = array(
          'class' => 'form',
          'id' => 'login_form',
          'name' => 'login_form',
          'enctype' => 'multipart/form-data',
        );
        echo form_open('products/delProducts', $attributes);
        ?>
        <div class="modal-header">
          <h5>Detalles de producto</h5>
        </div>

        <!-- Body started -->
        <div class="modal-body">
          <h4>¿Quieres eliminar este producto?</h4>
        </div>
        <!-- Body ended -->

        <div class="modal-footer">
          <input type="hidden" id="del_pid" name="pid" />
          <button type="submit" class="btn btn-sm btn-danger">Borrar</button>
          <a href="#" class="btn btn-sm btn-primary" data-dismiss="modal">Cerrar</a>
        </div>

        <?php echo
        form_close();
        ?>
      </div>
    </div>
  </div>

</body>

<script type="text/javascript">
$(function() {
  $(".alert").hide(6000);
});
  
  $(document).ready(function() {
    $('#example').DataTable({
      "pagingType": "full_numbers",
    });
  });


 // $(document).ready(function() {
    $('.editbtn').on('click', function() {

      $('#updProductModal').modal('show');

      $tr = $(this).closest('tr');

      var data = $tr.children('td').map(function() {
        return $(this).text();
      }).get();

      console.log(data);
      $('#farm_id').val(data[15]);
      $('#updated_by').val(data[0]);
      $('#upd_pid').val(data[1]);
      $('#fid').val(data[1]);
      $('#upd_name').val(data[5]);
      $('#upd_cost_price').val(data[7]);
      $('#upd_sell_price').val(data[8]);
      $('#upd_description').val(data[6]);
      $('#upd_cid').val(data[2]);
      $('#upd_unit').val(data[9]);
      $('#upd_total_qty').val(data[10]);

    });
//  });


//   $(document).ready(function() {
    $('.delbtn').on('click', function() {
      $('#delProductModal').modal('show');
      $tr = $(this).closest('tr');
      var data = $tr.children('td').map(function() {
        return $(this).text();
      }).get();
      console.log(data);
      $('#del_pid').val(data[1]);

    });
//   });
</script>

</html>