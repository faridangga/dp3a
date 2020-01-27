<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notif extends CI_Controller {

	public function notif_pengaduan()
	{
		$this->load->model('Pengaduan_model');
		$data = $this->Pengaduan_model->count_pengaduan();
		echo json_encode($data);
	}

}

/* End of file Notif.php */
/* Location: ./application/controllers/Admin/Notif.php */