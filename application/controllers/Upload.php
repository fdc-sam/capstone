<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Auth
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation      $form_validation The form validation library
 */
class Upload extends CI_Controller{
	
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
    
    public function fileUpload($proposalId = null){
        // get the current user information
        $data['userInfo'] = $this->ion_auth->user()->row();
        $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;
        
        // get the current user group id
        $currentThisesGroupId = $this->getThisesGroupId($data['userInfo']->id);
        
        $data = array(); 
        if(!empty($_FILES['selectedFile']['name'])){ 
            // Set preference 
            $config = array(
                'upload_path' => './uploads/',
                'allowed_types' => 'pdf|docx|png',
                'encrypt_name' => true,
                'max_size' => 202048000,
                'max_width' => 1024, //Mainly goes with images only
                'max_heigth' => 768
            );
            
            // Load upload library 
            $this->load->library('upload',$config);
            
            // File upload
            if($this->upload->do_upload('selectedFile')){ 
                // Get data about the file
                $uploadData = $this->upload->data(); 
                
				// current date
				$dateTime = date('Y-m-d H:i:s');
				
				//  to insert data
				$documentData = array(
					'group_id' => $currentThisesGroupId,
					'thesis_id' => $proposalId,
					'file_name' => $uploadData['file_name'],
					'display_file_name' => $_FILES['selectedFile']['name'],
					'file_extention' => $uploadData['file_ext'],
					'created_date' => $dateTime,
					'modified_date' => $dateTime,
					'created_ip' => $this->input->ip_address(),
					'modified_ip' => $this->input->ip_address()
				);
				
                // add documents 
                $addDocument = $this->universal->insert('documents',$documentData);
                
				redirect(base_url('student/home/capstoneDetails/'.$proposalId));
            }else{ 
                $data['response'] = array('error' => $this->upload->display_errors()); 
                pre($config['upload_path']);
            } 
        }else{ 
            $data['response'] = 'no data'; 
            pre($data['response']);
        } 
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
        
        if (!$currentThisesGroupId) {
            
            // get the current user information
            $data['userInfo'] = $this->ion_auth->user()->row();
            $data['fullName'] = $data['userInfo']->first_name." ".$data['userInfo']->middle_name." ".$data['userInfo']->last_name;
            
            // get the current user batch code 
            $currentUserBatchCodeId = $this->getStudentBatchCodeId($data['userInfo']->email);
            
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
        
        return isset($currentThisesGroupId->thesis_group_id)? $currentThisesGroupId->thesis_group_id: null;
    }
}
