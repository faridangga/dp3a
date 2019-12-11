<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admins extends CI_Controller {

	var $cname = "Admin/Admins";

	public function __construct()
	{
		parent::__construct();
		$this->load->model(['Admins_model','Golongan_model','Jabatan_model']);

	}

	public function index()
	{
		$data = [
			'title' => "Admins",
			'cname' => $this->cname,
			'pages' => "admin/admins/index",
			'data' => array(),
		];
		$data['data']['select_golongan'] = $this->Golongan_model->get_data();
		$data['data']['select_jabatan'] = $this->Jabatan_model->get_data();
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

	public function insert()
	{
		$id = $this->input->post('id_admin');
		$data = [
			'nama' => $this->input->post('nama'),
			'nomor_identitas' => $this->input->post('nomor_identitas'),
			'password' => md5($this->input->post('password')),
			'no_telp' => $this->input->post('no_telp'),
			'jabatan' => $this->input->post('jabatan'),
			'golongan' => $this->input->post('golongan'),
			'level_user' => $this->input->post('level_user'),
			'is_active' => $this->input->post('is_active'),
		];

		if ($id == "") {
			$insert = $this->Admins_model->insert($data);
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
			$update = $this->Admins_model->update($id, $data);
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

	public function delete_admin()
	{
		$id = $this->input->post('id_admin');

		if ($id != "") {
			$delete = $this->Admins_model->delete($id);
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
			
		} else {
			$ret = [
				'text' => "Delete failed",
				'title' => "Delete",
				'icon' => "warning",
			];
		}
		echo json_encode($ret);
	}

}

/* End of file Admins.php */
/* Location: ./application/controllers/Admin/Admins.php */