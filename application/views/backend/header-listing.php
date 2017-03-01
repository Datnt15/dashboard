
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
	<link href="assets/css/core.css" rel="stylesheet" type="text/css">
	<link href="assets/css/components.css" rel="stylesheet" type="text/css">
	<link href="assets/css/colors.css" rel="stylesheet" type="text/css">
	<link href="assets/css/extras/animate.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/icons/fontawesome/styles.min.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->
	
	<style>
		.table > thead > tr > th,
		.table > tbody > tr > td{
			padding: 10px 5px;
			cursor: pointer;
		}
	</style>

	<!-- Core JS files -->
	<script type="text/javascript" src="assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script type="text/javascript" src="assets/js/plugins/velocity/velocity.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/velocity/velocity.ui.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/buttons/spin.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="assets/js/core/app.js"></script>
	<script type="text/javascript" src="assets/js/plugins/buttons/ladda.min.js"></script>
	<script type="text/javascript" src="assets/js/pages/components_buttons.js"></script>
	<script type="text/javascript" src="assets/js/jspdf.min.js"></script>
	<script type="text/javascript" src="assets/js/html2canvas.min.js"></script>
	<!-- /theme JS files -->
	<script type="text/javascript">
	$(function() {
	    var content = $('#pdf_content'),
		cache_width = content.width(),
		a4  =[ 595.28,  841.89];  // for a4 size paper width and height

		$('#save_as_pdf').on('click',function(){
			createPDF();
		});
		//create pdf
		function createPDF(){
			getCanvas().then(function(canvas){
				var
				img = canvas.toDataURL("image/png"),
				doc = new jsPDF({
		          unit:'px',
		          format:'a4'
		        });
		        doc.addImage(img, 'JPEG', 20, 20);
		        doc.save('Report.pdf');
		        content.width(cache_width);
			});
		}

		// create canvas object
		function getCanvas(){
			content.width((a4[0]*1.33333) -80).css('max-width','none');
			return html2canvas(content,{
		    	imageTimeout:2000,
		    	height: a4[1]*1.33333,
		    	removeContainer:true
		    });
		}

	});
	</script>

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
						Bảng điều khiển
					</a>
				</li>
				<li>
					<a href="<?php echo base_url() . "index.php/listing"; ?>">
						<i class="fa fa-user-secret position-left"></i>
						Các mối đe dọa APT						 
					</a>
				</li>
				<li>
					<a href="./index.php/report">
						<i class="fa fa-file-text-o position-left"></i> 
						Báo cáo
					</a>
				</li>
				<li>
					<a href="#">
						<i class="fa fa-gears position-left"></i>
						Cấu hình hệ thống				 
					</a>
				</li>
				<li>
					<a href="#">
						<i class="fa fa-volume-control-phone position-left" aria-hidden="true"></i>
						Hỗ trợ				 
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