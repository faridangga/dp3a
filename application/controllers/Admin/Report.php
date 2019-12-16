<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

	// var $cname = "Admin/Report";

	public function __construct()
	{
		parent::__construct();
		$this->load->model(['Pengaduan_model','Report_model']);

	}

	public function laporan_kekerasan()
	{
		$data = [
			'title' => "Report",
			'cname' => "Admin/Pengaduan",
			'pages' => "admin/report/laporan_kekerasan",
			'count_pengaduan' => $this->Pengaduan_model->count_pengaduan(),
			'data' => array(),
		];
		$data['data'] = $this->Pengaduan_model->get_data();
		$data['data']['select_lokasi'] = $this->Pengaduan_model->get_lokasi();
		$this->load->view('layouts/dashboard',$data);
		if ($this->session->userdata('isLogin') == FALSE) {
			redirect('login','refresh');
		}
		
	}

}

/* End of file Report.php */
/* Location: ./application/controllers/Admin/Report.php */