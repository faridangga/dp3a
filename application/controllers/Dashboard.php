<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	var $cname = "Dashboard";

	public function __construct()
    {
        parent::__construct();
        
    }

	public function index()
	{
		$data = [
			'title' => "dashboard",
			'cname' => $this->cname,
			'pages' => "admin/dashboard/index",
			'data' => array(),
		];
		$this->load->view('layouts/dashboard',$data);
	}

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */