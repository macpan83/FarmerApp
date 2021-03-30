<!doctype html>
<html lang="en">

<head>
    <title>Admin | Manage Gallery</title>
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
        <?php

        require(dirname(__FILE__) . '/../common/nav.php');
        ?>
        <!-- Sidebar ended -->

        <div class="main-panel">
            <!-- Navbar -->
            <?php require_once(dirname(__FILE__) . '/../common/navbar.php'); ?>
            <!-- End Navbar -->

            <div class="content">




                <div class="container">
                    <h2>Gestión de galería</h2>

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
                            <h5><?php echo $title; ?></h5>
                            <!-- Add link -->
                            <div class="float-left">
                                <a href="<?php echo base_url('manage_gallery/add'); ?>" class="btn crtglrybtn"><i class="plus"></i>Crear Galería</a>
                            </div>
                        </div>

                        <!-- Data list table -->
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="10%"></th>
                                    <th width="20%">Título</th>
                                    <th width="19%">Creado en</th>
                                    <th width="8%">Estado</th>
                                    <th width="10%">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($gallery)) {
                                    $i = 0;
                                    foreach ($gallery as $row) {
                                        $i++;
                                        $defaultImage = !empty($row['default_image']) ? '<img style="max-width:150px" src="' . $row['default_image'] . '" alt="" />' : '';
                                        $statusLink = ($row['status'] == 1) ? site_url('manage_gallery/block/' . $row['id']) : site_url('manage_gallery/unblock/' . $row['id']);
                                        $statusTooltip = ($row['status'] == 1) ? 'Click to Inactive' : 'Click to Active';
                                ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $defaultImage; ?></td>
                                            <td><?php echo $row['title']; ?></td>
                                            <td><?php echo $row['created']; ?></td>
                                            <td><a href="<?php echo $statusLink; ?>" title="<?php echo $statusTooltip; ?>"><span class="btn <?php echo ($row['status'] == 1) ? ' delbtn bg-success' : 'delbtn bg-secondary'; ?>"><?php echo ($row['status'] == 1) ? 'Active' : 'Inactive'; ?></span></a></td>
                                            <td>
                                                <a href="<?php echo base_url('manage_gallery/view/' . $row['id']); ?>" class="btn btn-sm viewbtn"><i class="fa fa-eye"></i> </a>
                                                <a href="<?php echo base_url('manage_gallery/edit/' . $row['id']); ?>" class="btn btn-sm editbtn"><i class=" fa fa-pencil-square-o"></i></a>
                                                <a href="<?php echo base_url('manage_gallery/delete/' . $row['id']); ?>" class="btn btn-sm delbtn" onclick="return confirm('Are you sure to delete data?')?true:false;"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="6">No se encontró galería ...</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
            <?php require(dirname(__FILE__) . '/../common/footer.php') ?>
        </div>

        <script type="text/javascript">
            
  $(function() {
        $(".alert").hide(6000);
    }); 
        </script>