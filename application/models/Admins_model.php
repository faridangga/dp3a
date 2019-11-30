<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admins_model extends CI_Model {

	var $table = "admins";

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
		$this->db->where('id_admin', $id);
		$query = $this->db->get();
		return $query->row(0);
	}

}

/* End of file Admins_model.php */
/* Location: ./application/models/Admins_model.php */