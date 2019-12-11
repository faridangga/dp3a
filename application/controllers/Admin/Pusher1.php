<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pusher1 extends CI_Controller {

	var $cname = "Admin/Pusher";

	public function index()
	{
		$data = [
			'title' => "pusher",
			'cname' => $this->cname,
			'pages' => "admin/pusher/index",
			'data' => array(),
		];
		$this->load->view('layouts/dashboard',$data);
	}
}

/* End of file Pusher.php */
/* Location: ./application/controllers/Admin/Pusher.php */