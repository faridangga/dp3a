<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaduan_model extends CI_Model {

	var $table = "pengaduan";

	public function get_data()
	{
		$this->db->select('pengaduan.*, users.nama, kategori_laporan.nama_kategori, status_pengaduan.id_status');
		// $this->db->select('*');
		$this->db->from($this->table);
		$this->db->join('users', 'pengaduan.id_user = users.id_user','left');
		$this->db->join('kategori_laporan', 'pengaduan.id_kategori = kategori_laporan.id_kategori','left');
		$this->db->join('status_pengaduan', 'pengaduan.status = status_pengaduan.id_status','left');
		$this->db->where('pengaduan.status !=', 4);
		$this->db->order_by('waktu_lapor','desc');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_data_by_id($id)
	{
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('id_pengaduan',$id);
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
        $this->db->where('id_pengaduan', $id);
		$update = $this->db->update($this->table,$data);
		return $update;
	}
	
	public function delete($id)
	{
		$this->db->where('id_pengaduan',$id);
		$data = array('status' => 4);
		$delete = $this->db->update($this->table,$data);
		return $delete;
	}

	public function get_data_id($id)
	{
		$this->db->select('pengaduan.*, users.nama, kategori_laporan.nama_kategori, status_pengaduan.id_status');
		// $this->db->select('*');
		$this->db->from($this->table);
		$this->db->join('users', 'pengaduan.id_user = users.id_user','left');
		$this->db->join('kategori_laporan', 'pengaduan.id_kategori = kategori_laporan.id_kategori','left');
		$this->db->join('status_pengaduan', 'pengaduan.status = status_pengaduan.id_status','left');
		$this->db->where('users.id_user',$id);
		$query = $this->db->get();
		return $query->result();
	}

}

/* End of file Pengaduan_model.php */
/* Location: ./application/models/Pengaduan_model.php */