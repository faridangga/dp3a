<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jabatan extends CI_Controller {

	var $cname = "Admin/Jabatan";

	function __construct()
	{
        parent::__construct();
        $this->load->model('Jabatan_model');
	}

	public function index()
	{
		$data = [
			'title' => "Jabatan",
			'cname'=> $this->cname,
			'pages' => "admin/jabatan/index",
			'data' => array(),
		];
		$this->load->view('layouts/dashboard', $data);
	}

	public function get_data()
	{
		$data['data'] = $this->Jabatan_model->get_data();
		echo json_encode($data);
	}

	public function get_data_by_id()
	{
		$id = $this->input->post('id_jabatan');
		$data = $this->Jabatan_model->get_data_by_id();
		echo json_encode($data);
	}

	public function insert()
	{
		$data = [
			'id_jabatan' => $this->input->post('id_jabatan'),
			'nama_jabatan' => $this->input->post('nama_jabatan'),
			'status' => $this->input->post('status'),
		];
		$this->Jabatan_model->insert($data);
	}

}

/* End of file Jabatan.php */
/* Location: ./application/controllers/Admin/Jabatan.php */