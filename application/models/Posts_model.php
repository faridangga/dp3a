<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posts_model extends CI_Model {

	var $table = "posts";

	public function get_data()
	{
		$this->db->select('posts.*, kategori_post.nama_kategori, admins.nama');
		$this->db->from($this->table);
		$this->db->join('kategori_post', 'kategori_post.id_kategori = posts.category_id', 'left');
		$this->db->join('admins', 'admins.id_admin = posts.user_id', 'left');
		$this->db->where('posts.status !=', 2);
		$this->db->order_by('created_at','desc');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_data_by_id($id)
	{
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('id',$id);
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
		$this->db->where('id', $id);
		$update = $this->db->update($this->table,$data);
		return $update;
	}
	
	public function delete($id)
	{
		$this->db->where('id',$id);
		$data = array('status' => 2);
		$delete = $this->db->update($this->table,$data);
		return $delete;
	}

	public function update_is_slider($id)
	{
		$is_slider = 0;
		$this->db->where('id',$id);
		$query = $this->db->get($this->table)->result();
		foreach ($query as $key => $value) {	
			$is_slider = $value->is_slider;
		}
		
		if ($is_slider == 0 ) {
			$data = array('is_slider' => 1);
		}else {
			$data = array('is_slider' => 0);			
		}
		$this->db->where('id',$id);
		$ret = $this->db->update($this->table,$data);
		return $ret;
	}

	public function count_artikel()
	{
		$jumlah = 0;
		$query = $this->db->get($this->table)->result();
		foreach ($query as $key => $value) {	
			$jumlah++;
		}
		// echo json_encode($status);
		return $jumlah;

	}
}

/* End of file Posts_model.php */
/* Location: ./application/models/Posts_model.php */