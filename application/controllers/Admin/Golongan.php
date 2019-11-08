<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Golongan extends CI_Controller {

	var $cname = "Admin/Golongan";

	public function __construct()
    {
        parent::__construct();
        $this->load->model('Golongan_model');
        
    }

	public function index()
	{
		$data = [
			'title' => "Golongan",
			'cname' => $this->cname,
			'pages' => "admin/golongan/index",
			'data' => array(),
		];
		$this->load->view('layouts/dashboard',$data);
	}

	public function get_data()
	{
		$data['data'] = $this->Golongan_model->get_data();
		echo json_encode($data);
	}

	public function get_data_by_id()
	{
		$id = $this->input->post('id_golongan');
		$data = $this->Golongan_model->get_data_by_id($id);
		echo json_encode($data);
	}

	public function insert()
	{
		$data = [
			'id_golongan' => $this->input->post('id_golongan'),
			'nama_golongan' => $this->input->post('nama_golongan'),
			'status' => $this->input->post('status'),
		];
		// echo var_dump($data);
		$this->Golongan_model->insert($data);
		// $this->load->view('layouts/dashboard');
	}

	public function delete_golongan()
	{
		$id_golongan = $this->input->post('id_golongan');

		$delete = $this->db
		->where('id_golongan')
		->delete('golongan');
		echo var_dump($id_golongan);
		// if($delete){
		// 	$ret = [
		// 		'text' => "Delete success",
		// 		'title' => "Delete",
		// 		'icon' => "success",
		// 	];
		// }else{
		// 	$ret = [
		// 		'text' => "Delete failed",
		// 		'title' => "Delete",
		// 		'icon' => "warning",
		// 	];
		// }
		// echo json_encode($ret);

		// $this->Golongan_model->delete($id);
	}

}

/* End of file Golongan.php */
/* Location: ./application/controllers/admin/Golongan.php */