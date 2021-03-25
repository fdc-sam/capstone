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
}
