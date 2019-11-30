<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_Post extends CI_Controller {

	var $cname = "Admin/Kategori_Post";

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Kategori_Post_model');

	}

	public function index()
	{
		$data = [
			'title' => "Kategori Post",
			'cname' => $this->cname,
			'pages' => "admin/kategori_post/index",
			'data' => array(),
		];
		$this->load->view('layouts/dashboard',$data);
	}

	public function get_data()
	{
		$data['data'] = $this->Kategori_Post_model->get_data();
		echo json_encode($data);
	}

	public function get_data_by_id()
	{
		$id = $this->input->post('id_kategori');
		$data = $this->Kategori_Post_model->get_data_by_id($id);
		echo json_encode($data);
	}

	public function insert()
	{
		$id = $this->input->post('id_kategori');
		$data = [
			'nama_kategori' => $this->input->post('nama_kategori'),
			'parent' => $this->input->post('parent'),
			'status' => $this->input->post('status'),
		];

		if ($id == "") {
			$insert = $this->Kategori_Post_model->insert($data);
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
			$update = $this->Kategori_Post_model->update($id, $data);
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

	public function delete_kategori()
	{
		$id = $this->input->post('id_kategori');

		if ($id != "") {
			$delete = $this->Kategori_Post_model->delete($id);
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

/* End of file Kategori_Post.php */
/* Location: ./application/controllers/Admin/Kategori_Post.php */