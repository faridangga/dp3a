<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admins extends CI_Controller {

	var $cname = "Admin/Admins";

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Admins_model');
	}

	public function index()
	{
		$data = [
			'title' => "Admins",
			'cname' => $this->cname,
			'pages' => "admin/admins/index",
			'data' => array(),
		];
		$this->load->view('layouts/dashboard',$data);
	}

	public function get_data()
	{
		$data['data'] = $this->Admins_model->get_data();
		echo json_encode($data);
	}

	public function get_data_by_id()
	{
		$id = $this->input->post('id_admin');
		$data = $this->Admins_model->get_data_by_id($id);
		echo json_encode($data);
	}

}

/* End of file Admins.php */
/* Location: ./application/controllers/Admin/Admins.php */