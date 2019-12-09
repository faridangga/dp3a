<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaduan extends CI_Controller {

	var $cname = "Admin/Pengaduan";

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Pengaduan_model');

	}

	public function index()
	{
		$data = [
			'title' => "Pengaduan",
			'cname' => $this->cname,
			'pages' => "admin/pengaduan/index",
			'data' => array(),
		];
		$this->load->view('layouts/dashboard',$data);
	}

	public function get_data()
	{
		$data['data'] = $this->Pengaduan_model->get_data();
		echo json_encode($data);
	}

	public function get_data_by_id()
	{
		$id = $this->input->post('id_pengaduan');
		$data = $this->Pengaduan_model->get_data_by_id($id);
		echo json_encode($data);
	}

	public function insert()
	{
		$id = $this->input->post('id_pengaduan');
		$data = [
			'id_pengaduan' => $this->input->post('id_pengaduan'),
			'id_user' => $this->input->post('id_user'),
			'id_kategori' => $this->input->post('id_kategori'),
			'isi_laporan' => $this->input->post('isi_laporan'),
			'waktu_respon' => date("Y-m-d H:i:s"),
			'status' => $this->input->post('status'),
		];

		if ($id == "") {
			$insert = $this->Pengaduan_model->insert($data);
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
			$update = $this->Pengaduan_model->update($id, $data);
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

	public function delete_pengaduan()
	{
		$id_pengaduan = $this->input->post('id_pengaduan');

		$delete = $this->Pengaduan_model->delete($id_pengaduan);
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

	public function edit_pengaduan($id)
    {
        $data = $this->Pengaduan_model->get_data_by_id($id);
        echo json_encode($data);
    }

}

/* End of file Pengaduan.php */
/* Location: ./application/controllers/Admin/Pengaduan.php */