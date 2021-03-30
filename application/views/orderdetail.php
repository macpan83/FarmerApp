<!doctype html>
<html lang="en">

<head>
  <title>Admin | Order Detail</title>
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
    <?php require_once('common/nav.php') ?>
    <!-- Sidebar ended -->

    <div class="main-panel">
      <!-- Navbar -->
      <?php require_once('common/navbar.php'); ?>
      <!-- End Navbar -->

      <div class="content">


        <?php

        ?>

        <div class="container">
          <div class="row">
            <div class="col-md-6">
              <h2>Order Id : <?php echo $order_no; ?></h2>

            </div>
            <div class="col-md-6">
              <h4><b>Customer Name:</b> <?php echo $order_from; ?></h4>
              <h4><b>Customer Email:</b> <?php echo $customerEmail; ?></h4>
              <h4><b>Customer Phone:</b> <?php echo $customerPhone; ?></h4>
            </div>
          </div>



          <!-- Display status message -->
          <?php if (!empty($success_msg)) { ?>
            <div class="col-xs-12">
              <div class="alert alert-success"><?php echo $success_msg; ?></div>
            </div>
          <?php } elseif (!empty($error_msg)) { ?>
            <div class="col-xs-12">
              <div class="alert alert-danger"><?php echo $error_msg; ?></div>
            </div>
          <?php } ?>

          <div class="row">
            <div class="col-md-12 head">
              <!--    <h5><?php echo $title; ?></h5> -->
              <!-- Add link -->
              <!--  <div class="float-right">
                <a href="<?php echo base_url('manage_gallery/add'); ?>" class="btn btn-success"><i class="plus"></i> New Gallery</a>
            </div> -->
            </div>
 <a style="margin-top:50px; float:right" href="<?php echo base_url('orders'); ?>" class="btn btn-primary">Volver a la lista</a>
            <!-- Data list table -->
            <table class="table table-striped table-bordered">
              <thead class="thead-dark">
                <tr>
                  <th>#</th>
                  <th>Imagen</th>
                  <th>ID del Producto</th>
                  <th>Producto</th>
                  <th>Precio / Unidades</th>
                  <th>Cantidad</th>
                  <th>Precio total</th>
                  <th>Estado de la orden</th>
                  <th>Granjera</th>
                  <th>Correo electrónico del agricultor</th>
                  <th>Teléfono del agricultor</th>
                  <th>Dirección del agricultor</th>
                  <!--  <th>Action</th>    -->
                </tr>
              </thead>
              <tbody>
                <?php
                $i = 0;

                // echo "<pre>";
                // Print_r($data);
                // die();

                foreach ($data as $d) {

                ?>
                  <tr>
                    <td><?php echo $i + 1; ?></td>
                    <td style="display:none"><?php echo $d['products']['oid']; ?></td>
                    <td> <img src="<?= $d['products']['pimg']; ?>" alt="" width="50px" height="50px" /></td>
                    <td><?php echo $d['products']['pid']; ?></td>
                    <td><?php echo $d['products']['pname']; ?></td>
                    <td><?php echo $d['products']['sell_price'] . '/' . $d['products']['unit']; ?></td>
                    <td><?php echo $d['products']['ordered_qty']; ?></td>
                    <td><?php echo $d['products']['total_price']; ?></td>
                    <?php
                    if ($d['products']['status'] == 0) {
                      echo "<td style='color:blue;font-weight:600;'>Order Received</td>";
                    } else if ($d['products']['status'] == 1) {
                      echo "<td style='color:grey;font-weight:600;'>Order being processed</td>";
                    } else if ($d['products']['status'] == 2) {
                      echo "<td style='color:orange;font-weight:600;'>Order in transit</td>";
                    } else if ($d['products']['status'] == 3) {
                      echo "<td style='color:green;font-weight:600;'>Ready to Pickup</td>";
                    } else if ($d['products']['status'] == 4) {
                      echo "<td style='color:red;font-weight:600;'>Delivered </td>";
                    } else if ($d['products']['status'] == 5) {
                      echo "<td style='color:red;font-weight:600;'>Cancelled </td>";
                    } else {
                      echo " <td style='color:grey;font-weight:600;'>Unknown </td>";
                    } ?>
                    <td><?php echo $d['farmers']['fname']; ?></td>
                    <td><?php echo $d['farmers']['femail']; ?></td>
                    <td><?php echo $d['farmers']['fphone']; ?></td>
                    <td><?php echo $d['farmers']['faddress']; ?></td>
                    <!-- <td>                        
                        <a href="<?= site_url() . $d['products']['oid'] ?>" class="btn btn-warning editbtn" data-toggle="modal" data-target="#updOrderModal">edit status/ remark</a>
                    </td>   -->
                  </tr>
                <?php $i++;
                } ?>
              </tbody>
              <tfoot class="thead-dark">
                <tr>
                  <th>#</th>
                  <th>Image</th>
                  <th>Product ID</th>
                  <th>Product</th>
                  <th>Price/Units</th>
                  <th>Quantity</th>
                  <th>Total Price</th>
                  <th>Order Status</th>
                  <th>Farmer</th>
                  <th>Farmer Email</th>
                  <th>Farmer Phone</th>
                  <th>Farmer Address</th>
                  <!-- <th>Action</th>  -->
                </tr>
              </tfoot>
            </table>
           
          </div>

        </div>

      </div>

      <?php require_once('common/footer.php'); ?>
    </div>

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
            <input type="hidden" id="order_id" name="order_id" class="form-control" value="<?  ?>" />
            <input type="hidden" id="upd_at" name="updated_at" class="form-control" value="<?= date('Y-m-d H:i:s') ?>" />
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="cid">Estado de la orden</label>
                  <select id="or_status" name="or_status" class="form-control">

                    <?php $cats = ['Ordered', 'Deliver in transit', 'Partial delivery', 'Delivered', 'Cancelled'];
                    foreach ($cats as $key => $val) { ?>
                      <option value="<?= $key ?>"><?= $val ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <!-- <div class="col-md-6">
                <div class="form-group">
                  <label for="remark">Remark</label>
                  <input type="text" id="remark" name="order_remark" class="form-control">
                </div>
              </div> -->
            </div>

          </div>
          <!-- Body ended -->

          <div class="modal-footer">
            <button type="submit" class="btn btn-sm btn-primary">Actualizar</button>
            <button type="reset" class="btn btn-sm btn-success">Clara</button>
            <a href="#" class="btn btn-sm btn-danger" data-dismiss="modal">Cerrar</a>
          </div>

          <?php echo
          form_close();
          ?>
        </div>
      </div>
    </div>


    <script type="text/javascript">
      $(document).ready(function() {
        $('#example').DataTable({
          "pagingType": "full_numbers"
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
          //  $('#remark').val(data[7]);
          $('#order_id').val(data[1]);
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