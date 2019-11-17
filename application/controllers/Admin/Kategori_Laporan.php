<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_Laporan extends CI_Controller {

	var $cname = "Admin/Kategori_Laporan";

	public function __construct()
    {
        parent::__construct();
        $this->load->model('Kategori_Laporan_model');
        
    }

	public function index()
	{
		$data = [
			'title' => "Kategori Laporan",
			'cname' => $this->cname,
			'pages' => "admin/Kategori_Laporan/index",
			'data' => array(),
		];
		$this->load->view('layouts/dashboard',$data);
	}

	public function get_data()
	{
		$data['data'] = $this->Kategori_Laporan_model->get_data();
		echo json_encode($data);
	}

	public function get_data_by_id()
	{
		$id = $this->input->post('id_kategori');
		$data = $this->Kategori_Laporan_model->get_data_by_id($id);
		echo json_encode($data);
	}

	public function insert()
	{
		$id = $this->input->post('id_kategori');
		$data = [
			'nama_kategori' => $this->input->post('nama_kategori'),
			'status' => $this->input->post('status'),
		];

		if ($id == "") {
			$insert = $this->Kategori_Laporan_model->insert($data);
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
			$update = $this->Kategori_Laporan_model->update($id, $data);
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

		$delete = $this->Kategori_Laporan_model->delete($id);
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

/* End of file Kategori_Laporan.php */
/* Location: ./application/controllers/Admin/Kategori_Laporan.php */