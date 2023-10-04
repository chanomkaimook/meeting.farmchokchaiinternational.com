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
<?php
#
# Setting
#
#
$html_text_totalTicket = "จำนวนใบงาน";
$html_text_totalDefect = "จำนวนงาน defect";
$html_text_totalDefectScore = "รวมคะแนน defect";
$html_text_avgTicket = "ค่าเฉลี่ยใบงาน";
?>
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
		<input type="hidden" id="hidden_userid" name="hidden_userid" value="">
		<div class="row mb-0 mb-sm-2">
			<div class="col-md-6 d-flex d-md-block tool_filter">
				<div class="flex-fill d-md-inline text-center">
					<button class="btn btn-outline-light font-weight-bold text-uppercase" data-type="today" data-start="<?= $today_s; ?>" data-end="<?= $today_e; ?>">today</button>
				</div>
				<div class="flex-fill d-md-inline text-center">
					<button class="btn btn-outline-pink font-weight-bold text-uppercase" data-type="week" data-start="<?= $week_s; ?>" data-end="<?= $week_e; ?>">weekly</button>
				</div>
				<div class="flex-fill d-md-inline text-center">
					<button class="btn btn-outline-warning font-weight-bold text-uppercase" data-type="month" data-start="<?= $date_month_s; ?>" data-end="<?= $date_month_e; ?>">monthly</button>
				</div>
				<div class="flex-fill d-md-inline text-center">
					<button class="btn btn-outline-info font-weight-bold text-uppercase" data-type="year" data-start="<?= $date_year_s; ?>" data-end="<?= $date_year_e; ?>">yearly</button>
				</div>
			</div>

			<div id="frm_dash_filter_right" class="col-md-6 d-flex justify-content-center justify-content-md-end mt-2 mt-sm-0 ml-auto">
				<div class="divform">
					<div class="form-group mr-2 mb-2 mb-sm-0">
						<select name="operator" class="form-control form-control-sm">
							<option value="">ทั้งหมด</option>
							<?php if ($test) {
								foreach ($test as $row) {
							?>
									<option value="<?= $row->ID; ?>"><?= $row->staff_name; ?></option>
							<?php
								}
							}
							?>
						</select>
					</div>
				</div>
				<div class="divform">
					<div class="form-group mb-2 mb-sm-0">
						<input type="text" class="form-control form-control-sm" placeholder="วันเริ่ม" id="datestart-autoclose" name="datestart-autoclose">
					</div>
				</div>

				<div class="divform">
					<div class="form-group ml-2 mb-2 mb-sm-0">
						<input type="text" class="form-control form-control-sm" placeholder="วันสิ้นสุด" id="dateend-autoclose" name="dateend-autoclose">
					</div>

				</div>
			</div>

		</div>
		<!-- End Filter -->

		<!-- First Row -->
		<div class="row">

			<!-- CardBox -->
			<div class="col-md-3 score_card">
				<div class="card-box">
					<div class="text-center d-none">
						<div class="company-detail">
							<h4 class="mb-1 text-truncate text-danger">รอดำเนินการ</h4>
							<span><?= $html_text_totalTicket ?></span>
						</div>
						<div class="score score_waite font-weight-normal">
							<h1 class="text-danger"> <span data-plugin="counterup"></span></h1>
							<p class="score_avg text-danger"><span class="percent"></span> จากรวม</p>
						</div>
					</div>
				</div>
			</div>
			<!-- End CardBox -->
			<!-- CardBox -->
			<div class="col-md-3 score_card">
				<div class="card-box">
					<div class="text-center d-none">
						<div class="company-detail">
							<h4 class="mb-1 text-truncate text-warning">กำลังทำ</h4>
							<span><?= $html_text_totalTicket ?></span>
						</div>
						<div class="score score_doing font-weight-normal">
							<h1 class="text-warning"> <span data-plugin="counterup"></span></h1>
							<p class="score_avg text-warning"><span class="percent"></span> จากรวม</p>
						</div>
					</div>
				</div>
			</div>
			<!-- End CardBox -->
			<!-- CardBox -->
			<div class="col-md-3 score_card ">
				<div class="card-box">
					<div class="text-center d-none">
						<div class="company-detail">
							<h4 class="mb-1 text-truncate text-success">ทำสำเร็จ</h4>
							<span><?= $html_text_totalTicket ?></span>
						</div>
						<div class="score score_success font-weight-normal">
							<h1 class="text-success"> <span data-plugin="counterup"></span></h1>
							<p class="score_avg text-success"><span class="percent"></span> จากรวม</p>
						</div>
					</div>
				</div>
			</div>
			<!-- End CardBox -->
			<!-- CardBox -->
			<div class="col-md-3 score_card">
				<div class="card-box">
					<div class="text-center d-none">
						<div class="company-detail">
							<h4 class="mb-1 text-truncate text-purple">รวม</h4>
							<span><?= $html_text_totalTicket ?></span>
						</div>
						<div class="score score_all font-weight-normal">
							<h1 class="text-purple"> <span data-plugin="counterup"></span></h1>
							<p class="score_avg text-purple"><span class="percent"></span> จากทั้งหมด</p>
						</div>
					</div>
				</div>
			</div>
			<!-- End CardBox -->

		</div>
		<!-- End First Row -->

		<!-- First Row -->
		<div class="row">
			<div class="col-md-3 score_card">
				<div class="card-box">
					<div class="text-center d-none">
						<div class="company-detail">
							<h4 class="mb-1 text-truncate text-primary">Defect</h4>
							<span><?= $html_text_totalDefectScore ?></span>
						</div>
						<div class="score score_defectall font-weight-normal">
							<h1 class="text-primary"> <span data-plugin="counterup"></span></h1>
							<p class="score_avg text-primary"><span class="percent"></span> จากทั้งหมด</p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3 score_card">
				<div class="card-box">
					<div class="text-center d-none">
						<div class="company-detail">
							<h4 class="mb-1 text-truncate text-info">ใบงาน</h4>
							<span><?= $html_text_avgTicket ?></span>
						</div>
						<div class="score score_ticketavg font-weight-normal">
							<h1 class="text-info"> <span data-plugin="counterup"></span></h1>
							<p class="score_avg text-info"><span class="percent"></span> จากทั้งหมด</p>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-6 score_graph">
				<div class="card-box">
					<div class="chart-container">
						<canvas id="bar_operator"></canvas>
					</div>

				</div>
			</div>

		</div>
		<!-- End First Row -->

		<div class="row">
			<div class="col-md-12">
				<div class="card-box">
					<h4 class="header-title">
						ข้อมูลประเภทงาน <?= $is_mobile; ?>
						<button type="button" class="btn btn-sm btn-primary float-right" data-toggle="collapse" data-target="#graph">ดูข้อมูล</button>
					</h4>
					<div class="card-body">
						<div class="score_catagory d-flex flex-wrap ">

						</div>
					</div>

					<div id="graph" class="collapse">
						<!-- <style>
							.chart-container {
								position: realtive;
								margin: auto;
								height: <?= $barchart_height; ?>px;
								max-height:<?= $barchart_height; ?>px;
							}
						</style> -->
						<div class="chart-container d-none">
							<canvas id="bar"></canvas>
						</div>
						<div class="row mt-2">
							<div class="col-md-4 text-center">
								<div class="chart-container d-none">
									<canvas id="pie" class="mx-auto"></canvas>
									<p>ภาพรวม</p>
								</div>
							</div>
							<div class="col-md-4 text-center">
								<div class="chart-container d-none">
									<canvas id="doughnut" class="mx-auto"></canvas>
									<p>งานที่ทำเสร็จ</p>
								</div>
							</div>
							<div class="col-md-4 text-center">
								<div class="chart-container d-none">
									<canvas id="pie_compare" class="mx-auto"></canvas>
									<p>เทียบปริมาณทั้งหมด</p>
								</div>
							</div>


						</div>

					</div>


				</div>
			</div>
		</div>


		<div class="row">
			<div class="col-12">
				<div class="card-box table-responsive">
					<div class="row">
						<div class="col-md-12">

							<div class="filter">
								<?php //require_once 'application/views/partials/e_filter_doc_order.php'; 
								?>
							</div>
						</div>
					</div>
					<table id="datatable_operator" class="table dt-responsive nowrap d-none" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
						<thead>
							<tr>
								<th>#</th>
								<th>Task</th>
								<th>ประเภท</th>
								<th>สถานะ</th>
								<th>ฝ่าย</th>
								<th>โดย</th>
								<th>OP</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
			</div>
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
<?php require_once('script.php') ?>
<?php require_once('script_status.php') ?>
<?php include('script_catagory.php') ?>
<?php include('script_operator.php') ?>
<!-- End Script -->