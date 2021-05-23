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

        // get assigned group
        $assignedGroups = $this->universal->get(
            true,
            'thises_group_assigned_adviser',
            '*',
            'array',
            array(
                'instructor_id' => $data['userInfo']->id,
                'status' => array(0,1)
            )
        );

        foreach ($assignedGroups as $assignedGroupKey => $assignedGroup) {
            $groupMembers = $this->getGroupMemersDetails($assignedGroup['group_id']);
            $groupDetails = $this->getGroupDetails($assignedGroup['group_id']);

            $groupMemberFullname = array();
            foreach ($groupMembers as $key => $groupMember) {
                $groupMemberFullname[] = $groupMember['first_name'].' '.$groupMember['middle_name'].' '.$groupMember['last_name'];
            }

            if ($assignedGroup['status'] == 1) {
                $statusFlag = '<div class="badge badge-success ml-2">Accept</div>';
            }else if ($assignedGroup['status'] == 2) {
                $statusFlag = '<div class="badge badge-danger ml-2">Reject</div>';
            }else {
                $statusFlag = '<div class="badge badge-warning ml-2">Pending</div>';

            }

            $assignedGroups[$assignedGroupKey]['statusFlag'] = $statusFlag;
            $assignedGroups[$assignedGroupKey]['groupDetails'] = $groupDetails;
            $assignedGroups[$assignedGroupKey]['groupName'] = isset($groupDetails->thesis_group_name)? $groupDetails->thesis_group_name: '';
            $assignedGroups[$assignedGroupKey]['groupMembers'] = $groupMemberFullname;

        }

        //  if accept
        $get = $this->input->get();
        if (isset($get['errorFlag'])) {
            if ($get['errorFlag'] == 0) {
                $data['message'] = 'Group Accepted';
            }else{
                $data['message'] = 'Something Went Wrong';
            }
        }

        // - data
        $data['assignedGroups'] = $assignedGroups;
        $data['currentUserGroup'] = $currentUserGroup->name;
        $data['currentPageTitle'] = 'Adviser - Home';
        $data['mainContent'] = 'instructor/adviser';
        $data['subContent'] = 'adviser/index';

        // - load view
        $this->load->view('includes/instructor/header',$data);
		$this->load->view('instructor/adviser/index');
		$this->load->view('includes/instructor/footer');
    }

    public function rejectGroup($thisesGroupAssignedAdviserId = null){
        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;
        $currentUserGroup = $this->getCurrentUserGroupDetails($data['userInfo']->id);

        // if has post
        $post = $this->input->post();
        if (isset($post) && $post) {
            $updateForRejectReason = $this->universal->update(
                'thises_group_assigned_adviser',
                array(
                    'reject_ression' => $post['reasion'],
                    'status' => 2
                ),
                array(
                    'id' => $thisesGroupAssignedAdviserId
                )
            );
            if (isset($updateForRejectReason) && $updateForRejectReason) {
                $data['message'] = 'Group rejected';
            }
        }

        // - data
        $data['thisesGroupAssignedAdviserId'] = $thisesGroupAssignedAdviserId;
        $data['currentUserGroup'] = $currentUserGroup->name;
        $data['currentPageTitle'] = 'Adviser - Home';
        $data['mainContent'] = 'instructor/adviser';
        $data['subContent'] = 'adviser/rejectGroup';

        // - load view
        $this->load->view('includes/instructor/header',$data);
		$this->load->view('instructor/adviser/rejectGroup');
		$this->load->view('includes/instructor/footer');
    }

    public function acceptGroup($thisesGroupAssignedAdviserId = null){
        // if has post
        $updateForRejectReason = $this->universal->update(
            'thises_group_assigned_adviser',
            array(
                'status' => 1
            ),
            array(
                'id' => $thisesGroupAssignedAdviserId
            )
        );
        $errorFlag = 1;
        if (isset($updateForRejectReason) && $updateForRejectReason) {
            $errorFlag = 0;
        }
        redirect(base_url('instructor/adviser?errorFlag='.$errorFlag), 'refresh');
    }


    // get any details function
    public function getGroupDetails($groupId = null){
        $groupDetails = $this->universal->get(
            true,
            'thises_group',
            '*',
            'row',
            array(
                'id' => $groupId
            )
        );

        return $groupDetails;
    }


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

    public function getGroupMemersDetails($groupId = null){
        $groupMembersDetails = $this->universal->get(
            true,
            'thises_connect AS TC',
            'U.*, R.role_name, R.discreption',
            'array',
            array(
                'TC.thesis_group_id' => $groupId
            ),
            array(),
            array(
                'users AS U' => 'U.id = TC.user_id',
                'users_roles AS UR' => 'UR.user_id = U.id',
                'roles AS R' => 'R.id = UR.role_id'
            )
        );

        return $groupMembersDetails;
    }

}
