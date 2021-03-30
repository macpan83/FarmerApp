<!doctype html>
<html lang="en">

<head>
    <title>Admin | Course</title>
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

        .form-group input[type=file] {
            opacity: 1;
            position: relative;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
    </style>
</head>

<body>
    <div class="wrapper ">


        <!-- Sidebar started -->
        <?php require(dirname(__FILE__) . '/../common/nav.php');
        ?>
        <!-- Sidebar ended -->

        <div class="main-panel">
            <!-- Navbar -->
            <?php require_once(dirname(__FILE__) . '/../common/navbar.php'); ?>
            <!-- End Navbar -->

            <div class="content">

                <div class="container">
                    <h1><?php echo $title; ?></h1>
                    <hr>

                    <!-- Display status message -->
                    <?php if (!empty($error_msg)) { ?>
                        <div class="col-xs-12">
                            <div class="alert alert-danger"><?php echo $error_msg; ?></div>
                        </div>
                    <?php } ?>

                    <div class="row">
                        <div class="col-md-6 offset-md-4 bg-dark p-5">
                            <form method="post" action="" enctype="multipart/form-data">
                                <div class="form-group">
                                    <h4 style=" font-weight:500;  color:white">Título:</h4>
                                    <input type="text" name="title" class=" form-control text-white" placeholder="Enter title" value="<?php echo !empty($gallery['title']) ? $gallery['title'] : ''; ?>">
                                    <?php echo form_error('title', '<p class="text-white help-block text-danger">', '</p>'); ?>
                                </div>
                                <div class="">
                                    <h4 style="font-weight:500; color:white">Imágenes:</h4>
                                    <input type="file" name="images[]" class="form text-white form-control" multiple >
                                    <?php if (!empty($gallery['images'])) { ?>
                                        <div class="gallery-img">
                                            <?php foreach ($gallery['images'] as $imgRow) { ?>
                                                <div class="img-box" id="imgb_<?php echo $imgRow['id']; ?>" style="display: inline-block;">
                                                    <img style="max-width: 150px;" src="<?php echo $imgRow['file_name']; ?>">
                                                    <!--  <a href="javascript:void(0);" class="badge badge-danger" onclick="deleteImage('<?php echo $imgRow['id']; ?>')">delete</a> -->
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <br>
                                <input type="submit" name="imgSubmit" class="btn  btn-sm submitbtn" value="ENVIAR">

                                <input type="hidden" name="id" value="<?php echo !empty($gallery['id']) ? $gallery['id'] : ''; ?>">
                                <a href="<?php echo base_url('manage_gallery'); ?>" class="btn  btn-sm cancel">Atrás</a>
                            </form>
                        </div>
                    </div>
                </div>


            </div>
            <?php require(dirname(__FILE__) . '/../common/footer.php') ?>

        </div>