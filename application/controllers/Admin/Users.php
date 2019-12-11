<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	var $cname = "Admin/Users";

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Users_model');

	}

	public function index()
	{
		$data = [
			'title' => "Users",
			'cname' => $this->cname,
			'pages' => "admin/users/index",
			'data' => array(),
		];
		$this->load->view('layouts/dashboard',$data);
	}

	public function get_data()
	{
		$data['data'] = $this->Users_model->get_data();
		echo json_encode($data);
	}

	public function get_data_by_id()
	{
		$id = $this->input->post('id_user');
		$data = $this->Users_model->get_data_by_id($id);
		echo json_encode($data);
	}

	public function insert()
	{
		$id = $this->input->post('id_user');
		$data = [
			'nama' => $this->input->post('nama'),
			'password' => md5($this->input->post('password')),
			'nomor_telp' => $this->input->post('nomor_telp'),
			'alamat' => $this->input->post('alamat'),
			'tanggal_lahir' => $this->input->post('tanggal_lahir'),
			'status' => $this->input->post('status'),
		];

		if ($id == "") {
			$insert = $this->Users_model->insert($data);
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
			$update = $this->Users_model->update($id, $data);
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

	public function delete_user()
	{
		$id = $this->input->post('id_user');

		if ($id != "") {
			$delete = $this->Users_model->delete($id);
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

	public function update_status()
	{
		$id = $this->input->post('id_user');
		$update = $this->Users_model->update_status($id);
		if($update){
			$ret = [
				'text' => "Update success",
				'title' => "Update",
				'icon' => "success",
			];
		}else{
			$ret = [
				'text' => "Update failed",
				'title' => "Update",
				'icon' => "warning",
			];
		}
		echo json_encode($ret);
	}
}

/* End of file Users.php */
/* Location: ./application/controllers/Admin/Users.php */