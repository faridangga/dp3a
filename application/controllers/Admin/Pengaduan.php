<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengaduan extends CI_Controller
{

	var $cname = "Admin/Pengaduan";

	public function __construct()
	{
		parent::__construct();
		$this->load->model(['Pengaduan_model', 'Users_model', 'Kategori_Laporan_model', 'History_layanan_model']);
	}

	public function index()
	{
		$data = [
			'title' => "Pengaduan",
			'cname' => $this->cname,
			'pages' => "admin/pengaduan/index",
			'count_pengaduan' => $this->Pengaduan_model->count_pengaduan(),
			'data' => array(),
		];
		$data['data']['select_layanan'] = $this->Pengaduan_model->get_layanan();
		$data['data']['select_status_pengaduan'] = $this->Pengaduan_model->get_status_pengaduan();
		$this->load->view('layouts/dashboard', $data);
		if ($this->session->userdata('isLogin') == FALSE) {
			redirect('login', 'refresh');
		}
	}

	public function get_data()
	{
		$data['data'] = $this->Pengaduan_model->get_data();
		echo json_encode($data);
	}

	public function get_data_report()
	{
		$kecamatan = ($this->input->post('nama_kecamatan') != '0' ? $this->input->post('nama_kecamatan') : null);
		$year = $this->input->post('year');
		$data['data'] = $this->Pengaduan_model->get_data_report($kecamatan, $year);
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
			'waktu_respon' => date("Y-m-d H:i:s"),
			'status' => $this->input->post('status'),
			'nama_layanan' => $this->input->post('nama_layanan'),
		];

		if ($id == "") {
			$insert = $this->Pengaduan_model->insert($data);
			if ($insert) {
				$ret = [
					'title' => "Insert",
					'text' => "Insert success",
					'icon' => "success",
				];
			} else {
				$ret = [
					'title' => "Insert",
					'text' => "Insert failed",
					'icon' => "warning",
				];
			}
		} else {
			$update = $this->Pengaduan_model->update($id, $data);
			if ($update) {
				$ret = [
					'title' => "Update",
					'text' => "Update success",
					'icon' => "success",
				];
			} else {
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
		$id = $this->input->post('id_pengaduan');

		if ($id != "") {
			$delete = $this->Pengaduan_model->delete($id);
			if ($delete) {
				$ret = [
					'title' => "Delete",
					'text' => "Delete success",
					'icon' => "success",
				];
			} else {
				$ret = [
					'title' => "Delete",
					'text' => "Delete failed",
					'icon' => "warning",
				];
			}
		} else {
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

	public function update()
	{
		$id = $this->input->post('id_pengaduan');
		$data = [
			'waktu_respon' => date("Y-m-d H:i:s"),
			'status' => $this->input->post('status'),
			'layanan' => $this->input->post('layanan'),
		];

		$id_pengaduan = $this->input->post('id_pengaduan');
		$id_layanan = $this->input->post('id_layanan');
		$keterangan_history = $this->input->post('keterangan_history');
		$waktu = date("Y-m-d");
		$datas = array();

		$index = 0; // Set index array awal dengan 0    
		foreach ($id_layanan as $d) { // Kita buat perulangan berdasarkan nis sampai data terakhir      
			array_push($datas, array(
				'id_pengaduan' => $id_pengaduan,
				'id_layanan' => $d,
				'tanggal' => $waktu,
				'keterangan' => $keterangan_history[$index],
			));
			$index++;
		}
		$sql = $this->History_layanan_model->save_batch($datas);

		$update = $this->Pengaduan_model->update($id, $data);
		if ($update) {
			$ret = [
				'title' => "Update",
				'text' => "Update success",
				'icon' => "success",
			];
		} else {
			$ret = [
				'title' => "Update",
				'text' => "Update failed",
				'icon' => "warning",
			];
		}
		echo json_encode($ret);
	}

	public function count_pengaduan()
	{
		$data['data'] = $this->Pengaduan_model->count_pengaduan();
		echo json_encode($data);
	}
}

/* End of file Pengaduan.php */
/* Location: ./application/controllers/Admin/Pengaduan.php */