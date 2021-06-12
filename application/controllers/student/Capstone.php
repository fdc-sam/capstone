<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Capstone extends CI_Controller {

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
        
        $get = $this->input->get('capstoneFlag');
        $capstoneFlag = isset($get)? $get: 1;
        
        $thisesConnectDetails = $this->universal->get(
            true,
            'thises_connect',
            '*',
            'row',
            array(
                'user_id' => $data['userInfo']->id
            )
        );
        
        $panelistDetails = array();
        if (isset($thisesConnectDetails) && $thisesConnectDetails) {
            $panelistDetails = $this->getAllPanelist($thisesConnectDetails->thesis_group_id);

            foreach ($panelistDetails as $key => $panelistDetail) {
                $capstoneDetails = $this->getCapstoneDetails($panelistDetail['panelist_id'], $capstoneFlag);
                $panelistDetails[$key]['capstoneDetails'] = $capstoneDetails;
            }

            // pre($panelistDetails);
            // die;
        }

        // - data
        $data['capstoneFlag'] = $capstoneFlag;
        $data['panelistDetails'] = $panelistDetails;
        $data['currentPageTitle'] = 'Student - Capstone';
        $data['mainContent'] = 'student/capstone';
        $data['subContent'] = 'capstone/index';

        $this->load->view('includes/student/header',$data);
		$this->load->view('student/capstone/index');
		$this->load->view('includes/student/footer');
        $this->load->view('includes/student/modals');
	}

    public function capstone1Remark($panelistId = null){
        // get the current user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;

        $thisesConnectDetails = $this->universal->get(
            true,
            'thises_connect',
            '*',
            'row',
            array(
                'user_id' => $data['userInfo']->id
            )
        );

        // get the panelist information
        $panelistDetails = $this->universal->get(
            true,
            'users',
            '*',
            'row',
            array(
                'id' => $panelistId
            )
        );


        // get the capstone final Remark
        $capstoneFinalRemark = $this->universal->get(
            true,
            'capstone1_final_remarks',
            '*',
            'row',
            array(
                'instructor_id' => $panelistId,
                'group_id' => $thisesConnectDetails->thesis_group_id
            )
        );

        $remark = '';
        if (isset($capstoneFinalRemark) && $capstoneFinalRemark) {
            $remark = $capstoneFinalRemark->remarks;
        }

        // pre($remark);
        // die;

        // - data
        $data['fullName'] = $panelistDetails->first_name.' '.$panelistDetails->middle_name.' '.$panelistDetails->last_name;
        $data['remark'] = $remark;
        $data['currentPageTitle'] = 'Student - Capstone';
        $data['mainContent'] = 'student/capstone';
        $data['subContent'] = 'capstone/capstone1Remark';

        $this->load->view('includes/student/header',$data);
		$this->load->view('student/capstone/capstone1Remark');
		$this->load->view('includes/student/footer');
        $this->load->view('includes/student/modals');
    }
    
    public function capstone2Remark($panelistId = null){
        // get the current user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;

        $thisesConnectDetails = $this->universal->get(
            true,
            'thises_connect',
            '*',
            'row',
            array(
                'user_id' => $data['userInfo']->id
            )
        );

        // get the panelist information
        $panelistDetails = $this->universal->get(
            true,
            'users',
            '*',
            'row',
            array(
                'id' => $panelistId
            )
        );


        // get the capstone final Remark
        $capstoneFinalRemark = $this->universal->get(
            true,
            'capstone2_final_remarks',
            '*',
            'row',
            array(
                'instructor_id' => $panelistId,
                'group_id' => $thisesConnectDetails->thesis_group_id
            )
        );

        $remark = '';
        if (isset($capstoneFinalRemark) && $capstoneFinalRemark) {
            $remark = $capstoneFinalRemark->remarks;
        }

        // pre($remark);
        // die;

        // - data
        $data['fullName'] = $panelistDetails->first_name.' '.$panelistDetails->middle_name.' '.$panelistDetails->last_name;
        $data['remark'] = $remark;
        $data['currentPageTitle'] = 'Student - Capstone';
        $data['mainContent'] = 'student/capstone';
        $data['subContent'] = 'capstone/capstone2Remark';

        $this->load->view('includes/student/header',$data);
		$this->load->view('student/capstone/capstone2Remark');
		$this->load->view('includes/student/footer');
        $this->load->view('includes/student/modals');
    }

    public function groupEvaluation($capstoneId = null, $capstoneFlag = null){
        // get the current user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;
        
        if ($capstoneFlag == 1) {
            // for capstone1
            $getPanelDetails = $this->universal->get(
                true,
                'capstone1 AS C1',
                'U.*',
                'row',
                array(
                    'C1.id' => $capstoneId
                ),
                array(),
                array(
                    'users AS U' => 'U.id = C1.panelist_id'
                )
            );
    
            $panelistIdEvaluationDetails = $this->universal->get(
                true,
                'capstone1_evaluation_rubric_connect',
                '*',
                'array',
                array(
                    'capstone_id' => $capstoneId
                )
            );
            if (isset($panelistIdEvaluationDetails) && $panelistIdEvaluationDetails) {
                foreach ($panelistIdEvaluationDetails as $key => $panelistIdEvaluationDetail) {
                    $getEvaluationDetails = $this->universal->get(
                        true,
                        'evaluation_rubric',
                        '*',
                        'row',
                        array(
                            'id' => $panelistIdEvaluationDetail['evaluation_rubric_id']
                        )
                    );
    
                    $panelistIdEvaluationDetails[$key]['evaluationDetails'] = $getEvaluationDetails;
                }
            }
        }elseif ($capstoneFlag == 2) {
            // for capstone2
            $getPanelDetails = $this->universal->get(
                true,
                'capstone2 AS C2',
                'U.*',
                'row',
                array(
                    'C2.id' => $capstoneId
                ),
                array(),
                array(
                    'users AS U' => 'U.id = C2.panelist_id'
                )
            );
    
            $panelistIdEvaluationDetails = $this->universal->get(
                true,
                'capstone2_evaluation_rubric_connect',
                '*',
                'array',
                array(
                    'capstone_id' => $capstoneId
                )
            );
            if (isset($panelistIdEvaluationDetails) && $panelistIdEvaluationDetails) {
                foreach ($panelistIdEvaluationDetails as $key => $panelistIdEvaluationDetail) {
                    $getEvaluationDetails = $this->universal->get(
                        true,
                        'evaluation_rubric',
                        '*',
                        'row',
                        array(
                            'id' => $panelistIdEvaluationDetail['evaluation_rubric_id']
                        )
                    );
    
                    $panelistIdEvaluationDetails[$key]['evaluationDetails'] = $getEvaluationDetails;
                }
            }
        }
        

        // pre($panelistIdEvaluationDetails);
        // die;

        // - data
        $data['panelDetails'] = isset($getPanelDetails)? $getPanelDetails: null;
        $data['panelistIdEvaluationDetails'] = isset($panelistIdEvaluationDetails)? $panelistIdEvaluationDetails: array();
        $data['capstoneFlag'] = $capstoneFlag;
        $data['currentPageTitle'] = 'Student - Home';
        $data['mainContent'] = 'student/capstone';
        $data['subContent'] = 'capstone/groupEvaluation';

        $this->load->view('includes/student/header',$data);
		$this->load->view('student/capstone/groupEvaluation');
		$this->load->view('includes/student/footer');
        $this->load->view('includes/student/modals');
	}




    public function getCapstoneDetails($panelistId = null, $capstoneFlag = null){
        
        if ($capstoneFlag == 1) {
            // for capstone 1
            $capstoneDetails = $this->universal->get(
                true,
                'capstone1 C1',
                'C1.*',
                'row',
                array(
                    'C1.panelist_id' => $panelistId
                )
            );
        }elseif ($capstoneFlag == 2) {
            // for capstone 2
            $capstoneDetails = $this->universal->get(
                true,
                'capstone2 C2',
                'C2.*',
                'row',
                array(
                    'C2.panelist_id' => $panelistId
                )
            );
        }
        

        return $capstoneDetails;
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
}
?>
