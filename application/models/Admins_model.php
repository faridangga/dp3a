<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admins_model extends CI_Model {

	var $table = "admins";

	public function get_data()
	{
		$this->db->select('admins.*, golongan.nama_golongan, jabatan.nama_jabatan');
		$this->db->from($this->table);
		$this->db->join('golongan', 'golongan.id_golongan = admins.golongan', 'left');
		$this->db->join('jabatan', 'jabatan.id_jabatan = admins.jabatan', 'left');
		$this->db->where('is_active !=', 2);
		$this->db->order_by('id_admin','desc');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_data_by_id($id)
	{
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('id_admin',$id);
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
        $this->db->where('id_admin', $id);
		$update = $this->db->update($this->table,$data);
		return $update;
	}
	
	public function delete($id)
	{
		$this->db->where('id_admin',$id);
		$data = array('is_active' => 2);
		$delete = $this->db->update($this->table,$data);
		return $delete;
	}

}

/* End of file Admins_model.php */
/* Location: ./application/models/Admins_model.php */