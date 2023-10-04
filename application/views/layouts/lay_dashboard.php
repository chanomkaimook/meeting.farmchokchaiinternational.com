<?php
// path
$path_navbar = 'application/views/partials/e_nav.php';
$path_footer = 'application/views/partials/e_footer.php';
$path_head_link = 'application/views/partials/e_head_link.php';
$path_head_title = 'application/views/partials/e_head_title.php';
$path_script_begin = 'application/views/partials/e_script_begin.php';
$path_script_end = 'application/views/partials/e_script_end.php';
$path_script = 'application/views/partials/e_script.php';
?>

<!DOCTYPE html>
<html lang="en">
<style>
    .card {
        height: 1090px;
    }

    footer {
        position: fixed !important;
        bottom: 0 !important;
    }
</style>

<head>
    <!-- Head title -->
    <?php include($path_head_title); ?>

    <!-- third party css -->
    <link href="<?= base_url('') ?>asset/libs/datatables/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />

    <link href="<?= base_url('') ?>asset/plugins/datatablebutton/datatables.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('') ?>asset/libs/datatables/responsive.bootstrap4.css" rel="stylesheet" type="text/css" />

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

    <!-- Chart JS -->
    <!-- <script src="<?= base_url('') ?>asset/libs/chart-js/Chart.bundle.min.js"></script> -->
    <script src="<?= base_url('') ?>asset/plugins/chartjs/chartjs.min.js"></script>
    <!-- <script src="<?= base_url('') ?>asset/js/pages/chartjs.init.js"></script> -->

    <!-- Required datatable js -->
    <script src="<?= base_url('') ?>asset/libs/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('') ?>asset/libs/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Buttons examples -->
    <script src="<?= base_url('') ?>asset/plugins/datatablebutton/datatables.min.js"></script>

    <!-- Responsive examples -->
    <script src="<?= base_url('') ?>asset/libs/datatables/dataTables.responsive.min.js"></script>
    <script src="<?= base_url('') ?>asset/libs/datatables/responsive.bootstrap4.min.js"></script>

    <!-- Datatables init -->
    <script src="<?= base_url('') ?>asset/js/pages/datatables.init.js"></script>

    <!-- Script End -->
    <?php include($path_script_end); ?>

</body>

</html>