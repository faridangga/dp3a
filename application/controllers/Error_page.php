<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Error_page extends CI_Controller {

	public function index()
	{
		$this->load->view('welcome_message');
	}	

	public function error403()
	{
		$data = [
			'title' => "Error",
			'pages' => "admin/error_page/error404",
			'data' => array(),
		];
		$this->load->view('layouts/dashboard',$data);
	}

	public function error404()
	{
		$data = [
			'title' => "Error",
			'pages' => "admin/error_page/error404",
			'data' => array(),
		];
		$this->load->view('layouts/dashboard',$data);
	}

}

/* End of file Error_page.php */
/* Location: ./application/controllers/Error_page.php */