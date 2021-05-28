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

        $thisesConnectDetails = $this->universal->get(
            true,
            'thises_connect',
            '*',
            'row',
            array(
                'user_id' => $data['userInfo']->id
            )
        );

        if (isset($thisesConnectDetails) && $thisesConnectDetails) {
            $panelistDetails = $this->getAllPanelist($thisesConnectDetails->thesis_group_id);

            foreach ($panelistDetails as $key => $panelistDetail) {
                $capstoneDetails = $this->getCapstoneDetails($panelistDetail['panelist_id']);
                $panelistDetails[$key]['capstoneDetails'] = $capstoneDetails;
            }

            // pre($panelistDetails);
            // die;
        }

        // - data
        $data['panelistDetails'] = $panelistDetails;
        $data['currentPageTitle'] = 'Student - Home';
        $data['mainContent'] = 'student/capstone';
        $data['subContent'] = 'capstone/index';

        $this->load->view('includes/student/header',$data);
		$this->load->view('student/capstone/index');
		$this->load->view('includes/student/footer');
        $this->load->view('includes/student/modals');
	}

    public function groupEvaluation($capstoneId = null){
        // get the current user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;

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

        // pre($getPanelDetails);
        // die;

        // - data
        $data['panelDetails'] = $getPanelDetails;
        $data['panelistIdEvaluationDetails'] = $panelistIdEvaluationDetails;
        $data['currentPageTitle'] = 'Student - Home';
        $data['mainContent'] = 'student/capstone';
        $data['subContent'] = 'capstone/groupEvaluation';

        $this->load->view('includes/student/header',$data);
		$this->load->view('student/capstone/groupEvaluation');
		$this->load->view('includes/student/footer');
        $this->load->view('includes/student/modals');
	}




    public function getCapstoneDetails($panelistId = null){
        $capstoneDetails = $this->universal->get(
            true,
            'capstone1 C1',
            'C1.*',
            'row',
            array(
                'C1.panelist_id' => $panelistId
            )
        );

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
