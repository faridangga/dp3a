<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Login_model');
	}

	public function index()
	{
		$this->load->model('Login_model');
		$data = [
			'title' => "Dashboard",
			'data' => array(),
		];

		$this->load->view('layouts/login',$data);

		if ($this->session->userdata('isLogin') == TRUE) {
			redirect('dashboard','refresh');
		}
	}

	public function cekLogin(){

		$this->form_validation->set_rules('no_identitas',"Nomor identitas","trim|required");
		$this->form_validation->set_rules('password',"Password","trim|required");
		$this->form_validation->set_message('required',"{field} harus diisi");
		$this->form_validation->set_error_delimiters('','');

		if($this->form_validation->run() == false){
			$this->load->view('layouts/login',$data);
		}else{
			$no_identitas = $this->input->post("no_identitas");
			$password = $this->input->post("password");

			$get_login = $this->Login_model->getAdmin($no_identitas,md5($password));
			if ($get_login) {
				foreach ($get_login as $key => $value) {
					$data_session = array(
						'isLogin' => TRUE,
						'user_id' => $value->id_admin,
						'nama' => $value->nama, 
					);
				}
				$this->session->set_userdata($data_session);
				redirect('dashboard','refresh');
				echo json_encode($data_session);
			}else{
				$this->session->set_flashdata('gagal', '<div class="alert alert-danger">User dan Password salah</div>');
				redirect('login','refresh');
			}
		}

		

	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('Login');
	}

}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */