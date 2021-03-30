<!doctype html>
<html lang="en">

<head>
  <title>Admin | Download file</title>
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


<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
 <link href='https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css'>
 <link href='https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css'>
</head>
<style>
    #example th{
        font-size:11px;
    }
</style>
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

          <table id="example" class="display table2" style="width:100%">
            <thead>
              <tr>
                <th>Orden Id</th>
                <th>Número de orden</th>
                <th>Nombre del producto</th>
                <th>Nombre del cliente</th>
                <th>Correo electrónico del cliente</th>
                <th>Nombre del granjero</th>
                <th>Correo electrónico del agricultor</th>
                <th>Fecha de orden</th>
                <th>Estado del pedido</th>
                <th>Precio total</th>
                <th>Cantidad</th>
                <th>dirección de entrega</th>
                <th>Observación</th>                
              </tr>
            </thead>
            <tbody>

              <?php
              $key = 0;
              foreach ($data['data'] as  $value) {
              ?>
                <tr>
                
                  <td><?= $value['orderId'] ?></td>
                  <td><?= $value['poId'] ?></td>
                  <td><?= $value['product_name'] ?></td>
                  <td><?= $value['customerName'] ?></td>
                  <td><?= $value['customerEmail'] ?></td>
                  <td><?= $value['farmerName'] ?></td>
                  <td><?= $value['farmerEmail'] ?></td>
                  <td><?= $value['orderDate'] ?></td>
                  <?php
                  if ($value['status'] == 0) {
                    echo "<td style='color:blue;font-weight:600;'>Ordered</td>";
                  } else if ($value['status'] == 1) {
                    echo "<td style='color:grey;font-weight:600;'>Deliver in transit</td>";
                  } else if ($value['status'] == 2) {
                    echo "<td style='color:orange;font-weight:600;'>Partial delivery</td>";
                  } else if ($value['status'] == 3) {
                    echo "<td style='color:green;font-weight:600;'>Delivered</td>";
                  } else if ($value['status'] == 4) {
                    echo "<td style='color:red;font-weight:600;'>Cancelled </td>";
                  } else {
                    echo " <td style='color:grey;font-weight:600;'>Unknown </td>";
                  } ?>
                  <td><?= $value['price'] ?></td>
                  <td><?= $value['quantity'] ?></td>
                  <td><?= $value['delivery_add'] ?></td>
                  <td><?= $value['remark'] ?></td>
                  
                </tr>
              <?php
                $key++;
              } ?>

            </tbody>
            <tfoot>
              <tr>
              
                <th>Orden Id</th>
                <th>Número de orden</th>
                <th>Nombre del producto</th>
                <th>Nombre del cliente</th>
                <th>Correo electrónico del cliente</th>
                <th>Nombre del granjero</th>
                <th>Correo electrónico del agricultor</th>
                <th>Fecha de orden</th>
                <th>Estado del pedido</th>
                <th>Precio total</th>
                <th>Cantidad</th>
                <th>dirección de entrega</th>
                <th>Observación</th>  
                
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
var today = new Date();
var dd = String(today.getDate()).padStart(2, '0');
var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
var yyyy = today.getFullYear();

today = yyyy + '-' + mm + '-' + dd;


    $('#example').DataTable({
      // "pagingType": "full_numbers",  
       dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Order-record( '+today+' )'
            },
             {
                extend: 'csvHtml5',
               title: 'Order-record( '+today+' )'
            }
            // 'copyHtml5',
            // 'excelHtml5',
            // 'csvHtml5',
            // 'pdfHtml5'            
        ]      
    });
  });

 
</script>

</html>