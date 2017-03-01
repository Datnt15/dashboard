<!-- Main content -->
<div class="content-wrapper">

	<!-- Content area -->
	<div class="content">
		<div class="container">
			
			<div class="row">
				<div class="col-lg-6 pull-left">
					<h6 class="panel-title">Reporting</h6>
				</div>
				<div class="col-lg-6 pull-right text-right">
					<!-- Group by -->
					<div class="btn-group btn-group-animated">
		                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
		                	Group by <span class="caret"></span>
		                </button>
						<ul class="dropdown-menu">
							<li>
								<a href="./index.php/report/host">
									<i class="icon-menu7"></i> Host
								</a>
							</li>
							<li>
								<a href="./index.php/report/malware">
									<i class="icon-screen-full"></i> Malware
								</a>
							</li>
						</ul>
		            </div>

					<!-- Group by -->
					<div class="btn-group btn-group-animated">
		                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
		                	Duration <span class="caret"></span>
		                </button>
						<ul class="dropdown-menu">
							<li>
								<a href="./index.php/report/weekly">
									<i class="icon-screen-full"></i> Weekly(host)
								</a>
							</li>
							<li>
								<a href="./index.php/report/monthly">
									<i class="icon-menu7"></i> Monthly(host)
								</a>
							</li>
							<li>
								<a href="./index.php/report/yearly">
									<i class="icon-menu7"></i> Yearly(host)
								</a>
							</li>
							<li>
								<a href="./index.php/report/weekly/malware">
									<i class="icon-screen-full"></i> Weekly(malware)
								</a>
							</li>
							<li>
								<a href="./index.php/report/monthly/malware">
									<i class="icon-menu7"></i> Monthly(malware)
								</a>
							</li>
							<li>
								<a href="./index.php/report/yearly/malware">
									<i class="icon-menu7"></i> Yearly(malware)
								</a>
							</li>
						</ul>
		            </div>

		            <!-- Convert HTML -->
		            <!-- <button type="button" class="btn btn-primary btn-ladda btn-ladda-progress" data-style="zoom-in">
		            	<span class="ladda-label">Convert to HTML</span>
		            </button> -->

		            <!-- Convert PDF -->
		            <button type="button" id="save_as_pdf" class="btn btn-primary btn-ladda btn-ladda-progress" data-style="zoom-in">
		            	<span class="ladda-label">Convert to PDF</span>
		            </button>
				</div>
			</div>
		</div>
		<div class="container" id="pdf_content">
			<br>
			<div class="row well">
                <ul class="list list-icons no-margin-bottom">
					<?php foreach ($incidents as $inc) {?>
						<li class="col-lg-2" style="cursor: pointer;">
							<i class="icon-screen-full"></i> 
							<?php echo $inc; ?>
						</li>
					<?php } ?>
				</ul>
			</div>
			<br>
			<div class="row">
				<div class="panel panel-success">
					<div class="panel-heading">
						<h3 class="panel-title"><?php echo $incidents[0]; ?></h3>
					</div>
					<?php $host_info = $this->mongo_db->where(array('src_ip' => $incidents[0]))->get('incidents'); 
						$malwares = array();
						$name_mal = array();
						foreach ($host_info as $inc) {
							$mal = $this->mongo_db->where(array('id' => $inc['rule']))->get('mf');
							if (!empty($mal) && !in_array( $mal[0]['name'], $name_mal) ) {
								$malwares[] = $mal[0];
								$name_mal[] = $mal[0]['name'];
							}
						}
					?>
					<div class="panel-body">
						<div class="table-responsive" id="my-table">
							<table class="table datatable-columns table-striped">
								<thead>
									<tr>
										<th>Name</th>
										<th>Events</th>
										<th>Fisrt</th>
										<th>Last</th>
										<th>Impact</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($malwares as $mal) {
										$incident = $this->mongo_db->where(array('rule' => $mal['id']))->find_one('incidents');
										$name = '';
										$impact = 100;
										$name = $mal['name'];
										if (isset($mal['impact'])) {
											$impact = $mal['impact'];
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
										<tr data-id="<?php echo (string) $mal['_id']; ?>">
											<td><?php echo $name;?></td>
											<td><?php echo $incident['count'];?></td>
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
							<p></p>
							<div class="mal_info">
								<p>Name: <?php echo $malwares[0]['name'];?></p>
								<p>References: <?php echo implode(", ", $malwares[0]['references']);?></p>
								<p>Tags: <?php echo implode(", ", $malwares[0]['tags']);?></p>
								<p>Groups: <?php echo isset($malwares[0]['in_group']) ? $malwares[0]['in_group'] : "";?></p>
								<p>Industries: <?php echo implode(", ", $malwares[0]['industries']);?></p>
								<p>Targeted Countries: <?php echo implode(", ", $malwares[0]['targeted_countries']);?></p>
								<p>Description: <?php echo $malwares[0]['description'];?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(".list").on('click', 'li', function(event) {
			var host = $(this).children().remove().end().text().trim();
			$.post(
				$("base").attr('href') + 'index.php/report/get_malware', 
				{host: host}, 
				function(data) {
					$(".panel.panel-success").html(data);
				}
			);
		});
		$(".panel.panel-success").on('click', '.panel-body .table tbody tr', function(event) {
			$.post(
				$("base").attr('href') + 'index.php/report/get_malware', 
				{mal_id: $(this).attr('data-id')}, 
				function(data) {
					$(".panel.panel-success .panel-body .mal_info").html(data);
				}
			);
		});
	});
</script>
