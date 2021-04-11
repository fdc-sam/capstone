<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AutoLoad extends CI_Controller {
    
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
    
	// - notification 
	public function index(){
        
        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        
        // - data
        $data['currentPageTitle'] = 'Head - Home';
        $data['mainContent'] = 'instructor/head';
        $data['subContent'] = 'head/index';
        
        // - load view 
        $this->load->view('includes/instructor/header',$data);
		$this->load->view('instructor/head/index');
		$this->load->view('includes/instructor/footer');
    }
    
    // head Notifications
    public function headNotification(){
        
        // get all new proposal
        $hasThisesNotifications = $this->universal->get(
            true,
            'thises_group AS TG',
            'TG.*',
            'all',
            array(
                'T.status' => 0
            ),
            array(),
            array(
                'thises AS T' => 'T.thesis_group_id = TG.id'
            )
        );
        
    
        if ($hasThisesNotifications) {
            $output = '';
            foreach ($hasThisesNotifications as $key => $thisesGroup) {
                $groupMembers = ''; 
                
                // get all group members
                $getGroupMembers = $this->universal->get(
                    true,
                    'users AS U',
                    'U.first_name, U.middle_name, U.last_name',
                    'all',
                    array(
                        'TC.thesis_group_id' => $thisesGroup->id
                    ),
                    array(),
                    array(
                        'thises_connect AS TC' => 'U.id = TC.user_id' 
                    )
                );
                foreach ($getGroupMembers as $key => $getGroupMember) {
                    $fullname = $getGroupMember->first_name.' '.$getGroupMember->middle_name.' '.$getGroupMember->last_name;
                    $groupMembers .= $fullname.', ';
                }
                
                // get the proposals
                $getProposals = $this->universal->get(
                    true,
                    'thises AS T',
                    '*',
                    'all',
                    array(
                        'T.thesis_group_id' => $thisesGroup->id
                    )
                );
                $proposalOutPut = '';
                foreach ($getProposals as $key => $proposal) {
                    $proposalOutPut .= '<p class="description"> - '.$proposal->title.'</p>';
                    $timeIn12HourFormat = date("g:ia | D jS F Y", strtotime($proposal->created));
                }
                
                $output .= '
                    <a href="#" class="notification">
                        <div class="vertical-timeline-item vertical-timeline-element">
                            <div>
                                <span class="vertical-timeline-element-icon bounce-in">
                                    <i class="badge badge-dot badge-dot-xl badge-success"> </i>
                                </span>
                                <div class="vertical-timeline-element-content bounce-in">
                                    <h4 class="timeline-title">'.$groupMembers.'</h4>
                                    '.$proposalOutPut.'
                                    <p>'.$timeIn12HourFormat.'</p> 
                                </div>
                            </div>
                        </div>
                    </a>
                ';
            }
        }else {
            $output .= '
                <div class="vertical-timeline-item vertical-timeline-element">
                    <div>
                        <span class="vertical-timeline-element-icon bounce-in">
                            <i class="badge badge-dot badge-dot-xl badge-success"> </i>
                        </span>
                        <div class="vertical-timeline-element-content bounce-in">
                            <h4 class="timeline-title">No Data </h4>
                            <p class="description">Waiting for new Data</p>
                        </div>
                    </div>
                </div>
            ';
        }
        
        
        $totalNotificationCount = count($hasThisesNotifications);
        $result = array(
            'totalNotificationCount' => $totalNotificationCount,
            'output' => $output
        );
        
        echo json_encode($result);
        // pre($time_in_12_hour_format);
    }
    
}
