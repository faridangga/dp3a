<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_Kekerasan extends CI_Controller {

	var $cname = "Admin/Data_Kekerasan";

	public function __construct()
    {
        parent::__construct();
        $this->load->model(['Data_Kekerasan_model','Pengaduan_model']);  
    }

	public function index()
	{
		$data = [
			'title' => "Kategori Laporan",
			'cname' => $this->cname,
			'pages' => "admin/data_kekerasan/index",
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
		$data['data'] = $this->Data_Kekerasan_model->get_data();
		echo json_encode($data);
	}

	public function get_data_by_id()
	{
		$id = $this->input->post('id_laporan');
		$data = $this->Data_Kekerasan_model->get_data_by_id($id);
		echo json_encode($data);
	}

	public function insert()
	{
		$id = $this->input->post('id_laporan');
		$data = [
			'id_laporan' => $this->input->post('id_laporan'),
			'bulan' => $this->input->post('bulan'),
			'tahun' => $this->input->post('tahun'),
			'usia_1' => $this->input->post('usia_1'),
			'usia_2' => $this->input->post('usia_2'),
			'usia_3' => $this->input->post('usia_3'),
			'fsk' => $this->input->post('fsk'),
			'psi' => $this->input->post('psi'),
			'seks' => $this->input->post('seks'),
			'eks' => $this->input->post('eks'),
			'penelantaran' => $this->input->post('penelantaran'),
			'lain' => $this->input->post('lain'),
		];

		if ($id == "") {
			$insert = $this->Data_Kekerasan_model->insert($data);
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
			$update = $this->Data_Kekerasan_model->update($id, $data);
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
		$id = $this->input->post('id_laporan');

		if ($id != "") {
			$delete = $this->Data_Kekerasan_model->delete($id);
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

/* End of file Data_Kekerasan.php */
/* Location: ./application/controllers/Admin/Data_Kekerasan.php */