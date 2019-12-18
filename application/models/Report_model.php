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
		$this->db->select('kategori_laporan.nama_kategori, COUNT(pengaduan.id_kategori) as jumlah');
		$this->db->from('pengaduan');
		$this->db->join('kategori_laporan', 'pengaduan.id_kategori = kategori_laporan.id_kategori','left');
		$this->db->where('date(waktu_lapor) >=', $start);
		$this->db->where('date(waktu_lapor) <=', $end);
		$query = $this->db->get()->result();
		return $query;
	}

}

/* End of file Report_model.php */
/* Location: ./application/models/Report_model.php */