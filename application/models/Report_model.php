<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_model extends CI_Model {

	public function get_data_laporan_kekerasan()
	{
		$this->db->select('*');
		$this->db->from('pengaduan');
		$query = $this->db->get();
		return $query->result(); 
	}


	public function get_report_layanan($start = null, $end = null)
	{
		$this->db->select('pengaduan.*, layanan.nama_layanan as nama_layanan1,
			SUM(CASE WHEN nama_layanan ="Pengaduan" THEN 1 ELSE 0 END)
			+ SUM(CASE WHEN nama_layanan ="Kesehatan" THEN 1 ELSE 0 END)
			+ SUM(CASE WHEN nama_layanan ="Bantuan Hukum" THEN 1 ELSE 0 END)
			+ SUM(CASE WHEN nama_layanan ="Penegakan Hukum" THEN 1 ELSE 0 END)
			+ SUM(CASE WHEN nama_layanan ="Rehabilitasi Sosial" THEN 1 ELSE 0 END)
			+ SUM(CASE WHEN nama_layanan ="Reintegrasi Sosial" THEN 1 ELSE 0 END) 
			+ SUM(CASE WHEN nama_layanan ="Pemulangan" THEN 1 ELSE 0 END)
			+ SUM(CASE WHEN nama_layanan ="Pendampingan Tokoh Agama" THEN 1 ELSE 0 END) Total');
		// $this->db->select('pengaduan.*, kecamatan.nama_kecamatan');
		$this->db->from('pengaduan');
		$this->db->join('layanan', 'pengaduan.layanan = layanan.id_layanan','left');

		$this->db->where('pengaduan.status !=', 5);
		$this->db->where('pengaduan.layanan !=', 0);
		$this->db->group_by('layanan');
		$this->db->order_by('layanan','asc');
		if ($start != null && $end != null) {
			$this->db->where('waktu_lapor BETWEEN "'. date('Y-m-d', strtotime($start)). '" and "'. date('Y-m-d', strtotime($end)).'"');
		}

		$query = $this->db->get();
		return $query->result();
	}

	public function get_report_bar_layanan($start = null, $end = null)
	{
		$this->db->select('concat(layanan.nama_layanan) as date,
			SUM(CASE WHEN nama_layanan ="Pengaduan" THEN 1 ELSE 0 END)
			+ SUM(CASE WHEN nama_layanan ="Kesehatan" THEN 1 ELSE 0 END)
			+ SUM(CASE WHEN nama_layanan ="Bantuan Hukum" THEN 1 ELSE 0 END)
			+ SUM(CASE WHEN nama_layanan ="Penegakan Hukum" THEN 1 ELSE 0 END)
			+ SUM(CASE WHEN nama_layanan ="Rehabilitasi Sosial" THEN 1 ELSE 0 END)
			+ SUM(CASE WHEN nama_layanan ="Reintegrasi Sosial" THEN 1 ELSE 0 END) 
			+ SUM(CASE WHEN nama_layanan ="Pemulangan" THEN 1 ELSE 0 END)
			+ SUM(CASE WHEN nama_layanan ="Pendampingan Tokoh Agama" THEN 1 ELSE 0 END) Jumlah');
		$this->db->from('pengaduan');
		$this->db->join('layanan', 'pengaduan.layanan = layanan.id_layanan','left');
		$this->db->join('kecamatan', 'pengaduan.kecamatan = kecamatan.id_kecamatan', 'left');

		$this->db->where('pengaduan.status !=', 5);
		$this->db->where('pengaduan.layanan !=', 0);
		if ($start != null && $end != null) {
			$this->db->where('waktu_lapor BETWEEN "'. date('Y-m-d', strtotime($start)). '" and "'. date('Y-m-d', strtotime($end)).'"');
		}
		
		
		$this->db->group_by('kecamatan');
		$result = $this->db->get()->result_array();

		$labels = [];
		foreach ($result as $key1 => $value1) {
			array_push($labels,$value1['date']);
		}

		$ds_label = [];
		$ds_data = [];

		if(count($result) != 0){
			foreach ($result[0] as $key => $value) {
				if($key != 'date'){
					array_push($ds_label,$key);	
				}
			}
			for ($i=1; $i < (count($result[0])); $i++) { 
				$row_data = [];
				for ($j=0; $j < count($result); $j++) { 
					array_push($row_data,$result[$j][$ds_label[$i-1]]);
				}
				array_push($ds_data,$row_data);
			}
		}

		$backgroundColor = [
			'rgb(255, 99, 132, 0.2)',
		];

		$borderColor = [
			'rgb(255, 99, 132)',
		];

		$ret = [
			'labels' => $labels,
			'label' => $ds_label,
			'data' => $ds_data,
			'backgroundColor' => $backgroundColor,
			'borderColor' => $borderColor,
			// 'query' => $this->db->last_query()
		];
		return $ret;
	}

	public function get_report_layanan_lokasi($start = null, $end = null)
	{
		$this->db->select('pengaduan.*, kecamatan.nama_kecamatan,
			SUM(CASE WHEN nama_kategori ="Fisik" THEN 1 ELSE 0 END) Fisik
			, SUM(CASE WHEN nama_kategori ="Psikis" THEN 1 ELSE 0 END) Psikis
			, SUM(CASE WHEN nama_kategori ="Seksual" THEN 1 ELSE 0 END) Seksual
			, SUM(CASE WHEN nama_kategori ="Eksploitasi" THEN 1 ELSE 0 END) Eksploitasi
			, SUM(CASE WHEN nama_kategori ="Trafficking" THEN 1 ELSE 0 END) Trafficking
			, SUM(CASE WHEN nama_kategori ="Penelantaran" THEN 1 ELSE 0 END) Penelantaran
			, SUM(CASE WHEN nama_kategori ="Lainnya" THEN 1 ELSE 0 END) Lainnya
			, SUM(CASE WHEN nama_kategori ="Fisik" THEN 1 ELSE 0 END)
			+ SUM(CASE WHEN nama_kategori ="Psikis" THEN 1 ELSE 0 END)
			+ SUM(CASE WHEN nama_kategori ="Seksual" THEN 1 ELSE 0 END)
			+ SUM(CASE WHEN nama_kategori ="Eksploitasi" THEN 1 ELSE 0 END)
			+ SUM(CASE WHEN nama_kategori ="Trafficking" THEN 1 ELSE 0 END)
			+ SUM(CASE WHEN nama_kategori ="Penelantaran" THEN 1 ELSE 0 END) 
			+ SUM(CASE WHEN nama_kategori ="Lainnya" THEN 1 ELSE 0 END) Total');
		$this->db->from('pengaduan');
		$this->db->join('kategori_laporan', 'pengaduan.id_kategori = kategori_laporan.id_kategori','left');
		$this->db->join('kecamatan', 'pengaduan.kecamatan = kecamatan.id_kecamatan', 'left');

		$this->db->where('pengaduan.status !=', 5);
		$this->db->group_by('kecamatan.nama_kecamatan');
		$this->db->order_by('kecamatan.nama_kecamatan','asc');
		if ($start != null && $end != null) {
			$this->db->where('waktu_lapor BETWEEN "'. date('Y-m-d', strtotime($start)). '" and "'. date('Y-m-d', strtotime($end)).'"');
		}

		$query = $this->db->get();
		return $query->result();
	}

	public function get_report_bar_layanan_lokasi($start = null, $end = null)
	{
		$this->db->select("concat(kecamatan.nama_kecamatan) as date, COUNT(waktu_lapor) Jumlah");
		$this->db->from('pengaduan');
		$this->db->join('kecamatan', 'pengaduan.kecamatan = kecamatan.id_kecamatan', 'left');
		$this->db->where('pengaduan.status !=', 5);

		if ($start != null && $end != null) {
			$this->db->where('waktu_lapor BETWEEN "'. date('Y-m-d', strtotime($start)). '" and "'. date('Y-m-d', strtotime($end)).'"');
		}
		
		$this->db->group_by('kecamatan');
		$result = $this->db->get()->result_array();

		$labels = [];
		foreach ($result as $key1 => $value1) {
			array_push($labels,$value1['date']);
		}

		$ds_label = [];
		$ds_data = [];

		if(count($result) != 0){
			foreach ($result[0] as $key => $value) {
				if($key != 'date'){
					array_push($ds_label,$key);	
				}
			}
			for ($i=1; $i < (count($result[0])); $i++) { 
				$row_data = [];
				for ($j=0; $j < count($result); $j++) { 
					array_push($row_data,$result[$j][$ds_label[$i-1]]);
				}
				array_push($ds_data,$row_data);
			}
		}

		$backgroundColor = [
			'rgb(255, 99, 132, 0.2)',
		];

		$borderColor = [
			'rgb(255, 99, 132)',
		];

		$ret = [
			'labels' => $labels,
			'label' => $ds_label,
			'data' => $ds_data,
			'backgroundColor' => $backgroundColor,
			'borderColor' => $borderColor,
			// 'query' => $this->db->last_query()
		];
		return $ret;
	}
}

/* End of file Report_model.php */
/* Location: ./application/models/Report_model.php */