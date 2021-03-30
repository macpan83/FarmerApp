<!doctype html>
<html lang="en">

<head>
    <title>Admin | <?php echo !empty($gallery['title']) ? $gallery['title'] : ''; ?></title>
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
        <?php require(dirname(__FILE__) . '/../common/nav.php'); ?>
        <!-- Sidebar ended -->
        <div class="main-panel">
            <!-- Navbar -->
            <?php require_once(dirname(__FILE__) . '/../common/navbar.php'); ?>
            <!-- End Navbar -->
            <div class="content">


                <div class="container">
                    <div class="row">
                        <a style="margin-top:50px; float:right" href="<?php echo base_url('manage_gallery'); ?>" class="btn btn-primary">Volver a la lista</a>
                        <div class="col-md-12 ">
                            <h3 class="breadcrumb" style="font-size: 20px;font-weight: 400;">
                                Gallery <?php echo !empty($gallery['title']) ? $gallery['title'] : ''; ?>
                            </h3>

                            <?php if (!empty($gallery['images'])) { ?>
                                <div class="gallery-img row">
                                    <?php foreach ($gallery['images'] as $imgRow) { ?>
                                        <div class="img-box col-md-3" id="imgb_<?php echo $imgRow['id']; ?>">
                                            <img src="<?php echo $imgRow['file_name']; ?>" style="width: 250px;height:240px">
                                            <a style="display:block" href="javascript:void(0);" class="badge badge-danger" onclick="deleteImage('<?php echo $imgRow['id']; ?>')">delete</a>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php }
                            
                            else{?>
                             <div class="gallery-img row">
                                 <div class="img-box col-md-8">
                                     <h3>Sorry No image to display</h3>
                                 </div>
                             </div>
                            
                            <?php } ?>
                        </div>
                        <!---->
                    </div>

                </div>
</div>
                <?php require(dirname(__FILE__) . '/../common/footer.php') ?>

                <script>
                    $(function() {
  $(".alert").hide(6000);
}); 

                    function deleteImage(id) {
                        var result = confirm("Are you sure to delete?");
                        if (result) {
                            $.post("<?php echo base_url('manage_gallery/deleteImage'); ?>", {
                                id: id
                            }, function(resp) {
                                if (resp == 'ok') {
                                    $('#imgb_' + id).remove();
                                    alert('The image has been removed from the gallery');
                                } else {
                                    alert('Some problem occurred, please try again.');
                                }
                            });
                        }
                    }
                </script>
            </div>
        </div>
    </div>