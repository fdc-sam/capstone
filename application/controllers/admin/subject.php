<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subject extends CI_Controller {
    
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
        
        
        // subject
        $data['subjects'] = $this->universal->get(
            true,
            'subject',
            '*',
            'all'
        );
        
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
        
        // - data
		$data['mainContent'] = 'admin/subject';
        $data['subContent'] = 'subject/index';
        
        // - load view 
        $this->load->view('includes/admin/header',$data);
		$this->load->view('admin/subject/index');
		$this->load->view('includes/admin/footer');
	}
    
    public function createSubject(){
        
        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        
        // - request post
        $post = $this->input->post();
        
        // if submit post 
        if (!empty($post)) {
            $subjectName = $post['subjectName'];
            $subjectDescription = $post['subjectDescription'];
            $subjectId = $post['subjectId'];
            
            $find = $this->universal->get(
                true,
                'subject',
                '*',
                'all',
                array(
                    'subject_id' => $subjectId
                )
            );
            
            if (!empty($find)) {
                $this->session->set_flashdata('message',
                    '<div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <i class="material-icons">close</i>
                        </button>
                        <span>
                          <b> Error - </b> Subject ID is already exist 
                        </span>
                    </div>'
                ); 
            }else{
                // save subject to database 
                $result = $this->universal->insert(
                    'subject',
                    array(
                        'subject_id' => $subjectId,
                        'subject_name' => $subjectName,
                        'subject_description' => $subjectDescription,
                        'status' => 1,
                        'date_created' => date("Y-m-d H:i:s"),
                        'date_modified' => date("Y-m-d H:i:s")
                    )
                );
                
                if ($result) {
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
                              <b> Error - </b> Something went wrong
                            </span>
                        </div>'
                    ); 
                }
            }
            
            
            // echo "<pre>";
            // print_r($post);
            // die();
        }
        
        
        // - data
		$data['mainContent'] = 'admin/subject';
        $data['subContent'] = 'subject/createSubject';
        
        // - load view 
        $this->load->view('includes/admin/header',$data);
		$this->load->view('admin/subject/createSubject');
		$this->load->view('includes/admin/footer');
	}
    
    public function getSubjects(){
        if (!$this->ion_auth->is_admin()){
             // remove this elseif if you want to enable this for non-admins
			// redirect them to the home page because they must be an administrator to view this
			show_error('You must be an administrator to view this page.');
		}else{
			// $this->data['title'] = $this->lang->line('index_heading');
			// // set the flash data error message if there is one
			// $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            
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
                    'u.id' => $search['value'],
                    'u.first_name' => $search['value'],
                    'u.middle_name' => $search['value'],
                    'u.last_name' => $search['value'],
                    'u.email' => $search['value'],
                    'g.name' => $search['value']
    			);
    		}
            
            // get the teacher details to the database using the usniversal model
    		$result = $this->universal->datatables(
    			'subject',
    			'*',
                array(), 
    			array(),
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
    }
    
    public function edit($subject_id = null){
        
        
        // - request post
        $post = $this->input->post();
        
        // if submit post 
        if (!empty($post)) {
            $subjectId = $post['subjectId'];
            $subjectName = $post['subjectName'];
            $subjectDescription = $post['subjectDescription'];
            
            $update_subject = $this->universal->update(
                'subject',
                array(
                    'subject_id' => $subjectId,
                    'subject_name' => $subjectName,
                    'date_modified' => date('Y-m-d H:i:s'),
                    'subject_description' => $subjectDescription
                ),
                array(
                    'id' => $subject_id
                )
            );
            
            // 
            if ($update_subject) {
                $this->session->set_flashdata('message',
                    '<div class="alert alert-info">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <i class="material-icons">close</i>
                        </button>
                        <span>
                          <b> Success - </b> Subject was Update
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
        }
        
        // check if the subject has instructor 
        $subject_details = $this->universal->get(
            true,
            'subject',
            '*',
            'all',
            array(
                'id' => $subject_id
            )
        );
        
        if (!empty($subject_details)) {
            $data['subject_details'] = $subject_details[0];
            $data['has_instructor'] = $subject_details[0]->instructor_id;
        }
        
        
        // - subject id
        $data['subject_id'] = $subject_id;
        
        // - get the user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        
        // - data
		$data['mainContent'] = 'admin/subject';
        $data['subContent'] = 'subject/edit';
        
        // - load view 
        $this->load->view('includes/admin/header',$data);
		$this->load->view('admin/subject/edit');
		$this->load->view('includes/admin/footer');
    }
    
    public function deactivateSubject($subject_id = null){
        $result = $this->universal->update(
            'subject',
            array(
                'status' => 0
            ),
            array(
                'id' => $subject_id
            )
        );
        
        $this->alert($methon = 'index', $result, $message = 'This account is deactivated');
    }
    
    public function activateSubject($subject_id = null){
        $result = $this->universal->update(
            'subject',
            array(
                'status' => 1
            ),
            array(
                'id' => $subject_id
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
        
        redirect(base_url('admin/subject/'));
    } 
}
