<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Head extends CI_Controller {
    
    public $data = [];

	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library(['ion_auth', 'form_validation']);
		$this->load->helper(['url', 'language']);

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
        
        // load a model
        $this->load->model('instructor/Batch');
        
        // - login verificaion
        if (!$this->ion_auth->logged_in()){
			// redirect them to the login page
			redirect('login', 'refresh');
            
		}
	}
    
	// - home 
	public function index(){
        
        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        
        // - data
        $data['currentPageTitle'] = 'Head - Home';
        $data['mainContent'] = 'instructor/head';
        $data['subContent'] = 'head/index';
        
        // - load view 
        $this->load->view('includes/instructor/header',$data);
		$this->load->view('instructor/head/index');
		$this->load->view('includes/instructor/footer');
    }
    
    public function batch(){
        
        // genirate batch code
        $batch_code = $this->create_bactch_code(5);
        
        $has_batch = $this->universal->get(
            'true',
            'batch',
            '*',
            'all',
            array(
                'code' => $batch_code
            )
        );
        
        if ($has_batch) {
            $this->batch();
        }
        
        // - data
        $data['mainContent'] = 'instructor/head';
        $data['subContent'] = 'head/batch';
        $data['batch_code'] = $batch_code;
        
        // - load view 
        $this->load->view('includes/instructor/header',$data);
		$this->load->view('instructor/head/batch.php');
		$this->load->view('includes/instructor/footer');
    }
    
    // // genirate batch code function
    public function create_bactch_code($len){
		$result = "";
		$chars = "abcdefghijklmnopqrstuvwxyz0123456789";
		$charArray = str_split($chars);
		for($i = 0; $i < $len; $i++){
			$randItem = array_rand($charArray);
			$result .= "".$charArray[$randItem];
		}
		return $result;
	}
    
    public function insert_batch(){
        sleep(2);
        $post = $this->input->post();
        $batch_from = $post['batch_from'];
        $batch_to = $post['batch_to'];
        $batch_code = $post['batch_code'];
        $batch_description = $post['batch_description'];
        $currentDateTime = date('Y-m-d H:i:s');
        
        $batch_from = date_create($batch_from);
        $batch_from = date_format($batch_from, 'Y-m-d H:i:s');
        
        $batch_to = date_create($batch_to);
        $batch_to = date_format($batch_to, 'Y-m-d H:i:s');
        
        // isert batch data
        $getResult = $this->universal->insert(
            'batch',
            array(
                'batch_from' => $batch_from,
                'batch_to' => $batch_to,
                'code' => $batch_code,
                'description' => $batch_description,
                'created' => $currentDateTime,
                'modified' => $currentDateTime
            )
        );
        
        $output = array(
            'message' => 'failed',
            'error' => true
        );
        
        if ($getResult) {
            $output = array(
                'message' => 'success',
                'error' => false
            );
        }
        
        echo json_encode($output);
    }
    
    public function getBatchDataTable(){
        
        // - variables from datatable
        $post = $this->input->post();
        $draw = $this->input->post('draw');
        $length = $this->input->post('length');
        $offset = $this->input->post('start');
        $search = $this->input->post('search');
        $order = $this->input->post('order');
        $columns = $this->input->post('columns');
        
        // order of the data pass
        if(!empty($order)){
            $setorder =  array($columns[$order[0]['column']]['data'] => $order[0]['dir']);
        }else{
            $setorder = array();
        }
        
        //search functionality
        if(empty($search['value'])){
            $like = array();
        }else{
            $like = array(
                'b.id' => $search['value'],
                'b.batch_from' => $search['value'],
                'b.batch_to' => $search['value'],
                'b.code' => $search['value'],
                'b.status' => $search['value'],
                'b.created' => $search['value'],
                'b.modified' => $search['value']
            );
        }
        
        // get the teacher details to the database using the usniversal model
        $batchDataResult = $this->universal->datatables(
            'batch AS b',
            '*',
            array(), 
            array(),
            array($length => $offset),
            $setorder,
            $like, 
            true
        );
        
        $data['data'] = array();
        foreach ($batchDataResult['data'] as $k => $sheet){
            // get the count of
            $countBatch = $this->universal->get(
                true,
                'batch_connect',
                'id',
                'all',
                array(
                    'batch_id' =>  $sheet['id']
                )
            );
            $sheet['count'] =  count($countBatch);
            array_push($data['data'], $sheet);
        }
        
        echo json_encode(
            array(
                'draw' => intval($draw),
                "recordsTotal" => $batchDataResult['recordsTotal'],
                "recordsFiltered" => $batchDataResult['recordsFiltered'],
                "data" => $data['data']
            )
        );
    }
    
    public function changeBatchStatus(){
        $post = $this->input->post();
        
        if ($post['batchStatus'] == 1) {
            // to deactivate
            $status = 0;
        }else{
            // to active
            $status = 1;
        }
        
        $updateBatchStatus = $this->universal->update(
            'batch',
            array(
                'status' => $status
            ),
            array(
                'id' => $post['id']
            )
        );
        echo $updateBatchStatus;
    }
    
}