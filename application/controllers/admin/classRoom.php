<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ClassRoom extends CI_Controller {
    
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
    
    // - create user
    public function index(){
        
        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        
        
        // - data
		$data['mainContent'] = 'admin/classRoom';
        $data['subContent'] = 'classRoom/index';
        
        // - load view 
        $this->load->view('includes/admin/header',$data);
		$this->load->view('admin/classRoom/index');
		$this->load->view('includes/admin/footer');
	}
    
    public function getAllClassRoom(){
        
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
                'CR.class_room_name' => $search['value'],
                'CR.class_room_description' => $search['value'],
                'ins.first_name' => $search['value'],
                'ins.middle_name' => $search['value'],
                'ins.last_name' => $search['value'],
                'sub.subject_name' => $search['value']
            );
        }
        
        // get the teacher details to the database using the usniversal model
        $result = $this->universal->datatables(
            'class_room AS CR',
            'CR.id, CR.class_room_name, CR.status, sub.subject_name, ins.first_name, ins.middle_name, ins.last_name',
            array(
            ), 
            array(
                'subject AS sub' => 'sub.id = CR.subject_id',
                'users AS ins' => 'ins.id = CR.instructor_id'
            ),
            array($length => $offset),
            $setorder,
            $like, 
            true
        );
        
        $data['data'] = array();
        foreach ($result['data'] as $k => $sheet){
            array_push($data['data'], $sheet);
        }
        
        echo json_encode(
            array(
                'draw' => intval($draw),
                "recordsTotal" => $result['recordsTotal'],
                "recordsFiltered" => $result['recordsFiltered'],
                "data" => $data['data']
            )
        );
    }
    
    public function deactivateSubject($class_room_id = null){
        $result = $this->universal->update(
            'class_room',
            array(
                'status' => 0
            ),
            array(
                'id' => $class_room_id
            )
        );
        
        $this->alert($methon = 'index', $result, $message = 'This account is deactivated');
    }
    
    public function activateSubject($class_room_id = null){
        $result = $this->universal->update(
            'class_room',
            array(
                'status' => 1
            ),
            array(
                'id' => $class_room_id
            )
        );
        
        $this->alert($methon = 'index', $result, $message = 'This account is activated');
    }
    
    private function alert($methon = null, $result = null, $message){
        
        if ($result) {
            $this->session->set_flashdata('message',
                '<div class="alert alert-info">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <i class="material-icons">close</i>
                    </button>
                    <span>
                      <b> Success - </b> '.$message.'
                    </span>
                </div>'
            ); 
        }else{
            $this->session->set_flashdata('message',
                '<div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <i class="material-icons">close</i>
                    </button>
                    <span>
                      <b> Error - </b> Something went wrong
                    </span>
                </div>'
            );
        }
        
        redirect(base_url('admin/classRoom/'));
    } 
    
    // - create user
    public function createClassRoom(){
        
        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        
        $post = $this->input->post();
        
        // if submit post 
        if (!empty($post)) {
            
            $instructor_id = $post['instructor_id'];
            $subject_id = $post['subject_id'];
            $class_name = $post['class_name'];
            $class_description = $post['class_description'];
            
            // check if has subject
            $subject_already_use = $this->universal->get(
                true,
                'class_room',
                '*',
                'all',
                array(
                    'subject_id' => $subject_id
                )
            );
            
            
            // 
            // echo "<pre>";
            // print_r($result);
            // die();
            if (empty($instructor_id) || empty($subject_id) || empty($class_name) || empty($class_description) ) {
                // has empty fields
                $this->session->set_flashdata('message',
                    '<div class="alert alert-warning">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <i class="material-icons">close</i>
                        </button>
                        <span>
                          <b> Please dont leave a empty fields
                        </span>
                    </div>'
                ); 
            }else{
                
                if (empty($subject_already_use)) {
                    // save subject to database 
                    $result = $this->universal->insert(
                        'class_room',
                        array(
                            'class_room_name' => $class_name,
                            'class_room_description' => $class_description,
                            'instructor_id' => $instructor_id,
                            'subject_id' => $subject_id,
                            'status' => 1,
                            'date_created' => date("Y-m-d H:i:s"),
                            'date_modified' => date("Y-m-d H:i:s")
                        )
                    );
                }
                
                if (empty($subject_already_use)) {
                    $this->session->set_flashdata('message',
                        '<div class="alert alert-info">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <i class="material-icons">close</i>
                            </button>
                            <span>
                              <b> Success - </b> Subject was added
                            </span>
                        </div>'
                    ); 
                    
                }else{
                    $this->session->set_flashdata('message',
                        '<div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <i class="material-icons">close</i>
                            </button>
                            <span>
                              <b> Subject is already assigned
                            </span>
                        </div>'
                    ); 
                }
            }
            
            
        }
        
        
        // indtructor
        $data['instructors'] = $this->universal->get(
            true,
            'users',
            '*',
            'all',
            array(
                'groups.name' => 'instructor'
            ),
            array(),
            array(
                'users_groups' => 'users_groups.user_id = users.id',
                'groups' => 'users_groups.group_id = groups.id'
            )
        );
        

        // check if has subject
        $data['subjects'] = $this->universal->get(
            true,
            'subject',
            '*',
            'all'
        );
        
        // echo "<pre>";
        // print_r($data['subjects']);
        // die();
        // - data
		$data['mainContent'] = 'admin/classRoom';
        $data['subContent'] = 'classRoom/createClassRoom';
        
        // - load view 
        $this->load->view('includes/admin/header',$data);
		$this->load->view('admin/classRoom/createClassRoom');
		$this->load->view('includes/admin/footer');
	}
    
    
}
