<!doctype html>
<html lang="en">

<head>
  <title>Admin | Orders</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- Material Kit CSS -->
  <link href="<?=base_url('assets/css/material-dashboard.css?v=2.1.2')?>" rel="stylesheet" />

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
    <?php require_once('common/nav.php')?>
    <!-- Sidebar ended -->

    <div class="main-panel">
      <!-- Navbar -->
      <?php require_once('common/navbar.php');?>
      <!-- End Navbar -->
      <div class="content">
        <!-- Button trigger modal -->
        <!-- <button type="button" class="btn btn-primary mb-4" data-toggle="modal" data-target="#basicExampleModal">
          Add stocks
        </button> -->
        
        <div class="container-fluid">
          <!-- your content here -->
          
          <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>SlNo</th>
                    <th>Order Id</th>
                    <th>Customer Name</th>
                    <th>Customer Email</th>
                    <th>Order Date</th>
                    <th>Order Status</th>                  
                    <th>Total Price</th>                    
                    <th>Remark</th>
                    <th width="18%">Action</th>
                </tr>
            </thead>
            <tbody>

              <?php

             // print_r($data['data']);
$key = 0;
               foreach($data['data'] as  $value) { 
              ?>
                <tr>
                    <td><?=$key+1?></td>
                    <td><?=$value ['orderId']?></td>
                    <td><?=$value['customerName'] ?></td>
                    <td><?=$value['customerEmail'] ?></td>
                    <td><?=$value['orderDate'] ?></td>
                    <?php 
                    if($value['status']== 0){ 
                     echo"<td style='color:blue;font-weight:600;'>Ordered</td>";
                   }
                    else if($value['status']== 1){ 
                     echo "<td style='color:grey;font-weight:600;'>Deliver in transit</td>";
                  }
                    else if($value['status']== 2) { 
                      echo "<td style='color:orange;font-weight:600;'>Partial delivery</td>";
                  }
                    else if($value['status'] == 3){ 
                      echo "<td style='color:green;font-weight:600;'>Delivered</td>";
                   }
                   else if($value['status'] ==4){                
                    echo "<td style='color:red;font-weight:600;'>Cancelled </td>";
                   }else{ 
                    echo " <td style='color:grey;font-weight:600;'>Unknown </td>";
                  } ?>
                    <td><?=$value['price']?></td>                   
                    <td><?=$value['remark']?></td>
                    <td>
                        <a href="<?php echo base_url('Order_info/getOrderDetail/'.$value ['orderId']); ?>" class="btn btn-primary">view order detail</a>
                        <a href="<?=site_url().$value ['orderId']?>" class="btn btn-warning" data-toggle="modal" data-target="#updOrderModal">edit status/ remark</a>   

                         <!-- <a href="http://localhost/FarmersAppBackend/manage_gallery/delete/2" class="btn btn-danger" onclick="return confirm('Are you sure to delete data?')?true:false;">delete</a> -->
                       
                    </td>
                </tr>
             <?php 
$key ++; 
           } ?>
 
            </tbody>
            <tfoot>
                <tr>
                    <th>SlNo</th>
                    <th>Order Id</th>
                    <th>Customer Name</th>
                    <th>Customer Email</th>
                    <th>Order Date</th>
                    <th>Order Status</th>                  
                    <th>Total Price</th>                    
                    <th>Remark</th>
                    <th width="18%">Action</th>
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
        <!-- <form method="post" action="<?=site_url('products/addProducts');?>"> -->
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
            <h5>Update Order Details</h5>
          </div>
          
          <!-- Body started -->
          <div class="modal-body">

            <!--<input type="hidden" id="updated_by" name="created_by" class="form-control" value="<?//=$this->session->userdata('id')?>" />-->
            <input type="hidden" id="upd_pid" name="pid" class="form-control" value="" />
             <input type="hidden" id=farm_id name="created_by" class="form-control" value="" />
            <input type="hidden" id="upd_pid" name="updated_at" class="form-control" value="<?=date('Y-m-d H:i:s')?>" />
            <div class="row">
              <div class="col-md-6">
               <div class="form-group">
                  <label for="cid">Order Status</label>
                  <select id="cid" name="cid" class="form-control">
                   
                  <?php $cats = ['Ordered', 'Deliver in transit', 'Partial delivery', 'Delivered', 'Cancelled']; foreach($cats as $key => $val) {?>
                    <option value="<?=$key?>"><?=$val?></option>
                  <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="cost_price">Remark</label>
                  <input type="text" id="remark" name="order_remark" class="form-control">
                </div>
              </div>              
            </div>

          </div>
          <!-- Body ended -->

          <div class="modal-footer">
            <button type="submit" class="btn btn-sm btn-primary">Update</button>
            <button type="reset" class="btn btn-sm btn-success">Clear</button>
            <a href="#" class="btn btn-sm btn-danger" data-dismiss="modal">Close</a>
          </div>

        <?php echo 
          form_close();
          ?>
      </div>
    </div>
  </div>


  <script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable( {
            "pagingType": "full_numbers"
        } );
    } );
  </script>

</html>