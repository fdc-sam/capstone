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

        // - data
        $data['currentPageTitle'] = 'Student - Home';
        $data['mainContent'] = 'student/panel';
        $data['subContent'] = 'panel/index';

        $this->load->view('includes/student/header',$data);
		$this->load->view('student/panel/index');
		$this->load->view('includes/student/footer');
        $this->load->view('includes/student/modals');
	}

    public function getAllPanelist(){
        // get the current user information
        $data['userInfo'] = $this->ion_auth->user()->row();

        $groupDetails = $this->getGroupDetails($data['userInfo']->id);

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
                'U.id' => $search['value'],
                'U.first_name' => $search['value'],
                'U.middle_name' => $search['value'],
                'U.last_name' => $search['value']
            );
        }

        //  get all proposals
        $allPanelist = $this->universal->datatables(
            'project_title_hearing AS PTH',
            'U.*, PTH.status',
            array(
                'PTH.group_id' => $groupDetails->id,
                'PTH.status = in(0,1)'
            ),
            array(
                'users AS U' => 'U.id = PTH.panelist_id'
            ),
            array($length => $offset),
            $setorder,
            $like,
            true
        );

        echo json_encode(
            array(
                'draw' => intval($draw),
                "recordsTotal" => $allPanelist['recordsTotal'],
                "recordsFiltered" => $allPanelist['recordsFiltered'],
                "data" => $allPanelist['data']
            )
        );
    }



    // get all details
    public function getGroupDetails($userId = null){
        $groupDetails = $this->universal->get(
            true,
            'thises_connect AS TC',
            'TG.*',
            'row',
            array(
                'user_id' => $userId
            ),
            array(),
            array(
                'thises_group AS TG' => 'TG.id = TC.thesis_group_id'
            )
        );

        return $groupDetails;
    }
}
?>
