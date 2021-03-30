<!doctype html>
<html lang="en">

<head>
  <title>Admin | Stocks</title>
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
    <?php require_once('common/nav.php') ?>
    <!-- Sidebar ended -->

    <div class="main-panel">
      <!-- Navbar -->
      <?php require_once('common/navbar.php'); ?>
      <!-- End Navbar -->
      <div class="content">

        <!-- Button trigger modal -->
        <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#stockModal">Add Stock</a>

        <div class="container-fluid">
          <!-- your content here -->

          <table id="example" class="display" style="width:100%">
            <thead>
              <tr>
                <th class="th_1">SlNo</th>
                <th class="th_1">Producto</th>
                <th class="th_1">En</th>
                <th class="th_1">Fuera</th>
                <th class="th_1">Unidad</th>
                <th class="th_1">Cantidad</th>
                <th class="th_1">Cantidad restante</th>
                <th class="th_1">Calidad Total</th>
              </tr>
            </thead>
            <tbody>

              <?php foreach ($data['data'] as $key => $value) { ?>
                <tr>
                  <td><?= $key + 1 ?></td>
                  <td><?= $value['pid'] ?></td>
                  <td><?= date('Y/m/d', strtotime($value['stock_in_dt'])) ?></td>
                  <td><?= date('Y/m/d', strtotime($value['stock_out_dt'])) ?></td>
                  <td><?= $value['unit'] ?></td>
                  <td><?= $value['qnty'] ?></td>
                  <td><?= $value['remain_qty'] ?></td>
                  <td><?= $value['total_qty'] ?></td>
                </tr>

              <?php } ?>

            </tbody>
            <tfoot>
              <tr>
                <th class="th_1">SlNo</th>
                <th class="th_1">Product</th>
                <th class="th_1">In</th>
                <th class="th_1">Out</th>
                <th class="th_1">Unit</th>
                <th class="th_1">Quantity</th>
                <th class="th_1">Remain Qty</th>
                <th class="th_1">Total Qty</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>

      <?php require_once('common/footer.php') ?>

    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="productModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header"></div>
        <div class="modal-body"></div>
        <div class="modal-footer"></div>
      </div>
    </div>
  </div>



  <!-- ADD PRODUCT Modal -->
  <div class="modal fade" id="stockModal">
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
        echo form_open('stocks/addStocks', $attributes);
        ?>
        <div class="modal-header">
          <h5 class="lead font-weight-bold">Detalles de stock</h5>
        </div>

        <!-- Body started -->
        <div class="modal-body">

          <input type="hidden" id="created_by" name="created_by" class="form-control" value="<?= $this->session->userdata('id') ?>" />
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="pid">Nombre del producto</label>
                <select name="pid" id="pid" class="form-control">
                  <?php //foreach($data[]){
                  ?>
                  <option value="<?//=$val?>">
                    <?//=$val?>
                  </option>
                  <?php //}
                  ?>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="stock_in_dt">Acciones de</label>
                <input type="date" id="stock_in_dt" name="stock_in_dt" class="form-control">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="stock_out_dt">Agotar</label>
                <input type="date" id="stock_out_dt" name="stock_out_dt" class="form-control">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label for="unit">Unidad</label>
                <select name="unit" id="unit" class="form-control">
                  <?php //foreach($data[]){
                  ?>
                  <option value="<?//=$val?>">
                    <?//=$val?>
                  </option>
                  <?php //}
                  ?>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" id="quantity" name="quantity" class="form-control">
              </div>
            </div>
          </div>

        </div>
        <!-- Body ended -->

        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-primary">Salvar</button>
          <button type="reset" class="btn btn-sm btn-success">Clara</button>
          <a href="#" class="btn btn-sm btn-danger" data-dismiss="modal">Cerrar</a>
        </div>

        <?php echo
        form_close();
        ?>
      </div>
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