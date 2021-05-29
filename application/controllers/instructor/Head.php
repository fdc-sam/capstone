<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Head extends CI_Controller {

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
        $data['mainContent'] = 'instructor/head';
        $data['subContent'] = 'head/index';

        // - load view
        $this->load->view('includes/instructor/header',$data);
		$this->load->view('instructor/head/index');
		$this->load->view('includes/instructor/footer');
    }

    public function getAllInstructor(){
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
                'U.first_name' => $search['value'],
                'U.middle_name' => $search['value'],
                'U.last_name' => $search['value']
            );
        }

        // get the teacher details to the database using the usniversal model
        $usersDataResult = $this->universal->datatables(
            'users AS U',
            'U.*',
            array(
                'G.name' => 'instructor'
            ),
            array(
                'users_groups AS UG' => 'UG.user_id = U.id',
                'groups AS G' => 'UG.group_id = G.id'
            ),
            array($length => $offset),
            $setorder,
            $like,
            true
        );

        echo json_encode(
            array(
                'draw' => intval($draw),
                "recordsTotal" => $usersDataResult['recordsTotal'],
                "recordsFiltered" => $usersDataResult['recordsFiltered'],
                "data" => $usersDataResult['data']
            )
        );
    }

    public function changeStatus(){
        $activation = $this->input->post();

        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();

        $updateUserStatus = $this->universal->update(
            'users',
            array(
                'activation_selector' => $activation['activation']
            ),
            array(
                'id' => $activation['userId']
            )
        );

        $result = array(
            'message' => 'User Data not Updated',
            'error' => true
        );
        if ($updateUserStatus) {
            $result = array(
                'message' => 'User Data Updated',
                'error' => false
            );
        }

        echo json_encode($result);
    }

    public function batch(){

        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;

        // genirate batch code
        $batch_code = $this->create_bactch_code(5);

        $has_batch = $this->universal->get(
            'true',
            'batch',
            '*',
            'all',
            array(
                'code' => $batch_code
            )
        );

        if ($has_batch) {
            $this->batch();
        }

        $currentUserGroup = $this->getCurrentUserGroupDetails($data['userInfo']->id);

        // - data
        $data['currentUserGroup'] = $currentUserGroup->name;
        $data['currentPageTitle'] = 'Head - Batch';
        $data['mainContent'] = 'instructor/head';
        $data['subContent'] = 'head/batch';
        $data['batch_code'] = $batch_code;

        // - load view
        $this->load->view('includes/instructor/header',$data);
		$this->load->view('instructor/head/batch.php');
		$this->load->view('includes/instructor/footer');
    }

    // // genirate batch code function
    public function create_bactch_code($len){
		$result = "";
		$chars = "abcdefghijklmnopqrstuvwxyz0123456789";
		$charArray = str_split($chars);
		for($i = 0; $i < $len; $i++){
			$randItem = array_rand($charArray);
			$result .= "".$charArray[$randItem];
		}
		return $result;
	}

    public function viewStudent($batchCode = null){
        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;

        $currentUserGroup = $this->getCurrentUserGroupDetails($data['userInfo']->id);

        // - data
        $data['currentUserGroup'] = $currentUserGroup->name;
        $data['currentPageTitle'] = 'Head - Batch';
        $data['mainContent'] = 'instructor/head';
        $data['subContent'] = 'head/viewStudent';
        $data['batchCode'] = $batchCode;

        // - load view
        $this->load->view('includes/instructor/header',$data);
		$this->load->view('instructor/head/viewStudent.php');
		$this->load->view('includes/instructor/footer');
    }

    public function getBatchStudent(){
        $post = $this->input->post();
        $batchCode = $post['batchCode'];
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
                'b.id' => $search['value'],
                'b.batch_from' => $search['value'],
                'b.batch_to' => $search['value'],
                'b.code' => $search['value'],
                'b.status' => $search['value'],
                'b.created' => $search['value'],
                'b.modified' => $search['value']
            );
        }

        // get the teacher details to the database using the usniversal model
        $batchDataResult = $this->universal->datatables(
            'batch_connect AS BC',
            'U.*',
            array(
                'B.code' => $batchCode
            ),
            array(
                'users AS U' => 'U.email = BC.email',
                'batch AS B' => 'B.id = BC.batch_id'
            ),
            array($length => $offset),
            $setorder,
            $like,
            true
        );

        $data['data'] = array();
        foreach ($batchDataResult['data'] as $k => $sheet){
            // get the count of
            $countBatch = $this->universal->get(
                true,
                'batch_connect',
                'id',
                'all',
                array(
                    'batch_id' =>  $sheet['id']
                )
            );
            $sheet['count'] =  count($countBatch);
            array_push($data['data'], $sheet);
        }

        echo json_encode(
            array(
                'draw' => intval($draw),
                "recordsTotal" => $batchDataResult['recordsTotal'],
                "recordsFiltered" => $batchDataResult['recordsFiltered'],
                "data" => $data['data']
            )
        );
    }

    public function insert_batch(){
        sleep(2);
        $post = $this->input->post();
        $batch_from = $post['batch_from'];
        $batch_to = $post['batch_to'];
        $batch_code = $post['batch_code'];
        $batch_description = $post['batch_description'];
        $currentDateTime = date('Y-m-d H:i:s');

        $batch_from = date_create($batch_from);
        $batch_from = date_format($batch_from, 'Y-m-d H:i:s');

        $batch_to = date_create($batch_to);
        $batch_to = date_format($batch_to, 'Y-m-d H:i:s');

        // isert batch data
        $getResult = $this->universal->insert(
            'batch',
            array(
                'batch_from' => $batch_from,
                'batch_to' => $batch_to,
                'code' => $batch_code,
                'description' => $batch_description,
                'created' => $currentDateTime,
                'modified' => $currentDateTime
            )
        );

        $output = array(
            'message' => 'failed',
            'error' => true
        );

        if ($getResult) {
            $output = array(
                'message' => 'success',
                'error' => false
            );
        }

        echo json_encode($output);
    }

    public function getBatchDataTable(){

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
                'b.id' => $search['value'],
                'b.batch_from' => $search['value'],
                'b.batch_to' => $search['value'],
                'b.code' => $search['value'],
                'b.status' => $search['value'],
                'b.created' => $search['value'],
                'b.modified' => $search['value']
            );
        }

        // get the teacher details to the database using the usniversal model
        $batchDataResult = $this->universal->datatables(
            'batch AS b',
            '*',
            array(),
            array(),
            array($length => $offset),
            $setorder,
            $like,
            true
        );

        $data['data'] = array();
        foreach ($batchDataResult['data'] as $k => $sheet){
            // get the count of
            $countBatch = $this->universal->get(
                true,
                'batch_connect',
                'id',
                'all',
                array(
                    'batch_id' =>  $sheet['id']
                )
            );
            $sheet['count'] =  count($countBatch);
            array_push($data['data'], $sheet);
        }

        echo json_encode(
            array(
                'draw' => intval($draw),
                "recordsTotal" => $batchDataResult['recordsTotal'],
                "recordsFiltered" => $batchDataResult['recordsFiltered'],
                "data" => $data['data']
            )
        );
    }

    public function changeBatchStatus(){
        $post = $this->input->post();

        if ($post['batchStatus'] == 1) {
            // to deactivate
            $status = 0;
        }else{
            // to active
            $status = 1;
        }

        $updateBatchStatus = $this->universal->update(
            'batch',
            array(
                'status' => $status
            ),
            array(
                'id' => $post['id']
            )
        );
        echo $updateBatchStatus;
    }

    // - proposal
	public function proposal(){

        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;

        $currentUserGroup = $this->getCurrentUserGroupDetails($data['userInfo']->id);

        // - data
        $data['currentUserGroup'] = $currentUserGroup->name;
        $data['currentPageTitle'] = 'Head - Home';
        $data['mainContent'] = 'instructor/head';
        $data['subContent'] = 'head/proposal';

        // - load view
        $this->load->view('includes/instructor/header',$data);
		$this->load->view('instructor/head/proposal');
		$this->load->view('includes/instructor/footer');
    }

    // head Notifications
    public function getAllProposal(){

        // - variables from datatable
        $post = $this->input->post();
        $draw = $this->input->post('draw');
        $length = $this->input->post('length');
        $offset = $this->input->post('start');
        $search = $this->input->post('search');
        $order = $this->input->post('order');
        $columns = $this->input->post('columns');


        // order of the data pass
        if($draw == 1){
            $setorder = array(
                'TG.assigned_panelist_flag' => "DESC",
                'TG.modified' => "ASC"
            );
        }else{
            $setorder = array();
        }

        //search functionality
        if(empty($search['value'])){
            $like = array();
        }else{
            $like = array(
                'TG.thesis_group_name' => $search['value'],
                'TG.created' => $search['value'],
                'T.title' => $search['value']
            );
        }

        //  get all proposals
        $thisesGroups = $this->universal->datatables(
            'thises_group AS TG',
            'TG.*, T.title',
            array(),
            array(
                'thises AS T' => 'T.thesis_group_id = TG.id',
                'thises_connect AS TC' => 'TC.thesis_group_id = TG.id',
                'users AS U' => 'U.id = TC.user_id'
            ),
            array($length => $offset),
            $setorder,
            $like,
            true
        );

        $data['data'] = array();
        if (isset($thisesGroups['data']) && $thisesGroups['data']) {

            foreach ($thisesGroups['data'] as $k => $thisesGroup){
                // get the count of

                $thisesProposals = $this->universal->get(
                    true,
                    'thises AS T',
                    '*',
                    'all',
                    array(
                        'T.thesis_group_id' =>  $thisesGroup['id']
                    )
                );



                if ($thisesProposals) {
                    $groupPoposals = '';
                    foreach ($thisesProposals as $key => $thisesProposal) {
                        if (isset($thisesProposal->thesis_group_id)) {
                            $count = $key + 1;
                            $groupPoposals .= '<span class="proposalTitle">'.$count.') '.$thisesProposal->title.'</span><br>';
                            $groupPoposals .= '<span class="proposalDiscreption"> - '.$thisesProposal->discreption.'</span><br>';
                            $thisesGroup['proposalCreated'] = date("g:ia | D jS F Y", strtotime($thisesProposal->created));
                            $thisesGroup['proposalModified'] = date("g:ia | D jS F Y", strtotime($thisesProposal->modified));
                            $thisesGroup['thesisGroupId'] = $thisesProposal->thesis_group_id;


                            //  capstone1 start
                            $allPanelistArr = $this->getAllPanelist($thisesProposal->thesis_group_id);
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
                                    $thisesGroup['scoreStatus'] = '<div class="mb-2 mr-2 badge badge-primary">Superior</div>';
                                }elseif ($groupTotalScore >= 48 && $groupTotalScore <= 62) {
                                    $thisesGroup['scoreStatus'] = '<div class="mb-2 mr-2 badge badge-primary">Good</div>';
                                }elseif ($groupTotalScore >= 32 && $groupTotalScore <= 47) {
                                    $thisesGroup['scoreStatus'] = '<div class="mb-2 mr-2 badge badge-primary">Acceptable</div>';
                                }elseif ( $groupTotalScore <= 31) {
                                    $thisesGroup['scoreStatus'] = '<div class="mb-2 mr-2 badge badge-danger">Unacceptable</div>';
                                }
                            }else{
                                $thisesGroup['scoreStatus'] = '<div class="mb-2 mr-2 badge badge-warning">On Proccess</div>';
                            }
                            $thisesGroup['groupTotalScore'] = $groupTotalScore;
                            //  capstone1 end

                        }
                    }
                    $thisesGroup['groupPoposals'] =  $groupPoposals;
                }

                $usersData = $this->universal->get(
                    true,
                    'thises_connect AS TC',
                    'U.first_name, U.middle_name, U.last_name',
                    'all',
                    array(
                        'TC.thesis_group_id' =>  $thisesGroup['id']
                    ),
                    array(),
                    array(
                        'users AS U' => 'U.id = TC.user_id'
                    )
                );
                if ($usersData) {
                    $fullName = '';
                    foreach ($usersData as $key => $userData) {
                        if (isset($userData->first_name)) {
                            $fullName .= '<b> - '.$userData->first_name.' '.$userData->middle_name.' '.$userData->last_name.'</b><br>';
                        }
                    }

                }

                $newKey = isset($thisesGroups['data'][$k + 1]['id'])? $thisesGroups['data'][$k + 1]['id'] : null;
                $assignedFlag = false;
                $assignedPanelistFullName = '';
                $countPanelist = 0;
                if ($newKey != $thisesGroup['id']) {
                    $assignedPanelist = $this->getAssignedPanelist($thisesGroup['id']);
                    // pre($assignedPanelist);
                    // die();
                    if (isset($assignedPanelist) && $assignedPanelist && $assignedPanelist != null) {
                        $instructors = json_decode($assignedPanelist->instructor_id);
                        $countPanelist = isset($instructors)? count($instructors): 0;
                        $assignedPanelistFullName = '';
                        if ($countPanelist > 1) {
                            $assignedFlag = true;
                            foreach ($instructors as $key => $value) {
                                $instructorDetails = $this->getPanelistDetails($value);
                                $assignedPanelistFullName .= $instructorDetails->first_name.' '.$instructorDetails->middle_name.' '.$instructorDetails->last_name.'<br>';
                            }
                        }
                    }

                    // count panelist who rejected the group
                    $panelistRejectTheGroup = $this->getPanelistRejectTheGroup($thisesGroup['id']);
                    $countPanelistRejectTheGroup = 0;
                    if ($panelistRejectTheGroup) {
                        $countPanelistRejectTheGroup = count($panelistRejectTheGroup);
                    }

                    // get the chairman og the panel
                    $getChairman =  $this->universal->get(
                        true,
                        'project_title_hearing AS PTH',
                        'U.*, PTH.group_id',
                        'row',
                        array(
                            'PTH.group_id' => $thisesGroup['id'],
                            'PTH.chairman_flag' => 1
                        ),
                        array(),
                        array(
                            'users AS U' => 'U.id = PTH.panelist_id'
                        )
                    );

                    if (isset($getChairman) && $getChairman) {
                        $chairmanFullname = $getChairman->first_name.' '.$getChairman->middle_name.' '.$getChairman->last_name;
                        $chairmanBtn ='

                            <a href="'.base_url('instructor/head/chairman/'.$thisesGroup['id'].'/'.$getChairman->id).'">
                                '.$chairmanFullname.'
                            </a>
                        ';
                        $thisesGroup['chairman'] = $chairmanBtn;
                    }else{
                        $chairmanBtn ='
                            <a href="'.base_url('instructor/head/chairman/'.$thisesGroup['id']).'">
                                <div class="mb-2 mr-2 badge badge-danger">No C  hairman Assigne</div>
                            </a>
                        ';
                        $thisesGroup['chairman'] = $chairmanBtn;
                    }



                    if (isset($thisesGroup['groupPoposals'])) {
                        $thisesGroup['countPanelistRejectTheGroup'] =  $countPanelistRejectTheGroup;
                        $thisesGroup['countPanelist'] =  $countPanelist;
                        $thisesGroup['assignedFlag'] =  $assignedFlag;
                        $thisesGroup['assignedPanelistFullName'] =  $assignedPanelistFullName;
                        array_push($data['data'], $thisesGroup);
                    }
                }
            }
        }


        echo json_encode(
            array(
                // 'order' => $columns[$order[0]['column']]['data'],
                'draw' => intval($draw),
                "recordsTotal" => count($data['data']),
                "recordsFiltered" => count($data['data']),
                "data" => $data['data']
            )
        );
    }

    public function chairman($thisesGroup = null, $panelistId = null){
        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();

        $panelists = $this->getProjectHearingDetails($thisesGroup);
        $panelistDetails = array();
        if (isset($panelists) && $panelists) {
            foreach ($panelists as $key => $panelist) {
                $panelistDetails[] = $this->getPanelistDetails($panelist['panelist_id']);
            }
        }


        // pre($panelistDetails);
        // die();
        // - data
        $data['panelistId'] = isset($panelistId)? $panelistId : null;
        $data['panelistDetails'] = $panelistDetails;
        $data['thisesGroup'] = $thisesGroup;
        $data['currentPageTitle'] = 'Team Proposal';
        $data['mainContent'] = 'instructor/head';
        $data['subContent'] = 'head/chairman';

        // - load view
        $this->load->view('includes/instructor/header',$data);
		$this->load->view('instructor/head/chairman');
		$this->load->view('includes/instructor/footer');
    }

    public function addChairman(){
        $post = $this->input->post();


        if ($post['oldChairman']) {
            $updateOldChairman = $this->universal->update(
                'project_title_hearing',
                array(
                    'chairman_flag' => 0,
                    'date_modified' => date('Y-m-d H:i:s')
                ),
                array(
                    'panelist_id' => $post['oldChairman'],
                    'group_id' => $post['thisesGroup']
                )
            );
        }

        $updateChairman = $this->universal->update(
            'project_title_hearing',
            array(
                'chairman_flag' => 1,
                'date_modified' => date('Y-m-d H:i:s')
            ),
            array(
                'panelist_id' => $post['panelist'],
                'group_id' => $post['thisesGroup']
            )
        );

        redirect(base_url('instructor/head/proposal') , 'refresh');
    }

    public function proposalDetails($thesisGroupId = null){
        $this->load->library('layout');
        $approvedFlag = false;

        // get all team proposal
        $getCapstoneDetails = $this->universal->get(
            true,
            'thises AS T',
            '
                T.id, T.thesis_group_id, T.title, T.discreption, T.limitations_of_the_studies, T.design_development_plans, T.created, T.created, T.modified, T.status,
                TG.thesis_group_name
            ',
            'all',
            array(
                'T.thesis_group_id' => $thesisGroupId
            ),
            array(),
            array(
                'thises_group AS TG' => 'TG.id = T.thesis_group_id'
            )
        );

        foreach ($getCapstoneDetails as $key => $getCapstoneDetail) {
            $userDetails = $this->universal->get(
                true,
                'thises_connect AS TC',
                '
                    U.first_name, U.middle_name, U.last_name, U.email,
                    US.signatures,
                    R.role_name,

                ',
                'all',
                array(
                    'TC.thesis_group_id' => $getCapstoneDetail->thesis_group_id
                ),
                array(),
                array(
                    'users AS U' => 'U.id = TC.user_id',
                    'users_signature AS US' => 'US.users_id = U.id',
                    'users_roles AS UR' => 'UR.user_id = U.id',
                    'roles AS R' => 'R.id = UR.role_id',

                )
            );

            $getCapstoneDetail->users = $userDetails;
        }



        // check if has approved proposal
        foreach ($getCapstoneDetails as $key => $thisesGroupData) {
            if ($thisesGroupData->status == 1) {
                $approvedFlag = true;
            }
        }

        $getProposalDetails = array();
        foreach ($getCapstoneDetails as $key => $thisesGroupData) {

            // convert date time to `5:56am | Fri 9th April 2021`
            $thisesGroupData->created = date("g:ia | D jS F Y", strtotime($thisesGroupData->created));
            $thisesGroupData->modified = date("g:ia | D jS F Y", strtotime($thisesGroupData->modified));

            $thisesGroupData->approvedFlag = $approvedFlag;
            array_push($getProposalDetails, $thisesGroupData);
        }

        // pre($getProposalDetails);
        // die();

        if ($getProposalDetails) {
            $data['getCapstoneDetails'] = $getProposalDetails;
        }

        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;

        $currentUserGroup = $this->getCurrentUserGroupDetails($data['userInfo']->id);

        // - data
        $data['currentUserGroup'] = $currentUserGroup->name;
        $data['currentPageTitle'] = 'Team Proposal';
        $data['mainContent'] = 'instructor/head';
        $data['subContent'] = 'head/proposalDetails';
        $data['thesisGroupId'] = $thesisGroupId;

        // - load view
        $this->load->view('includes/instructor/header',$data);
		$this->load->view('instructor/head/proposalDetails');
		$this->load->view('includes/instructor/footer');
    }

    public function teamProposal($thesisGroupId = null){
        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;

        // - data
        $data['currentPageTitle'] = 'Team Proposal';
        $data['mainContent'] = 'instructor/head';
        $data['subContent'] = 'head/teamProposal';
        $data['thesisGroupId'] = $thesisGroupId;

        // - load view
        $this->load->view('includes/instructor/header',$data);
		$this->load->view('instructor/head/teamProposal');
		$this->load->view('includes/instructor/footer');
    }

    public function getProposalDetails(){
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
                'thesis_group_id' => $search['value'],
                'title' => $search['value'],
                'discreption' => $search['value'],
                'created' => $search['value'],
                'modified' => $search['value']
            );
        }

        //  get all proposals
        $thisesGroups = $this->universal->datatables(
            'thises',
            '*',
            array(
                'thesis_group_id' => $post['thesisGroupId']
            ),
            array(),
            array($length => $offset),
            $setorder,
            $like,
            true
        );

        $approvedFlag = false;
        $result = array();

        // check if has approved proposal
        foreach ($thisesGroups['data'] as $key => $thisesGroupData) {
            if ($thisesGroupData['status'] == 1) {
                $approvedFlag = true;
            }
        }

        foreach ($thisesGroups['data'] as $key => $thisesGroupData) {

            // convert date time to `5:56am | Fri 9th April 2021`
            $thisesGroupData['created'] = date("g:ia | D jS F Y", strtotime($thisesGroupData['created']));
            $thisesGroupData['modified'] = date("g:ia | D jS F Y", strtotime($thisesGroupData['modified']));

            $thisesGroupData['approvedFlag'] = $approvedFlag;
            array_push($result, $thisesGroupData);
        }

        echo json_encode(
            array(
                'draw' => intval($draw),
                "recordsTotal" => $thisesGroups['recordsTotal'],
                "recordsFiltered" => $thisesGroups['recordsFiltered'],
                "data" => $result
            )
        );
    }

    public function thesisChangeStatus(){
        $post = $this->input->post();
        $status = 0;

        if ($post['activation'] == 'Reject') {
            $status = 2;
        }
        if ($post['activation'] == 'Approve') {
            $status = 1;
        }

        $updateThesisStatus = $this->universal->update(
            'thises',
            array(
                'status' => $status
            ),
            array(
                'id' => $post['proposalId']
            )
        );
    }

    public function groups(){
        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;


        // $instructorDetails = $this->universal->get(
        //     true,
        //     ''
        // );

        $currentUserGroup = $this->getCurrentUserGroupDetails($data['userInfo']->id);

        // - data
        $data['currentUserGroup'] = $currentUserGroup->name;
        $data['currentPageTitle'] = 'Team Proposal';
        $data['mainContent'] = 'instructor/head';
        $data['subContent'] = 'head/groups';

        // - load view
        $this->load->view('includes/instructor/header',$data);
		$this->load->view('instructor/head/groups');
		$this->load->view('includes/instructor/footer');
    }

    public function getAllGroups(){

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
                'TG.thesis_group_name' => $search['value'],
                'TG.created' => $search['value'],
                'U.first_name' => $search['value'],
                'U.middle_name' => $search['value'],
                'U.last_name' => $search['value'],
                'TG.modified' => $search['value']
            );
        }

        //  get all proposals
        $thisesGroups = $this->universal->datatables(
            'thises_group AS TG',
            'TG.*',
            array(),
            array(),
            array($length => $offset),
            $setorder,
            $like,
            true
        );

        $result = array();
        $count = 0;
        $matchFlag = 0;
        foreach ($thisesGroups['data'] as $key => $thisesGroupData) {

            if ($matchFlag == $thisesGroupData['id'] || $matchFlag == 0) {
                $result[$count] = array(
                    "id" => $thisesGroupData['id'],
                    "discreption" => $thisesGroupData['discreption'],
                    "title" => $thisesGroupData['title'],
                    "members" => array()
                );
                $matchFlag = $thisesGroupData['id'];
            }else{
                $count ++;
                $result[$count] = array(
                    "id" => $thisesGroupData['id'],
                    "discreption" => $thisesGroupData['discreption'],
                    "title" => $thisesGroupData['title'],
                    "members" => array()
                );
                $matchFlag = $thisesGroupData['id'];
            }
        }

        foreach ($result as $reskey => $value) {
            $fullName = null;
            foreach ($thisesGroups['data'] as $key => $thisesGroupData) {
                if ($value['id'] == $thisesGroupData['id']) {
                    $fullName = " ".$thisesGroupData['first_name']." ".$thisesGroupData['middle_name']." ".$thisesGroupData['last_name'];
                    array_push($result[$reskey]['members'], $fullName);
                    $matchFlag = $thisesGroupData['id'];
                }
            }

        }

        echo json_encode(
            array(
                'draw' => intval($draw),
                "recordsTotal" => $thisesGroups['recordsTotal'],
                "recordsFiltered" => $thisesGroups['recordsFiltered'],
                "data" => $thisesGroups['data']
            )
        );

    }


    public function assignPanelist($thesisGroupId = null){
        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;
        $data['thesisGroupId'] = $thesisGroupId;

        $intructors = $this->universal->get(
            true,
            'users AS U',
            'U.*',
            'all',
            array(
                'UG.group_id' => 5
            ),
            array(),
            array(
                'users_groups AS UG' => 'UG.user_id = U.id',
            )
        );

        $data['intructors'] = $intructors;

        $currentUserGroup = $this->getCurrentUserGroupDetails($data['userInfo']->id);

        // - data
        $data['currentUserGroup'] = $currentUserGroup->name;
        $data['currentPageTitle'] = 'Team Proposal';
        $data['mainContent'] = 'instructor/head';
        $data['subContent'] = 'head/assignPanelist';

        // - load view
        $this->load->view('includes/instructor/header',$data);
		$this->load->view('instructor/head/assignPanelist');
		$this->load->view('includes/instructor/footer');
    }

    public function assignPanelistToGroup($params = array()){
        $thesisGroupId = $params['thesisGroupId'];
        $instructorIds = $params['instructorIds'];

        // count assigned panelist
        if (isset($instructorIds) && $instructorIds ) {
            $countPanelist = count($instructorIds);
            if ($countPanelist < 3) {
                return true;
            }
        }

        $ids = json_encode($instructorIds);

        // check if has already assigned
        $hasAssignedPanelist = $this->universal->get(
            true,
            'thises_group_assigned_panelist',
            '*',
            'row',
            array(
                'group_id' => $thesisGroupId
            )
        );

        if (!isset($hasAssignedPanelist) && !$hasAssignedPanelist) {
            $assignedPanelist = $this->universal->insert(
                'thises_group_assigned_panelist',
                array(
                    'group_id' => $thesisGroupId,
                    'instructor_id' => $ids,
                    'date_created' => date('Y-m-d H:i:s'),
                    'date_modified' => date('Y-m-d H:i:s')
                )
            );

            if ($assignedPanelist) {
                $updateGroup = $this->universal->update(
                    'thises_group',
                    array(
                        'assigned_panelist_flag' => 1
                    ),
                    array(
                        'id' => $thesisGroupId
                    )
                );
                if ($updateGroup) {
                    // $result = array(
                    //     'error' => false,
                    //     'messsage' => 'Successfully panelist Assigned'
                    // );
                }

            }else {
                // $result = array(
                //     'error' => true,
                //     'messsage' => 'error'
                // );
            }
        }else{

            $updateAssignedPanelist = $this->universal->update(
                'thises_group_assigned_panelist',
                array(
                    'instructor_id' => $ids,
                    'date_modified' => date('Y-m-d H:i:s')
                )
            );

            if ($updateAssignedPanelist) {
                $updateGroup = $this->universal->update(
                    'thises_group',
                    array(
                        'assigned_panelist_flag' => 1
                    ),
                    array(
                        'id' => $thesisGroupId
                    )
                );
                if ($updateGroup) {
                    // $result = array(
                    //     'error' => false,
                    //     'messsage' => 'Successfully panelist Assigned'
                    // );
                }

            }else {
                // $result = array(
                //     'error' => true,
                //     'messsage' => 'error'
                // );
            }
        }
    }

    public function addProjectHearingSched(){
        $posts = $this->input->post();
        $hearingDateTime = $posts['hearingDateTime'];
        $currentDate = date('Y-m-d H:i:s');

        $result = array();
        $errorFlag = true;
        $message = '';

        $params = array(
            'thesisGroupId' => $posts['groupId'],
            'instructorIds' => $posts['panelistId']
        );
        $assignPanelistToGroup = $this->assignPanelistToGroup($params);
        $temp = json_decode($assignPanelistToGroup);
        if (isset($temp) && $temp) {
            $result = array(
                'errorFlag' => true,
                'message' => 'panelist lessthan 3'
            );
            echo json_encode($result);
            return;
        }

        if (isset($posts['editFlag']) && $posts['editFlag'] == 1) {
            $deltePanelist = $this->universal->delete(
                'project_title_hearing',
                array(
                    'group_id' => $posts['groupId']
                )
            );
            if ($deltePanelist) {
                foreach ($posts['panelistId'] as $key => $panelistId) {

                    $projectTitleHearing = $this->universal->insert(
                        'project_title_hearing',
                        array(
                            'group_id' => $posts['groupId'],
                            'panelist_id' => $panelistId,
                            'chairman_flag' => $chairmanFlag,
                            'hearing_date' => $hearingDateTime,
                            'date_create' => $currentDate,
                            'date_modified' => $currentDate
                        )
                    );

                    if ($projectTitleHearing) {
                        $errorFlag = false;
                        $message = 'Data Saved';
                    }
                }
            }
        }else {
            foreach ($posts['panelistId'] as $key => $panelist) {
                $groupId = $posts['groupId'][$key];

                $panelistIds = json_decode($panelist);
                foreach ($panelistIds as $key1 => $panelistId) {

                    // add to database
                    $projectTitleHearing = $this->universal->insert(
                        'project_title_hearing',
                        array(
                            'group_id' => $groupId,
                            'panelist_id' => $panelistId,
                            'chairman_flag' => $chairmanFlag,
                            'hearing_date' => $hearingDateTime,
                            'date_create' => $currentDate,
                            'date_modified' => $currentDate
                        )
                    );

                    if ($projectTitleHearing) {
                        $errorFlag = false;
                        $message = 'Data Saved';
                    }
                }
            }
        }


        $result = array(
            'errorFlag' => $errorFlag,
            'message' => $message
        );

        echo json_encode($result);
    }


    public function assignPanel(){
        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;

        $currentUserGroup = $this->getCurrentUserGroupDetails($data['userInfo']->id);

        // - data
        $data['currentUserGroup'] = $currentUserGroup->name;
        $data['currentPageTitle'] = 'Team Proposal';
        $data['mainContent'] = 'instructor/head';
        $data['subContent'] = 'head/assignPanel';

        // - load view
        $this->load->view('includes/instructor/header',$data);
		$this->load->view('instructor/head/assignPanel');
		$this->load->view('includes/instructor/footer');
    }

    public function getAllInstructorSelect2(){
        $instructors = $this->universal->get(
            true,
            'users AS U',
            'U.*',
            'array',
            array(
                'G.name' => array('instructor', 'IT Head')
            ),
            array(),
            array(
                'users_groups AS UG' => 'UG.user_id = U.id',
                'groups AS G' => 'UG.group_id = G.id'
            )
        );

        $results = array();
        foreach ($instructors as $key => $instructor) {
            $fullName = $instructor['first_name']." ".$instructor['middle_name']." ".$instructor['last_name'];
            $results[] = array(
                'id' => $instructor['id'],
                'text' => $fullName
            );
        }

        echo json_encode($results);
    }

    public function getAllGroupsSelect2(){
        $search = $this->input->get();
        if(empty($search['searchTerm'])){
            $like = array();
        }else{
            $like = array(
                'GC.thesis_group_name' => $search['searchTerm']
            );
        }

        $groups = $this->universal->get(
            true,
            'thises_group AS GC',
            'GC.*',
            'array',
            array(),
            $like
        );

        $results = array();
        foreach ($groups as $key => $group) {

            // check if has group id on project_title_hearing
            $hasGroup = $this->universal->get(
                true,
                'project_title_hearing',
                '*',
                'row',
                array(
                    'group_id' =>  $group['id']
                )
            );

            if (!$hasGroup) {
                $results[] = array(
                    'id' => $group['id'],
                    'text' => $group['thesis_group_name']
                );
            }

        }
        echo json_encode($results);
    }

    public function getThisesProposal(){
        $post = $this->input->post();

        $thisesProposals = $this->universal->get(
            true,
            'thises',
            'title',
            'array',
            array(
                'thesis_group_id' => $post['groupId']
            )
        );
        $output = '';
        $errorFlag = true;
        if (isset($thisesProposals) && $thisesProposals) {
            foreach ($thisesProposals as $key => $thisesProposal) {
                $output .= '<li>
                        <span style="font-family: Arial; font-size: 12pt; font-weight: bold; font-style: italic;">
                            '.$thisesProposal['title'].'
                        </span>
                    </li>
                ';
            }
            $errorFlag = false;
        }


        $result = array(
            'messsage' => $output,
            'error_flag' => $errorFlag
        );

        echo json_encode($result);
    }



    public function titleHearingDetails($groupId = null){
        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;

        $where = array('status' => array(0,1));
        if (isset($groupId) && $groupId) {
            $where = array(
                'group_id' => $groupId,
                'status' => array(0,1)
            );
        }

        // get the title for hearing
        $projects = $this->universal->get(
            true,
            'project_title_hearing',
            '*',
            'array',
            $where
        );

        $result = array();
        $outputs = array();
        $count = 0;
        $groupMatchFlag = null;
        foreach ($projects as $key => $project) {
            if ($count == 0) {
                $groupMatchFlag = $project['group_id'];
            }
            $groupMatchFlag = isset($projects[$key+1]['group_id'])? $projects[$key+1]['group_id']: null;
            if ($project['group_id'] == $groupMatchFlag) {
                $result[] = $project['panelist_id'];
            }else{
                $result[] = $project['panelist_id'];
                $projects[$key]['panelistArr'] = $result;
                array_push($outputs, $projects[$key]);
                $result = array();
            }
        }

        $display = '';
        foreach ($outputs as $key => $output) {
            // get the groupDetails
            $groupDetails = $this->getGroupDetails($output['group_id']);

            // get project details
            $projectDetails = $this->getProjectDetails($output['group_id']);
            $projectTitles = '';
            foreach ($projectDetails as $key => $projectDetail) {
                $projectTitles .= '<li>
                        <span style="font-family: Arial; font-size: 12pt; font-weight: bold; font-style: italic;">
                            '.$projectDetail['title'].'
                        </span>
                    </li>
                ';
            }

            // get all panelist details
            $panelistNames = '';
            foreach ($output['panelistArr'] as $key => $panelistId) {
                $panelistDetails = $this->getPanelistDetails($panelistId);
                $fullName = $panelistDetails->first_name.' '.$panelistDetails->middle_name.' '.$panelistDetails->last_name;
                $panelistNames .='<span style="font-family: Arial; font-size: 12pt; font-weight: bold;">'.$fullName.', </span>';
            }


            $display .= '<div class="table-wrapper">
                <a href="'.base_url('instructor/head/titleHearingEdit/'.$output['group_id']).'" class="btn btn-sm btn-light removeProjectHearing" style="float: right;">Edit</a>
                <table class="TableGrid">
                    <tr>
                        <td style="width: 15%;">
                            <p style="text-align: center;">
                                <span style="font-family: Arial; font-size: 12pt; font-weight: bold;">TEAM </span>
                            </p>
                        </td>
                        <td>
                            <p style="text-align: center;">
                                <span style="font-family: Arial; font-size: 12pt; font-weight: bold;">PROPOSED TITLES </span>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="text-align: center;">
                                <span style="font-family: Arial; font-size: 12pt;"> '.$groupDetails->thesis_group_name.'</span>
                            </p>
                        </td>
                        <td>
                            <ul>
                                '.$projectTitles.'
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="text-align: right;">
                                <span style="font-family: Arial; font-size: 12pt; font-weight: bold;">Panel: </span>
                            </p>
                        </td>
                        <td>
                            <p>
                                '.$panelistNames.'
                            </p>
                        </td>
                    </tr>
                </table>
                <p>&nbsp;</p>
            </div>';
        }


        // - data
        $data['display'] = $display;
        $data['currentPageTitle'] = 'Team Proposal';
        $data['mainContent'] = 'instructor/head';
        $data['subContent'] = 'head/titleHearingDetails';

        // - load view
        $this->load->view('includes/instructor/header',$data);
		$this->load->view('instructor/head/titleHearingDetails');
		$this->load->view('includes/instructor/footer');
    }

    public function titleHearingEdit($groupId = null){
        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;

        // get project hearing details
        $projectHearingDetails = $this->getProjectHearingDetails($groupId);

        // get group details
        $groupDetail = $this->getGroupDetails($groupId);
        if ($groupDetail) {
            if ($this->input->is_ajax_request()) {
                foreach ($projectHearingDetails as $key => $projectHearingDetail) {
                    $panelistDetails = $this->getPanelistDetails($projectHearingDetail['panelist_id']);
                    $fullName = $panelistDetails->first_name." ".$panelistDetails->last_name." ".$panelistDetails->middle_name;
                    $results[] = array(
                        'id' => $panelistDetails->id,
                        'text' => $fullName
                    );
                }

                echo json_encode($results);
                die;
            }
        }


        $currentUserGroup = $this->getCurrentUserGroupDetails($data['userInfo']->id);

        // - data
        $data['currentUserGroup'] = $currentUserGroup->name;
        $data['groupId'] = $groupId;
        $data['groupDetail'] = $groupDetail;
        $data['projectHearingDetail'] = isset($projectHearingDetails)? $projectHearingDetails:'';
        $data['currentPageTitle'] = 'Team Proposal';
        $data['mainContent'] = 'instructor/head';
        $data['subContent'] = 'head/titleHearingEdit';

        // - load view
        $this->load->view('includes/instructor/header',$data);
		$this->load->view('instructor/head/titleHearingEdit');
		$this->load->view('includes/instructor/footer');
    }

    public function getGroupPanelist(){
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
        $thisesGroups = $this->universal->datatables(
            'project_title_hearing',
            '*',
            array(
                'group_id' => $post['thesisGroupId']
            ),
            array(),
            array($length => $offset),
            $setorder,
            $like,
            true
        );

        foreach ($thisesGroups['data'] as $key => $projectHearingDetail) {
            $panelistDetails = $this->getPanelistDetails($projectHearingDetail['panelist_id']);
            $fullName = $panelistDetails->first_name." ".$panelistDetails->last_name." ".$panelistDetails->middle_name;
            $thisesGroups['data'][$key]['panelistFullName'] = $fullName;

        }
        // pre($thisesGroups['data']);
        // die;

        echo json_encode(
            array(
                'draw' => intval($draw),
                "recordsTotal" => $thisesGroups['recordsTotal'],
                "recordsFiltered" => $thisesGroups['recordsFiltered'],
                "data" => $thisesGroups['data']
            )
        );
    }

    public function viewPanelEvaluationRubric($groupId = null, $panelistId = null){
        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;

        // get panelist details
        $panelistDetails = $this->getPanelistDetails($panelistId);
        if (isset($panelistDetails) && $panelistDetails) {
            $panelistFullName = $panelistDetails->first_name.' '.$panelistDetails->middle_name.' '.$panelistDetails->last_name;
        }

        // get all evaluation rubric information
        $evaluationRubricDetailsArr = $this->universal->get(
            true,
            'evaluation_rubric',
            '*',
            'array'
        );

        // capstone 1 evaluation
        if (isset($evaluationRubricDetailsArr) && $evaluationRubricDetailsArr) {
            foreach ($evaluationRubricDetailsArr as $key => $value) {
                $getPanelEvaluation = $this->universal->get(
                    true,
                    'capstone1 AS C1',
                    'C1ERConnect.*',
                    'row',
                    array(
                        'C1.panelist_id' => $panelistId,
                        'C1.thesis_group_id' => $groupId,
                        'C1ERConnect.evaluation_rubric_id' => $value['id']
                    ),
                    array(),
                    array(
                        'capstone1_evaluation_rubric_connect AS C1ERConnect' => 'C1ERConnect.capstone_id = C1.id'
                    )
                );

                $evaluationRubricDetailsArr[$key]['group_id'] = $groupId;
                $evaluationRubricDetailsArr[$key]['panelist_id'] = $panelistId;
                $evaluationRubricDetailsArr[$key]['score'] = isset($getPanelEvaluation->evaluation_rubric_score)? $getPanelEvaluation->evaluation_rubric_score: 0;
                $evaluationRubricDetailsArr[$key]['comment'] = isset($getPanelEvaluation->evaluation_rubric_comment)? $getPanelEvaluation->evaluation_rubric_comment: null;
            }

        }
        // pre($evaluationRubricDetailsArr);
        // die();

        // - data
        $data['panelistFullName'] = isset($panelistFullName)? $panelistFullName: null;
        $data['evaluationRubricDetailsArr'] = $evaluationRubricDetailsArr;
        $data['groupId'] = $groupId;
        $data['currentPageTitle'] = 'Team Proposal';
        $data['mainContent'] = 'instructor/head';
        $data['subContent'] = 'head/viewPanelEvaluationRubric';

        // - load view
        $this->load->view('includes/instructor/header',$data);
		$this->load->view('instructor/head/viewPanelEvaluationRubric');
		$this->load->view('includes/instructor/footer');
    }

    public function panelistReject($hearingId = null){
        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;

        $get = $this->input->get();
        $data['message'] = "";
        if (isset($get) && $get) {
            $data['message'] = "Something went wrong";
        }

        $hearingDetails = $this->universal->get(
            true,
            'project_title_hearing',
            '*',
            'row',
            array(
                'id' => $hearingId
            )
        );

        // pre($hearingDetails);
        // die();
        // - data
        $data['hearingDetails'] = $hearingDetails;
        $data['hearingId'] = $hearingId;
        $data['currentPageTitle'] = 'Team Proposal';
        $data['mainContent'] = 'instructor/head';
        $data['subContent'] = 'head/panelistReject';

        // - load view
        $this->load->view('includes/instructor/header',$data);
		$this->load->view('instructor/head/panelistReject');
		$this->load->view('includes/instructor/footer');
    }

    public function removePanelist($hearingId = null){
        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;

        $hearingDetails = $this->universal->get(
            true,
            'project_title_hearing',
            '*',
            'row',
            array(
                'id' => $hearingId
            )
        );

        $hearingDetailsDelete = $this->universal->delete(
            'project_title_hearing',
            array(
                'id' => $hearingId
            )
        );
        if ($hearingDetailsDelete) {
            redirect(base_url('instructor/head/teamProposal/'.$hearingDetails->group_id), 'refresh');
        }else{
            redirect(base_url('instructor/head/panelistReject/'.$hearingId.'?errorFlag=1'), 'refresh');
        }
    }

    public function createEvaluationRubric($evaluationRubricId = null){
        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;

        // edit phase
        if (isset($evaluationRubricId) && $evaluationRubricId) {
            $evaluationRubricDetails = $this->universal->get(
                true,
                'evaluation_rubric',
                '*',
                'row',
                array(
                    'id' => $evaluationRubricId
                )
            );
        }

        $post = $this->input->post();
        if (isset($post) && $post) {
            if (isset($evaluationRubricId) && $evaluationRubricId) {
                // Update
                $updateEvaluationRubric = $this->universal->update(
                    'evaluation_rubric',
                    array(
                        'title' => $post['title'],
                        'unacceptable' => $post['unacceptable'],
                        'acceptable' => $post['acceptable'],
                        'good' => $post['good'],
                        'superior' => $post['superior'],
                        'date_modified' => date('Y-m-d H:i:s'),
                    ),
                    array(
                        'id' => $evaluationRubricId
                    )
                );

                $output = array(
                    'message' => "Error! Somthing went Wrong",
                    'class' => 'alert-danger'
                );
                if (isset($updateEvaluationRubric) && $updateEvaluationRubric) {
                    $output = array(
                        'message' => "Evaluation Rubric Updated",
                        'class' => 'alert-success'
                    );
                }
            }else{
                // insert data
                $insertEvaluationRubric = $this->universal->insert(
                    'evaluation_rubric',
                    array(
                        'title' => $post['title'],
                        'unacceptable' => $post['unacceptable'],
                        'acceptable' => $post['acceptable'],
                        'good' => $post['good'],
                        'superior' => $post['superior'],
                        'date_created' => date('Y-m-d H:i:s'),
                        'date_modified' => date('Y-m-d H:i:s'),
                    )
                );

                $output = array(
                    'message' => "Error! Somthing went Wrong",
                    'class' => 'alert-danger'
                );
                if (isset($insertEvaluationRubric) && $insertEvaluationRubric) {
                    $output = array(
                        'message' => "Evaluation Rubric Created",
                        'class' => 'alert-success'
                    );
                }
            }

            $this->session->set_flashdata('message', $output);
        }
        // pre($hearingDetails);
        // die();

        // - data
        $data['evaluationRubricId'] = isset($evaluationRubricId)? $evaluationRubricId: null;
        $data['evaluationRubricDetails'] = isset($evaluationRubricDetails)? $evaluationRubricDetails: null;
        $data['currentPageTitle'] = 'Head - Create Evaluation Rubric';
        $data['mainContent'] = 'instructor/head';
        $data['subContent'] = 'head/createEvaluationRubric';

        // - load view
        $this->load->view('includes/instructor/header',$data);
		$this->load->view('instructor/head/createEvaluationRubric');
		$this->load->view('includes/instructor/footer');
    }

    public function viewEvaluationRubric(){
        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;

        // get all EvaluationRubric
        $evaluationRubricDetailsArr = $this->universal->get(
            true,
            'evaluation_rubric',
            '*',
            'array'
        );
        // pre($evaluationRubricDetailsArr);
        // die();

        // - data
        $data['evaluationRubricDetailsArr'] = $evaluationRubricDetailsArr;
        $data['currentPageTitle'] = 'Head - View Evaluation Rubric';
        $data['mainContent'] = 'instructor/head';
        $data['subContent'] = 'head/viewEvaluationRubric';

        // - load view
        $this->load->view('includes/instructor/header',$data);
		$this->load->view('instructor/head/viewEvaluationRubric');
		$this->load->view('includes/instructor/footer');
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

    public function getProjectDetails($groupId = null){
        $getProjectDetailsArr = $this->universal->get(
            true,
            'thises',
            '*',
            'array',
            array(
                'thesis_group_id' => $groupId
            )
        );

        return $getProjectDetailsArr;
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

    public function getAssignedPanelist($groupId = null){
        $assignedPanelist = $this->universal->get(
            true,
            'thises_group_assigned_panelist',
            '*',
            'row',
            array(

            ),
            array(
                'group_id' => $groupId
            )
        );

        return $assignedPanelist;
    }

    public function getPanelistRejectTheGroup($groupId = null){
        $getProjectHearingDetails = $this->universal->get(
            true,
            'project_title_hearing',
            '*',
            'array',
            array(
                'group_id' => $groupId,
                'status' => 2
            )
        );
        return $getProjectHearingDetails;
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

}
