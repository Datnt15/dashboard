<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Listing extends CI_Controller {

	function __construct() {
        parent::__construct();
        $this->load->library('session');
		if (!$this->session->has_userdata("is_logged_in") || !$this->session->is_logged_in) {
			redirect(base_url() . 'index.php/home/login');
		}
    }

	
	public function index(){
		$data = array();
		$data['incidents'] 	= $this->mongo_db->get('incidents');
		$data['events'] 	= $this->mongo_db->where(array('iid' => $data['incidents'][0]['_id']))->get('events');
		$data['mf'] 	= $this->mongo_db->where(array('id' => $data['incidents'][0]['rule']))->find_one('mf');
		$data["title"] 		= "Listing Page";
		
		$this->load->view("backend/header-listing", $data, FALSE);
		// $this->load->view("backend/sidebar");
		$this->load->view("backend/listing");
		$this->load->view("backend/footer");
	}

	public function get_events(){
		$host = $this->input->post('host');

		if ($host != NULL) {
			$incidents = $this->mongo_db->where(array('src_ip' => $host))->get('incidents');
			$events = $this->mongo_db->where(array('iid' => $incidents[0]['_id']))->get('events');
			$mf = $this->mongo_db->where(array('id' => $incidents[0]['rule']))->find_one('mf');
			?>

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
				<div class="panel">
					<div class="panel-heading navbar-inverse">
						<h6 class="panel-title"><?php echo $mf['name']; ?></h6>
					</div>
					<div class="panel-body">
						<div class="list-group no-border no-padding-top">
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

		<?php }
	}

	public function get_single_event(){
		$id = $this->input->post('id');

		if ($id != NULL) {
			$id = new MongoId($id);

			$event = $this->mongo_db->where(array('_id' => $id))->get('events'); ?>
			<div class="row">
				<div class="col-lg-6">
					<h6>Type: <?php echo isset($event[0]['type']) ? $event[0]['type'] : "";?></h6>
					<h6>Method: <?php echo isset($event[0]['method']) ? $event[0]['method'] : "";?></h6>
					<h6>Uri: <?php echo isset($event[0]['uri']) ? $event[0]['uri'] : "";?></h6>
					<h6>Host: <?php echo isset($event[0]['host']) ? $event[0]['host'] : "";?></h6>
					<h6>User Agent: <?php echo isset($event[0]['user_agent']) ? $event[0]['user_agent'] : "";?></h6>
					<h6>Status Code: <?php echo isset($event[0]['status_code']) ? $event[0]['status_code'] : "";?></h6>
					<h6>Referrer: <?php echo isset($event[0]['referrer']) ? $event[0]['referrer'] : "";?></h6>
					<h6>Internal host: <?php echo isset($event[0]['orig_h']) ? $event[0]['orig_h'] : "";?></h6>
					<h6>Connected IP: <?php echo isset($event[0]['resp_h']) ? $event[0]['resp_h'] : "";?></h6>
				</div>
				<div class="col-lg-6">
					<h6>Type: <?php echo isset($event[0]['type']) ? $event[0]['type'] : "";?></h6>
					<h6>Query: <?php echo isset($event[0]['query']) ? $event[0]['query'] : "";?></h6>
					<h6>Internal host: <?php echo isset($event[0]['orig_h']) ? $event[0]['orig_h'] : "";?></h6>
					<h6>qtype_name: <?php echo isset($event[0]['qtype_name']) ? $event[0]['qtype_name'] : "";?></h6>
				</div>
			</div>
		<?php }
	}
}