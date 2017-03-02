
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<base href="<?php echo base_url(); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $title; ?></title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="assets/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="assets/css/icons/fontawesome/styles.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/core.css" rel="stylesheet" type="text/css">
	<link href="assets/css/components.css" rel="stylesheet" type="text/css">
	<link href="assets/css/colors.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->
	<style>
		.list
			{
			    display: -webkit-flex;
			    display: -ms-flexbox;
			    display: flex;
			 
			    -webkit-flex-wrap: wrap;
			    -ms-flex-wrap: wrap;
			    flex-wrap: wrap;
				// overflow: hidden;
			}
		/*.table > thead > tr > th,.table > tbody > tr > td{
			padding: 10px 5px;
		}*/
	</style>
	<!-- Core JS files -->
	<script type="text/javascript" src="assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script type="text/javascript" src="assets/js/plugins/visualization/d3/d3.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
	<script type="text/javascript" src="assets/js/plugins/visualization/d3/venn.js"></script>
	<script type="text/javascript" src="assets/js/plugins/visualization/dimple/dimple.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/styling/switchery.min.js"></script>
	<script type="text/javascript" src="assets/js/core/app.js"></script>
	<script type="text/javascript" src="assets/js/charts/dimple/bars/bar_horizontal.js"></script>
	<script type="text/javascript" src="assets/js/charts/d3/venn/venn_basic.js"></script>
	<script type="text/javascript" src="assets/js/charts/d3/venn/venn_colors.js"></script>
	<script type="text/javascript" src="assets/js/charts/d3/venn/venn_rings.js"></script>
	<script type="text/javascript" src="assets/js/charts/d3/venn/venn_weighted.js"></script>
	<script type="text/javascript" src="assets/js/charts/d3/venn/venn_interactive.js"></script>
	<script type="text/javascript" src="assets/js/charts/d3/venn/venn_tooltip.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
	<script type="text/javascript" src="assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/ui/headroom/headroom.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/ui/headroom/headroom_jquery.min.js"></script>
	
	<!-- Setting variable -->
	<script type="text/javascript">
		var data_event = [],data_incident = [],data_marker = [], legend_data = [], nodes_data = [], links_data = [], pie_legend_data = [], pies_series_data = [], data_map_table = [];
		<?php 
		// Set event data
		foreach ($events as $event) {
			echo "data_event.push(" . $event['ts']->usec . ");";
		} 

		foreach ($this->mongo_db->distinct("events", "resp_h") as $ip) {
			// Tu IP lay ra ten dia chi
			// Cai nay k có ten nuoc
			// nên em phải dùng thêm cái dưới
			$data = (array) json_decode(file_get_contents("http://ipinfo.io/{$ip}"));

			if (isset($data['region']) && $data['region'] != '' ) {
				// Lấy ra địa chỉ quốc gia từ tên thành phố
				$country = (array) json_decode(file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?latlng=".$data['loc']."&sensor=false"));
				if (isset($country['results'][2]->address_components[3])) {
					$country = $country['results'][2]->address_components[3];
					echo "data_marker.push({latLng: [".$data['loc']."], name: '".$country->long_name."'});";
					echo "data_map_table.push(['".$country->long_name."','assets/images/flags/".strtolower($country->short_name).".png','".$this->mongo_db->where("resp_h", $ip)->count('events')."']);";
				}
			}
		}
		foreach ($incidents as $incident) {
			echo "data_incident.push(" . $incident['firstseen']->usec . ");";
		} 
		foreach ($domain_connect as $key => $value) {
			echo "legend_data.push('".$value."');";
			echo "nodes_data.push({name:'".$value."'});";
		}

		foreach ($nodes as $node) {
			echo "nodes_data.push({name:'".$node['orig_h']."'});";
			echo "links_data.push({source: '".$node['host']."', target: '".$node['orig_h']."', weight: 0.9, name: 'Effectiveness'});";
			echo "links_data.push({target: '".$node['host']."', source: '".$node['orig_h']."', weight: 1});";
		}
		$i = 0;
		foreach ($mfs as $mf) {
			if ($i++ > 9) {
				break;
			}
			$name = implode(' ', array_slice(explode(' ', $mf['name']), 0, 5));
			echo "pie_legend_data.push('".$name."');";
			?>
			pies_series_data.push({
				value: <?php echo $mf['revision'];?>, name: '<?php echo $name; ?>'
			});
		<?php }

		?>
	</script>
	<script type="text/javascript" src="assets/js/pages/datatables_advanced.js"></script>
	<script type="text/javascript" src="assets/js/charts/echarts/pies_donuts.js"></script>
	<script type="text/javascript" src="assets/js/plugins/visualization/echarts/echarts.js"></script>
	<!-- <script type="text/javascript" src="assets/js/charts/echarts/timeline_option.js"></script> -->
	<script type="text/javascript" src="assets/js/charts/echarts/funnels_chords.js"></script>
	<script type="text/javascript" src="assets/js/plugins/maps/jvectormap/jvectormap.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/maps/jvectormap/map_files/world.js"></script>
	<script type="text/javascript" src="assets/demo_data/maps/vector/gdp_demo_data.js"></script>
	<script type="text/javascript" src="assets/js/pages/dashboard_main.js"></script>
	<script type="text/javascript" src="assets/js/maps/vector/vector_maps_demo.js"></script>
	<!-- <script type="text/javascript" src="assets/js/plugins/ui/ripple.min.js"></script> -->
	<!-- <script type="text/javascript" src="assets/js/set-height.js"></script> -->
	<!-- /theme JS files -->


</head>
<body>
	<!-- Main navbar -->
	<div class="navbar navbar-default navbar-component">
		<div class="navbar-header">
			<ul class="nav navbar-nav visible-xs-block">
				<li>
					<a data-toggle="collapse" data-target="#navbar-mobile">
						<i class="icon-tree5"></i>
					</a>
				</li>
				<li>
					<a class="sidebar-mobile-main-toggle">
						<i class="icon-paragraph-justify3"></i>
					</a>
				</li>
			</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile">
			<ul class="nav navbar-nav">
				<li>
					<a href="<?php echo base_url(); ?>">
						<i class="icon-display4 position-left"></i> 
						Dashboard
					</a>
				</li>
				<li>
					<a href="<?php echo base_url() . "index.php/listing"; ?>">
						<i class="fa fa-user-secret position-left"></i>
						APT	Threats
					</a>
				</li>

				<li>
					<a href="./index.php/report">
						<i class="fa fa-file-text-o position-left"></i> 
						Report
					</a>
				</li>
				<li>
					<a href="#">
						<i class="fa fa-gears position-left"></i>
						Setting				 
					</a>
				</li>
				<li>
					<a href="#">
						<i class="fa fa-volume-control-phone position-left" aria-hidden="true"></i>
						Contact
					</a>
				</li>
			</ul>

			<div class="navbar-right">
				<ul class="nav navbar-nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-people"></i>
							<span class="visible-xs-inline-block position-right">Users</span>
						</a>
						
						<div class="dropdown-menu dropdown-content">
							<div class="dropdown-content-heading">
								Users online
								<ul class="icons-list">
									<li><a href="#"><i class="icon-gear"></i></a></li>
								</ul>
							</div>
							<div class="media-list dropdown-content-body width-300">
								<ul class="">
									<li class="media">
										<div class="media-left"><img src="assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></div>
										<div class="media-body">
											<a href="#" class="media-heading text-semibold">Jordana Ansley</a>
											<span class="display-block text-muted text-size-small">Lead web developer</span>
										</div>
										<div class="media-right media-middle"><span class="status-mark border-success"></span></div>
									</li>

									<li class="media">
										<div class="media-left"><img src="assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></div>
										<div class="media-body">
											<a href="#" class="media-heading text-semibold">Will Brason</a>
											<span class="display-block text-muted text-size-small">Marketing manager</span>
										</div>
										<div class="media-right media-middle"><span class="status-mark border-danger"></span></div>
									</li>

									<li class="media">
										<div class="media-left"><img src="assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></div>
										<div class="media-body">
											<a href="#" class="media-heading text-semibold">Hanna Walden</a>
											<span class="display-block text-muted text-size-small">Project manager</span>
										</div>
										<div class="media-right media-middle"><span class="status-mark border-success"></span></div>
									</li>

									<li class="media">
										<div class="media-left"><img src="assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></div>
										<div class="media-body">
											<a href="#" class="media-heading text-semibold">Dori Laperriere</a>
											<span class="display-block text-muted text-size-small">Business developer</span>
										</div>
										<div class="media-right media-middle"><span class="status-mark border-warning-300"></span></div>
									</li>

									<li class="media">
										<div class="media-left"><img src="assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></div>
										<div class="media-body">
											<a href="#" class="media-heading text-semibold">Vanessa Aurelius</a>
											<span class="display-block text-muted text-size-small">UX expert</span>
										</div>
										<div class="media-right media-middle"><span class="status-mark border-grey-400"></span></div>
									</li>
								</ul>

								<div class="dropdown-content-footer">
									<a href="#" data-popup="tooltip" title="All users"><i class="icon-menu display-block"></i></a>
								</div>
							</div>
						</div>
					</li>

					<li class="dropdown dropdown-user">
						<a class="dropdown-toggle" data-toggle="dropdown">
							<img src="assets/images/placeholder.jpg" alt="">
							<span>Admin</span>
							<i class="caret"></i>
						</a>

						<ul class="dropdown-menu dropdown-menu-right">
							<li><a href="#"><i class="icon-user-plus"></i> My profile</a></li>
							<li><a href="#"><i class="icon-coins"></i> My balance</a></li>
							<li><a href="#"><span class="badge bg-blue pull-right">58</span> <i class="icon-comment-discussion"></i> Messages</a></li>
							<li class="divider"></li>
							<li><a href="#"><i class="icon-cog5"></i> Account settings</a></li>
							<li><a href="<?php echo base_url() . 'index.php/home/logout';?>"><i class="icon-switch2"></i> Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- /main navbar -->
	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">