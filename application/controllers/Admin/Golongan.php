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
	    $id = $this->input->post('id_golongan');
		$data = [
			'nama_golongan' => $this->input->post('nama_golongan'),
			'status' => $this->input->post('status'),
		];

		if ($id == "") {
			$insert = $this->Golongan_model->insert($data);
			if($insert){
				$ret = [
					'title' => "Insert",
					'text' => "Insert success",
					'icon' => "success",
				];
			}else{
				$ret = [
					'title' => "Insert",
					'text' => "Insert failed",
					'icon' => "warning",
				];
			}   
		}else {
			$update = $this->Golongan_model->update($id, $data);
			if($update){
				$ret = [
					'title' => "Update",
					'text' => "Update success",
					'icon' => "success",
				];
			}else{
				$ret = [
					'title' => "Update",
					'text' => "Update failed",
					'icon' => "warning",
				];
			}
		}

			// echo var_dump($data);
		// $this->form_validation->set_rules('nama_golongan', 'Nama Golongan', 'trim|required');
		// $this->form_validation->set_rules('status', 'Status', 'trim|required');

		// $this->load->helper('security');
		// $this->form_validation->set_error_delimiters('','');

		// $ret_data = [
		// 	'code' => 0,
		// 	'text' => '',
		// 	'result' => array(),
		// ];

		// if ($this->form_validation->run() == TRUE) {
		// 	$data = [
		// 		'nama_golongan' => $this->input->post('nama_golongan'),
		// 		'status' => $this->input->post('status'),
		// 	];

		// 	$ret_data = [
		// 		'code' => 0,
		// 		'text' => '',
		// 		'result' => array(),
		// 	];

		// 	$insert = $this->Golongan_model->insert($data);
		// 	if($insert){
		// 		$ret = [
		// 			'code' => 1,
		// 			'title' => "Insert",
		// 			'text' => "Insert success",
		// 			'icon' => "success",
		// 		];
		// 	}else{
		// 		$ret = [
		// 			'code' => 2,
		// 			'title' => "Insert",
		// 			'text' => "Insert failed",
		// 			'icon' => "warning",
		// 		];
		// 	}
		// } else {
		// 	$ret = [
		// 		'title' => 'Warning',
		// 		'text' => ''.validation_errors('',''),
		// 		'field' => $this->form_validation->error_array(),
		// 		'icon' => 'warning'
		// 	];
		// }

		echo json_encode($ret);
	}

	public function delete_golongan()
	{
		$id = $this->input->post('id_golongan');

		$delete = $this->Golongan_model->delete($id);
		if($delete){
			$ret = [
				'title' => "Delete",
				'text' => "Delete success",
				'icon' => "success",
			];
		}else{
			$ret = [
				'title' => "Delete",
				'text' => "Delete failed",
				'icon' => "warning",
			];
		}
		echo json_encode($ret);

	}

}

/* End of file Golongan.php */
/* Location: ./application/controllers/admin/Golongan.php */