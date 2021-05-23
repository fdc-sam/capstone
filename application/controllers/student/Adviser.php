<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Adviser extends CI_Controller {

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
        // get the current user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;

        // get the current user batch code
        $data['currentUserBatchCodeId'] = $this->getStudentBatchCodeId($data['userInfo']->email);

        // get all user
        $data['studentInfo'] = $this->getStudent($data['currentUserBatchCodeId']);

        // - data
        $data['currentPageTitle'] = 'Student - Home';
        $data['mainContent'] = 'student/adviser';
        $data['subContent'] = 'adviser/index';

        $this->load->view('includes/student/header',$data);
		$this->load->view('student/adviser/index');
		$this->load->view('includes/student/footer');
        $this->load->view('includes/student/modals');
	}
}
?>
