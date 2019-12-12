<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

	var $table = "data_kekerasan";

	public function get_bar_pengaduan($id_kategori,$waktu_lapor)
	{
		// $query = $this->db->query('SELECT * FROM pengaduan WHERE id_kategori ='.$id_kategori.' and YEAR(waktu_lapor) = '.$waktu_lapor.'')->result(); 

		$this->db->where('id_kategori',$id_kategori);
		$this->db->where('year(waktu_lapor)',$waktu_lapor);
		$query = $this->db->get("pengaduan")->result();
		return $query;
	}

	public function getKategori(){
		$query = $this->db->get('kategori_laporan');
		return $query->result();
	}

}

/* End of file Dashboard_model.php */
/* Location: ./application/models/Dashboard_model.php */