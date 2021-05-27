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

        // get student group id
        $group = $this->getGroupId($data['userInfo']->id);
        $groupId = null;
        if (isset($group) && $group) {
            $groupId = $group->thesis_group_id;
        }

        // get the adviser
        $assignAdviser = $this->universal->get(
            true,
            'thises_group_assigned_adviser',
            '*',
            'row',
            array(
                'group_id' => $groupId,
                'status' => 1
            )
        );

        $adviserDetails = $this->getadviserDetails($assignAdviser->instructor_id);

        // - data
        $data['groupId'] = $groupId;
        $data['assignAdviser'] = $assignAdviser;
        $data['adviserDetails'] = $adviserDetails;
        $data['currentPageTitle'] = 'Student - Home';
        $data['mainContent'] = 'student/adviser';
        $data['subContent'] = 'adviser/index';

        $this->load->view('includes/student/header',$data);
		$this->load->view('student/adviser/index');
		$this->load->view('includes/student/footer');
        $this->load->view('includes/student/modals');
	}

    public function viewLogs($groupId = null){
        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;

        // get all thesis logs
        $thisesLogs = $this->universal->get(
            true,
            'thises_logs',
            '*',
            'array',
            array(
                'group_id' => $groupId
            )
        );

        $output = '';
        if (isset($thisesLogs) && $thisesLogs) {
            foreach ($thisesLogs as $key => $thisesLog) {
                if ($thisesLog['user_id'] == $data['userInfo']->id) {
                    $outputName = "Your Group";
                }else{
                    $outputName = "Your Adviser";
                }

                $date = date("g:ia | D jS F Y", strtotime($thisesLog['date_created']));

                // get the capstone project
                $getThisesDetails = $this->getThisesDetails($thisesLog['thises_id']);

                if ($thisesLog['remark_flag'] == 2) {
                    // for thesis comment
                    $output .= '
                        <div class="vertical-timeline-item vertical-timeline-element">
                            <div>
                                <div class="vertical-timeline-element-icon bounce-in">
                                    <div class="timeline-icon border-primary">
                                        <i class="fa fa-comment" aria-hidden="true"></i>
                                    </div>
                                </div>
                                <div class="vertical-timeline-element-content bounce-in">
                                    <p>
                                        <h4 class="timeline-title">'.$outputName.' Comment</h4>
                                        to <a href="">'.$getThisesDetails->title.'</a> document
                                    </p>
                                    <p>
                                        <span class="text-dark">'.$date.'</span>
                                    </p>
                                    <p>'.$thisesLog['remark'].'</p>
                                </div>
                            </div>
                        </div>
                    ';
                }elseif ($thisesLog['remark_flag'] == 1) {
                    // for thises logs
                    if ($thisesLog['action'] == 'Adivisory Rejected') {
                        // for thesis action logs Reject
                        $output .= '
                            <div class="vertical-timeline-item vertical-timeline-element">
                                <div>
                                    <div class="vertical-timeline-element-icon bounce-in">
                                        <div class="timeline-icon border-danger">
                                            <i class="fa fa-fw"></i>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-element-content bounce-in">
                                        <p>
                                            <h4 class="timeline-title">'.$outputName.' Rejected the Group</h4>
                                        </p>
                                        <p>
                                            <span class="text-dark">'.$date.'</span>
                                        </p>
                                        <p>'.$thisesLog['remark'].'</p>
                                    </div>
                                </div>
                            </div>
                        ';
                    }elseif ($thisesLog['action'] == 'Accept Adivisory') {
                        // for thesis action logs Accept
                        $output .= '
                            <div class="vertical-timeline-item vertical-timeline-element">
                                <div>
                                    <div class="vertical-timeline-element-icon bounce-in">
                                        <div class="timeline-icon border-success">
                                            <i class="fa fa-tasks"></i>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-element-content bounce-in">
                                        <p>
                                            <h4 class="timeline-title">'.$outputName.' Accepted the Group</h4>
                                        </p>
                                        <p>
                                            <span class="text-dark">'.$date.'</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        ';
                    }
                }
            }
        }
        $output .= '
            <a href="'.base_url('student/adviser/addMessageToAdviser/'.$groupId).'">
                <div class="vertical-timeline-item vertical-timeline-element">
                    <div>
                        <div class="vertical-timeline-element-icon bounce-in">
                            <div class="timeline-icon border-primary">
                                <i class="fa fa-comments" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="vertical-timeline-element-content bounce-in">
                            <p>
                                <h4 class="timeline-title">Add Message to Adviser</h4>
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        ';
        // pre($thisesLogs);
        // die();

        // - data
        $data['thisesLogs'] = $output;
        $data['currentPageTitle'] = 'Adviser - Home';
        $data['mainContent'] = 'student/adviser';
        $data['subContent'] = 'adviser/viewLogs';

        // - load view
        $this->load->view('includes/student/header',$data);
		$this->load->view('student/adviser/viewLogs');
		$this->load->view('includes/student/footer');
        $this->load->view('includes/student/modals');

    }

    public function addMessageToAdviser($groupId = null){
        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;

        // get the coment post
        $post = $this->input->post();
        if (isset($post) && $post) {
            $instructorId = $data['userInfo']->id;

            $getThisesId = $this->universal->get(
                true,
                'thises',
                '*',
                'row',
                array(
                    'thesis_group_id' => $groupId,
                    'status' => 1
                )
            );

            $thisesId = isset($getThisesId->id)? $getThisesId->id: null;
            $action = "Add comment";
            $remarks = $post['remark'];
            $addCommend = $this->addThisesLogs($instructorId, $groupId, $thisesId, $action, $remarks);

            $output = array(
                'message' => "Error! Somthing went Wrong",
                'class' => 'alert-danger'
            );
            if (isset($addCommend) && $addCommend) {
                $output = array(
                    'message' => "Successfully Add Commend",
                    'class' => 'alert-success'
                );
            }

            // set session message
            $this->session->set_flashdata('message', $output);
        }

        // - data
        $data['groupId'] = $groupId;
        $data['currentPageTitle'] = 'Adviser - Home';
        $data['mainContent'] = 'student/adviser';
        $data['subContent'] = 'adviser/addMessageToAdviser';

        // - load view
        $this->load->view('includes/student/header',$data);
		$this->load->view('student/adviser/addMessageToAdviser');
		$this->load->view('includes/student/footer');
        $this->load->view('includes/student/modals');
    }

    public function addThisesLogs($instructorId = null, $groupId = null, $thisesId = null, $action = null, $remarks = null){
        $data = array(
            'user_id' => $instructorId,
            'group_id' => $groupId,
            'thises_id' => $thisesId,
            'action' => $action,
            'date_created' => date('Y-m-d H:i:s')
        );

        // has comment
        if (isset($remarks) && $remarks) {
            $data['remark'] = $remarks;
            $data['remark_flag'] = 2;
        }else{
            $data['remark_flag'] = 1;
        }

        $addThisesLogs = $this->universal->insert(
            'thises_logs',
            $data
        );

        return $addThisesLogs;
    }

    public function getadviserDetails($userId = null){
        $adviserDetails = $this->universal->get(
            true,
            'users',
            '*',
            'row',
            array(
                'id' => $userId
            )
        );

        return $adviserDetails;
    }



    public function getThisesDetails($thisesId = null){
        $getThisesDetails = $this->universal->get(
            true,
            'thises',
            '*',
            'row',
            array(
                'id' => $thisesId,
                'status' => 1
            )
        );

        return $getThisesDetails;
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

    public function getGroupId($userId = null){
        $getGroupDetails = $this->universal->get(
            true,
            'thises_connect',
            '*',
            'row',
            array(
                'user_id' => $userId
            )
        );

        return $getGroupDetails;
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
}
?>
