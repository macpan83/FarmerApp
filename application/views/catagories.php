<!doctype html>
<html lang="en">

<head>
  <title>Admin | Categor&#205;as</title>
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

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" />
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
  <link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'>
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
          <b class="breadcrumb" style=" font-size:30px">Categorías de Producto</b>
        <?php if($status){?>
              <div class="alert alert-success"><?php echo $message ?></div>
      <?php }else{ ?>
              <div class="alert alert-danger"><?php echo $message ?></div>
      <?php } ?>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary mb-4" data-toggle="modal" data-target="#productModal">
          Agregar categorías
        </button>
        <div class="container-fluid">
          <!-- your content here -->

          <table id="example" class="display" style="width:100%">
            <thead>
              <tr>
                <th style="width:100px">Categoria ID</th>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Creado en</th>
                <th>Acción</th>
              </tr>
            </thead>
            <tbody>

              <?php foreach ($data['data'] as $key => $value) { ?>
                <tr>
                  <td><?= $value['cid'] ?></td>
                  <td>
                    <img class="productimg" src="<?= $value['c_img'] ?>" alt="" width="50px" height="50px" />
                  </td>
                  <td><?= $value['name'] ?></td>
                  <td><?= $value['description'] ?></td>
                  <td><?= date('d-M-Y', strtotime($value['created_at'])) ?></td>
                  <td style="text-align:center">
                    <a href="<?= site_url() . $value['cid'] ?>" class="btn btn-sm editbtn" title="Edit category" data-toggle="modal" data-target="#updProductModal"><i class=" fa fa-pencil-square-o"></i></a>
                    <a href="<?= site_url() . 'po/invoice.php?id=' . $value['cid'] ?>" target="_blank" title="Delete Item" class="btn btn-sm delbtn" data-toggle="modal" data-target="#delProductModal"><i class="fa fa-trash"></i></a>
                  </td>
                </tr>

              <?php } ?>

            </tbody>
            <tfoot>
              <tr>
                <th>Category Id</th>
                <th>Image</th>
                <th>Name</th>
                <th>Description</th>
                <th>Created At</th>
                <th>Action</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>

      <?php require_once('common/footer.php') ?>

    </div>
  </div>
  <div class="modal fade" id="productModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <!-- <form method="post" action="<?= site_url('products/addProducts'); ?>"> -->
        <?php
        $attributes = array(
          'class' => 'form',
          'id' => 'add_cat_form',
          'name' => 'login_form',
          'enctype' => 'multipart/form-data',
        );
        echo form_open_multipart('category/add_category', $attributes);
        ?>
        <div class="modal-header">
          <h5 class="lead font-weight-bold">Añadir nueva categoria</h5>
        </div>
        <!-- Body started -->
        <div class="modal-body">
          <div class="row">
            <div class="col-md-5">
              <div class="form-group">
                <label for="name">Nombre de la categoría</label>
                <input type="text" id="name" name="name" class="form-control" required>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="description">Descripción</label>
                <textarea id="description" name="description" class="form-control" required></textarea>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="">
                <input type="file" class="form form-control" name="cat_img" required/>
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
          'id' => 'upd_cat_form',
          'name' => 'login_form',
          'enctype' => 'multipart/form-data',
        );
        echo form_open('category/update_category', $attributes);
        ?>
        <div class="modal-header">
          <h5 class="lead font-weight-bold">Actualizar los detalles de la categoría</h5>
        </div>

        <!-- Body started -->
        <div class="modal-body">
          <!--<input type="hidden" id="updated_by" name="created_by" class="form-control" value="<?//=$this->session->userdata('id')?>" />-->
          <input type="hidden" id="upd_cid" name="cid" class="form-control" value="" />
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label for="name">Nombre de la categoría</label>
                <input type="text" id="upd_cat_name" name="name" class="form-control" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="">
                <label for="description">Imagen de categoría</label>
                <input type="file" id="upd_cat_img" name="cat_img" class="form form-control" name="image" />
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label for="description">Descripción</label>
                <textarea id="upd_cat_description" name="description" class="form-control" required></textarea>
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
          'id' => 'del_cat_form',
          'name' => 'login_form',
          'enctype' => 'multipart/form-data',
        );
        echo form_open('category/delete_category', $attributes);
        ?>
        <div class="modal-header">
          <h5 class="lead font-weight-bold">Eliminar categoría</h5>
        </div>

        <!-- Body started -->
        <div class="modal-body">
          <h4>¿Quieres eliminar este producto?</h4>
        </div>
        <!-- Body ended -->

        <div class="modal-footer">
          <input type="hidden" id="del_cid" name="cid" />
          <button type="submit" class="btn btn-sm  btn-danger">Borrar</button>
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

      $('#upd_cid').val(data[0]);
      $('#upd_cat_name').val(data[2]);
      $('#upd_cat_description').val(data[3]);


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

      $('#del_cid').val(data[0]);


    });
  });
</script>

</html>