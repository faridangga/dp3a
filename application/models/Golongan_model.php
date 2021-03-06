<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Golongan_model extends CI_Model {

	var $table = "golongan";

	public function get_data()
	{
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('status !=', 2);
		$this->db->order_by('id_golongan','desc');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_data_by_id($id)
	{
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('id_golongan',$id);
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
        $this->db->where('id_golongan', $id);
		$update = $this->db->update($this->table,$data);
		return $update;
	}
	
	public function delete($id)
	{
		$this->db->where('id_golongan',$id);
		$data = array('status' => 2);
		$delete = $this->db->update($this->table,$data);
		return $delete;
	}
}

/* End of file Golongan_model.php */
/* Location: ./application/models/Golongan_model.php */