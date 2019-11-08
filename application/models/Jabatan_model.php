<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jabatan_model extends CI_Model {

	var $table = 'jabatan';

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
		$this->db->where('id_jabatan',$id);
		$query = $this->db->get();
		return $query->row(0);
	}

	public function insert($data)
	{
		$insert = $this->db->insert($this->table,$data);
		// return $insert;
		redirect('admin/jabatan/index','refresh');
	}
}

/* End of file Jabatan_model.php */
/* Location: ./application/models/Jabatan_model.php */