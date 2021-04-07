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
        // get the current user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;
        
        // get the current user batch code 
        $data['currentUserBatchCodeId'] = $this->getStudentBatchCodeId($data['userInfo']->email);
        
        // get all user 
        $data['studentInfo'] = $this->getStudent($data['currentUserBatchCodeId']);
        
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
        
        $getUserAlreadyHasGroup = $this->universal->get(
            true,
            'thises_connect',
            'user_id',
            'all'
        );
        
        $result = array();
        $result1 = array();
        foreach ($getUserAlreadyHasGroup as $key => $value) {
            array_push($result, $value->user_id);
        }
        
        foreach ($getAllBatchStudent as $key => $value) {
            
            if (!in_array($value->id,$result)) {
                array_push($result1, $value);
            }
        
        }
        
        // pre($result1);
        // die();
        return isset($result1)? $result1: null;
    }
    
    public function addGroupMember(){
        $post = $this->input->post();
        $errorFlag = 0;
        
        // get the current user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;
        
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
    
    public function myProfile(){
        // get the current user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;
        
        // echo "<pre>";
        // print_r($data['userInfo']);
        // die();
        
        // - data
        $data['currentPageTitle'] = 'Student - My Profile';
        $data['mainContent'] = 'student/home';
        $data['subContent'] = 'home/MyProfile';
        
        $this->load->view('includes/student/header',$data);
		$this->load->view('student/MyProfile');
		$this->load->view('includes/student/footer');
    }
    
    public function updateMyProfile(){
        // request post data
        $post = $this->input->post();
        
        $updateCurrentUserProfile = $this->universal->update(
            'users',
            array(
                'email' => $post['email'],
                'username' => $post['email'],
                'first_name' => $post['firstName'],
                'middle_name' => $post['middleName'],
                'last_name' => $post['lastName'],
                'gender' => $post['gender']
            ),
            array(
                'id' => $this->ion_auth->user()->row()->id
            )
        );
        
        $output = array(
            'message' => 'Failed to update',
            'error' => true
        );
        
        if ($updateCurrentUserProfile) {
            $output = array(
                'message' => 'Successfully updated',
                'error' => false
            );
        }
        echo json_encode($output);
	}
    
    public function changePassword(){
        // get the current user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;
        
        // pre();
        // die();
        
        // - data
        $data['currentPageTitle'] = 'Student - Chagne Password';
        $data['mainContent'] = 'student/home';
        $data['subContent'] = 'home/changePassword';
        
        $this->load->view('includes/student/header',$data);
		$this->load->view('student/changePassword');
		$this->load->view('includes/student/footer');
    }
    
    public function addPropose(){
        // $proposeData = array(); 
        
        // get the current user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;
        
        // get the current user Thises Group Id
        $currentThisesGroupId = $this->getThisesGroupId($data['userInfo']->id);
        
        // get the input post
        $post = $this->input->post();
        
        $result = array(
            'message' => 'Data Not Save',
            'error' => 1
        );
        
        if (!empty($post)) {
            foreach ($post['titles'] as $key => $title) {
                // $proposeData[] = array(
                //     'title' => $title,
                //     'description' => $post['descriptions'][$key]
                // );
                
                $addProposal = $this->universal->insert(
                    'thises',
                    array(
                        'thesis_group_id' => $currentThisesGroupId,
                        'title' => $title,
                        'discreption' => $post['descriptions'][$key],
                        'created' => date('Y-m-d H:i:s'),
                        'modified' => date('Y-m-d H:i:s')
                    )
                );
                
                $result = array(
                    'message' => 'Data Save',
                    'error' => 0
                );
            }
        }
        echo json_encode($result);
    }
    
    public function getThisesGroupId($currentUserId = null){
        $currentThisesGroupId = $this->universal->get(
            true,
            'thises_connect',
            'thesis_group_id',
            'row',
            array(
                'user_id' => $currentUserId
            )
        );
        
        return isset($currentThisesGroupId->thesis_group_id)? $currentThisesGroupId->thesis_group_id: null;
    }
    
    public function countAvailableProposalLeft(){
        
        // get the current user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        
        // get the current user Thises Group Id
        $currentThisesGroupId = $this->getThisesGroupId($data['userInfo']->id);
        
        $countAvailableProposalLeft = $this->universal->get(
            true,
            'thises',
            '*',
            'all',
            array(
                'thesis_group_id' => $currentThisesGroupId
            )
        );

        $count =  count($countAvailableProposalLeft);
        $proposeData = '';
        // pre($countAvailableProposalLeft);
        // die;
        if ($count != 0) {
            foreach ($countAvailableProposalLeft as $key => $value) {
                if ( $value->status == 0) {
                    $sideStatusBar = 'bg-warning';
                    $requestStatus = '<div class="badge badge-warning ml-2">Pending</div>';
                }
                if ($value->status == 1) {
                    $sideStatusBar = 'bg-success';
                    $requestStatus = '<div class="badge badge-success ml-2">Approved</div>';
                }
                if ($value->status == 2) {
                    $sideStatusBar = 'bg-danger';
                    $requestStatus = '<div class="badge badge-danger ml-2">Rejected</div>';
                }
                $proposeData .= '
                    <li class="list-group-item">
                        <div class="todo-indicator '.$sideStatusBar.' "></div>
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left">
                                    <div class="widget-heading">'.$value->title.'
                                        '.$requestStatus.'
                                    </div>
                                    <div class="widget-subheading"><i> '.$value->discreption.' </i></div>
                                </div>
                                <div class="widget-content-right">
                                    <button class="border-0 btn-transition btn btn-outline-danger deletePropossal" thisesId="'. $value->id.'">
                                        <i class="fa fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </li>
                ';
            }
        }else{
            $proposeData .= '
                <li class="list-group-item" aligne->
                    <h5 style="text-align: center;">No Data</h5>
                </li>
            ';
        }
        $result = array(
            'count' => $count,
            'data' => $proposeData
        );
        echo json_encode($result);
    }
    
    public function deletePropossal(){
        $post = $this->input->post();
        $deletePropossal = $this->universal->delete(
            'thises',
            array(
                'id' => $post['id']
            )
        );
        
        $result = array(
            'message' => 'Unable to Delete',
            'error' => 1
        );
        
        if ($deletePropossal) {
            $result = array(
                'message' => 'Data Deleted',
                'error' => 0
            );
        }
        
        echo json_encode($result);
    }
}
?>