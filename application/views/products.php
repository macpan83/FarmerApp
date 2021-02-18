<!doctype html>
<html lang="en">

<head>
  <title>Admin | Course</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
  <!-- Material Kit CSS -->
  <link href="<?=base_url('assets/css/material-dashboard.css?v=2.1.2')?>" rel="stylesheet" />

  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" />
  <link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'>
  <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js'></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

  <style type="text/css">
    .th_1{
      font-size: 12px;
    }
  </style>
</head>

<body>
  <div class="wrapper ">

    <!-- Sidebar started -->
    <?php require_once('common/nav.php');?>
    <!-- Sidebar ended -->
    
    <div class="main-panel">
      <!-- Navbar -->
      <?php require_once('common/navbar.php');?>
      <!-- End Navbar -->

      <div class="content">

        <!-- Button trigger modal -->
        <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#productModal">Add Product</a>

        <div class="container-fluid">
          <!-- your content here -->
          
          <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th class="th_1">SlNo</th>
                    <th class="th_1">Catagory</th>
                    <!-- <th class="th_1">Type</th> -->
                    <th class="th_1">Image</th>
                    <th class="th_1">Name</th>
                    <th class="th_1">Description</th>
                    <th class="th_1">Cost Price</th>
                    <th class="th_1">Sell Price</th>
                    <th class="th_1">Unit</th>
                    <th class="th_1">Remaining Qty</th>
                    <th class="th_1">Status</th>
                    <th class="th_1">Edit</th>
                    <th class="th_1">Delete</th>
                    <!-- <th class="th_1">Created At</th>
                    <th class="th_1">Created By</th> -->
                </tr>
            </thead>
            <tbody>

              <?php foreach($data['data'] as $key => $value) { ?>
                <tr>
                    <td><?=$key+1?></td>
                    <td style="display: none;"><?=$value['pid']?></td>
                    <td style="display: none;"><?=$value['cid']?></td>                   
                    <td><a href="<?=site_url('catagories')?>" style="text-decoration: none;"><?=$value['category']?></a></td>
                    <!-- <td><?=$value['type']?></td> -->
                    <td>
                      <img src="<?=/*base_url('uploads/products/').*/$value['image']?>" alt="" width="50px" height="50px" />
                    </td>
                    <td><?=$value['name']?></td>
                    <td><?=$value['description']?></td>
                    <td><?=$value['cost_price']?></td>
                    <td><?=$value['sell_price']?></td>
                    <td><?=$value['unit']?></td>
                    <td><?=$value['total_qty']?></td>
                    <td><?=$value['approve'] == 0?"Rejected":"Approved"?></td>
                    <td>
                      <a href="<?=site_url().$value['pid']?>" class="btn btn-sm btn-info editbtn" data-toggle="modal" data-target="#updProductModal">
                        <i class="fas fa-edit"></i>
                      </a>
                    </td>
                    <td>
                      <a href="#" class="btn btn-sm btn-danger delbtn" data-toggle="modal" data-target="#delProductModal">
                        <i class="fas fa-trash-alt"></i>
                      </a>
                      <!-- <a href="#" id="delp" data-id="<?=$value['pid']?>" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delProductModal">Delete</a> -->
                    </td>
                    <td style="display: none;"><?=$value['created_by']?></td>
                    <!-- <td><?=$value['created_at']?></td>
                    <td><?=$value['created_by']?></td> -->
                </tr>

              <?php } ?>

            </tbody>
            <tfoot>
                <tr>
                    <th class="th_1">SlNo</th>
                    <th class="th_1">Catagory</th>
                    <th class="th_1" style="display:none">farmerId</th>
                    <th class="th_1">Image</th>
                    <th class="th_1">Name</th>
                    <th class="th_1">Description</th>
                    <th class="th_1">Cost Price</th>
                    <th class="th_1">Sell Price</th>
                    <th class="th_1">Unit</th>
                    <th class="th_1">Remaining Qty</th>
                    <th class="th_1">Status</th>
                    <th class="th_1">Edit</th>
                    <th class="th_1">Delete</th>
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
        <!-- <form method="post" action="<?=site_url('products/addProducts');?>"> -->
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
            <h5 class="lead font-weight-bold">Product details</h5>
          </div>
          
          <!-- Body started -->
          <div class="modal-body">

            <input type="hidden" id="created_by" name="created_by" class="form-control" value="<?=$this->session->userdata('id')?>" />
            <div class="row">
              <div class="col-md-5">
                <div class="form-group">
                  <label for="name">Product name</label>
                  <input type="text" id="name" name="name" class="form-control">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="cost_price">Cost Price</label>
                  <input type="text" id="cost_price" name="cost_price" class="form-control">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="sell_price">Sell Price</label>
                  <input type="text" id="sell_price" name="sell_price" class="form-control">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="total_qty">Total Quantity</label>
                  <input type="text" id="total_qty" name="total_qty" class="form-control">
                </div>
              </div>
            </div>            

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="description">Description</label>
                  <textarea id="description" name="description" class="form-control"></textarea>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="cid">Catagory</label>
                  <select id="cid" name="cid" class="form-control">
                  <?php $cats = ['none', 'Frutas', 'Vegetables', 'Lácteos', 'Farináceos', 'Provisiones']; foreach($cats as $key => $val) {?>
                    <option value="<?=$key?>"><?=$val?></option>
                  <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="unit">Unit</label>
                  <select id="unit" name="unit" class="form-control">
                  <?php $units = ['none', 'Pcs', 'Lbs', 'Cases']; foreach($units as $key) {?>
                    <option value="<?=$key?>"><?=$key?></option>
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
            <button type="submit" class="btn btn-sm btn-primary">Save</button>
            <button type="reset" class="btn btn-sm btn-success">Clear</button>
            <a href="#" class="btn btn-sm btn-danger" data-dismiss="modal">Close</a>
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
            <h5>Update Product Details</h5>
          </div>
          
          <!-- Body started -->
          <div class="modal-body">

            <!--<input type="hidden" id="updated_by" name="created_by" class="form-control" value="<?//=$this->session->userdata('id')?>" />-->
            <input type="hidden" id="upd_pid" name="pid" class="form-control" value="" />
             <input type="hidden" id=farm_id name="created_by" class="form-control" value="" />
            <input type="hidden" id="upd_pid" name="updated_at" class="form-control" value="<?=date('Y-m-d H:i:s')?>" />
            <div class="row">
              <div class="col-md-8">
                <div class="form-group">
                  <label for="name">Product name</label>
                  <input type="text" id="upd_name" name="name" class="form-control">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="cost_price">Cost Price</label>
                  <input type="text" id="upd_cost_price" name="cost_price" class="form-control">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="sell_price">Sell Price</label>
                  <input type="text" id="upd_sell_price" name="sell_price" class="form-control">
                </div>
              </div>
            </div>            

            <div class="row">
              <div class="col-md-8">
                <div class="form-group">
                  <label for="description">Description</label>
                  <textarea id="upd_description" name="description" class="form-control"></textarea>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="cid">Catagory</label>
                  <select id="upd_cid" name="cid" class="form-control">
                  <?php $cats = ['none', 'Frutas', 'Vegetables', 'Lácteos', 'Farináceos', 'Provisiones']; foreach($cats as $key => $val) {?>
                    <option value="<?=$key?>"><?=$val?></option>
                  <?php } ?>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="unit">Unit</label>
                  <select id="upd_unit" name="unit" class="form-control">
                  <?php $units = ['none', 'Pcs', 'Lbs', 'Cases']; foreach($units as $key) {?>
                    <option value="<?=$key?>"><?=$key?></option>
                  <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="total_qty">Total Quantity</label>
                  <input type="text" id="upd_total_qty" name="total_qty" class="form-control">
                </div>
              </div>
              
              <div class="col-md-2">
                <div class="form-group">
                  <label for="approve">Status</label>
                  <select id="upd_unit" name="approve" class="form-control">
                      <option value="none">None</option>
                  <?php $appr = [0, 1]; foreach($appr as $key) {?>
                    <option value="<?=$key?>"><?=$key==0?"Reject":"Approve" ?></option>
                  <?php } ?>
                  </select>
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

  <!-- DELETE PRODUCT Modal -->
  <div class="modal fade" id="delProductModal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <!-- <form method="post" action="<?=site_url('products/addProducts');?>"> -->
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
            <h5>Product details</h5>
          </div>
          
          <!-- Body started -->
          <div class="modal-body">
            <h4>Do you want to delete this product?</h4>
          </div>
          <!-- Body ended -->

          <div class="modal-footer">
            <input type="hidden" id="del_pid" name="pid" />
            <button type="submit" class="btn btn-sm btn-primary">Delete</button>
            <a href="#" class="btn btn-sm btn-danger" data-dismiss="modal">Close</a>
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
        $('#example').DataTable( {
            "pagingType": "full_numbers"
        } );
    } );

    
    $(document).ready( function(){
        $('.editbtn').on('click', function() {

          $('#updProductModal').modal('show');

          $tr = $(this).closest('tr');

          var data = $tr.children('td').map(function() {
            return $(this).text();
          }).get();

          console.log(data);
          $('#farm_id').val(data[14]);
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
    });


    $(document).ready( function(){
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