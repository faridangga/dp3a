<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posts extends CI_Controller {

	var $cname = "Admin/Posts";

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->model(['Posts_model','Kategori_Post_model','Admins_model']);
	}

	public function index()
	{
		$data = [
			'title' => "Posts",
			'cname' => $this->cname,
			'pages' => "admin/posts/index",
			'data' => array(),
		];
		$data['data']['select_kategori_post'] = $this->Kategori_Post_model->get_data_status();
		$data['data']['select_admins'] = $this->Admins_model->get_data();
		$this->load->view('layouts/dashboard',$data);
	}

	public function get_data()
	{
		$data['data'] = $this->Posts_model->get_data();
		echo json_encode($data);
	}

	public function get_data_by_id()
	{
		$id = $this->input->post('id');
		$data = $this->Posts_model->get_data_by_id($id);
		echo json_encode($data);
	}

	public function insert()
	{

		$config['upload_path']          = './uploads/images/artikel';
		$config['allowed_types']        = 'gif|jpg|png';
		$config['max_size']             = 10000;
		$config['max_width']            = 102400;
		$config['max_height']           = 76800;

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('image_url')){
			$error = array('error' => $this->upload->display_errors());
			// redirect('Admin/Posts/index','refresh');
			echo json_encode($error);
		}
		else{
			$id = $this->input->post('id');

			$artikel = array('upload_data' => $this->upload->data('file_name'));
			$data = [
				'title' => $this->input->post('title'),
				'content' => $this->input->post('content'),
				'category_id' => $this->input->post('category_id'),
				'hit' => $this->input->post('hit'),
				'post_type' => $this->input->post('post_type'),
				'image_url' => 'uploads/images/artikel/'.$artikel['upload_data'],
				'video_embed_code' => $this->input->post('video_embed_code'),
				'user_id' => $this->input->post('user_id'),
				'created_at' => date("Y-m-d H:i:s"),
				'status' => $this->input->post('status'),
				'is_slider' => $this->input->post('is_slider'),
			];
				// $insert = $this->Posts_model->insert($data);

			if ($id == "") {
				$insert = $this->Posts_model->insert($data);
				if($insert){
					$ret = [
						'title' => "Insert",
						'text' => "Insert success",
						'icon' => "success",
					];
				}else{
					$ret = [
						'title' => "Insert",
						'text' => "Insert failed",
						'icon' => "warning",
					];
				}   
			}else {
				$update = $this->Posts_model->update($id, $data);
				if($update){
					$ret = [
						'title' => "Update",
						'text' => "Update success",
						'icon' => "success",
					];
				}else{
					$ret = [
						'title' => "Update",
						'text' => "Update failed",
						'icon' => "warning",
					];
				}
			}
		}

		echo json_encode($ret);
		
		// echo json_encode($insert);
	}

	public function delete_posts()
	{
		$id = $this->input->post('id');

		$delete = $this->Posts_model->delete($id);
		if($delete){
			$ret = [
				'text' => "Delete success",
				'title' => "Delete",
				'icon' => "success",
			];
		}else{
			$ret = [
				'text' => "Delete failed",
				'title' => "Delete",
				'icon' => "warning",
			];
		}
		echo json_encode($ret);
	}

	public function update_is_slider()
	{
		$id = $this->input->post('id');
		$update = $this->Posts_model->update_is_slider($id);
		if($update){
			$ret = [
				'text' => "Update success",
				'title' => "Update",
				'icon' => "success",
			];
		}else{
			$ret = [
				'text' => "Update failed",
				'title' => "Update",
				'icon' => "warning",
			];
		}
		echo json_encode($ret);
	}

}

/* End of file Post.php */
/* Location: ./application/controllers/Admin/Post.php */