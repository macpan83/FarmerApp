<!DOCTYPE html>
<html>
<head>
  <title>Codeigniter Paypal Integration Example - nicesnippets.com</title>
  <!-- Latest CSS -->
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
 <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> 
</head>
<body>
  <div class="container">
    <h2 class="mt-3 mb-3">Products</h2>
    <div class="row">
        <?php 
        if(!empty($products['data'])): foreach($products['data'] as $product):
$buyProURL = 'buyProduct/' . $product["pid"];
         ?>
        <div class="thumbnail">
            <img src="<?php echo $product['image']; ?>" alt="">
            <div class="caption">
                <h4 class="pull-right">$<?php echo $product['sell_price']; ?></h4>
                <h4><a href="javascript:void(0);"><?php echo $product['name']; ?></a></h4>
            </div><a href="<?= site_url() . $buyProURL ?>" class="btn btn-sm viewbtn"><img src="<?php echo base_url(); ?>assets/images/buy-button.png" style="width: 70px;"></a>
        </div>
        <?php endforeach; endif; ?>
    </div>
  </div>
</body>
</html>