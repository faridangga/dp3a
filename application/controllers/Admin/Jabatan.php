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
		$data = $this->Jabatan_model->get_data_by_id($id);
		echo json_encode($data);
	}

	public function insert()
	{
		$id = $this->input->post('id_jabatan');
		$data = [
			'nama_jabatan' => $this->input->post('nama_jabatan'),
			'status' => $this->input->post('status'),
		];

		if ($id == "") {
			$insert = $this->Jabatan_model->insert($data);
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
			$update = $this->Jabatan_model->update($id, $data);
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
		echo json_encode($ret);

	}

	public function delete_jabatan()
	{
		$id = $this->input->post('id_jabatan');

		$delete = $this->Jabatan_model->delete($id);
		if($delete){
			$ret = [
				'text' => "Delete success",
				'title' => "Delete",
				'icon' => "success",
			];
		}else{
			$ret = [
				'text' => "Delete failed",
				'title' => "Delete",
				'icon' => "warning",
			];
		}
		echo json_encode($ret);

	}

}

/* End of file Jabatan.php */
/* Location: ./application/controllers/Admin/Jabatan.php */