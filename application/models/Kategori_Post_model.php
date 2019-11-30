<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_Post_model extends CI_Model {

	var $table = "kategori_post";

	public function get_data()
	{
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('status !=', 2);
		$this->db->order_by('id_kategori','desc');
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
		return $insert;
	}

	public function update($id, $data)
	{
        $this->db->where('id_kategori', $id);
		$update = $this->db->update($this->table,$data);
		return $update;
	}
	
	public function delete($id)
	{
		$this->db->where('id_kategori',$id);
		$data = array('status' => 2);
		$delete = $this->db->update($this->table, $data);
		return $delete;
	}


}

/* End of file Kategori_Post_model.php */
/* Location: ./application/models/Kategori_Post_model.php */