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
        $get = $this->input->get();
        if (isset($get) && $get) {
            if ($get['errorFlag'] == 0) {
                $data['message'] = 'Group Accepted';
            }else{
                $data['message'] = 'Something wrong';
            }
        }
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

    // - home
	public function assignedGroupReject($projectTitleHearingId = null, $groupId = null){
        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;

        $post = $this->input->post();
        if (isset($post) && $post) {

            $updateRejectAssignedGroup = $this->universal->update(
                'project_title_hearing',
                array(
                    'status' => 2,
                    'reject_ression' => $post['reasion'],
                    'date_modified' => date('Y-m-d H:i:s')
                ),
                array(
                    'id' => $projectTitleHearingId
                )
            );

            $getUpdatedPanelist = $this->getProjectHearingDetails($groupId);
            $panelistId = array();
            foreach ($getUpdatedPanelist as $key => $value) {
                $panelistId[] = $value['panelist_id'];
            }
            $panelistIdJson = json_encode($panelistId);

            $this->universal->update(
                'thises_group_assigned_panelist',
                array(
                    'instructor_id' => $panelistIdJson,
                    'date_modified' => date('Y-m-d H:i:s')
                ),
                array(
                    'group_id' => $groupId
                )
            );

            if (isset($updateRejectAssignedGroup) && $updateRejectAssignedGroup) {
                $data['message'] = 'Group Rejected';
            }else{
                $data['message'] = 'Something Went Wrong';
            }

        }

        $currentUserGroup = $this->getCurrentUserGroupDetails($data['userInfo']->id);

        // - data
        $data['projectTitleHearingId'] = $projectTitleHearingId;
        $data['groupId'] = $groupId;
        $data['currentUserGroup'] = $currentUserGroup->name;
        $data['currentPageTitle'] = 'Head - Home';
        $data['mainContent'] = 'instructor/panel';
        $data['subContent'] = 'panel/assignedGroupReject';

        // - load view
        $this->load->view('includes/instructor/header',$data);
		$this->load->view('instructor/panel/assignedGroupReject');
		$this->load->view('includes/instructor/footer');
    }

    public function assignedGroupAccept($projectTitleHearingId = null, $groupId = null){
        $updateRejectAssignedGroup = $this->universal->update(
            'project_title_hearing',
            array(
                'status' => 1,
                'reject_ression' => "",
                'date_modified' => date('Y-m-d H:i:s')
            ),
            array(
                'id' => $projectTitleHearingId
            )
        );

        $getUpdatedPanelist = $this->getProjectHearingDetails($groupId);
        $panelistId = array();
        foreach ($getUpdatedPanelist as $key => $value) {
            $panelistId[] = $value['panelist_id'];
        }
        $panelistIdJson = json_encode($panelistId);

        $this->universal->update(
            'thises_group_assigned_panelist',
            array(
                'instructor_id' => $panelistIdJson,
                'date_modified' => date('Y-m-d H:i:s')
            ),
            array(
                'group_id' => $groupId
            )
        );

        if (isset($updateRejectAssignedGroup) && $updateRejectAssignedGroup) {
            redirect(base_url('instructor/panel?errorFlag=0'), 'refresh');
        }else{
            redirect(base_url('instructor/panel?errorFlag=1'), 'refresh');
        }

    }

    public function getAllAssignedCapstone(){
        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();

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
            $like = array();
        }

        //  get all proposals
        $assignedGroup = $this->universal->datatables(
            'project_title_hearing',
            '*',
            array(
                'panelist_id' => $data['userInfo']->id
            ),
            array(),
            array($length => $offset),
            $setorder,
            $like,
            true
        );

        foreach ($assignedGroup['data'] as $key => $projectHearingDetail) {
            $panelistDetails = $this->getPanelistDetails($projectHearingDetail['panelist_id']);
            $fullName = $panelistDetails->first_name." ".$panelistDetails->last_name." ".$panelistDetails->middle_name;
            $assignedGroup['data'][$key]['panelistFullName'] = $fullName;

            // get group details
            $groupDetails = $this->getGroupDetails($projectHearingDetail['group_id']);

            $assignedGroup['data'][$key]['groupName'] = isset($groupDetails->thesis_group_name)? $groupDetails->thesis_group_name: "";

            $getThisesDetails = $this->universal->get(
                true,
                'thises',
                '*',
                'array',
                array(
                    'thesis_group_id' => $projectHearingDetail['group_id'],
                    'status' => 1
                ),
            );
            $assignedGroup['data'][$key]['approvedFlag'] = 0;
            if (isset($getThisesDetails) && $getThisesDetails) {
                $assignedGroup['data'][$key]['approvedFlag'] = 1;
            }

        }

        if (isset($post['countResult']) && $post['countResult'] == 1) {
            echo count($assignedGroup['data']);
            return;
        }
        // pre();
        // die;

        echo json_encode(
            array(
                'draw' => intval($draw),
                "recordsTotal" => $assignedGroup['recordsTotal'],
                "recordsFiltered" => $assignedGroup['recordsFiltered'],
                "data" => $assignedGroup['data']
            )
        );
    }


    public function countAllAssignedCapstone(){
        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();

        //  get all proposals
        $assignedGroup = $this->universal->get(
            true,
            'project_title_hearing',
            '*',
            'array',
            array(
                'panelist_id' => $data['userInfo']->id,
                'status' => 0
            )
        );

        $output = 0;
        if (isset($assignedGroup) && $assignedGroup) {
            $output = count($assignedGroup);
        }
        echo $output;
    }

    public function projectTitleHearing(){
        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;

        $currentUserGroup = $this->getCurrentUserGroupDetails($data['userInfo']->id);

        // - data
        $data['currentUserGroup'] = $currentUserGroup->name;
        $data['currentPageTitle'] = 'Head - Home';
        $data['mainContent'] = 'instructor/panel';
        $data['subContent'] = 'panel/projectTitleHearing';

        // - load view
        $this->load->view('includes/instructor/header',$data);
		$this->load->view('instructor/panel/projectTitleHearing');
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

    public function viewProposal($panelistId = null, $groupId = null){
        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;

        // get group members
        $groupMemersDetails = $this->getGroupMemersDetails($groupId);

        $get = $this->input->get();
        if (isset($get['errorFlag'])) {
            // pre($get['errorFlag']);
            // die();
            if (!$get['errorFlag']) {
                $data['message'] = "Project Title Approved";
            }else{
                $data['message'] = "Something Went Wrong";
            }
        }

        $currentUserGroup = $this->getCurrentUserGroupDetails($data['userInfo']->id);

        // if current user is chairman
        $getChairman = $this->universal->get(
            true,
            'project_title_hearing',
            '*',
            'row',
            array(
                'chairman_flag' => 1,
                'panelist_id' => $panelistId,
                'group_id' => $groupId
            )
        );

        $data['chairmanFlag'] = false;
        if (isset($getChairman) && $getChairman) {
            $data['chairmanFlag'] = true;
        }

        // approved flagging
        $approvedFlagging = $this->universal->get(
            true,
            'thises',
            '*',
            'row',
            array(
                'thesis_group_id' => $groupId,
                'status' => 1
            )
        );

        if (isset($approvedFlagging) && $approvedFlagging) {
            $data['approvedProposalDetails'] = array(
                'approvedFlag' => 1,
                'approvedProposalDetails' => $approvedFlagging
            );
        }

        // - data
        $data['groupMemersDetails'] = $groupMemersDetails;
        $data['currentUserGroup'] = $currentUserGroup->name;
        $data['panelistId'] = $panelistId;
        $data['groupId'] = $groupId;
        $data['currentPageTitle'] = 'View Proposal';
        $data['mainContent'] = 'instructor/panel';
        $data['subContent'] = 'panel/viewProposal';

        // - load view
        $this->load->view('includes/instructor/header',$data);
		$this->load->view('instructor/panel/viewProposal');
		$this->load->view('includes/instructor/footer');
    }

    public function approvedProposal($groupId = null){
        $data['userInfo'] = $this->ion_auth->user()->row();

        // if current user is chairman
        $getAllProjects = $this->universal->get(
            true,
            'thises',
            '*',
            'array',
            array(
                'thesis_group_id' => $groupId
            )
        );
        $arr = array();
        foreach ($getAllProjects as $key => $getAllProject) {
            // get all count
            $getChairman = $this->universal->get(
                true,
                'thises_copy',
                'id, panelist_id, thises_id, count(id) AS count',
                'row',
                array(
                    'status' => 1,
                    'thesis_group_id' => $groupId,
                    'thises_id' => $getAllProject['id']
                ),
                array(),
                array(),
                array(),
                array(),
                array('id')
            );
            $arr[] = $getChairman;
        }

        foreach ($arr as $key => $value) {

            if (isset($arr[$key]) && $arr[$key]) {
                if (isset($arr[$key+1]) && $arr[$key+1]) {
                    if ($value->count >= $arr[$key+1]) {
                        $thises_id = $value->thises_id;
                    }else{
                        $thises_id = $arr[$key+1]->thises_id;
                    }
                }else{
                    $thises_id = $value->thises_id;
                }
            }
        }

        $approvedProposal = $this->universal->update(
            'thises',
            array(
                'status' => 1
            ),
            array(
                'id' => $thises_id
            )
        );

        $errorFlag = 1;
        if (isset($approvedProposal) && $approvedProposal) {
            $errorFlag = 0;
        }

        redirect(base_url('instructor/panel/viewProposal/'.$data['userInfo']->id.'/'.$groupId.'?errorFlag='.$errorFlag),'refresh');
    }


    public function getProposalDetails(){
        $post = $this->input->post();
        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;

        $getAllPanelists = $this->universal->get(
            true,
            'project_title_hearing',
            '*',
            'array',
            array(
                'group_id' => $post['groupId']
            )
        );

        foreach ($getAllPanelists as $key => $getAllPanelist) {
            $getProposalDetails = $this->universal->get(
                true,
                'thises',
                '*',
                'array',
                array(
                    'thesis_group_id' => $post['groupId']
                )
            );

            foreach ($getProposalDetails as $key => $value) {
                $hasData = $this->universal->get(
                    true,
                    'thises_copy',
                    '*',
                    'array',
                    array(
                        'thesis_group_id' => $post['groupId'],
                        'panelist_id' => $getAllPanelist['panelist_id'],
                        'thises_id' => $value['id']
                    )
                );

                if ($hasData) {
                    // code...

                }else{

                    $insertDataToCoppy = $this->universal->insert(
                        'thises_copy',
                        array(
                            'thises_id' => $value['id'],
                            'panelist_id' => $getAllPanelist['panelist_id'],
                            'thesis_group_id' =>$post['groupId'],
                            'title' => $value['title'],
                            'discreption' => $value['discreption'],
                            'limitations_of_the_studies' => $value['limitations_of_the_studies'],
                            'design_development_plans' => $value['design_development_plans'],
                            'created' => $value['created'],
                            'modified' => $value['modified'],
                            'status' => $value['status']
                        )
                    );
                }
            }
        }



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
            $like = array();
        }

        // get the teacher details to the database using the usniversal model
        $proposalDetails = $this->universal->datatables(
            'thises_copy',
            '*',
            array(
                'thesis_group_id' => $post['groupId'],
                'panelist_id' => $data['userInfo']->id
            ),
            array(),
            array($length => $offset),
            $setorder,
            $like,
            true
        );

        echo json_encode(
            array(
                'draw' => intval($draw),
                "recordsTotal" => $proposalDetails['recordsTotal'],
                "recordsFiltered" => $proposalDetails['recordsFiltered'],
                "data" => $proposalDetails['data']
            )
        );
    }

    public function thesisChangeStatus(){
        $post = $this->input->post();
        $hangeStatusFlag = $post['changeStatusFlag'];
        $thesisGroupId = $post['thesisGroupId'];
        $thesisId = $post['thesisId'];

        $data['userInfo'] = $this->ion_auth->user()->row();

        $output = array('error' => true);
        $update = $this->universal->update(
            'thises_copy',
            array(
                'status' => $hangeStatusFlag
            ),
            array(
                'thesis_group_id' => $thesisGroupId,
                'thises_id' => $thesisId,
                'panelist_id' => $data['userInfo']->id
            )
        );
        if ($update) {
            $output = array(
                'error' => false
            );
        }

        echo json_encode($output);
    }

    public function projectTitleHearingResult(){
        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;
        $currentUserGroup = $this->getCurrentUserGroupDetails($data['userInfo']->id);

        $approvedProposals = $this->universal->get(
            true,
            'thises',
            '*',
            'array',
            array(
                'status' => 1
            )
        );

        if (isset($approvedProposals) && $approvedProposals) {

            foreach ($approvedProposals as $key => $approvedProposal) {
                // get the group adviser
                $projectAdviser = $this->universal->get(
                    true,
                    'thises_group_assigned_adviser',
                    '*',
                    'row',
                    array(
                        'group_id' => $approvedProposal['thesis_group_id']
                    )
                );

                if (isset($projectAdviser) && $projectAdviser) {
                    // get instructor details
                    $adviser = $this->getPanelistDetails($projectAdviser->instructor_id);
                    $AdviserFullName = $adviser->first_name.' '.$adviser->middle_name.' '.$adviser->last_name;
                    $adviserRequestStatus = $projectAdviser->status;
                }

                $groupMembers = $this->universal->get(
                    true,
                    'users AS U',
                    'U.*',
                    'array',
                    array(
                        'TC.thesis_group_id' => $approvedProposal['thesis_group_id']
                    ),
                    array(),
                    array(
                        'thises_connect AS TC' => 'TC.user_id = U.id'
                    )
                );

                $groupMemberFullname = array();
                if (isset($groupMembers) && $groupMembers) {
                    foreach ($groupMembers as $groupMembersKey => $groupMember) {
                        $groupMemberFullname[] = $groupMember['first_name'].' '.$groupMember['middle_name'].' '.$groupMember['last_name'];
                    }
                }

                $groupDetails = $this->getGroupDetails($approvedProposal['thesis_group_id']);
                $chairmanFullname = $this->getChairman($approvedProposal['thesis_group_id']);

                // all data
                $approvedProposals[$key]['chairmanFullname'] = $chairmanFullname;
                $approvedProposals[$key]['groupMemberFullname'] = $groupMemberFullname;
                $approvedProposals[$key]['adviserFlag'] = isset($AdviserFullName)? true: false;
                $approvedProposals[$key]['adviserRequestStatus'] = isset($adviserRequestStatus)? $adviserRequestStatus: 100;
                $approvedProposals[$key]['adviser'] = isset($AdviserFullName)? $AdviserFullName: '<div class="badge badge-warning ml-2">No Assign Adviser</div>';
                $approvedProposals[$key]['groupName'] = isset($groupDetails->thesis_group_name)? $groupDetails->thesis_group_name: "";

            }
        }
        // pre($approvedProposals);
        // die;
        // - data
        $data['approvedProposals'] = $approvedProposals;
        $data['currentUserGroup'] = $currentUserGroup->name;
        $data['currentPageTitle'] = 'View Proposal';
        $data['mainContent'] = 'instructor/panel';
        $data['subContent'] = 'panel/projectTitleHearingResult';

        // - load view
        $this->load->view('includes/instructor/header',$data);
		$this->load->view('instructor/panel/projectTitleHearingResult');
		$this->load->view('includes/instructor/footer');
    }

    public function assignAdviser($groupId = null, $thisesId = null){
        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;
        $currentUserGroup = $this->getCurrentUserGroupDetails($data['userInfo']->id);
        $message = null;
        // if add adviser using post method
        $post = $this->input->post();
        if (isset($post) && $post) {
            $hasAdviser = $this->universal->get(
                true,
                'thises_group_assigned_adviser',
                'id',
                'row',
                array(
                    'group_id' => $groupId
                )
            );

            // insert thises_group_assigned_adviser_logs
            $instructorId = $post['selec2-assignAdviser'];
            $action = "Assigned Instructor to be an adviser";
            $assignedAdviserLogs = $this->addAssignedAdviserLogs($instructorId, $groupId, $thisesId, $action);

            // check ig has adviser
            if (isset($hasAdviser) && $hasAdviser) {
                $updateAssignAdviser = $this->universal->update(
                    'thises_group_assigned_adviser',
                    array(
                        'instructor_id' => $post['selec2-assignAdviser'],
                        'thises_id' => $thisesId,
                        'status' => 0,
                        'date_modified' => date('Y-m-d H:i:s')
                    ),
                    array(
                        'group_id' => $groupId,
                        'thises_id' => $thisesId
                    )
                );
                $message = "Data Successfully Updated";
            }else{
                $inserteAssignAdviser = $this->universal->insert(
                    'thises_group_assigned_adviser',
                    array(
                        'group_id' => $groupId,
                        'thises_id' => $thisesId,
                        'instructor_id' => $post['selec2-assignAdviser'],
                        'date_created' => date('Y-m-d H:i:s'),
                        'date_modified' => date('Y-m-d H:i:s'),
                    )
                );
                $message = "Data Successfully Inserted";
            }

            if (
                isset($inserteAssignAdviser) && $inserteAssignAdviser
            ) {
                $hasDataCapstone = $this->universal->get(
                    true,
                    'capstone1',
                    '*',
                    'array',
                    array(
                        'thesis_group_id' => $groupId
                    )
                );
            }
        }

        // get all panelist id og current param group id
        $groupPanelists = $this->universal->get(
            true,
            'project_title_hearing',
            'panelist_id',
            'array',
            array(
                'group_id' => $groupId,
                'status' => array(0,1)
            )
        );

        $panelistId = array();
        if (isset($groupPanelists) && $groupPanelists) {
            foreach ($groupPanelists as $key => $groupPanelist) {
                $panelistId[] = $groupPanelist['panelist_id'];
            }
        }

        $allInstructors = $this->universal->get(
            true,
            'users AS U',
            'U.*, G.name AS groupName',
            'array',
            array(
                'U.id NOT' => $panelistId,
                'G.id' => array(3,5)
            ),
            array(),
            array(
                'users_groups AS UG' => 'UG.user_id = U.id',
                'groups AS G' => 'G.id = UG.group_id'
            )
        );

        $currentGroupAdviser = $this->universal->get(
            true,
            'thises_group_assigned_adviser',
            'instructor_id',
            'row',
            array(
                'group_id ' => $groupId
            )
        );
        // pre($message);
        // die();

        if (isset($message) && $message) {
            $this->session->set_flashdata('message',
                '<div class="alert alert-warning">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="pe-7s-close"> </i>
                    </button>
                    <span>
                        <p>'.$message.'</p>
                    </span>
                </div>');
        }


        // - data
        $data['currentGroupAdviserId'] = isset($currentGroupAdviser->instructor_id)? $currentGroupAdviser->instructor_id: null;
        $data['allInstructors'] = $allInstructors;
        $data['groupId'] = $groupId;
        $data['thisesId'] = $thisesId;
        $data['currentUserGroup'] = $currentUserGroup->name;
        $data['currentPageTitle'] = 'View Proposal';
        $data['mainContent'] = 'instructor/panel';
        $data['subContent'] = 'panel/assignAdviser';

        // - load view
        $this->load->view('includes/instructor/header',$data);
		$this->load->view('instructor/panel/assignAdviser');
		$this->load->view('includes/instructor/footer');
    }

    public function groupDetails($groupId = null){
        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;
        $currentUserGroup = $this->getCurrentUserGroupDetails($data['userInfo']->id);

        $groupDetails = $this->getGroupDetails($groupId);
        $groupMemberDetails = $this->getGroupMemersDetails($groupId);

        $allPanelist = $this->getAllPanelist($groupId);
        // pre($allPanelist);
        // die();

        // view data
        $data['allPanelist'] = $allPanelist;
        $data['groupMemberDetails'] = $groupMemberDetails;
        $data['groupName'] = $groupDetails->thesis_group_name;
        $data['groupId'] = $groupId;
        $data['currentUserGroup'] = $currentUserGroup->name;
        $data['currentPageTitle'] = 'View Proposal';
        $data['mainContent'] = 'instructor/panel';
        $data['subContent'] = 'panel/groupDetails';

        // - load view
        $this->load->view('includes/instructor/header',$data);
		$this->load->view('instructor/panel/groupDetails');
		$this->load->view('includes/instructor/footer');
    }

    public function capstone1(){
        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;
        $currentUserGroup = $this->getCurrentUserGroupDetails($data['userInfo']->id);

        $capstone1Details = $this->universal->get(
            true,
            'capstone1',
            '*',
            'array',
            array(
                'panelist_id' => $data['userInfo']->id
            )
        );

        foreach ($capstone1Details as $key => $capstone1Detail) {
            $groupDetailsObj = $this->getGroupDetails($capstone1Detail['thesis_group_id']);
            $groupMemberDetailsArr = $this->getGroupMemersDetails($capstone1Detail['thesis_group_id']);
            $allPanelistArr = $this->getAllPanelist($capstone1Detail['thesis_group_id']);
            $proposalDetailsObj = $this->proposalDetails($capstone1Detail['thises_id']);


            $emptyFlag = false;
            $groupTotalScore = 0;
            foreach ($allPanelistArr as $allPanelistKey => $allPanelist) {

                $getPanelistScore = $this->universal->get(
                    true,
                    'capstone1 AS C1',
                    'sum(CERConnect.evaluation_rubric_score) AS score',
                    'row',
                    array(
                        'C1.panelist_id' => $allPanelist['panelist_id'],
                        'C1.thesis_group_id' => $allPanelist['group_id']
                    ),
                    array(),
                    array(
                        'capstone1_evaluation_rubric_connect AS CERConnect' => 'CERConnect.capstone_id = C1.id'
                    )
                );

                $score = $getPanelistScore->score;
                if ($score == null) {
                    $emptyFlag = true;
                }
                $groupTotalScore = $groupTotalScore + $score;

                $allPanelistArr[$allPanelistKey]['evaluationRubricScore'] = $getPanelistScore->score;
            }

            if (!$emptyFlag) {
                if ($groupTotalScore >= 63) {
                    $updatedStatus = 1;
                }elseif ($groupTotalScore >= 48 && $groupTotalScore <= 62) {
                    $updatedStatus = 1;
                }elseif ($groupTotalScore >= 32 && $groupTotalScore <= 47) {
                    $updatedStatus = 1;
                }elseif ( $groupTotalScore <= 31) {
                    $updatedStatus = 2;
                }
                $updateStatus = $this->universal->update(
                    'capstone1',
                    array(
                        'status' => $updatedStatus
                    ),
                    array(
                        'thesis_group_id' => $capstone1Detail['thesis_group_id']
                    )
                );
            }

            $capstone1Details[$key]['groupDetailsObj'] = $groupDetailsObj;
            $capstone1Details[$key]['proposalDetailsObj'] = $proposalDetailsObj;
            $capstone1Details[$key]['groupMemberDetails'] = $groupMemberDetailsArr;
            $capstone1Details[$key]['allPanelistArr'] = $allPanelistArr;
            // pre($allPanelistArr);
            // die();
        }



        // view data
        $data['capstone1Details'] = $capstone1Details;
        $data['currentuserId'] = $data['userInfo']->id;
        $data['currentUserGroup'] = $currentUserGroup->name;
        $data['currentPageTitle'] = 'View Proposal';
        $data['mainContent'] = 'instructor/panel';
        $data['subContent'] = 'panel/capstone1';

        // - load view
        $this->load->view('includes/instructor/header',$data);
		$this->load->view('instructor/panel/capstone1');
		$this->load->view('includes/instructor/footer');
    }

    public function groupEvaluation($groupId = null, $capstone1Id = null){
        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;
        $currentUserGroup = $this->getCurrentUserGroupDetails($data['userInfo']->id);

        $post = $this->input->post();
        if (isset($post) && $post) {

            foreach ($post['evaluationRubricId'] as $key => $evaluationRubricId) {
                $score = $post['score'][$key];
                $comment = $post['comment'][$key];

                // check if capstone1Id is exist
                $hasAlreadyExist = $this->universal->get(
                    true,
                    'capstone1_evaluation_rubric_connect',
                    '*',
                    'array',
                    array(
                        'capstone_id' => $capstone1Id,
                        'evaluation_rubric_id' => $evaluationRubricId
                    )
                );

                if (isset($hasAlreadyExist) && $hasAlreadyExist) {
                    // update score and comment
                    if ($score || $comment) {
                        $updateCapstone1EvaluationRubricConnect = $this->universal->update(
                            'capstone1_evaluation_rubric_connect',
                            array(
                                'evaluation_rubric_score' => $score,
                                'evaluation_rubric_comment' => $comment,
                                'date_modified' => date('Y-m-d H:i:s')
                            ),
                            array(
                                'capstone_id' => $capstone1Id,
                                'evaluation_rubric_id' => $evaluationRubricId,
                            )
                        );
                    }

                }else{
                    // insert score and comment
                    $insertCapstone1EvaluationRubricConnect = $this->universal->insert(
                        'capstone1_evaluation_rubric_connect',
                        array(
                            'capstone_id' => $capstone1Id,
                            'evaluation_rubric_id' => $evaluationRubricId,
                            'evaluation_rubric_score' => $score,
                            'evaluation_rubric_comment' => $comment,
                            'date_created' => date('Y-m-d H:i:s'),
                            'date_modified' => date('Y-m-d H:i:s')
                        )
                    );
                }
            } // foreach end

            $output = array(
                'message' => "Data Save",
                'class' => 'alert-success'
            );

            $this->session->set_flashdata('message', $output);
        }

        // data display
        $evaluationRubricDetails = $this->universal->get(
            true,
            'evaluation_rubric',
            '*',
            'array'
        );
        foreach ($evaluationRubricDetails as $EVRKey => $evaluationRubricDetail) {
            // check if capstone1Id is exist
            $CERConnect = $this->universal->get(
                true,
                'capstone1_evaluation_rubric_connect',
                '*',
                'row',
                array(
                    'capstone_id' => $capstone1Id,
                    'evaluation_rubric_id' => $evaluationRubricDetail['id']
                )
            );

            if (isset($CERConnect) && $CERConnect) {
                $evaluationRubricDetails[$EVRKey]['score'] = $CERConnect->evaluation_rubric_score;
                $evaluationRubricDetails[$EVRKey]['comment'] = $CERConnect->evaluation_rubric_comment;
            }
        }
        // pre($evaluationRubricDetails);
        // die;

        // view data
        $data['groupId'] = $groupId;
        $data['capstone1Id'] = $capstone1Id;
        $data['evaluationRubricDetails'] = $evaluationRubricDetails;
        $data['currentUserGroup'] = $currentUserGroup->name;
        $data['currentPageTitle'] = 'View Proposal';
        $data['mainContent'] = 'instructor/panel';
        $data['subContent'] = 'panel/groupEvaluation';

        // - load view
        $this->load->view('includes/instructor/header',$data);
		$this->load->view('instructor/panel/groupEvaluation');
		$this->load->view('includes/instructor/footer');
    }



    // get any details function
    public function proposalDetails($thisesId = null){
        $proposalDetails = $this->universal->get(
            true,
            'thises',
            '*',
            'row',
            array(
                'id' => $thisesId,
                'status' => 1
            )
        );

        return $proposalDetails;
    }
    public function getAllPanelist($groupId = null){
        $getAllPanelists = $this->universal->get(
            true,
            'project_title_hearing',
            '*',
            'array',
            array(
                'group_id' => $groupId
            )
        );

        foreach ($getAllPanelists as $key => $value) {
            $getPanelistDetails = $this->getPanelistDetails($value['panelist_id']);
            $getAllPanelists[$key]['panelistFullName'] = $getPanelistDetails->first_name.' '.$getPanelistDetails->middle_name.' '.$getPanelistDetails->last_name;
            $getAllPanelists[$key]['panelistEmail'] = $getPanelistDetails->email;
            $getAllPanelists[$key]['gender'] =  ($getPanelistDetails->gender == 1) ? "Male" : "Female" ;
        }

        return $getAllPanelists;
    }

    public function getChairman($groupId = null){
        $hasChairman = $this->universal->get(
            true,
            'project_title_hearing',
            '*',
            'row',
            array(
                'chairman_flag' => 1,
                'group_id' => $groupId
            )
        );

        if (isset($hasChairman) && $hasChairman) {
            $getChairmanDetails = $this->getPanelistDetails($hasChairman->panelist_id);
            $chairmanFullname = $getChairmanDetails->first_name.' '.$getChairmanDetails->middle_name.' '.$getChairmanDetails->last_name;
        }

        return isset($chairmanFullname)? $chairmanFullname: null;
    }

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

    public function getPanelistDetails($userId = null){
        $getPanelistDetails = $this->universal->get(
            true,
            'users',
            '*',
            'row',
            array(
                'id' => $userId
            )
        );
        return $getPanelistDetails;
    }

    public function getProjectHearingDetails($groupId = null){
        $getProjectHearingDetails = $this->universal->get(
            true,
            'project_title_hearing',
            '*',
            'array',
            array(
                'group_id' => $groupId,
                'status' => array(0,1)
            )
        );
        return $getProjectHearingDetails;
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

    public function addAssignedAdviserLogs($instructorId = null, $groupId = null, $thisesId = null, $action = null){
        $addAssignedAdviserLogs = $this->universal->insert(
            'thises_group_assigned_adviser_logs',
            array(
                'instructor_id' => $instructorId,
                'group_id' => $groupId,
                'thises_id' => $thisesId,
                'action' => $action,
                'date_created' => date('Y-m-d H:i:s')
            )
        );
    }
}
