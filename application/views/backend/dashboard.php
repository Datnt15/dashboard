<!-- Main content -->
<div class="content-wrapper">

	<!-- Content area -->
	<div class="content">

		

		<!-- Custom markers -->
		<div class="panel panel-flat">
			<div class="panel-heading">
				<h1 class="panel-title text-center">Top 10 countries detected of cyber attack on Vietnam</h1>
				<div class="heading-elements">
					<ul class="icons-list">
                		<li><a data-action="collapse"></a></li>
                		<!-- <li><a data-action="reload"></a></li> -->
                		<li><a data-action="close"></a></li>
                	</ul>
            	</div>
			</div>

			<div class="panel-body">
				<div class="map-container map-world-markers"></div>
				<div class="map-regions"></div>
				<div class="map-unemployment"></div>
				<table class="table" id="top-attack-country">
					<thead>
						<th>#</th>
						<th>Country</th>
						<th>Attacks</th>
						<th>Percent</th>
					</thead>
					<tbody>
						
					</tbody>
				</table>
			</div>
		</div>
		<!-- /custom markers -->

		<div class="row list">
			<div class="col-lg-6 col-xs-12 list-item">
				
				<!-- Basic bar chart -->
				<div class="panel panel-flat">
					<div class="panel-heading">
						<h2 class="panel-title">Events statistics</h2>
						<div class="heading-elements">
							<ul class="icons-list">
		                		<li><a data-action="collapse"></a></li>
		                		<!-- <li><a data-action="reload"></a></li> -->
		                		<li><a data-action="close"></a></li>
		                	</ul>
	                	</div>
					</div>

					<div class="panel-body">
						<div class="chart-container">
							<div class="chart" id="dimple-bar-horizontal"></div>
						</div>
					</div>
				</div>
				<!-- /basic bar chart -->
				
			</div>
			<div class="col-lg-6 col-xs-12 list-item">
				<!-- Pie chart timeline -->
				<div class="panel panel-flat">
					<div class="panel-heading">
						<h2 class="panel-title">Top 10 malwares</h2>
						<div class="heading-elements">
							<ul class="icons-list">
		                		<li><a data-action="collapse"></a></li>
		                		<!-- <li><a data-action="reload"></a></li> -->
		                		<li><a data-action="close"></a></li>
		                	</ul>
	                	</div>
					</div>

					<div class="panel-body">
						<div class="chart-container has-scroll">
							<div class="chart has-fixed-height has-minimum-width" id="pie_timeline"></div>
						</div>
					</div>
				</div>
				<!-- /pie chart timeline -->
			</div>
		</div>

		<!-- Marketing campaigns -->
		<div class="row list">
			<div class="col-lg-6 col-xs-12 list-item">
				<div class="panel panel-flat">
					<div class="panel-heading">
						<h2 class="panel-title">Unexpected Connections</h2>
						<div class="heading-elements">
							<ul class="icons-list">
		                		<li><a data-action="collapse"></a></li>
		                		<!-- <li><a data-action="reload"></a></li> -->
		                		<li><a data-action="close"></a></li>
		                	</ul>
	                	</div>
					</div>


					<div class="table-responsive" id="my-table">
						<table class="table datatable-columns table-striped table-hover datatable-basic datatable-select-multiple dataTable table-responsive">
							<thead>
								<tr>
									<th>Internal host</th>
									<th>Events</th>
									<th>Name</th>
									<th>First</th>
									<th>Last</th>
									<th>Impact</th>
								</tr>
							</thead>
							<tbody>

								<?php foreach ($incidents as $incident) {
									$name_data = $this->mongo_db->where(array('id' => $incident['rule']))->find_one('mf');
									$name = '';
									$impact = 100;
									if (!empty($name_data)) {
										$name = $name_data['name'];
										if (isset($name_data['impact'])) {
											$impact = $name_data['impact'];
										}
									}
									$label_class = "label-";
									if ($impact < 40) {
										$label_class .= "success";
									}
									elseif($impact < 60){
										$label_class .= "info";
									}
									elseif($impact < 80){
										$label_class .= "warning";
									}else{
										$label_class .= "danger";
									}
									?>
									<tr>
										<td><?php echo $incident['src_ip'];?></td>
										<td><?php echo $incident['count'];?></td>
										<td><?php echo $name;?></td>
										<td><?php echo @date("Y-m-d H:i", $incident['firstseen']->sec);?></td>
										<td><?php echo @date("Y-m-d H:i", $incident['lastseen']->sec);?></td>
										<td>
											<h4>
												<span class="label <?php echo $label_class; ?>">
													<?php echo $impact;?>
												</span>
											</h4>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-lg-6 col-xs-12 list-item">
				<!-- Non-ribbon chord -->
				<div class="panel panel-flat">
					<div class="panel-heading">
						<h2 class="panel-title">Top connected domains </h2>
						<div class="heading-elements">
							<ul class="icons-list">
		                		<li><a data-action="collapse"></a></li>
		                		<!-- <li><a data-action="reload"></a></li> -->
		                		<li><a data-action="close"></a></li>
		                	</ul>
	                	</div>
					</div>

					<div class="panel-body">
						<div class="chart-container has-scroll">
							<div class="chart has-fixed-height has-minimum-width" id="chord_non_ribbon"></div>
						</div>
					</div>
				</div>
				<!-- /non-ribbon chord -->
			</div>
		</div>
		<!-- /marketing campaigns -->


		<!-- Footer -->
		<div class="footer text-muted">
			&copy; 2015. <a href="#">Limitless Web App Kit</a> by <a href="http://themeforest.net/user/Kopyov" target="_blank">Eugene Kopyov</a>
		</div>
		<!-- /footer -->

	</div>
	<!-- /content area -->

</div>
<!-- /main content -->




	