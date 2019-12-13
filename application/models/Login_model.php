<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

	var $table = "admins";
	
	public function getAdmin($no_identitas,$password)
	{
		$this->db->where('nomor_identitas', $no_identitas);
		$this->db->where('password', $password);
		$result = $this->db->get('admins')->result();
		return $result;
		
	}
}

/* End of file Login_model.php */
/* Location: ./application/models/Login_model.php */