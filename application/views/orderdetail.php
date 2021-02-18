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
 <?php require_once('common/nav.php')?>
    <!-- Sidebar ended -->
    
    <div class="main-panel">
      <!-- Navbar -->
   <?php require_once('common/navbar.php');?> 
      <!-- End Navbar -->

      <div class="content">


<?php

  ?>

<div class="container">
  <div class="row">
    <div class="col-md-6">
     <h2>Order Id : <?php echo $order_id; ?></h2>
     
   </div>
    <div class="col-md-6">
     <h4><b>Customer  Name:</b> <?php echo $order_from; ?></h4>
     <h4><b>Customer  Email:</b> <?php echo $customerEmail; ?></h4>
     <h4><b>Customer  Phone:</b> <?php echo $customerPhone; ?></h4>
    </div>
  </div>

   
	
    <!-- Display status message -->
    <?php if(!empty($success_msg)){ ?>
    <div class="col-xs-12">
        <div class="alert alert-success"><?php echo $success_msg; ?></div>
    </div>
    <?php }elseif(!empty($error_msg)){ ?>
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
        
        <!-- Data list table --> 
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Product ID</th>
                    <th>Product</th>
                    <th>Price/Units</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Farmer</th>
                    <th>Farmer Email</th>
                    <th>Farmer Phone</th>
                    <th>Farmer Address</th>                    
                </tr>
            </thead>
            <tbody>
                <?php  
                $i = 0;
                    foreach($data as $d){  
; 
                ?>
                <tr>
                    <td><?php echo $i +1; ?></td>
                    <td> <img src="<?= $d['products']['pimg']; ?>" alt="" width="50px" height="50px" /></td>
                    <td><?php echo $d['products']['pid']; ?></td>
                    <td><?php echo $d['products']['pname']; ?></td>
                    <td><?php echo $d['products']['sell_price'] .'/'.$d['products']['unit']; ?></td>
                    <td><?php echo $d['products']['ordered_qty']; ?></td>
                     <td><?php echo $d['products']['total_price']; ?></td>
                    <td><?php echo $d['farmers']['fname']; ?></td>  
                    <td><?php echo $d['farmers']['femail']; ?></td>
                     <td><?php echo $d['farmers']['fphone']; ?></td>   
                      <td><?php echo $d['farmers']['faddress']; ?></td>                  
                </tr>
                <?php $i++;
                 } ?>
            </tbody> 
        </table>
         <a style="margin-top:50px; float:right" href="<?php echo base_url('orders'); ?>" class="btn btn-primary">Back to List</a>
    </div>

</div>

 

<?php require_once('common/footer.php');?>

    </div>
  </div>