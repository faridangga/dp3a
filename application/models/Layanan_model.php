<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Layanan_model extends CI_Model
{

	var $table = "layanan";

	public function get_data()
	{
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('status !=', 2);
		$this->db->order_by('id_layanan', 'asc');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_data_by_id($id)
	{
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('id_layanan', $id);
		$query = $this->db->get();
		return $query->row(0);
	}

	public function insert($data)
	{
		$insert = $this->db->insert($this->table, $data);
		return $insert;
	}

	public function update($id, $data)
	{
		$this->db->where('id_layanan', $id);
		$update = $this->db->update($this->table, $data);
		return $update;
	}

	public function delete($id)
	{
		$this->db->where('id_layanan', $id);
		$data = array('status' => 2);
		$delete = $this->db->update($this->table, $data);
		return $delete;
	}
}

/* End of file Layanan_model.php */
/* Location: ./application/models/Layanan_model.php */