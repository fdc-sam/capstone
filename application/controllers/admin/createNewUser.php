<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class createNewUser extends CI_Controller {
    
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
		$data['mainContent'] = 'admin/createNewUser';
        $data['subContent'] = 'createNewUser';
        
        // - load view 
        $this->load->view('includes/admin/header',$data);
		$this->load->view('admin/createNewUser');
		$this->load->view('includes/admin/footer');
	}
}
