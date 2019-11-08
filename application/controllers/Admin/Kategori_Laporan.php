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
			'title' => "Kategori",
			'cname' => $this->cname,
			'pages' => "admin/kategori_laporan/index",
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
		$data = [
			'id_kategori' => $this->input->post('id_kategori'),
			'nama_kategori' => $this->input->post('nama_kategori'),
			'status' => $this->input->post('status'),
		];
		// echo var_dump($data);
		$this->Kategori_Laporan_model->insert($data);
		// $this->load->view('layouts/dashboard');
	}

	public function delete_kategori()
	{
		$id_kategori = $this->input->post('id_kategori');

		$delete = $this->db
		->where('id_kategori')
		->delete('kategori');
		// echo var_dump($id_kategori);
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

		$this->Golongan_model->delete($id);
	}

}

/* End of file Kategori_Laporan.php */
/* Location: ./application/controllers/Admin/Kategori_Laporan.php */