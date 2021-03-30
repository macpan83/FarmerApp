<!doctype html>
<html lang="en">

<head>
  <title>Admin | Dashboard</title>
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
  <script src='https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" />
  <link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'>
  <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js'></script>
  <style>
    .flex {
      -webkit-box-flex: 1;
      -ms-flex: 1 1 auto;
      flex: 1 1 auto
    }

    @media (max-width:991.98px) {
      .padding {
        padding: 1.5rem
      }
    }

    @media (max-width:767.98px) {
      .padding {
        padding: 0rem
      }

    }

    .info-box {
      display: block;
      min-height: 130px;
      background: #fff;
      width: 100%;
      box-shadow: 0 1px 16px 5px rgb(0 0 0 / 3%), 0 1px 5px 5px rgb(0 0 0 / 1%);

      margin-bottom: 15px;
      padding: 12px 0;
    }

    .info-box-text {

      font-size: 15px;
      font-weight: 400;
      text-transform: capitalize !important;
    }

    .info-box-content {
      padding: 5px 12px;
      /* float: right;*/
    }

    .info-box-icon {
      float: left !important;
      padding: 4px 15px;
      text-align: center !important;
    }

    .info-box-icon .material-icons {
      font-size: 30px !important;
      line-height: 1.6;
    }

    .info-box-number {
      display: block;
      font-weight: bold;
      font-size: 45px;
      padding-top: 10px;
      text-align: left;
      line-height: 100%;
    }

    .info-box-icon {
      float: right;
    }

    .info-box-text-small {
      line-height: 1.6;
      font-size: 12px;
      padding-top: 7px;
    }

    .padding {
      padding: 1rem
    }

    .card {
      background: #fff;
      border-width: 0;
      border-radius: .25rem;
      box-shadow: 0 1px 3px rgba(0, 0, 0, .05);
      margin-bottom: 1.5rem
    }

    .card {
      position: relative;
      display: flex;
      flex-direction: column;
      min-width: 0;
      word-wrap: break-word;
      background-color: #fff;
      background-clip: border-box;
      border: 1px solid rgba(19, 24, 44, .125);
      border-radius: .25rem
    }

    .card-header {
      padding: .75rem 1.25rem;
      margin-bottom: 0;
      background-color: rgba(19, 24, 44, .03);
      border-bottom: 1px solid rgba(19, 24, 44, .125)
    }

    .card-header:first-child {
      border-radius: calc(.25rem - 1px) calc(.25rem - 1px) 0 0
    }

    card-footer,
    .card-header {
      background-color: transparent;
      border-color: rgba(160, 175, 185, .15);
      background-clip: padding-box
    }

    /* changes */
    .main-panel>.content {
      background-color: #fdfdfd !important;
    }

    .breadcrumb {
      font-size: 20px;
      font-weight: 400;
    }

    /* dashboard pannel */
    .clr1 {

      box-shadow: 0 2px 10px 0px #0288d1, 0 7px 10px -5px #26c6da;
      background: linear-gradient(45deg, #0288d1, #26c6da) !important;
    }



    .clr2 {

      box-shadow: 0 2px 10px 0px #26c6da, 0 7px 10px -5px #ffca28;
      background: linear-gradient(45deg, #30E8BF, #ffca28) !important;
    }



    .clr3 {

      box-shadow: 0 2px 10px 0px #ffca28, 0 7px 10px -5px #ff6f00;
      background: linear-gradient(45deg, #ffca28, #ff6f00) !important;
    }



    .clr4 {

      box-shadow: 0 2px 10px 0px #ffca28, 0 7px 10px -5px #08db2b;
      background: linear-gradient(45deg, #e5ff58, #50b20e) !important
    }

    .clr5 {

      box-shadow: 0 2px 10px 0px #08db2b, 0 7px 10px -5px #43a047;
      background: linear-gradient(45deg, #08db2b, #43a047) !important
    }

    .clr6 {

      box-shadow: 0 2px 10px 0px #ba2626, 0 7px 10px -5px #ff3a04;
      background: linear-gradient(45deg, #ba2626, #ff3a04) !important
    }



    .info-box-text,
    .info-box-text-small,
    .info-box,
    .info-box-number {
      color: white !important;
      font-weight: 500;
      text-align: right;
    }

    .dashboard-table th {
      background-color: #f6f9fc;
      border-bottom: 1px solid #c9bebe !important;
      font-size: 14px !important;
      font-weight: 600;
      color: #444c57;
    }

    .info-box-icon {
      background-color: rgba(0, 0, 0, .18);
      border-radius: 50%;
      color: white;
    }



    .icon-box1 {
      padding: 20px 30px 20px 20px;
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
        <div class="container-fluid">
          <section class="" style="margin-top:0px">
            <ol class="breadcrumb">
              <li><i class="fa fa-dashboard"></i> Inicio -  </li>
              <li class="active"> Panel de control</li>
              <li style="position: absolute;right: 100px;"><?php echo "Fecha :  " . date("Y-m-d") . "<br>"; ?></li>
            </ol>
          </section>
          <!-- Main content -->
          <section style="padding:10px 10px 50px 10px">
            <!-- Info boxes -->
            <div class="row mb-5">
                
              <div class="col-md-2 offset-md-8">
                <div class="form-group">
                  <label for="timePeriod">A&#241;o</label>
                  <select id="year" name="year" class="form-control">
                    <option value="" selected>Seleccionar A&#241;o</option>
                    <?php
                    foreach ($statics['years'] as $val) { ?>
                      <option value="<?= $val ?>"><?= $val ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="timePeriod">Mes</label>
                  <select id="month" name="month" class="form-control" onchange="sendTimePeriod()">
                    <option value=0 selected>Seleccionar Mes</option>
                    <?php $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                    foreach ($months as $key => $val) { ?>
                      <option value="<?= $key + 1 ?>"><?= $val ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box clr1">
                  <div class=" info-box-content row">
                    <div class="col-md-4 col-sm-4 col-xs-4 icon-box1">
                      <span class="info-box-icon clr11">
                        <i class="material-icons">shopping_cart</i>
                      </span>
                    </div>
                    <div class="col-md-8 col-sm-8 col-xs-8">
                      <span class="info-box-text">Pedido Recibido</span>
                      <span class="info-box-number" id="order_recieved"><?php echo $statics['order_recieved'] ?></span>
                      <span class="info-box-text-small" id="order_recieved_text">Hoy</span>
                    </div>
                  </div>
                </div>
              </div>

              <!-- /.col -->
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box clr2">
                  <div class="info-box-content row">
                    <div class="col-md-4 col-sm-4 col-xs-4 icon-box1 ">
                      <span class="info-box-icon clr22 bg-aqua">
                        <i class="material-icons">grading</i>
                      </span>
                    </div>
                    <div class="col-md-8 col-sm-8 col-xs-8">
                      <span class="info-box-text">Pedido En Proceso</span>
                      <span class="info-box-number" id="order_being_processed"><?php echo $statics['order_being_processed'] ?></span>
                      <span class="info-box-text-small" id="order_being_processed_text">Hoy</span>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.col -->

              <!-- fix for small devices only -->
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box clr3">
                  <div class="info-box-content row">
                    <div class="col-md-4 col-sm-4 col-xs-4 icon-box1 ">
                      <span class="info-box-icon clr33 bg-aqua">
                        <i class="material-icons">inventory_2</i>
                      </span>
                    </div>
                    <div class="col-md-8 col-sm-8 col-xs-8">
                      <span class="info-box-text">Pedido En tr&#225;nsito</span>
                      <span class="info-box-number" id="order_in_transit"><?php echo $statics['order_in_transit'] ?></span>
                      <span class="info-box-text-small" id="order_in_transit_text">Hoy</span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box clr4">
                  <div class="info-box-content row">
                    <div class="col-md-4 col-sm-4 col-xs-4 icon-box1 ">
                      <span class="info-box-icon clr44 bg-aqua">
                        <i class="material-icons">local_shipping</i>
                      </span>
                    </div>
                    <div class="col-md-8 col-sm-8 col-xs-8 pl-3">
                      <span class="info-box-text">Listo Para Recoger</span>
                      <span class="info-box-number" id="ready_to_pickup"><?php echo $statics['ready_to_pickup'] ?></span>
                      <span class="info-box-text-small" id="ready_to_pickup_text">Hoy</span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box clr5">
                  <div class="info-box-content row">
                    <div class="col-md-4 col-sm-4 col-xs-4 icon-box1 ">
                      <span class="info-box-icon clr44 bg-aqua">
                        <i class="material-icons">verified</i>
                      </span>
                    </div>
                    <div class="col-md-8 col-sm-8 col-xs-8 pl-5">
                      <span class="info-box-text">Entregado</span>
                      <span class="info-box-number" id="delivered"><?php echo $statics['delivered'] ?></span>
                      <span class="info-box-text-small" id="delivered_text">Hoy</span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box clr6">
                  <div class="info-box-content row">
                    <div class="col-md-4 col-sm-4 col-xs-4 icon-box1 ">
                      <span class="info-box-icon clr44 bg-aqua">
                        <i class="material-icons">close</i>
                      </span>
                    </div>
                    <div class="col-md-8 col-sm-8 col-xs-8 pl-5">
                      <span class="info-box-text">Cancelado</span>
                      <span class="info-box-number" id="cancelled"><?php echo $statics['cancelled'] ?></span>
                      <span class="info-box-text-small" id="cancelled_text">Hoy</span>
                    </div>
                  </div>
                </div>
              </div>

              <!-- /.col -->
            </div>
          </section>
          <section style="padding:50px 10px">
            <a class="pull-right btn btn-primary btn-xs" href="<?php echo site_url() ?>admin_management/createxls"><i class="fa fa-file-excel-o" style="font-size: 12px;margin-right: 5px; line-height: 1.2;
"></i> Exportar datos</a>
            <table id="example" class="display dashboard-table" style="width:100%">
              <thead>
                <tr>
                  <th width="7%">SlNo</th>
                  <th>Número de orden</th>
                  <th>Nombre del cliente</th>
                  <th>Correo electrónico del cliente</th>
                  <th>Fecha de orden</th>
                  <th>Estado del pedido</th>
                  <th>Precio total</th>

                </tr>
              </thead>
              <tbody>

                <?php
                $key = 0;
                foreach ($statics['order_list_item'] as  $value) {
                ?>
                  <tr>
                    <td><?= $key + 1 ?></td>
                    <td><?= $value['poId'] ?></td>
                    <td><?= $value['customerName'] ?></td>
                    <td><?= $value['customerEmail'] ?></td>
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
                  </tr>
                <?php
                  $key++;
                } ?>

              </tbody>
              <tfoot>
                <tr>
                  <th width="7%">SlNo</th>
                  <th>Número de orden</th>
                  <th>Nombre del cliente</th>
                  <th>Correo electrónico del cliente</th>
                  <th>Fecha de orden</th>
                  <th>Estado del pedido</th>
                  <th>Precio total</th>


                </tr>
              </tfoot>
            </table>
          </section>
        </div>
      </div>

      <section style="padding:50px 0; background:white">
        <div class="row" style="margin-left:0px;margin-right:0px">
          <div class="col-md-6">
            <?php
            if (count($data) != 0) { ?>
              <div id="chartContainer" style="height: 370px; max-width: 420px; margin: 0px auto;"></div>
            <?php } else { ?>
              <div class="p-3 text-center">
                <h3>No Data for product sale is availaible</h3>
              </div>
            <?php } ?>

          </div>
          <div class="col-md-6">
            <?php if (count($rec) != 0) { ?>
              <div id="graphContainer" style="height: 370px; max-width: 420px; margin: 0px auto;"></div>
            <?php } else { ?>
              <div class="p-3 text-center">
                <h3>No Data for product sale is availaible</h3>
              </div>
            <?php } ?>

          </div>
        </div>
      </section>
      <?php require_once('common/footer.php') ?>
    </div>
  </div>
</body>

<script type="text/javascript">
  $(document).ready(function() {
    $('#example').DataTable({
      initComplete: function() {
        this.api().columns().every(function() {
          var column = this;
          var select = $('<select><option value="">Seleccionar</option></select>')
            .appendTo($(column.header()).empty())
            .on('change', function() {
              var val = $.fn.dataTable.util.escapeRegex(
                $(this).val()
              );

              column
                .search(val ? '^' + val + '$' : '', true, false)
                .draw();
            });

          column.data().unique().sort().each(function(d, j) {
            select.append('<option value="' + d + '">' + d + '</option>')
          });
        });
      }
    });
  });
</script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.bundle.min.js'></script>

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

<script>
  window.onload = function() {

    var chart = new CanvasJS.Chart("chartContainer", {
      exportEnabled: true,
      animationEnabled: true,
      title: {
        text: "Most Order Products"
      },
      legend: {
        cursor: "pointer",
        itemclick: explodePie
      },
      data: [{
        type: "pie",
        showInLegend: true,
        toolTipContent: "{name}: <strong>{y}%</strong>",
        indexLabel: "{name} - {y}%",
        dataPoints: [
          <?php
          foreach ($data as $d) {
            echo "{ y: " . $d['y'] . ", name:'" . $d['name'] . "'},";
          }
          ?>
        ]
      }]
    });

    chart.render();


    var graph = new CanvasJS.Chart("graphContainer", {
      animationEnabled: true,
      title: {
        text: "Company Revenue"
      },
      axisX: {
        title: "timeline",
        gridThickness: 1
      },
      axisY: {
        title: "Revenue in USD",
        valueFormatString: "",
        prefix: "$"
      },
      data: [{
        type: "splineArea",
        color: "rgba(54,158,173,.7)",
        markerSize: 1,
        xValueFormatString: "YY-MM-DD",
        yValueFormatString: "$#,##0.##",
        dataPoints: [
          <?php
          foreach ($rec as $r) {
            echo "{ x: new Date(" . $r['year'] . "," . ($r['month'] - 1) . "," . $r['date'] . "),y:" . (int)$r['y'] . "},";
          }
          ?>

        ]
      }]
    });
    graph.render();

  }

  function explodePie(e) {
    if (typeof(e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e.dataPointIndex].exploded) {
      e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
    } else {
      e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
    }
    e.chart.render();

  }

  function sendTimePeriod() {
    var months = document.getElementById("month");
    var month = months.value;
    var years = document.getElementById("year");
    var year = years.value;
    var monthname = $("#month option:selected");
    var selectedDuration = year + '-' + monthname.text();
    var url = "<?php echo base_url('admin_management/getDataFromTime') ?>";

    $.ajax({
      type: "POST", //send with post 
      url: "<?php echo base_url('admin_management/getDataFromTime') ?>",
      data: {
        month: month,
        year: year
      },
      success: function(data) {
        console.log(data);
        if (data !== 'null') {
          var d = JSON.parse(data);
          console.log(d);
          // var totalOrder = d.order_recieved;
          // var delvtrans = d.delv_in_transit_today;
          // var pardelv = d.total_partial_delv;
          // var delivered = d.delivered_today;

          $("#order_recieved_text").html(selectedDuration);
          $('#order_recieved').html(d.order_recieved);
          $('#order_being_processed_text').html(selectedDuration);
          $('#order_being_processed').html(d.order_being_processed);
          $('#order_in_transit_text').html(selectedDuration);
          $('#order_in_transit').html(d.order_in_transit);
          $("#ready_to_pickup_text").html(selectedDuration);
          $('#ready_to_pickup').html(d.ready_to_pickup);
          $("#delivered_text").html(selectedDuration);
          $('#delivered').html(d.delivered);
          $("#cancelled_text").html(selectedDuration);
          $('#cancelled').html(d.cancelled);

        } else {

          $('#order_recieved').html(0);

          $('#order_being_processed').html(0);

          $('#order_in_transit').html(0);

          $('#ready_to_pickup').html(0);

          $('#delivered').html(0);

          $('#cancelled').html(0);
        }

      }
    });
  }

  $("#year").change(function() {
    $('#month').val(0)
  });
</script>

</html>