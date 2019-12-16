<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_model extends CI_Model {

	public function get_data_laporan_kekerasan()
	{
		$this->db->select('*');
		$this->db->from('pengaduan');
		$query = $this->db->get();
		return $query->result(); 
	}

}

/* End of file Report_model.php */
/* Location: ./application/models/Report_model.php */