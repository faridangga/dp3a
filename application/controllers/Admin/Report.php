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
			'title' => "Rekap Jumlah Kekerasan",
			'cname' => "Admin/Pengaduan",
			'pages' => "admin/report/laporan_kekerasan",
			'count_pengaduan' => $this->Pengaduan_model->count_pengaduan(),
			'data' => array(),
		];
		$data['data'] = $this->Pengaduan_model->get_data_report();
		$data['data']['select_lokasi'] = $this->Pengaduan_model->get_lokasi();
		$this->load->view('layouts/dashboard',$data);
		if ($this->session->userdata('isLogin') == FALSE) {
			redirect('login','refresh');
		}
	}

	public function get_filter_date_kekerasan()
	{
		$start = ($this->input->post('start') != '0' ? $this->input->post('start') : null);
		$end = ($this->input->post('end') != '0' ? $this->input->post('end') : null);
		$data = $this->Report_model->get_filter_date_kekerasan($start, $end);
		echo json_encode($data);
	}

	public function report_layanan()
	{
		$data = [
			'title' => "Report Layanan",
			'cname' => "Admin/Report",
			'pages' => "admin/report/layanan",
			'count_pengaduan' => $this->Pengaduan_model->count_pengaduan(),
			'data' => array(),
		];
		// $data['data'] = $this->Pengaduan_model->get_data();
		$this->load->view('layouts/dashboard',$data);
		if ($this->session->userdata('isLogin') == FALSE) {
			redirect('login','refresh');
		}
	}

	public function get_report_layanan()
	{
		$start = ($this->input->post('start') != '0' ? $this->input->post('start') : null);
		$end = ($this->input->post('end') != '0' ? $this->input->post('end') : null);
		$data = $this->Report_model->get_report_layanan($start, $end);
		echo json_encode($data);
	}

	public function kekerasan_lokasi()
	{
		$data = [
			'title' => "Report Kekerasan Lokasi",
			'cname' => "Admin/Report",
			'pages' => "admin/report/kekerasan_lokasi",
			'count_pengaduan' => $this->Pengaduan_model->count_pengaduan(),
			'data' => array(),
		];
		$this->load->view('layouts/dashboard',$data);
		if ($this->session->userdata('isLogin') == FALSE) {
			redirect('login','refresh');
		}
	}

	public function get_report_bar_layanan_lokasi()
	{
		$start = ($this->input->post('start') != '0' ? $this->input->post('start') : null);
		$end = ($this->input->post('end') != '0' ? $this->input->post('end') : null);
		$data = $this->Report_model->get_report_bar_layanan_lokasi($start, $end);
		echo json_encode($data);
	}

	public function get_report_layanan_lokasi()
	{
		$start = ($this->input->post('start') != '0' ? $this->input->post('start') : null);
		$end = ($this->input->post('end') != '0' ? $this->input->post('end') : null);
		$data = $this->Report_model->get_report_layanan_lokasi($start, $end);
		echo json_encode($data);
	}
}

/* End of file Report.php */
/* Location: ./application/controllers/Admin/Report.php */