<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->model('Login_model');
		$data = [
			'title' => "Dashboard",
			'data' => array(),
		];

		$this->form_validation->set_rules('nama',"nama","trim|required|callback_authentication");
		$this->form_validation->set_rules('password',"Password","trim|required");
		$this->form_validation->set_message('required',"{field} harus diisi");
		$this->form_validation->set_error_delimiters('','');

		if($this->form_validation->run() == false){
			$this->load->view('layouts/login',$data);
		}else{
			if ($this->session->userdata('logged_in')['level'] == '1') {
				redirect('Admin/Home');
			}else{
				redirect('Home','refresh');
			}
		}

		if ($this->form_validation->run() == false) {
			$this->load->view('login');
		}else{
			if ($this->session->userdata('logged_in')['level'] == '1') {
				redirect('Admin/Home');
			}else{
				redirect('Home','refresh');
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