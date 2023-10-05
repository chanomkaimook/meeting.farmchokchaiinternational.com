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
		<input type="hidden" id="hidden_userid" name="hidden_userid" value="<?= $this->session->userdata('user_code'); ?>">
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
					<button class="btn btn-outline-warning font-weight-bold text-uppercase" data-type="month" data-start="<? //= $date_month_s; 
																															?>" data-end="<? //= $date_month_e; 
																																			?>">monthly</button>
				</div>
				<div class="flex-fill d-md-inline text-center">
					<button class="btn btn-outline-info font-weight-bold text-uppercase" data-type="year" data-start="<? //= $date_year_s; 
																														?>" data-end="<? //= $date_year_e; 
																																		?>">yearly</button>
				</div>
			</div>

			<div id="frm_dash_filter_right" class="col-md-6 d-flex justify-content-center justify-content-md-end mt-2 mt-sm-0 ml-auto">
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
			<div class="col-xl-4 col-sm-6">
				<div class="card-box widget-box-four">
					<div id="dashboard-1" class="widget-box-four-chart"></div>
					<div class="float-left">
						<h4 class="mt-0 font-15 font-weight-medium mb-1 text-overflow" title="Total Revenue">น้ำหนักข้าวโพด</h4>
						<p class="font-secondary text-muted">Oct 2023</p>
						<h3 class="mb-0 mt-2"> <span data-plugin="counterup">1,500</span> <span>กิโลกรัม</span></h3>
					</div>
					<div class="clearfix"></div>
				</div>
			</div><!-- end col -->

			<div class="col-xl-4 col-sm-6">
				<div class="card-box widget-box-four">
					<div id="dashboard-2" class="widget-box-four-chart"></div>
					<div class="float-left">
						<h4 class="mt-0 font-15 mb-1 font-weight-medium text-overflow" title="Total Unique Visitors">ปริมาณหยดน้ำ</h4>
						<p class="font-secondary text-muted">Oct 2023</p>
						<h3 class="mb-0 mt-2"> <span data-plugin="counterup">500</span> <span>หยด</span></h3>
					</div>
					<div class="clearfix"></div>
				</div>
			</div><!-- end col -->

			<div class="col-xl-4 col-sm-6">
				<div class="card-box widget-box-four">
					<div id="dashboard-3" class="widget-box-four-chart"></div>
					<div class="float-left">
						<h4 class="mt-0 font-15 mb-1 font-weight-medium text-overflow" title="Number of Transactions">น้ำหนักหิน</h4>
						<p class="font-secondary text-muted">Oct 2023</p>
						<h3 class="mb-0 mt-2"> <span data-plugin="counterup">250</span> <span>กิโลกรัม</span></h3>
					</div>
					<div class="clearfix"></div>
				</div>
			</div><!-- end col -->

		</div>
		<!-- end row -->

		<div class="row">
			<div class="col-12">
				<div class="card-box">
					<h4 class="header-title">พื้นที่จัดเก็บข้อมูล</h4>
					<div class="text-center">
						<div class="row">
							<div class="col-4">
								<div class="mt-3 mb-3">
									<h3 class="mb-2">150 <span>TB</span></h3>
									<p class="text-uppercase mb-1 font-13 font-weight-normal">พื้นที่ทั้งหมด</p>
								</div>
							</div>
							<div class="col-4">
								<div class="mt-3 mb-3">
									<h3 class="mb-2">0.1 <span>TB</span></h3>
									<p class="text-uppercase mb-1 font-13 font-weight-normal">ใช้ไปแล้ว</p>
								</div>
							</div>
							<div class="col-4">
								<div class="mt-3 mb-3">
									<h3 class="mb-2">149.9 <span>TB</span></h3>
									<p class="text-uppercase mb-1 font-13 font-weight-normal">พื้นที่คงเหลือที่ใช้ได้</p>
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
<script>
	$(document).ready(function() {
		function donut_chart(donut, array = null) {
			let typeArray = [],
				totalArray = []
			get_data(donut, null)
				.then((data) => {
					let type, total
					for (let i = 1; i <= 8; i++) {
						type = data['donut'][i].TYPE
						total = data['donut'][i].TOTAL

						typeArray.push(type)
						totalArray.push(total)
					}

					var dtx = document.getElementById("donut");
					var donut = new Chart(dtx, {
						// type: 'bar',
						// type: 'line',
						type: 'doughnut',
						data: {
							labels: typeArray,
							datasets: [{
								label: typeArray[0],
								data: totalArray,
								backgroundColor: [
									'#007AFF',
									'#D20000',
									'#007355',
									'#2A37FF',
									'#FFC900',
									'#FF6100',
									'#8E8E8E',
									'#17D9FF',
									'#BF55FF'

								],
								borderColor: [
									'#007AFF',
									'#D20000',
									'#007355',
									'#2A37FF',
									'#FFC900',
									'#FF6100',
									'#8E8E8E',
									'#17D9FF',
									'#BF55FF'
								],
								borderWidth: 0
							}]
						},
						options: {
							responsive: true,
							title: {
								display: true,
								text: 'สถิติการใช้สิทธิ์ลา'
							}
						}
					});
				})
		}

		function line_chart(line) {
			let divisionArray = [],
				calArray = [],
				altArray = [],
				totalArray = [],
				total
			get_data(line)
				.then((data) => {
					for (let d = 0; d < data['line']['DIVISION'].length; d++) {
						divisionArray.push(data['line']['DIVISION'][d]['department'])
					}

					for (let i = 0; i < divisionArray.length; i++) {
						calArray.push(data['line'][divisionArray[i]]['calendar'])
						altArray.push(data['line'][divisionArray[i]]['alternate'])

						total = parseInt(calArray[i]) + parseInt(altArray[i])
						totalArray.push(total)
					}

					var ltx = document.getElementById("line");
					var line = new Chart(ltx, {
						type: 'bar',
						// type: 'line',
						// type: 'doughnut',
						data: {
							labels: divisionArray,
							datasets: [{
								label: 'ใช้ไป',
								data: totalArray,
								fill: false,
								backgroundColor: [
									'#007AFF',
									'#D20000',
									'#007355',
									'#2A37FF',
									'#FFC900',
									'#FF6100',
									'#8E8E8E',
									'#17D9FF',
									'#BF55FF'

								],
								borderColor: [
									'#007AFF',
									'#D20000',
									'#007355',
									'#2A37FF',
									'#FFC900',
									'#FF6100',
									'#8E8E8E',
									'#17D9FF',
									'#BF55FF'

								],
								borderWidth: 2
								/*	},
								{
									label: divisionArray[1]['department'],
									data: ADMINArray,
									fill: false,
									tension: 0.1,
									borderColor: '#D20000',
									borderWidth: 2
									},
								{
									label: '',
									data: '',
									fill: false,
									tension: 0.1,
									borderColor: '#007355',
									borderWidth: 1
									},
										 {
												label: 'ฝ่าย CMK',
												data: usedArray,
												borderColor: '#2A37FF',
												borderWidth: 1
											},
											{
												label: 'ฝ่ายสำนักงาน',
												data: usedArray,
												borderColor: '#FFC900',
												borderWidth: 1
											},
											{
												label: 'ฝ่ายการเงิน',
												data: usedArray,
												borderColor: '#FF6100',
												borderWidth: 1
											},
											{
												label: 'ฝ่ายบัญชี',
												data: usedArray,
												borderColor: '#8E8E8E',
												borderWidth: 1
											},
											{
												label: 'ฝ่ายเบเกอรี่',
												data: usedArray,
												borderColor: '#17D9FF',
												borderWidth: 1
											},
											{
												label: 'ฝ่ายขาย และการตลาด',
												data: usedArray,
												borderColor: '#BF55FF'
												borderWidth: 1 */
							}],
						},
						options: {
							responsive: true,
							title: {
								display: true,
								text: 'สถิติการลาประจำปี'
							}
						}
					});
				})
		}
	})
</script>