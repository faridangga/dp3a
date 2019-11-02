<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blank extends CI_Controller {

	var $cname = "Blank";

	public function __construct()
    {
        parent::__construct();
        
    }

	public function index()
	{
		$data = [
			'title' => "Blank",
			'cname' => $this->cname,
			'pages' => "blank",
			'data' => array(),
		];
		$this->load->view('layouts/dashboard',$data);
	}

}

/* End of file Blank.php */
/* Location: ./application/controllers/Blank.php */