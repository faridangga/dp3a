<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model {

	var $table = "users";

	public function get_data()
	{
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('status !=', 2);
		$this->db->order_by('id_user','desc');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_data_by_id($id)
	{
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('id_user',$id);
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
        $this->db->where('id_user', $id);
		$update = $this->db->update($this->table,$data);
		return $update;
	}
	
	public function delete($id)
	{
		$this->db->where('id_user',$id);
		$data = array('status' => 2);
		$delete = $this->db->update($this->table,$data);
		return $delete;
	}

	public function update_status($id)
	{
		$status = 0;
		$this->db->where('id_user',$id);
		$query = $this->db->get($this->table)->result();
		foreach ($query as $key => $value) {	
			$status = $value->status;
		}
		
		if ($status == 0 ) {
			$data = array('status' => 1);
		}else {
			$data = array('status' => 0);			
		}
		$this->db->where('id_user',$id);
		$ret = $this->db->update($this->table,$data);
		return $ret;
	}

	public function count_user()
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

/* End of file Users_model.php */
/* Location: ./application/models/Users_model.php */