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

        // create a random Thesis Group Name code
        $thesisGroupName = $this->getRandomString(10);

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
            $insertGroup = $this->universal->insert(
                'thises_group',
                array(
                    'thesis_group_name' => $thesisGroupName,
                    'created' => date('Y-m-d H:i:s'),
                    'modified' => date('Y-m-d H:i:s')
                )
            );
            $addGroupMember = $this->universal->insert(
                'thises_connect',
                array(
                    'thesis_group_id' => $insertGroup,
                    'batch_id' => $currentUserBatchCodeId,
                    'user_id' => $data['userInfo']->id,
                    'created' => date('Y-m-d H:i:s'),
                    'modified' => date('Y-m-d H:i:s')
                )
            );
            $thesisGroupId = $insertGroup;
        }else{
            $thesisGroupId = $hasGroup->thesis_group_id;
        }

        // add members to the group
        foreach ($post['groupMemberId'] as $key => $value) {
            // determine if has already a group
            $hasGroup1 = $this->universal->get(
                true,
                'thises_connect',
                '*',
                'row',
                array(
                    'user_id' => $value
                )
            );

            if (!$hasGroup1) {
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

        $data['getMySignature'] = $this->universal->get(
            true,
            'users_signature',
            '*',
            'row',
            array(
                'users_id' => $data['userInfo']->id
            )
        );

        // pre($getMySignature);
        // die();

        // - data
        $data['currentPageTitle'] = 'Student - My Profile';
        $data['mainContent'] = 'home/MyProfile';
        $data['subContent'] = 'home/MyProfile';

        $this->load->view('includes/student/header',$data);
		$this->load->view('student/myProfile');
        $this->load->view('includes/student/footer');
        $this->load->view('includes/student/modals');
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



        // - data
        $data['currentPageTitle'] = 'Student - Chagne Password';
        $data['mainContent'] = 'student/home';
        $data['subContent'] = 'home/changePassword';

        $this->load->view('includes/student/header',$data);
		$this->load->view('student/changePassword');
        $this->load->view('includes/student/footer');
        $this->load->view('includes/student/modals');
    }

    public function addPropose(){
        // $proposeData = array();

        // get the current user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;

        // get the current user Thises Group Id
        $currentThisesGroupId = $this->getThisesGroupId($data['userInfo']->id);

        // get the current user batch code
        $currentUserBatchCodeId = $this->getStudentBatchCodeId($data['userInfo']->email);

        if (!$currentThisesGroupId) {
            // create a random Thesis Group Name code
            $thesisGroupName = $this->getRandomString(10);

            $insertGroup = $this->universal->insert(
                'thises_group',
                array(
                    'thesis_group_name' => $thesisGroupName,
                    'created' => date('Y-m-d H:i:s'),
                    'modified' => date('Y-m-d H:i:s')
                )
            );
            $addGroupMember = $this->universal->insert(
                'thises_connect',
                array(
                    'thesis_group_id' => $insertGroup,
                    'batch_id' => $currentUserBatchCodeId,
                    'user_id' => $data['userInfo']->id,
                    'created' => date('Y-m-d H:i:s'),
                    'modified' => date('Y-m-d H:i:s')
                )
            );
            $currentThisesGroupId = $insertGroup;
        }

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
                        'limitations_of_the_studies' => $post['limitations'][$key],
                        'design_development_plans' => $post['designDevelopmentPlan'][$key],
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

        // if (!$currentThisesGroupId) {
        //
        //     // get the current user information
        //     $data['userInfo'] = $this->ion_auth->user()->row();
        //     $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;
        //
        //     // get the current user batch code
        //     $currentUserBatchCodeId = $this->getStudentBatchCodeId($data['userInfo']->email);
        //
        //     // create a random Thesis Group Name code
        //     $thesisGroupName = $this->getRandomString(10);
        //
        //     $insertGroup = $this->universal->insert(
        //         'thises_group',
        //         array(
        //             'thesis_group_name' => $thesisGroupName,
        //             'created' => date('Y-m-d H:i:s'),
        //             'modified' => date('Y-m-d H:i:s')
        //         )
        //     );
        //     $addGroupMember = $this->universal->insert(
        //         'thises_connect',
        //         array(
        //             'thesis_group_id' => $insertGroup,
        //             'batch_id' => $currentUserBatchCodeId,
        //             'user_id' => $data['userInfo']->id,
        //             'created' => date('Y-m-d H:i:s'),
        //             'modified' => date('Y-m-d H:i:s')
        //         )
        //     );
        //
        //     $currentThisesGroupId = $insertGroup;
        // }

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
                if ($value->status == 2 || $value->status == 3) {
                    $sideStatusBar = 'bg-danger';
                    $requestStatus = '<div class="badge badge-danger ml-2">Rejected</div>';
                }

                $proposeData .= '
                    <li class="list-group-item">

                            <div class="todo-indicator '.$sideStatusBar.' "></div>
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <a href="'.base_url().'student/home/capstoneDetails/'.$value->id.'" class="hrefProposal">
                                        <div class="widget-content-left">
                                            <div class="widget-heading">
                                                <span class="timeline-title">'.$value->title.'</span>
                                            </div>
                                            <div class="widget-subheading proposalDescription">
                                                <span style="
                                                    display:inline-block;
                                                    white-space: nowrap;
                                                    overflow: hidden;
                                                    text-overflow: ellipsis;
                                                    max-width: 28ch;
                                                ">
                                                '.$value->discreption.' asdasdasd asdasdasdasdasdasdasdasdasdasdasdasd
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="widget-content-right">
                                        '.$requestStatus.'
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

    public function getGroupMembers(){
        // get the current user information
        $data['userInfo'] = $this->ion_auth->user()->row();

        // get the current user Thises Group Id
        $currentThisesGroupId = $this->getThisesGroupId($data['userInfo']->id);


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
            $like = array(
                'TC.id' => $search['value'],
                'TC.thesis_group_id' => $search['value'],
                'TC.thises_id' => $search['value'],
                'TC.batch_id ' => $search['value'],
                'TC.user_id' => $search['value'],
                'TC.created' => $search['value'],
                'TC.modified' => $search['value']
            );
        }

        // get the teacher details to the database using the usniversal model
        $batchDataResult = $this->universal->datatables(
            'thises_connect AS TC',
            'TC.id,
            TC.thesis_group_id,
            TC.thises_id,
            TC.batch_id,
            TC.user_id,
            TC.created,
            TC.modified,
            U.id AS users_id,
            U.email,
            U.first_name,
            U.middle_name,
            U.last_name,
            U.gender',
            array(
                'TC.thesis_group_id' => $currentThisesGroupId,
                'TC.user_id !=' => $data['userInfo']->id
            ),
            array(
                'users as U' => 'U.id = TC.user_id'
            ),
            array($length => $offset),
            $setorder,
            $like,
            true
        );

        foreach ($batchDataResult['data'] as $key => $value) {

            //  get member roles
            $getGroupMemberRoles = $this->universal->get(
                true,
                'users_roles AS UR',
                'R.role_name',
                'row',
                array(
                    'UR.user_id' => $value['users_id']
                ),
                array(),
                array(
                    'roles AS R' => 'R.id = UR.role_id'
                )
            );

            $batchDataResult['data'][$key]['role_name'] =  isset($getGroupMemberRoles->role_name)? $getGroupMemberRoles->role_name : 'Not Role';
        }


        echo json_encode(
            array(
                'draw' => intval($draw),
                "recordsTotal" => $batchDataResult['recordsTotal'],
                "recordsFiltered" => $batchDataResult['recordsFiltered'],
                "data" => $batchDataResult['data']
            )
        );
    }

    public function deleteGroupMember(){
        $post = $this->input->post();
        $deletePropossal = $this->universal->delete(
            'thises_connect',
            array(
                'user_id' => $post['user_id']
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

    public function capstoneDetails($proposalId = null){
        // get the current user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;

        // get the current user group id
        $currentThisesGroupId = $this->getThisesGroupId($data['userInfo']->id);

        $getCapstoneDetails = $this->universal->get(
            true,
            'thises AS T',
            '
                T.id, T.thesis_group_id, T.title, T.discreption, T.limitations_of_the_studies, T.design_development_plans, T.created, T.created, T.modified, T.status,
                U.first_name, U.middle_name, U.last_name, U.email,
                US.signatures,
                R.role_name,
                TG.thesis_group_name
            ',
            'all',
            array(
                'T.id' => $proposalId
            ),
            array(),
            array(
                'thises_connect AS TC' => 'TC.thesis_group_id = T.thesis_group_id' ,
                'users AS U' => 'U.id = TC.user_id',
                'users_signature AS US' => 'US.users_id = U.id',
                'users_roles AS UR' => 'UR.user_id = U.id',
                'roles AS R' => 'R.id = UR.role_id',
                'thises_group AS TG' => 'TG.id = T.thesis_group_id'
            )
        );

        // pre($getCapstoneDetails);
        // die();
        if ($getCapstoneDetails) {
            $data['getCapstoneDetails'] = $getCapstoneDetails;
        }

        // get the thesis document
        $thesisDocument = $this->universal->get(
            true,
            'documents AS D',
            'D.*',
            'all',
            array(
                'D.group_id' => $currentThisesGroupId,
                'D.thesis_id' => $proposalId
            )
        );

        if ($thesisDocument) {
            $data['thesisDocuments'] = $thesisDocument;
        }

        // - data
        $data['proposalId'] = $proposalId;
        $data['currentPageTitle'] = 'Student - Proposal Details';
        $data['mainContent'] = 'student/home';
        $data['subContent'] = 'home/capstoneDetails';

        $this->load->view('includes/student/header',$data);
		$this->load->view('student/capstoneDetails');
        $this->load->view('includes/student/footer');
        $this->load->view('includes/student/modals');
    }

    public function deleteDocument(){
        $post = $this->input->post();

        // get the thesis document
        $thesisDocument = $this->universal->get(
            true,
            'documents AS D',
            'D.*',
            'row',
            array(
                'D.id' => $post['documentId']
            )
        );

        $result = $this->universal->delete(
            'documents',
            array(
                'id' => $post['documentId']
            )
        );

        $output = false;
        if ($result) {
            // delete file to the local
            unlink(FCPATH.'uploads/'.$thesisDocument->file_name);
            $output = true;
        }

        echo $output;
    }

    public function viewDocumentPDF($documentId = null){
        // get the current user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;

        // get the current user group id
        $currentThisesGroupId = $this->getThisesGroupId($data['userInfo']->id);

        // get the thesis document
        $thesisDocument = $this->universal->get(
            true,
            'documents AS D',
            'D.*',
            'row',
            array(
                'D.group_id' => $currentThisesGroupId,
                'D.id' => $documentId
            )
        );

        if ($thesisDocument) {
            // pre($thesisDocument);
            // die();
            $data['thesisDocuments'] = $thesisDocument;
        }

        // - data
        $data['currentPageTitle'] = 'Student - Proposal Details';
        $data['mainContent'] = 'student/home';
        $data['subContent'] = 'home/viewDocumentPDF';

        $this->load->view('includes/student/header',$data);
		$this->load->view('student/viewDocumentPDF');
        $this->load->view('includes/student/footer');
        $this->load->view('includes/student/modals');
    }

    public function myGroup(){
        // get the current user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;

        // get the current user group id
        $currentThisesGroupId = $this->getThisesGroupId($data['userInfo']->id);

        $data['updateFlag'] = false;
        $post = $this->input->post();
        if ($post) {
            $updateGroupName = $this->universal->update(
                'thises_group',
                array(
                    'thesis_group_name' => $post['groupName']
                ),
                array(
                    'id' => $post['id']
                )
            );

            if ($updateGroupName) {
                $data['updateFlag'] = true;
            }
        }

        $data['groupDetails'] = $this->universal->get(
            true,
            'thises_group',
            '*',
            'row',
            array(
                'id' => $currentThisesGroupId
            )
        );

        // pre($data['groupDetails']);
        // die();
        // - data
        $data['currentPageTitle'] = 'Student - Proposal Details';
        $data['mainContent'] = 'student/home';
        $data['subContent'] = 'home/myGroup';

        $this->load->view('includes/student/header',$data);
		$this->load->view('student/myGroup');
        $this->load->view('includes/student/footer');
        $this->load->view('includes/student/modals');
    }

    public function myRole(){
        // get the current user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;


        $data['usersRoles'] = $this->universal->get(
            true,
            'users_roles',
            '*',
            'row',
            array(
                'user_id' => $data['userInfo']->id
            )
        );

        $data['updateFlag'] = false;
        $post = $this->input->post();
        if ($data['usersRoles']) {

            if ($post) {
                $updateRole = $this->universal->update(
                    'users_roles',
                    array(
                        'role_id' => $post['selectedRole']
                    ),
                    array(
                        'user_id' =>  $data['userInfo']->id
                    )
                );

                if ($updateRole) {
                    $data['updateFlag'] = true;
                }
            }
        }else{

            if ($post) {
                $insertRole = $this->universal->insert(
                    'users_roles',
                    array(
                        'role_id' => $post['selectedRole'],
                        'user_id' => $data['userInfo']->id
                    )
                );

                if ($insertRole) {
                    $data['updateFlag'] = true;
                }
            }
        }

        $data['roles'] = $this->universal->get(
            true,
            'roles',
            '*',
            'all'
        );

        // pre($data['roles']);
        // die();

        // - data
        $data['currentPageTitle'] = 'Student - Proposal Details';
        $data['mainContent'] = 'student/home';
        $data['subContent'] = 'home/myRole';

        $this->load->view('includes/student/header',$data);
		$this->load->view('student/myRole');
        $this->load->view('includes/student/footer');
        $this->load->view('includes/student/modals');
    }

    public function mySignature(){
        // get the current user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;

        $getMySignature = $this->universal->get(
            true,
            'users_signature',
            '*',
            'row',
            array(
                'users_id' => $data['userInfo']->id
            )
        );

        $data['signatureFlag'] = false;
        $post = $this->input->post();
        if ($post) {

            $image = array();
            $image['image_parts'] = explode(";base64,", $post['signed']);

            $image['image_type_aux'] = explode("image/", $image['image_parts'][0]);

            $image['image_type'] = $image['image_type_aux'][1];

            $image['image_base64'] = base64_decode($image['image_parts'][1]);

            if ($getMySignature) {
                $updateSignature = $this->universal->update(
                    'users_signature',
                    array(
                        'signatures' => $image['image_parts'][1]
                    ),
                    array(
                        'users_id' => $data['userInfo']->id
                    )
                );
            }else {
                $insertSignature = $this->universal->insert(
                    'users_signature',
                    array(
                        'users_id' => $data['userInfo']->id,
                        'signatures' => $image['image_parts'][1]
                    )
                );
            }

            if ($updateSignature || $insertSignature) {
                redirect(base_url('student/home/myProfile'));
            }

        }

        // - data
        $data['currentPageTitle'] = 'Student - Proposal Details';
        $data['mainContent'] = 'student/home';
        $data['subContent'] = 'home/mySignature';

        $this->load->view('includes/student/header',$data);
		$this->load->view('student/mySignature');
        $this->load->view('includes/student/footer');
        $this->load->view('includes/student/modals');
    }
}
?>
