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
		// $where = "DATE(waktu_lapor) >= '2019-11-1' AND DATE(waktu_lapor) <= '2019-12-30'";
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

}

/* End of file Report_model.php */
/* Location: ./application/models/Report_model.php */