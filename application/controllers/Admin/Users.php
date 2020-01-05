<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	var $cname = "Admin/Users";

	public function __construct()
	{
		parent::__construct();
		$this->load->model(['Users_model','Pengaduan_model']);

	}

	public function index()
	{
		$data = [
			'title' => "Users",
			'cname' => $this->cname,
			'pages' => "admin/users/index",
			'count_pengaduan' => $this->Pengaduan_model->count_pengaduan(),
			'data' => array(),
		];
		$this->load->view('layouts/dashboard',$data);
		if ($this->session->userdata('isLogin') == FALSE) {
			redirect('login','refresh');
		}
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

	public function reset_pass()
	{
		// $tanggal_lahir = '';
		$id_user = $this->input->post('id_user');
		$data = $this->Users_model->get_data_by_id2($id_user);

		foreach ($data as $key => $value) {
			$tanggal_lahir = $value->tanggal_lahir;
		}

		$pass = str_replace('-', '', $tanggal_lahir);
		// $update_pass = $this->Users_model->update($id);
		// $tanggal_lahir = $this->input->post('tanggal_lahir');
		if ($id_user != "") {
			$update_pass = $this->Users_model->update($id_user, $pass);
			// $update_pass = $this->Users_model->update($id_user);
			if($update_pass){
				$ret = [
					'text' => "Reset Password Berhasil",
					'title' => "Reset Password",
					'icon' => "success",
				];
			}else{
				$ret = [
					'text' => "Reset Password Gagal",
					'title' => "Reset Password",
					'icon' => "warning",
				];
			}
			
		} else {
			$ret = [
				'text' => "Reset Password Gagal Karena ID kosong",
				'title' => "Reset Password",
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