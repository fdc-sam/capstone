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
        
        // - data
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
        
        // - data
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
        
        // - data
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
        
        // - data
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
                'TG.created' => $search['value']
            );
        }
        
        //  get all proposals
        $thisesGroups = $this->universal->datatables(
            'thises_group AS TG',
            'TG.*',
            array(), 
            array(
                'thises AS T' => 'T.thesis_group_id = TG.id'
            ),
            array($length => $offset),
            $setorder,
            $like, 
            true
        );
        
        $data['data'] = array();
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
                $thisesGroup['groupMembers'] =  $fullName;
            }
            
            if (isset($thisesGroup['groupPoposals'])) {
                array_push($data['data'], $thisesGroup);
            }
            
        }
        
        echo json_encode(
            array(
                'draw' => intval($draw),
                "recordsTotal" => $thisesGroups['recordsTotal'],
                "recordsFiltered" => $thisesGroups['recordsFiltered'],
                "data" => $data['data']
            )
        );
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
        
        // - data
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
        
        // - data
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
            'T.*, U.first_name, U.middle_name, U.last_name, U.email',
            array(), 
            array(
                'thises_connect AS TC' => 'TC.thesis_group_id = TG.id',
                'thises AS T' => 'T.thesis_group_id = TG.id AND T.status = 1',
                'users AS U' => 'U.id = TC.user_id'  
            ),
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
                "data" => $result
            )
        );
        
    }
    
}
