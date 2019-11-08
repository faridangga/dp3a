<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Golongan_model extends CI_Model {


	var $table = "golongan";

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
		$this->db->where('id_golongan',$id);
		$query = $this->db->get();
		return $query->row(0);
	}

	public function insert($data)
	{
		$insert = $this->db->insert($this->table,$data);
		// return $insert;
		redirect('admin/golongan/index','refresh');
	}
	
	public function delete($id)
	{
		$delete = $this->db->delete($this->table);
		return $delete;
	}
}

/* End of file Golongan_model.php */
/* Location: ./application/models/Golongan_model.php */