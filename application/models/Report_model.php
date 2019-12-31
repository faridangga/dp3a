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

	public function get_filter_date_kekerasan($start = null, $end = null)
	{
		$this->db->select('kategori_laporan.nama_kategori');
		$this->db->from('pengaduan');
		$this->db->join('kategori_laporan', 'pengaduan.id_kategori = kategori_laporan.id_kategori','left');
		$this->db->where('date(waktu_lapor) >=', $start);
		$this->db->where('date(waktu_lapor) <=', $end);
		$filter_date = $this->db->get()->result();

		$this->db->select('kecamatan.nama_kecamatan, IFNULL(COUNT(id_pengaduan),0) as jumlah');
		$this->db->from('pengaduan');
		$this->db->join('kecamatan', 'pengaduan.kecamatan = kecamatan.id_kecamatan', 'right');
		$this->db->group_by('nama_kecamatan');
		$query = $this->db->get();
		$result = $query->result_array();
		$ret_pengaduan_ok = 0;
		$ret_pengaduan_n_ok = 0;

		foreach ($result as $key => $value) {
			if($value['jumlah'] == '1'){
				$ret_pengaduan_ok ++;
			}else{
				$ret_pengaduan_n_ok ++;
			}
		}



		$ret = [
			'filter_date' => $filter_date,
			// 'count_all' => $ret_query,
			'count_pengaduan_ok' => $ret_pengaduan_ok,

		];

		return $ret;
	}

	public function get_report_layanan($start = null, $end = null)
	{
		$this->db->select('concat(monthname(waktu_lapor)," ",year(waktu_lapor)) as date,
			SUM(CASE WHEN layanan = "1" THEN 1 ELSE 0 END) "Pengaduan",
			SUM(CASE WHEN layanan = "2" THEN 1 ELSE 0 END) "Kesehatan",
			SUM(CASE WHEN layanan = "3" THEN 1 ELSE 0 END) "Bantuan Hukum",
			SUM(CASE WHEN layanan = "4" THEN 1 ELSE 0 END) "Penegakan Hukum",
			SUM(CASE WHEN layanan = "5" THEN 1 ELSE 0 END) "Rehabilitasi Sosial",
			SUM(CASE WHEN layanan = "6" THEN 1 ELSE 0 END) "Reintegrasi Sosial",
			SUM(CASE WHEN layanan = "7" THEN 1 ELSE 0 END) "Pemulangan",
			SUM(CASE WHEN layanan = "8" THEN 1 ELSE 0 END) "Pendampingan Tokoh Agama"');
		$this->db->from('pengaduan');
		if ($start != null && $end != null) {
			$this->db->where('waktu_lapor BETWEEN "'. date('Y-m-d', strtotime($start)). '" and "'. date('Y-m-d', strtotime($end)).'"');
		}
		
		// if($start != null){
		// 	$this->db->where('waktu_lapor >=',$start);
		// }
		// if($end != null){
		// 	$this->db->where('waktu_lapor <=',$end);
		// }


		$this->db->group_by('year(waktu_lapor),month(waktu_lapor)');
		// $this->db->group_by('waktu_lapor');

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
			'rgba(255, 159, 64, 0.2)',
			'rgba(75, 192, 192, 0.2)',
			'rgb(54, 162, 235, 0.2)',
			'rgb(153, 102, 255, 0.2)',
			'rgb(174, 1, 126, 0.2)',
			'rgb(127, 59, 8, 0.2)',
			'rgb(37, 37, 37, 0.2)',
		];

		$borderColor = [
			'rgb(255, 99, 132)',
			'rgba(255, 159, 64)',
			'rgba(75, 192, 192)',
			'rgb(54, 162, 235)',
			'rgb(153, 102, 255)',
			'rgb(174, 1, 126)',
			'rgb(127, 59, 8)',
			'rgb(37, 37, 37)',
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