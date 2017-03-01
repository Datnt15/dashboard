<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

	function __construct() {
        parent::__construct();
        $this->load->library('session');
		if (!$this->session->has_userdata("is_logged_in") || !$this->session->is_logged_in) {
			redirect(base_url() . 'index.php/home/login');
		}
    }

	
	public function index(){
		$this->host();
	}
	
	public function host(){
		$data = array();
		$data['incidents'] 	= $this->mongo_db->distinct("incidents", "src_ip");
		$data["title"] 	= "Reporting Host Page";
		
		$this->load->view("backend/header-listing", $data, FALSE);
		// $this->load->view("backend/sidebar");
		$this->load->view("backend/reporting-host");
		$this->load->view("backend/footer");
	}



	public function get_malware(){
		$ip = $this->input->post('host');
		if ($ip != null) {?>
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo $ip; ?></h3>
			</div>
			
			<?php $host_info = $this->mongo_db->where(array('src_ip' => $ip))->get('incidents'); 
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
		<?php }
		$mal_id = $this->input->post('mal_id');
		if ($mal_id != null) {
			$mal_id = new MongoId($mal_id);

			$mal = $this->mongo_db->where(array('_id' => $mal_id))->get('mf');
			?>
			<p>Name: <?php echo $mal[0]['name'];?></p>
			<p>References: <?php echo implode(", ", $mal[0]['references']);?></p>
			<p>Tags: <?php echo implode(", ", $mal[0]['tags']);?></p>
			<p>Groups: <?php echo isset($mal[0]['in_group']) ? $mal[0]['in_group'] : "";?></p>
			<p>Industries: <?php echo implode(", ", $mal[0]['industries']);?></p>
			<p>Targeted Countries: <?php echo implode(", ", $mal[0]['targeted_countries']);?></p>
			<p>Description: <?php echo $mal[0]['description'];?></p>
		<?php }
	}

	public function malware(){
		$data = array();
		$data['mfs'] 	= $this->mongo_db->distinct("mf", "name");
		$data["title"] 	= "Reporting Malware Page";
		$data['mf'] 	= $this->mongo_db->where(array('name' => $data['mfs'][0]))->find_one('mf');
		
		$this->load->view("backend/header-listing", $data, FALSE);
		// $this->load->view("backend/sidebar");
		$this->load->view("backend/reporting-malware");
		$this->load->view("backend/footer");
	}


	public function  weekly($type = 'host'){
		$this->host();		
	}

	public function monthly($type = 'host'){
		$this->host();
	}

	public function yearly($type = 'host'){
		$this->host();		
	}

	public function test(){
		phpinfo();die();
		$data = array();
		$data['incidents'] 	= $this->mongo_db->aggregate('incidents', array(
			// array('$year' => '$lastseen'),
			// array('$month' => '$lastseen'),
			// array('$dayOfMonth' => '$lastseen'),
			// array('$hour' => '$lastseen'),
			// array('$minute' => '$lastseen'),
			// array('$second' => '$lastseen'),
			// array('$millisecond' => '$lastseen'),
			// array('$dayOfYear' => '$lastseen'),
			// array('$dayOfWeek' => '$lastseen'),
			array('week' => '$lastseen')
		));
		print_r($data['incidents']);
	}

}