
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
			}
		li{
			list-style: none;
		}
		/*.table > thead > tr > th,.table > tbody > tr > td{
			padding: 10px 5px;
		}*/
		.page-header .breadcrumb-line a{
			color: #333333;
			font-size: 16px;
		}
		.chart-container.has-scroll {
		    overflow-x: hidden;
		}
		.content{
			font-size: 14px;
		}
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
		var data_event = [],data_incident = [],data_marker = [], legend_data = [], nodes_data = [], links_data = [], pie_legend_data = [], pies_series_data = [], data_map_table = [], sorting_data = [], sorting_legend = [], domain_data = [], domain_legend = [];
		<?php 
		// Set event data
		foreach ($events as $event) {
			echo "data_event.push(" . $event['ts']->usec . ");";
		} 

		foreach ($this->mongo_db->distinct("events", "resp_h") as $ip) {
			
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
		$domain_data = array();
		foreach ($domain_connect as $key => $value) {
			echo "legend_data.push('".$value."');";
			echo "nodes_data.push({name:'".$value."'});";
			if (!isset($domain_data[$value])) {
				$domain_data[$value] = 1;
			}else{
				$domain_data[$value]++;
			}
		}
		foreach ($domain_data as $key=>$value) {
			echo "domain_data.push({name:'".$key."', value:".$value/array_sum($domain_data)*100 ."});";
			echo "domain_legend.push('".$key."');";
		}

		$statistic_node = array();
		foreach ($nodes as $node) {
			if (isset($statistic_node[$node['orig_h']])) {
				$statistic_node[$node['orig_h']] ++;
			}else{
				$statistic_node[$node['orig_h']] = 1;
			}
			echo "nodes_data.push({name:'".$node['orig_h']."'});";
			echo "links_data.push({source: '".$node['host']."', target: '".$node['orig_h']."', weight: 0.9, name: 'Effectiveness'});";
			echo "links_data.push({target: '".$node['host']."', source: '".$node['orig_h']."', weight: 1});";
		}
		foreach ($statistic_node as $key => $value) {
			echo "sorting_data.push({name:'".$key."', value:".$value/array_sum($statistic_node)*100 ."});";
			echo "sorting_legend.push('".$key."');";
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
		<?php }?>
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
	<div class="navbar navbar-inverse ">

		<div class="navbar-header">
			<a class="navbar-brand" href="index.html">
				<img src="assets/images/logo_light.png" alt="">
			</a>
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
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						<i class="icon-git-compare"></i>
						<span class="visible-xs-inline-block position-right">Git updates</span>
						<span class="badge bg-warning-400">9</span>
					</a>
					
					<div class="dropdown-menu dropdown-content">
						<div class="dropdown-content-heading">
							Git updates
							<ul class="icons-list">
								<li><a href="#"><i class="icon-sync"></i></a></li>
							</ul>
						</div>

						<ul class="media-list dropdown-content-body width-350">
							<li class="media">
								<div class="media-left">
									<a href="#" class="btn border-primary text-primary btn-flat btn-rounded btn-icon btn-sm"><i class="icon-git-pull-request"></i></a>
								</div>

								<div class="media-body">
									Drop the IE <a href="#">specific hacks</a> for temporal inputs
									<div class="media-annotation">4 minutes ago</div>
								</div>
							</li>

							<li class="media">
								<div class="media-left">
									<a href="#" class="btn border-warning text-warning btn-flat btn-rounded btn-icon btn-sm"><i class="icon-git-commit"></i></a>
								</div>
								
								<div class="media-body">
									Add full font overrides for popovers and tooltips
									<div class="media-annotation">36 minutes ago</div>
								</div>
							</li>

							<li class="media">
								<div class="media-left">
									<a href="#" class="btn border-info text-info btn-flat btn-rounded btn-icon btn-sm"><i class="icon-git-branch"></i></a>
								</div>
								
								<div class="media-body">
									<a href="#">Chris Arney</a> created a new <span class="text-semibold">Design</span> branch
									<div class="media-annotation">2 hours ago</div>
								</div>
							</li>

							<li class="media">
								<div class="media-left">
									<a href="#" class="btn border-success text-success btn-flat btn-rounded btn-icon btn-sm"><i class="icon-git-merge"></i></a>
								</div>
								
								<div class="media-body">
									<a href="#">Eugene Kopyov</a> merged <span class="text-semibold">Master</span> and <span class="text-semibold">Dev</span> branches
									<div class="media-annotation">Dec 18, 18:36</div>
								</div>
							</li>

							<li class="media">
								<div class="media-left">
									<a href="#" class="btn border-primary text-primary btn-flat btn-rounded btn-icon btn-sm"><i class="icon-git-pull-request"></i></a>
								</div>
								
								<div class="media-body">
									Have Carousel ignore keyboard events
									<div class="media-annotation">Dec 12, 05:46</div>
								</div>
							</li>
						</ul>

						<div class="dropdown-content-footer">
							<a href="#" data-popup="tooltip" title="All activity"><i class="icon-menu display-block"></i></a>
						</div>
					</div>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
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

						<ul class="media-list dropdown-content-body width-300">
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
				</li>
			</ul>
			<p class="navbar-text">
				<span class="label bg-success">Online</span>
			</p>

			<div class="navbar-right">
				<ul class="nav navbar-nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
							<i class="icon-bubbles4"></i>
							<span class="visible-xs-inline-block position-right">Messages</span>
							<span class="badge bg-teal-800">2</span>
						</a>
						
						<div class="dropdown-menu dropdown-content width-350">
							<div class="dropdown-content-heading">
								Messages
								<ul class="icons-list">
									<li><a href="#"><i class="icon-compose"></i></a></li>
								</ul>
							</div>

							<ul class="media-list dropdown-content-body">
								<li class="media">
									<div class="media-left">
										<img src="assets/images/placeholder.jpg" class="img-circle img-sm" alt="">
										<span class="badge bg-danger-400 media-badge">5</span>
									</div>

									<div class="media-body">
										<a href="#" class="media-heading">
											<span class="text-semibold">James Alexander</span>
											<span class="media-annotation pull-right">04:58</span>
										</a>

										<span class="text-muted">who knows, maybe that would be the best thing for me...</span>
									</div>
								</li>

								<li class="media">
									<div class="media-left">
										<img src="assets/images/placeholder.jpg" class="img-circle img-sm" alt="">
										<span class="badge bg-danger-400 media-badge">4</span>
									</div>

									<div class="media-body">
										<a href="#" class="media-heading">
											<span class="text-semibold">Margo Baker</span>
											<span class="media-annotation pull-right">12:16</span>
										</a>

										<span class="text-muted">That was something he was unable to do because...</span>
									</div>
								</li>

								<li class="media">
									<div class="media-left"><img src="assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></div>
									<div class="media-body">
										<a href="#" class="media-heading">
											<span class="text-semibold">Jeremy Victorino</span>
											<span class="media-annotation pull-right">22:48</span>
										</a>

										<span class="text-muted">But that would be extremely strained and suspicious...</span>
									</div>
								</li>

								<li class="media">
									<div class="media-left"><img src="assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></div>
									<div class="media-body">
										<a href="#" class="media-heading">
											<span class="text-semibold">Beatrix Diaz</span>
											<span class="media-annotation pull-right">Tue</span>
										</a>

										<span class="text-muted">What a strenuous career it is that I've chosen...</span>
									</div>
								</li>

								<li class="media">
									<div class="media-left"><img src="assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></div>
									<div class="media-body">
										<a href="#" class="media-heading">
											<span class="text-semibold">Richard Vango</span>
											<span class="media-annotation pull-right">Mon</span>
										</a>
										
										<span class="text-muted">Other travelling salesmen live a life of luxury...</span>
									</div>
								</li>
							</ul>

							<div class="dropdown-content-footer">
								<a href="#" data-popup="tooltip" title="" data-original-title="All messages"><i class="icon-menu display-block"></i></a>
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
			<div class="content-wrapper">
				
				<!-- Page header -->
				<div class="page-header page-header-default">
					<div class="breadcrumb-line">
						<div class="navbar-collapse collapse">
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
									<li>
										<a href="#">
											<i class="icon-comment-discussion position-left"></i>
											Support
										</a>
									</li>
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
											<i class="icon-gear position-left"></i>
											<span class="caret"></span>
										</a>

										<ul class="dropdown-menu dropdown-menu-right">
											<li><a href="#"><i class="icon-user-lock"></i> Account security</a></li>
											<li><a href="#"><i class="icon-statistics"></i> Analytics</a></li>
											<li><a href="#"><i class="icon-accessibility"></i> Accessibility</a></li>
											<li class="divider"></li>
											<li><a href="#"><i class="icon-gear"></i> All settings</a></li>
										</ul>
									</li>
								</ul>
							</div>
						</div>

						
					</div>
				</div>
				<!-- /page header -->
			