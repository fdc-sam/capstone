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
    
	public function index(){
        
        // get the user information
        // $data['userId'] = $this->ion_auth->user()->row()->id;
        // print_r($data['userId']);
        // die();
        $data['userInfo'] = $this->ion_auth->user()->row();
        
		$data['mainContent'] = 'student/index';
        $data['subContent'] = 'chatbot/index';
        
        $this->load->view('includes/student/header',$data);
		$this->load->view('student/index');
		$this->load->view('includes/student/footer');
	}

}
?>