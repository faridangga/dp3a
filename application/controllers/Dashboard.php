<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	var $cname = "Dashboard";

	public function __construct()
	{
		parent::__construct();
		$this->load->model(['Pengaduan_model','Posts_model','Users_model','Dashboard_model','Kategori_Laporan_model']);

	}

	public function index()
	{
		$data = [
			'title' => "dashboard",
			'cname' => $this->cname,
			'pages' => "admin/dashboard/index",
			'count_pengaduan' => $this->Pengaduan_model->count_pengaduan(),
			'count_pengaduan_all' => $this->Pengaduan_model->count_pengaduan_all(),
			'count_artikel' => $this->Posts_model->count_artikel(),
			'count_user' => $this->Users_model->count_user(),
			'data' => array(),
		];
		$data['data']['select_kategori'] = $this->Kategori_Laporan_model->get_data();
		$data['data']['tahun'] = $this->Pengaduan_model->get_data_date();	
		$this->load->view('layouts/dashboard',$data);

		if ($this->session->userdata('isLogin') == FALSE) {
			redirect('login','refresh');
		}
	}


	public function get_chart_pengaduan()
	{
		$id_kategori = ($this->input->post('id_kategori') != '0' ? $this->input->post('id_kategori') : null);
		$waktu_lapor = ($this->input->post('waktu_lapor') != '0' ? $this->input->post('waktu_lapor') : null);
		$data = $this->Pengaduan_model->get_chart_pengaduan($id_kategori, $waktu_lapor);
		echo json_encode($data);
	}

	public function get_table_pengaduan()
	{
		$data['data'] = $this->Dashboard_model->get_table_pengaduan();
		echo json_encode($data);
	}
}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */