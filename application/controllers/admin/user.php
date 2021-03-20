<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    
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
    
    // - create user
    public function index(){
        
        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        
        // - data
		$data['mainContent'] = 'admin/user';
        $data['subContent'] = 'user/viewUsers';
        
        // - load view 
        $this->load->view('includes/admin/header',$data);
		$this->load->view('admin/user/viewUsers');
		$this->load->view('includes/admin/footer');
	}
    
    public function createNewUser(){
        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        
        
        // - data
		$data['mainContent'] = 'admin/user';
        $data['subContent'] = 'user/createNewUser';
        
        // - load view 
        $this->load->view('includes/admin/header',$data);
		$this->load->view('admin/user/createNewUser');
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
    
    public function deactivateAccount($user_id = null){
        $result = $this->universal->update(
            'users',
            array(
                'active' => 0
            ),
            array(
                'id' => $user_id
            )
        );
        
        $this->alert($methon = 'index', $result, $message = 'This account is deactivated');
    }
    
    public function activateAccount($user_id = null){
        $result = $this->universal->update(
            'users',
            array(
                'active' => 1
            ),
            array(
                'id' => $user_id
            )
        );
        
        $this->alert($methon = 'index', $result, $message = 'This account is activated');
    }
    
    private function alert($methon = null, $result = null, $message){
        
        if ($result) {
            $this->session->set_flashdata('message',
                '<div class="alert alert-info">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <i class="material-icons">close</i>
                    </button>
                    <span>
                      <b> Success - </b> '.$message.'
                    </span>
                </div>'
            ); 
        }else{
            $this->session->set_flashdata('message',
                '<div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <i class="material-icons">close</i>
                    </button>
                    <span>
                      <b> Error - </b> Something went wrong
                    </span>
                </div>'
            );
        }
        
        redirect(base_url('admin/user/'));
    } 
}
