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
		// $data['data']['count_pengaduan'] = $this->Pengaduan_model->count_pengaduan();
		// echo json_encode($data['data']['count_pengaduan']);
		$this->load->view('layouts/dashboard',$data);

		if ($this->session->userdata('isLogin') == FALSE) {
			redirect('login','refresh');
		}
	}

	public function tes(){
		$a = $this->Pengaduan_model->get_data_date();
		echo json_encode($a);
	}

	// public function count_pengaduan()
	// {
	// 	$data = $this->Pengaduan_model->count_pengaduan();
	// 	echo json_encode($data);
	// }

	// public function get_pengaduan_1($pengaduan_category = null)
	// {
	// 	if($pengaduan_category == "0") $pengaduan_category = null;
	// 	$data = $this->Dashboard_model->get_sto_1($pengaduan_category);
	// 	echo json_encode($data);
	// }

	public function get_chart_pengaduan()
	{
		$id_kategori = $this->input->post('id_kategori');
		$waktu_lapor = $this->input->post('waktu_lapor');
		$status = 
		$arr_data = array();
		$data= $this->Pengaduan_model->get_chart_pengaduan($id_kategori, $waktu_lapor);
		$status_pengaduan = $this->Pengaduan_model->get_status_pengaduan();
		
		$i = 1;
		foreach ($data as $key => $value) {
			
		}

		


		echo json_encode($arr_data);
	}

	public function get_bar_pengaduan()
	{
		$id_kategori = $this->input->post('id_kategori');
		$waktu_lapor = $this->input->post('waktu_lapor');
		
		// $pengaduan = $this->Dashboard_model->get_bar_pengaduan(5,2019);
		$this->db->where('id_kategori',$id_kategori);
		$this->db->where('year(waktu_lapor)',$waktu_lapor);
		$query = $this->db->get("pengaduan")->result();

		$jumlah = 0;
		$belum_direspon = 0;
		$sudah_teratasi = 0;
		$tidak_bisa_hub = 0;
		$tidak_teratasi = 0;

		foreach ($query as $key => $value) {
			if ($value->status == 0) {
				$belum_direspon++;
			}elseif ($value->status == 1) {
				$sudah_teratasi++;
			}elseif ($value->status == 2) {
				$tidak_teratasi++;
			}elseif ($value->status == 3) {
				$tidak_bisa_hub++;
			}
		}

		$result = array(
			"belum_direspon" => $belum_direspon,
			"sudah_teratasi" => $sudah_teratasi,
			"tidak_teratasi" => $tidak_teratasi,
			"tidak_bisa_hub" => $tidak_bisa_hub
		);

		echo json_encode($result);	
	}

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */