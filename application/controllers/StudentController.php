<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class StudentController extends My_Controller {

	public function index()
	{
		$data['mainContent'] = 'student/index';
		$this->studentPageRendere('student/index', $data);
	}

}
