<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	protected $ci_nonce;
	function __construct() {
        parent::__construct();
        $this->load->library('session');
        // access token
        if (!$this->session->has_userdata('ci_nonce') || !isset($_POST['ci_nonce'])) {
	        $this->session->set_userdata("ci_nonce", substr(md5(microtime()),rand(0,26),15));
        }
        $this->ci_nonce = $this->session->ci_nonce;
    }

	
	public function index(){
		if (!$this->session->has_userdata("is_logged_in") || !$this->session->is_logged_in) {
			redirect(base_url() . 'index.php/home/login');
		}
		$data = array();
		$data['events'] 		= $this->mongo_db->limit(24)->get('events');
		$data['incidents'] 		= $this->mongo_db->order_by(array('count' => 'DESC'))->get('incidents');

		$data['mfs'] = array();
		$malware = array();
		foreach ($data['incidents'] as $incident) {
			$data2 = $this->mongo_db->where(array('id' => $incident['rule']))->get('mf');
			if (!empty($data2) && !in_array( $data2[0]['name'], $malware) ) {
				$malware[] = $data2[0]['name'];
				$data['mfs'][]=$data2[0];
			}
		}
		
		$data['domain_connect'] = array_slice( $this->mongo_db->distinct("events", "host"), 0, 3 );
		$data['ips'] = $this->mongo_db->distinct("events", "orig_h");
		$data['nodes'] 		 	= $this->mongo_db->limit(500)->where_in("host", $data['domain_connect'])->get('events');
		$data["title"] 	= "Dashboard";
		
		$this->create_event_tsv_file($this->reset_array($this->mongo_db->get('events')), "assets/demo_data/events", "demo_data");
		$this->load->view("backend/header", $data, FALSE);
		// $this->load->view("backend/sidebar");
		$this->load->view("backend/dashboard");
		$this->load->view("backend/footer");

	}

	private function reset_array($data){
		$items = array();
		foreach ($data as &$row) {
	        foreach($row as $key => $val){
	        	if ($key == 'ts') {
	        		$val = (array)$val;
	        		$key = array_keys($val);
	        		$val = $val[$key[0]];
        			$items[] = @date("H D", $val + 0);
        			// $items[] = @date("H d-M", $val + 0);
	        	}
	        }
        }
        $occurences = array_count_values($items);
		$results = array();
		foreach ($occurences as $key => $value) {
			$results[] = array('ts' => $key, 'count' => $value);
		}
		return $results;
	}

	public function create_event_tsv_file($data, $path, $file_name){
		@chmod($path, 0777);
		$fe = @fopen($path . "/".$file_name.".tsv", "w");
		
		if($fe){           
		    $content = "";
		    //$content = "header('Content-type: text/html; charset=utf-8')";
		    $fields_count = 0;

		    // fields headers
		    
	        foreach(array_keys($data[0]) as $key){
	            if($fields_count++ > 0) $content .= "\t";
	            // mysql column headers here
	            $content .= $key;
	        }
		    
		    $content .= "\r\n"; 

		    

	        foreach ($data as $row) {
		        $fields_count = 0;
		        foreach($row as $key => $val){
		        	
		            if($fields_count++ > 0) $content .= "\t";
		            //my own special code start
		            $val = str_replace("\n","", $val);
		            $val = str_replace("\r","", $val);
		            $val = str_replace("\t","", $val);

		            $val = stripslashes($val);                    
		            $val = str_replace("chr(13)","", $val);
		            //my own special code end

		            $content .= $val;              
		        }
		        $content .= "\r\n"; 
	        }
		    
		    utf8_encode($content);
		    // $content = mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8");

		    // write some content to the opened file.
		   	if (fwrite($fe, utf8_encode($content)) == FALSE)
		       echo 'file_writing_error'." (export.tsv)"; 
		   	
		    fclose($fe);           
		}
	}

	public function get_bar_data(){
		$this->create_event_tsv_file($this->reset_array($this->mongo_db->get('events')), "assets/demo_data/events", "demo_data");
	}


	public function get_malware_data(){
		$data['incidents'] 		= $this->mongo_db->order_by(array('count' => 'DESC'))->get('incidents');

		$mfs = array();
		$malware = array();
		foreach ($data['incidents'] as $incident) {
			$data2 = $this->mongo_db->where(array('id' => $incident['rule']))->get('mf');
			if (!empty($data2) && !in_array( $data2[0]['name'], $malware) ) {
				$malware[] = $data2[0]['name'];
				$mfs[]=$data2[0];
			}
		}
		echo json_encode($mfs);
	}

	public function get_domain_connect_data(){
		$data['domain_connect'] = array_slice( $this->mongo_db->distinct("events", "host"), 0, 3 );
		echo json_encode($this->mongo_db->limit(200)->where_in("host", $data['domain_connect'])->get('events'));
	}

	public function get_domains(){
		echo json_encode(array_slice( $this->mongo_db->distinct("events", "host"), 0, 3 ));
	}

	public function get_table_data(){?>
		<table class="table datatable-columns">
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
				<?php 
				foreach ($this->mongo_db->order_by(array('count' => 'DESC'))->get('incidents') as $incident) {
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
				<?php }?>
			</tbody>
		</table><?php
	}


	public function login(){
		if ($this->session->has_userdata("is_logged_in") && $this->session->is_logged_in) {
			redirect(base_url());
		}
		$data = array(
			'title' => "Dashboard login",
			"ci_nonce" => $this->ci_nonce
		);
		$this->load->view("backend/login", $data);
	}

	public function register(){
		if ($this->session->has_userdata("is_logged_in") && $this->session->is_logged_in) {
			redirect(base_url());
		}
		$data = array(
			'title' => "Dashboard Registration",
			"ci_nonce" => $this->ci_nonce
		);
		$this->load->view("backend/register", $data);
	}

	public function check_login(){
		if (isset($_POST['ci_nonce']) && $this->ci_nonce == $_POST['ci_nonce']) {
			$file = fopen(base_url()."db/ci.csv","r");
			$flag = false;
			while(! feof($file)){
				$row = fgetcsv($file);
			  	if ($row[1] == $_POST['username'] && $row[3] == md5($_POST['password'])) {
			  		$flag = true;
			  		break;
			  	}
			}

			fclose($file);
			
			if ($flag) {
				
				$this->session->set_userdata( array('is_logged_in' => true, 'username' => $_POST['username']) );
				redirect(base_url());
			}
			else {
				$this->session->set_flashdata('error','Invalid username or password');
				redirect(base_url() . 'index.php/home/login');
			}
		}else {
			$this->session->set_flashdata('error','Invalid access token');
			redirect(base_url() . 'index.php/home/login');
		}
	}

	public function logout(){
		$this->session->unset_userdata(array('username', 'is_logged_in'));
		redirect(base_url() . 'index.php/home/login');
	}
}