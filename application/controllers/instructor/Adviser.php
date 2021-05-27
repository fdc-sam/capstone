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
                'status' => array(0,1,2)
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

        // pre($assignedGroups);
        // die;

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

            $getAllGroupAssigned = $this->universal->get(
                true,
                'thises_group_assigned_adviser',
                '*',
                'row',
                array(
                    'id' => $thisesGroupAssignedAdviserId
                )
            );

            // insert thises_group_assigned_adviser_logs
            $instructorId = $data['userInfo']->id;
            $action = "Adivisory Rejected";
            $groupId = $getAllGroupAssigned->group_id ;
            $thisesId = $getAllGroupAssigned->thises_id;
            $assignedAdviserLogs = $this->addThisesLogs($instructorId, $groupId, $thisesId, $action, $post['reasion']);

            if (isset($getAllGroupAssigned) && $getAllGroupAssigned) {
                $getCapstone1Details = $this->universal->get(
                    true,
                    'capstone1',
                    '*',
                    'row',
                    array(
                        'panelist_id' => $data['userInfo']->id,
                        'thises_id' => $getAllGroupAssigned->thises_id,
                        'thesis_group_id' => $getAllGroupAssigned->group_id
                    )
                );
                if (isset($getCapstone1Details) && $getCapstone1Details) {
                    // update capstone1
                    $updateCapstone1 = $this->universal->update(
                        'capstone1',
                        array(
                            'panelist_status' => 2, // accept
                            'panelist_id' => $data['userInfo']->id,
                            'thesis_group_id' => $getAllGroupAssigned->group_id,
                            'thises_id' => $getAllGroupAssigned->thises_id,
                            'date_created' => date('Y-m-d H:i:s'),
                            'date_modified' => date('Y-m-d H:i:s')
                        ),
                        array(
                            'thesis_group_id' => $getAllGroupAssigned->group_id,
                            'thises_id' => $getAllGroupAssigned->thises_id,
                            'panelist_id' => $data['userInfo']->id
                        )
                    );
                }else{
                    // insert data to capstone1
                    $insertCapstone1 = $this->universal->insert(
                        'capstone1',
                        array(
                            'panelist_status' => 2, // accept
                            'panelist_id' => $data['userInfo']->id,
                            'thesis_group_id' => $getAllGroupAssigned->group_id,
                            'thises_id' => $getAllGroupAssigned->thises_id,
                            'date_created' => date('Y-m-d H:i:s'),
                            'date_modified' => date('Y-m-d H:i:s')
                        )
                    );
                }
            }

            $output = array(
                'message' => "Error! Somthing went Wrong",
                'class' => 'alert-danger'
            );
            if (isset($updateForRejectReason) && $updateForRejectReason) {
                $output = array(
                    'message' => "Assigned Group Rejected",
                    'class' => 'alert-success'
                );
            }

            $this->session->set_flashdata('message', $output);
            redirect(base_url('instructor/adviser'), 'refresh');
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
        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;

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

        $getAllGroupAssigned = $this->universal->get(
            true,
            'thises_group_assigned_adviser',
            '*',
            'row',
            array(
                'id' => $thisesGroupAssignedAdviserId
            )
        );

        // insert thises_group_assigned_adviser_logs
        $instructorId = $data['userInfo']->id;
        $action = "Accept Adivisory";
        $groupId = $getAllGroupAssigned->group_id ;
        $thisesId = $getAllGroupAssigned->thises_id;
        $assignedAdviserLogs = $this->addThisesLogs($instructorId, $groupId, $thisesId, $action);

        if (isset($getAllGroupAssigned) && $getAllGroupAssigned) {
            $getCapstone1Details = $this->universal->get(
                true,
                'capstone1',
                '*',
                'row',
                array(
                    'panelist_id' => $data['userInfo']->id,
                    'thises_id' => $getAllGroupAssigned->thises_id,
                    'thesis_group_id' => $getAllGroupAssigned->group_id
                )
            );
            if (isset($getCapstone1Details) && $getCapstone1Details) {
                // update capstone1
                $updateCapstone1 = $this->universal->update(
                    'capstone1',
                    array(
                        'panelist_status' => 1, // accept
                        'panelist_id' => $data['userInfo']->id,
                        'thesis_group_id' => $getAllGroupAssigned->group_id,
                        'thises_id' => $getAllGroupAssigned->thises_id,
                        'date_created' => date('Y-m-d H:i:s'),
                        'date_modified' => date('Y-m-d H:i:s')
                    ),
                    array(
                        'thesis_group_id' => $getAllGroupAssigned->group_id,
                        'thises_id' => $getAllGroupAssigned->thises_id,
                        'panelist_id' => $data['userInfo']->id
                    )
                );
            }else{
                // insert data to capstone1
                $insertCapstone1 = $this->universal->insert(
                    'capstone1',
                    array(
                        'panelist_status' => 1, // accept
                        'panelist_id' => $data['userInfo']->id,
                        'thesis_group_id' => $getAllGroupAssigned->group_id,
                        'thises_id' => $getAllGroupAssigned->thises_id,
                        'date_created' => date('Y-m-d H:i:s'),
                        'date_modified' => date('Y-m-d H:i:s')
                    )
                );
            }
        }

        $output = array(
            'message' => "Error! Somthing went Wrong",
            'class' => 'alert-danger'
        );
        if (isset($updateForRejectReason) && $updateForRejectReason) {
            $output = array(
                'message' => "Assigned Group Accepted",
                'class' => 'alert-success'
            );
        }

        $this->session->set_flashdata('message', $output);
        redirect(base_url('instructor/adviser'), 'refresh');
    }

    public function viewLogs($groupId = null){
        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;
        $currentUserGroup = $this->getCurrentUserGroupDetails($data['userInfo']->id);

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
                    $outputName = "You";
                }else{
                    $outputName = "Assigned Group";
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
                                        <i class="fa fa-commenting" aria-hidden="true"></i>
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
        $pdfPageCount = $this->universal->get(
            true,
            'documents',
            '*',
            'row',
            array(
                'group_id' => $groupId
            )
        );
        // $documentsId = null,
        // $groupId = null,
        // $documentFileName = null
        $output .= '
            <a href="'.base_url('instructor/adviser/commentDocumentPDF/'.$pdfPageCount->id.'/'.$groupId.'/'.$pdfPageCount->file_name).'">
                <div class="vertical-timeline-item vertical-timeline-element">
                    <div>
                        <div class="vertical-timeline-element-icon bounce-in">
                            <div class="timeline-icon border-primary">
                                <i class="fa fa-comments" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="vertical-timeline-element-content bounce-in">
                            <p>
                                <h4 class="timeline-title">Add Message to Group</h4>
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
        $data['currentUserGroup'] = $currentUserGroup->name;
        $data['currentPageTitle'] = 'Adviser - Home';
        $data['mainContent'] = 'instructor/adviser';
        $data['subContent'] = 'adviser/viewLogs';

        // - load view
        $this->load->view('includes/instructor/header',$data);
		$this->load->view('instructor/adviser/viewLogs');
		$this->load->view('includes/instructor/footer');
    }


    // - home
	public function advisory(){
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
                'status' => 1
            )
        );

        foreach ($assignedGroups as $assignedGroupKey => $assignedGroup) {
            $groupMembers = $this->getGroupMemersDetails($assignedGroup['group_id']);
            $groupDetails = $this->getGroupDetails($assignedGroup['group_id']);

            // get document
            $documentFiles = $this->getDocumentFile($assignedGroup['group_id']);

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

            $assignedGroups[$assignedGroupKey]['thesisDocuments'] = $documentFiles;
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

        // pre($assignedGroups);
        // die;

        // - data
        $data['assignedGroups'] = $assignedGroups;
        $data['currentUserGroup'] = $currentUserGroup->name;
        $data['currentPageTitle'] = 'Adviser - Home';
        $data['mainContent'] = 'instructor/adviser';
        $data['subContent'] = 'adviser/advisory';

        // - load view
        $this->load->view('includes/instructor/header',$data);
		$this->load->view('instructor/adviser/advisory');
		$this->load->view('includes/instructor/footer');
    }

    public function viewDocumentPDF($documentsId = null, $groupId = null, $documentFileName = null){
        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;
        $currentUserGroup = $this->getCurrentUserGroupDetails($data['userInfo']->id);

        // get pdf page count
        $pdfPageCount = $this->universal->get(
            true,
            'documents',
            'page_count',
            'row',
            array(
                'group_id' => $groupId,
                'id' => $documentsId
            )
        );

        // - data
        $data['documentsId'] = $documentsId;
        $data['groupId'] = $groupId;
        $data['documentFileName'] = $documentFileName;
        $data['pageCount'] = $pdfPageCount->page_count;
        $data['currentUserGroup'] = $currentUserGroup->name;
        $data['currentPageTitle'] = 'Adviser - Home';
        $data['mainContent'] = 'instructor/adviser';
        $data['subContent'] = 'adviser/viewDocumentPDF';

        // - load view
        $this->load->view('includes/instructor/header',$data);
		$this->load->view('instructor/adviser/viewDocumentPDF');
		$this->load->view('includes/instructor/footer');
    }

    public function commentDocumentPDF($documentsId = null, $groupId = null, $documentFileName = null){
        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;
        $currentUserGroup = $this->getCurrentUserGroupDetails($data['userInfo']->id);

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

        // get pdf page count
        $pdfPageCount = $this->universal->get(
            true,
            'documents',
            '*',
            'row',
            array(
                'group_id' => $groupId,
                'id' => $documentsId
            )
        );

        // - data
        $data['documentsId'] = $documentsId;
        $data['groupId'] = $groupId;
        $data['documentFileName'] = $documentFileName;
        $data['pageCount'] = $pdfPageCount->page_count;
        $data['currentUserGroup'] = $currentUserGroup->name;
        $data['currentPageTitle'] = 'Adviser - Home';
        $data['mainContent'] = 'instructor/adviser';
        $data['subContent'] = 'adviser/commentDocumentPDF';

        // - load view
        $this->load->view('includes/instructor/header',$data);
		$this->load->view('instructor/adviser/commentDocumentPDF');
		$this->load->view('includes/instructor/footer');
    }

    // get any details function
    public function getDocumentFile($groupId = null){
        $thesisDocument = $this->universal->get(
            true,
            'documents',
            '*',
            'row',
            array(
                'group_id' => $groupId
            )
        );

        return isset($thesisDocument)? $thesisDocument: null;
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

    // get the capstone project
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

}
