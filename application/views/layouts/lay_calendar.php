<?php
// path
$path_navbar = 'application/views/partials/e_nav.php';
$path_footer = 'application/views/partials/e_footer.php';
$path_head_link = 'application/views/partials/e_head_link.php';
$path_head_title = 'application/views/partials/e_head_title.php';
$path_script_begin = 'application/views/partials/e_script_begin.php';
$path_script_end = 'application/views/partials/e_script_end.php';
?>

<!DOCTYPE html>
<html lang="en">
<style>
    .card {
        height: 100%;
    }

    footer {
        position: fixed !important;
        bottom: 0 !important;
    }
</style>

<head>
    <!-- Head title -->
    <?php include($path_head_title); ?>

    <!-- Plugin css -->
    <link rel="stylesheet" href="<?= base_url('') ?>asset/plugins/jquery/ui/1.13.2/jquery-ui.css" />

    <link href="<?= base_url('') ?>asset/libs/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" />

    <link href="<?= base_url('') ?>asset/libs/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->

    <link href="<?= base_url('') ?>asset/libs/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />

    <!-- Link main -->
    <?php include($path_head_link); ?>
</head>

<body data-layout="horizontal">

    <!-- Begin page -->
    <div id="wrapper">
        <!-- Topbar Start -->
        <?php include($path_navbar); ?>
        <!-- end Topbar -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
        <div class="content-page">

            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title"><?php echo $template['title']; ?></h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <?php echo $template['body']; ?>

                </div> <!-- end container-fluid -->

            </div> <!-- end content -->


            <!-- Footer Start -->
            <?php include($path_footer); ?>
            <!-- end Footer -->

        </div>
        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

    <!-- Script Begin -->
    <?php include($path_script_begin); ?>

    <!-- plugin js -->
    <script src="<?= base_url('') ?>asset/libs/moment/moment.min.js"></script>
    <script src="<?= base_url('') ?>asset/plugins/jquery/ui/1.13.2/jquery-ui.js"></script>
    <script src="<?= base_url('') ?>asset/libs/fullcalendar/fullcalendar.min.js"></script>
    
    <script src="<?= base_url('') ?>asset/libs/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>

    <script src="<?= base_url('') ?>asset/libs/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    
    <!-- Script End -->
    <?php include($path_script_end); ?>

</body>

</html>