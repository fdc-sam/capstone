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
        $data['userInfo'] = $this->ion_auth->user()->row();
        
        // get the current user batch code 
        $currentUserBatchCodeId = $this->getStudentBatchCodeId($data['userInfo']->email);
        
        // get all user 
        $data['studentInfo'] = $this->getStudent($currentUserBatchCodeId);
        
        // echo "<pre>";
        // print_r($data['studentInfo']);
        // die();
        
        // - data
        $data['currentPageTitle'] = 'Student - Home';
        $data['mainContent'] = 'student/home';
        $data['subContent'] = 'home/index';
        
        $this->load->view('includes/student/header',$data);
		$this->load->view('student/index');
		$this->load->view('includes/student/footer');
        $this->load->view('includes/student/modals');
	}
    
    // get the current user batch code 
    public function getStudentBatchCodeId($email = null){
        $currentUserBatchCode = $this->universal->get(
            true,
            'batch_connect',
            'batch_connect.batch_id',
            'row',
            array(
                'batch_connect.email' => $email,
            )
        );
        return isset($currentUserBatchCode->batch_id)? $currentUserBatchCode->batch_id:null;
    }
    
    // get all student
    public function getStudent($currentUserBatchCodeId = null){
        
        // get the current user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        
        $getAllBatchStudent = $this->universal->get(
            true,
            'batch_connect AS batchConnect',
            'User.first_name, User.middle_name, User.last_name, User.id',
            'all',
            array(
                'batchConnect.batch_id' => $currentUserBatchCodeId,
                'batchConnect.email !=' => $data['userInfo']->email
            ),
            array(),
            array(
                'users AS User' => 'User.email = batchConnect.email'
            )
        );
        
        return isset($getAllBatchStudent)? $getAllBatchStudent: null;
    }
    
    public function addGroupMember(){
        $post = $this->input->post();
        $errorFlag = 0;
        
        // get the current user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        
        // get the current user batch code 
        $currentUserBatchCodeId = $this->getStudentBatchCodeId($data['userInfo']->email);
        
        // create a random Thesis Group Id code
        $thesisGroupId = $this->getRandomString(10);
        
        //  add curent user to the group
        $hasGroup = $this->universal->get(
            true,
            'thises_connect',
            '*',
            'row',
            array(
                'user_id' => $data['userInfo']->id
            )
        );
        
        if (!$hasGroup) {
            $addGroupMember = $this->universal->insert(
                'thises_connect',
                array(
                    'thesis_group_id' => $thesisGroupId,
                    'batch_id' => $currentUserBatchCodeId,
                    'user_id' => $data['userInfo']->id,
                    'created' => date('Y-m-d H:i:s'),
                    'modified' => date('Y-m-d H:i:s')
                )
            );
        }
        
        // add members to the group
        foreach ($post['groupMemberId'] as $key => $value) {
            // determine if has already a group
            $hasGroup = $this->universal->get(
                true,
                'thises_connect',
                '*',
                'row',
                array(
                    'user_id' => $value
                )
            );
            
            if (!$hasGroup) {
                $addGroupMember = $this->universal->insert(
                    'thises_connect',
                    array(
                        'thesis_group_id' => $thesisGroupId,
                        'batch_id' => $currentUserBatchCodeId,
                        'user_id' => $value,
                        'created' => date('Y-m-d H:i:s'),
                        'modified' => date('Y-m-d H:i:s')
                    )
                );
            }else{
                
            }
            
            //  determine if has an error 
            if (!$addGroupMember) {
                $errorFlag ++;
            }
        }
        
        if ($errorFlag > 0) {
            $result = array(
                'message' => 'failed',
                'error' => true
            );
        }else{
            $result = array(
                'message' => 'success',
                'error' => false
            );
        }
        
        echo json_encode($result);
    }
    
    // create a random activation code
	public function getRandomString($len){
		$result = "";
		$chars = "abcdefghijklmnopqrstuvwxyz-0123456789";
		$charArray = str_split($chars);
		for($i = 0; $i < $len; $i++){
			$randItem = array_rand($charArray);
			$result .= "".$charArray[$randItem];
		}
		return $result;
	}
}
?>