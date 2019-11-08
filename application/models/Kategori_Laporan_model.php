<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_Laporan_model extends CI_Model {

	var $table = "kategori_laporan";

	public function get_data()
	{
		$this->db->select('*');
		$this->db->from($this->table);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_data_by_id($id)
	{
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('id_kategori',$id);
		$query = $this->db->get();
		return $query->row(0);
	}

	public function insert($data)
	{
		$insert = $this->db->insert($this->table,$data);
		// return $insert;
		redirect('admin/kategori_laporan/index','refresh');
	}
	
	public function delete($id)
	{
		$delete = $this->db->delete($this->table);
		return $delete;
	}
	

}

/* End of file Kategori_Laporan_model.php */
/* Location: ./application/models/Kategori_Laporan_model.php */