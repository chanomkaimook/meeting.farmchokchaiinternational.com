<style>
.grid-container {
    display: grid;
    grid-template-columns: auto auto auto auto;
}

.grid-container-three {
    display: grid;
    grid-template-columns: auto auto auto;
}
</style>

<div class="content">
    <style>
    #frm_dash_filter_right .form-group {
        align-items: center;
        /* margin-bottom: 0; */
    }

    #frm_dash_filter_right .divform {
        display: flex;
        align-items: center;
    }

    .score_card .score p {
        margin-bottom: 0px;
    }

    .score_catagory .score p {
        margin-bottom: 0px;
    }

    .score_catagory .score {
        padding: 0px 15px;
    }
    </style>
    <!-- Start Content-->
    <div class="container-fluid">
        <!-- Filter -->
        <input type="hidden" id="hidden_datestart" name="hidden_datestart" value="">
        <input type="hidden" id="hidden_dateend" name="hidden_dateend" value="">
        <input type="hidden" id="hidden_userid" name="hidden_userid"
            value="<?= $this->session->userdata('user_code'); ?>">
        <div class="row mb-0 mb-sm-2">
            <div class="col-md-6 d-flex d-md-block tool_filter">
                <div class="flex-fill d-md-inline text-center">
                    <button class="btn btn-outline-light font-weight-bold text-uppercase" data-type="today" data-start="<? //= $today_s; 
																														?>" data-end="<? //= $today_e; 
																																		?>">today</button>
                </div>
                <div class="flex-fill d-md-inline text-center">
                    <button class="btn btn-outline-pink font-weight-bold text-uppercase" data-type="week" data-start="<? //= $week_s; 
																														?>" data-end="<? //= $week_e; 
																																		?>">weekly</button>
                </div>
                <div class="flex-fill d-md-inline text-center">
                    <button class="btn btn-outline-warning font-weight-bold text-uppercase" data-type="month"
                        data-start="<? //= $date_month_s; 
																															?>" data-end="<? //= $date_month_e; 
																																			?>">monthly</button>
                </div>
                <div class="flex-fill d-md-inline text-center">
                    <button class="btn btn-outline-info font-weight-bold text-uppercase" data-type="year" data-start="<? //= $date_year_s; 
																														?>" data-end="<? //= $date_year_e; 
																																		?>">yearly</button>
                </div>
            </div>

            <div id="frm_dash_filter_right"
                class="col-md-6 d-flex justify-content-center justify-content-md-end mt-2 mt-sm-0 ml-auto">
                <div class="divform">
                    <div class="form-group mb-2 mb-sm-0">
                        <input type="text" class="form-control form-control-sm" placeholder="วันเริ่ม"
                            id="datestart-autoclose" name="datestart-autoclose">
                    </div>
                </div>

                <div class="divform">
                    <div class="form-group ml-2 mb-2 mb-sm-0">
                        <input type="text" class="form-control form-control-sm" placeholder="วันสิ้นสุด"
                            id="dateend-autoclose" name="dateend-autoclose">
                    </div>

                </div>
            </div>

        </div>
        <!-- End Filter -->

        <!-- First Row -->
        <div class="row">

            <div class="col-xl-6 col-sm-6">
                <div class="card-box widget-box-two widget-two-custom">
                    <div class="media">
                        <div class="avatar-lg rounded-circle bg-primary widget-two-icon align-self-center">
                            <i class="mdi mdi-currency-usd avatar-title font-30 text-white"></i>
                        </div>

                        <div class="wigdet-two-content media-body">
                            <p class="m-0 text-uppercase font-weight-medium text-truncate" title="Statistics">กิจกรรม</p>
                            <h3 class="font-weight-medium my-2"><span data-plugin="counterup">25 </span>%</h3>
                            <p class="m-0">25 กิจกรรม</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->

            <div class="col-xl-6 col-sm-6">
                <div class="card-box widget-box-two widget-two-custom ">
                    <div class="media">
                        <div class="avatar-lg rounded-circle bg-primary widget-two-icon align-self-center">
                            <i class="mdi mdi-account-multiple avatar-title font-30 text-white"></i>
                        </div>

                        <div class="wigdet-two-content media-body">
                            <p class="m-0 text-uppercase font-weight-medium text-truncate" title="Statistics">การประชุม</p>
                            <h3 class="font-weight-medium my-2"> <span data-plugin="counterup">75 </span>%</h3>
                            <p class="m-0">75 การประชุม</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->

        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <h4 class="header-title">การให้ความร่วมมือของพนักงาน</h4>
                    <div class="text-center">
                        <div class="row">
                            <div class="col-4">
                                <div class="mt-3 mb-3">
                                    <h3 class="mb-2">500</h3>
                                    <p class="text-uppercase mb-1 font-13 font-weight-normal">พนักงานทั้งหมด</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mt-3 mb-3">
                                    <h3 class="mb-2">350</h3>
                                    <p class="text-uppercase mb-1 font-13 font-weight-normal">พนักงานที่ได้รับเชิญให้เข้าร่วม</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mt-3 mb-3">
                                    <h3 class="mb-2">329</h3>
                                    <p class="text-uppercase mb-1 font-13 font-weight-normal">พนักงานที่ตอบรับการเข้าร่วม</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="morris-bar-stacked" class="morris-charts" style="height: 310px;"></div>

                </div>

            </div><!-- end col -->

        </div>
        <!-- end row -->

    </div> <!-- end container-fluid -->

</div> <!-- end content -->

<style>
.sk-circle {
    margin: 0px auto;
    height: 26px;
}
</style>

<!-- Script -->
<?//php require_once('script.php') ?>
<?//php require_once('script_status.php') ?>
<?//php include('script_catagory.php') ?>
<?//php include('script_operator.php') ?>
<!-- End Script -->