<!doctype html>
<html lang="en">

<head>
  <title>Admin | Orders</title>
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
          <b class="breadcrumb" style=" font-size:30px">Pedidos</b>
        <?php if($status){?>
              <div class="alert alert-success"><?php echo $message ?></div>
      <?php }else{ ?>
              <div class="alert alert-danger"><?php echo $message ?></div>
      <?php } ?>
        <!-- Button trigger modal -->
        <!-- <button type="button" class="btn btn-primary mb-4" data-toggle="modal" data-target="#basicExampleModal">
          Add stocks
        </button> -->

        <div class="container-fluid">
          <!-- your content here -->

          <table id="example" class="display table2" style="width:100%">
            <thead>
              <tr>
                <th width="5%">SlNo</th>
                <th>Orden Id</th>
                <th>Número de orden</th>
                <th>Nombre del cliente</th>
                <th>Correo electrónico del cliente</th>
                <th>Fecha de orden</th>
                <th>Estado del pedido</th>
                <th>Precio total</th>
                <th>Observación</th>
                <th width="13%">Acción</th>
              </tr>
            </thead>
            <tbody>

              <?php
              $key = 0;
              foreach ($data['data'] as  $value) {
              ?>
                <tr>
                  <td><?= $key + 1 ?></td>
                  <td><?= $value['orderId'] ?></td>
                  <td><?= $value['poId'] ?></td>
                  <td><?= $value['customerName'] ?></td>
                  <td><?= $value['customerEmail'] ?></td>
                  <td><?= $value['orderDate'] ?></td>
                  <?php
                  if ($value['status'] == 0) {
                    echo "<td style='color:blue;font-weight:600;'>Order Received</td>";
                  } else if ($value['status'] == 1) {
                    echo "<td style='color:grey;font-weight:600;'>Order being processed</td>";
                  } else if ($value['status'] == 2) {
                    echo "<td style='color:orange;font-weight:600;'>Order in transit</td>";
                  } else if ($value['status'] == 3) {
                    echo "<td style='color:green;font-weight:600;'>Ready to Pickup</td>";
                  } else if ($value['status'] == 4) {
                    echo "<td style='color:red;font-weight:600;'>Delivered </td>";
                  } else if ($value['status'] == 5) {
                    echo "<td style='color:red;font-weight:600;'>Cancelled </td>";
                  } else {
                    echo " <td style='color:grey;font-weight:600;'>Unknown </td>";
                  } ?>
                  <td>$ <?= $value['price'] ?></td>
                  <td><?= $value['remark'] ?></td>
                  <td>
                    <a href=" <?php echo base_url('Order_info/getOrderDetail/' . $value['poId']); ?>" title="Ver detalles del pedido" class="btn btn-sm viewbtn"><i class="fa fa-eye"></i> </a>
                    <a href="<?= site_url() . $value['poId'] ?>" class="btn btn-sm editbtn" title="Editar estado / comentario" data-toggle="modal" data-target="#updOrderModal"><i class=" fa fa-pencil-square-o"></i></a>
                    <a href="<?= site_url() . 'po/invoice.php?id=' . $value['poId'] ?>" target="_blank" title="Descargar factura" class="btn btn-sm delbtn"><i class="fa fa-download"></i></a>

                    <!-- <a href="http://localhost/FarmersAppBackend/manage_gallery/delete/2" class="btn btn-danger" onclick="return confirm('Are you sure to delete data?')?true:false;">delete</a> -->

                  </td>
                </tr>
              <?php
                $key++;
              } ?>

            </tbody>
            <tfoot>
              <tr>
                <th>SlNo</th>
                <th>Order Id</th>
                <th>No of order</th>
                <th>Customer Name</th>
                <th>Customer Email</th>
                <th>Order Date</th>
                <th>Order Status</th>
                <th>Total Price</th>
                <th>Remark</th>
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


<div class="modal fade" id="updOrderModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <?php
      $attributes = array(
        'class' => 'form',
        'id' => 'login_form',
        'name' => 'login_form',
        'enctype' => 'multipart/form-data',
      );
      echo form_open('Order_info/updateOrderDetail', $attributes);
      ?>
      <div class="modal-header">
        <h5>Actualizar los detalles del pedido</h5>
      </div>

      <!-- Body started -->
      <div class="modal-body">

        <!--<input type="hidden" id="updated_by" name="created_by" class="form-control" value="<?//=$this->session->userdata('id')?>" />-->
        <!-- <input type="hidden" id="upd_pid" name="pid" class="form-control" value="" /> -->
        <input type="hidden" id="order_no" name="order_no" class="form-control" value="<?  ?>" />
        <input type="hidden" id="upd_at" name="updated_at" class="form-control" value="<?= date('Y-m-d H:i:s') ?>" />
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="cid">Estado de la orden</label>
              <select id="or_status" name="or_status" class="form-control">

                <?php $cats = ['Order Received', 'Order being processed', 'Order in transit', 'Ready to Pick UP', 'Delivered', 'Cancelled'];
                foreach ($cats as $key => $val) { ?>
                  <option value="<?= $key ?>"><?= $val ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="remark">Observación</label>
              <input type="text" id="remark" name="order_remark" class="form-control">
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


<script type="text/javascript">
$(function() {
  $(".alert").hide(5000);
});
  
  $(document).ready(function() {
    $('#example').DataTable({
      "pagingType": "full_numbers",
    });
  });

  $(document).ready(function() {
    $('.editbtn').on('click', function() {

      // $('#updOrderModal').modal('show');

      $tr = $(this).closest('tr');

      var data = $tr.children('td').map(function() {
        return $(this).text();
      }).get();

      console.log(data);
      // $('#farm_id').val(data[14]);
      // $('#updated_by').val(data[0]);
      $('#remark').val(data[8]);
      $('#order_no').val(data[2]);
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