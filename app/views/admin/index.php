	<!-- MAIN CONTENT -->
	<div class="main-content">
		<div class="container-fluid">
			<!-- OVERVIEW -->
			<div class="panel panel-headline">
				<div class="panel-heading">
					<h3 class="panel-title">Weekly Overview</h3>
					<p class="panel-subtitle">Period: Oct 14, 2016 - Oct 21, 2016</p>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-3">
							<div class="metric">
								<span class="icon"><i class="fa fa-download"></i></span>
								<p>
									<span class="number">0</span>
									<span class="title">Departments</span>
								</p>
							</div>
						</div>
						<div class="col-md-3">
							<div class="metric">
								<span class="icon"><i class="fa fa-shopping-bag"></i></span>
								<p>
									<span class="number">0</span>
									<span class="title">Packages</span>
								</p>
							</div>
						</div>
						<div class="col-md-3">
							<div class="metric">
								<span class="icon"><i class="fa fa-eye"></i></span>
								<p>
									<span class="number">0</span>
									<span class="title">Employees</span>
								</p>
							</div>
						</div>
						<div class="col-md-3">
							<div class="metric">
								<span class="icon"><i class="fa fa-bar-chart"></i></span>
								<p>
									<span class="number">35%</span>
									<span class="title">Conversions</span>
								</p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-10">
								<div id="headline-chart" class="ct-chart"></div>
							</div>
							<div class="col-md-2">
								<div class="weekly-summary text-right">
									<span class="number">0</span>
									<span class="info-label">Total Packages</span>
								</div>
								<div class="weekly-summary text-right">
									<span class="number">0</span>
									<span class="info-label">Packages per month</span>
								</div>
								<div class="weekly-summary text-right">
									<span class="number">0</span>
									<span class="info-label">Packages per week</span>
								</div>
							</div>
						</div>
					</div>
				<!--	<div class="row">
						<div class="col-md-offset-3 col-md-3">
							<a href="{{ route('images.index') }}">
								<div class="mgmt-btn">
									Images Managment
								</div>
							</a>
						</div>
						<div class="col-md-3">
							<a href="{{ route('categories.index') }}">
							<div class="mgmt-btn">
								Categories Managment
							</div>
							</a>
						</div>
					</div>
				</div>-->
			</div>
		<!-- END OVERVIEW -->
		</div>
	</div>
		<script>
			$(function() {
				var data, options;

				// headline charts
				data = {
					labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
					series: [
						[23, 29, 24, 40, 25, 24, 35],
						[14, 25, 18, 34, 29, 38, 44],
					]
				};

				options = {
					height: 300,
					showArea: true,
					showLine: false,
					showPoint: false,
					fullWidth: true,
					axisX: {
						showGrid: false
					},
					lineSmooth: false,
				};

				new Chartist.Line('#headline-chart', data, options);
			});
		</script>
	<!-- END MAIN CONTENT -->