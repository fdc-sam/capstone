<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LandingPageController extends My_Controller {

	//landing how to register
	public function index(){
		$data['mainContent'] = 'landingPage/index';
		$this->landingPageRenderer('landingPage/index', $data);
	}

	// landing page how to request files
	public function checkBatchCode(){
		$post = $this->input->post();
		$data['mainContent'] = 'landingPage/howToRequestFile';
		$this->landingPageRenderer('landingPage/howToRequestFile',$data);
	}

	public function checkStudentOrInstructorId(){
		$post = $this->input->post();
		if (isset($post['studentOrInstructorId']) && $post['studentOrInstructorId']) {

			$hasId = $this->universal->get(
				true,
				'users',
				'*',
				'array',
				array(
					'school_users_id' => $post['studentOrInstructorId']
				)
			);
		}


		$output = 0;
		if (isset($hasId) && $hasId) {
			$output = 1;
		}
		echo $output;
	}
}
