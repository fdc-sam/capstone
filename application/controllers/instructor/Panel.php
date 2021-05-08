<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Panel extends CI_Controller {
    
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
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;
        
        $currentUserGroup = $this->getCurrentUserGroupDetails($data['userInfo']->id);
    
        // - data
        $data['currentUserGroup'] = $currentUserGroup->name;
        $data['currentPageTitle'] = 'Head - Home';
        $data['mainContent'] = 'instructor/panel';
        $data['subContent'] = 'panel/index';
        
        // - load view 
        $this->load->view('includes/instructor/header',$data);
		$this->load->view('instructor/panel/index');
		$this->load->view('includes/instructor/footer');
    }
    
    
    // get any details function
    public function getCurrentUserGroupDetails($userId = null){
        $currentUserGroup = $this->universal->get(
            true,
            'groups AS G',
            'G.*',
            'row',
            array(
                
            ),
            array(
                'UG.user_id' => $userId
            ),
            array(
                'users_groups AS UG' => 'UG.group_id = G.id'
            )
        );
        
        return $currentUserGroup;
    }
    
}
