<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class RegistrarController extends My_Controller {

	public function index()
	{
		$data['mainContent'] = 'registrar/index';
		$this->registrarPageRenderer('registrar/index', $data);
	}

	public function createNewUser(){
		$data['mainContent'] = 'registrar/createNewUser';
		$this->registrarPageRenderer('registrar/createNewUser',$data);
	}
}
