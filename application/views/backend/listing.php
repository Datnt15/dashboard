<!-- Main content -->
<div class="content-wrapper">

	<!-- Content area -->
	<div class="content">
		<div class="row list">
			
			<div class="panel panel-flat">
				<div class="panel-heading">
					<h6 class="panel-title">Listing</h6>
				</div>

				<div class="panel-body">
					<div class="tabbable">
						<ul class="nav nav-tabs nav-tabs-highlight">
							<li class="active">
								<a href="#fade-tab1" data-toggle="tab">Incidents</a>
								</li>
							<li>
								<a href="#fade-tab2" data-toggle="tab">Events</a>
							</li>
						</ul>

						<div class="tab-content">
							<div class="tab-pane fade in active" id="fade-tab1">
								<div class="table-responsive" id="my-table">
									<table class="table datatable-columns table-striped">
										<thead>
											<tr>
												<th>Internal host</th>
												<th>Events</th>
												<th>Name</th>
												<th>Fisrt</th>
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

							<div class="tab-pane fade" id="fade-tab2">
								<div class="table-responsive col-lg-8">
									<table class="table datatable-columns table-striped">
										<thead>
											<tr>
												<th>Timestamp</th>
												<th>Type</th>
												<th>Internal host</th>
												<th>Connected IP</th>
												<th>Host</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($events as $event) { ?>
												<tr data-id="<?php echo (string) $event['_id']; ?>">
													<td>
														<?php echo @date("Y-m-d H:i", $event['ts']->sec);
														?>
													</td>
													<td><?php echo $event['type'];?></td>
													<td><?php echo $event['orig_h'];?></td>
													<td><?php echo $event['resp_h'];?></td>
													<td><?php echo $event['host'];?></td>
												</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
								<div class="col-lg-4">
									<div class="list-group no-border no-padding-top">
										<a href="#" class="list-group-item">
											<i class="icon-user"></i> 
											Name: <?php echo $mf['name']; ?>
										</a>
										<a href="#" class="list-group-item">
											<i class="icon-cash3"></i> References: <?php echo implode( ",", $mf['references'] ); ?>
										</a>
										<a href="#" class="list-group-item">
											<i class="icon-tree7"></i> Tags: <?php echo implode( ",", $mf['tags'] ); ?>
										</a>
										<a href="#" class="list-group-item">
											<i class="icon-users"></i> Groups: <?php echo $mf['author_name']; ?>
										</a>
										<a href="#" class="list-group-item">
											<i class="icon-calendar3"></i> Industries: <?php echo implode( ",", $mf['industries'] ); ?>
										</a>
										<a href="#" class="list-group-item">
											<i class="icon-cog3"></i> Target Country: <?php echo implode( ",", $mf['targeted_countries'] ); ?>
										</a>
										<a href="#" class="list-group-item">
											<i class="icon-cog3"></i> Description: 
											<div class="col-lg-12 border-left-lg border-left-danger">
												<?php echo $mf['description']; ?>
											</div>
										</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-md-3"></div>
		</div>
	</div>
</div>
<!-- Info modal -->
<div id="modal_theme_info" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-info">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h6 class="modal-title">Event Details </h6>
			</div>

			<div class="modal-body">
				
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- /info modal -->
<script type="text/javascript">
	$(function() {

		$("#my-table").on('click', 'table tbody tr', function(event) {
			var host = $(this).find('td').eq(0).text();
			$.post(
				$("base").attr('href') + 'index.php/listing/get_events', 
				{host: host}, 
				function(data) {
					$("#fade-tab2").html(data);
					$("a[href='#fade-tab2']").click();
				}
			);
		});

		$("#fade-tab2").on('click', '.col-lg-8 table tbody tr', function(event) {
			var id = $(this).attr('data-id');
			$.post(
				$("base").attr('href') + 'index.php/listing/get_single_event', 
				{id: id}, 
				function(data) {
					$("#modal_theme_info .modal-body").html(data);
					$('#modal_theme_info').modal('show');
				}
			);
		});
		
	    // Setting datatable defaults
	    $.extend( $.fn.dataTable.defaults, {
	        autoWidth: false,
	        columnDefs: [{ 
	            orderable: false,
	            width: '100px',
	            targets: [ 5 ]
	        }],
	        dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
	        language: {
	            search: '<span>Filter:</span> _INPUT_',
	            lengthMenu: '<span>Show:</span> _MENU_',
	            paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
	        },
	        drawCallback: function () {
	            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
	        },
	        preDrawCallback: function() {
	            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
	        }
	    });
	    
	    // Columns rendering
	    $('.datatable-columns').dataTable({
	        "order": [
	            [1, "desc"]
	        ],
	        pageLength: 10
	    });

	});

</script>
