<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    
    public $data = [];

	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library(['ion_auth', 'form_validation']);
		$this->load->helper(['url', 'language']);

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
        
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
        $data['mainContent'] = 'admin/home';
        $data['subContent'] = 'index';
        
        // - load view 
        $this->load->view('includes/admin/header',$data);
		$this->load->view('admin/index');
		$this->load->view('includes/admin/footer');
    }
    
    public function getAllUserData(){
        if (!$this->ion_auth->is_admin()){
             // remove this elseif if you want to enable this for non-admins
			// redirect them to the home page because they must be an administrator to view this
			show_error('You must be an administrator to view this page.');
		}else{
			// $this->data['title'] = $this->lang->line('index_heading');
			// // set the flash data error message if there is one
			// $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            
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
                    'u.id' => $search['value'],
                    'u.first_name' => $search['value'],
                    'u.middle_name' => $search['value'],
                    'u.last_name' => $search['value'],
                    'u.email' => $search['value'],
                    'g.name' => $search['value']
    			);
    		}
            
            // get the teacher details to the database using the usniversal model
    		$result = $this->universal->datatables(
    			'users AS u',
    			'u.id, u.first_name, u.middle_name, u.last_name, u.email, u.active, g.name',
                array(
                    'g.name !=' => 'admin'
                ), 
    			array(
                    'users_groups AS ug' => 'ug.user_id = u.id',
                    'groups AS g' => 'g.id = ug.group_id'
                ),
    			array($length => $offset),
    			$setorder,
    			$like, 
    			true
    		);
            
            $data['data'] = array();
            foreach ($result['data'] as $k => $sheet){
                array_push($data['data'], $sheet);
            }
    		
    		echo json_encode(
    			array(
    				'draw' => intval($draw),
    				"recordsTotal" => $result['recordsTotal'],
    				"recordsFiltered" => $result['recordsFiltered'],
    				"data" => $data['data']
    			)
    		);
		}
    }
}
