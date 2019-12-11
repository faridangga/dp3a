<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		$data = [
			'title' => "Dashboard",
			'data' => array(),
		];
		$this->load->view('layouts/login', $data);
	}
}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */