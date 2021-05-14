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
