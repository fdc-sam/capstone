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

            // get grup details
            $groupDetails = $this->getGroupDetails($projectHearingDetail['group_id']);
            $assignedGroup['data'][$key]['groupName'] = $groupDetails->thesis_group_name;

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
        // pre($assignedGroup['data']);
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
                'panelist_id, thises_id, count(id) AS count',
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
                array('thises_id')
            );
            $arr[] = $getChairman;
        }
        
        foreach ($arr as $key => $value) {

            if (isset($arr[$key+1]) && $arr[$key+1]) {
                if ($value->count >= $arr[$key+1]) {
                    $thises_id = $value->thises_id;
                }else{
                    $thises_id = $arr[$key+1]->thises_id;
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
}
