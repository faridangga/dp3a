<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_Kekerasan_model extends CI_Model {

	var $table = "data_kekerasan";

	public function get_data()
	{
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->order_by('id_laporan','desc');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_data_by_id($id)
	{
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('id_laporan',$id);
		$query = $this->db->get();
		return $query->row(0);
	}

	public function insert($data)
	{
		$insert = $this->db->insert($this->table,$data);
		return $insert;
	}

	public function update($id, $data)
	{
        $this->db->where('id_laporan', $id);
		$update = $this->db->update($this->table,$data);
		return $update;
	}
	
	public function delete($id)
	{
		$this->db->where('id_laporan',$id);
		$delete = $this->db->delete($this->table);
		return $delete;
	}
}

/* End of file Data_Kekerasan_model.php */
/* Location: ./application/models/Data_Kekerasan_model.php */