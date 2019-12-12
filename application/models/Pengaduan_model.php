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

	public function get_data_date(){
		$this->db->select('DISTINCT(YEAR(waktu_lapor)) as tahun');  
		$this->db->from('pengaduan');  
		$query=$this->db->get()->result();  
		return $query;
	}

	public function get_data_by_id($id)
	{
		$this->db->select('pengaduan.*, users.nama, kategori_laporan.nama_kategori, status_pengaduan.id_status');
		// $this->db->select('*');
		$this->db->from($this->table);
		$this->db->join('users', 'pengaduan.id_user = users.id_user','left');
		$this->db->join('kategori_laporan', 'pengaduan.id_kategori = kategori_laporan.id_kategori','left');
		$this->db->join('status_pengaduan', 'pengaduan.status = status_pengaduan.id_status','left');
		$this->db->where('pengaduan.status !=', 4);
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

	public function count_pengaduan()
	{
		$jumlah = 0;
		$status = 0;
		$this->db->where('status =', 0);
		$query = $this->db->get($this->table)->result();
		foreach ($query as $key => $value) {	
			if ($value->status == 0) {
				$jumlah++;
			}
		}
		// echo json_encode($status);
		return $jumlah;

	}

	public function count_pengaduan_all()
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

/* End of file Pengaduan_model.php */
/* Location: ./application/models/Pengaduan_model.php */