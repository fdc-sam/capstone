<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_Controller extends CI_Controller {

	//
	public function pageRenderer($page, array $data){
		$this->load->view('includes/landingPage/header',$data);
		$this->load->view($page);
		$this->load->view('includes/landingPage/footer');
	}

	//landing pages
	public function landingPageRenderer($page, array $data){
		$this->load->view('includes/landingPage/header',$data);
		$this->load->view($page);
		$this->load->view('includes/landingPage/footer');
	}

	
	public function registrarPageRenderer($page, array $data){
		$this->load->view('includes/registrar/header',$data);
		$this->load->view($page);
		$this->load->view('includes/registrar/footer');
	}

	public function studentPageRendere($page, array $data){
		$this->load->view('includes/student/header',$data);
		$this->load->view($page);
		$this->load->view('includes/student/footer');
	}
}
