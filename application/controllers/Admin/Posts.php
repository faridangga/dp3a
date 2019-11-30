<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posts extends CI_Controller {

	var $cname = "Admin/Posts";

	public function __construct()
	{
		parent::__construct();
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
		$data['data']['select_kategori_post'] = $this->Kategori_Post_model->get_data();
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
		$id = $this->input->post('id');
		$data = [
			'title' => $this->input->post('title'),
			'content' => $this->input->post('content'),
			'category_id' => $this->input->post('category_id'),
			'image_content' => $this->input->post('image_content'),
			'hit' => $this->input->post('hit'),
			'is_slider' => $this->input->post('is_slider'),
			'is_recommended' => $this->input->post('is_recommended'),
			'visibility' => $this->input->post('visibility'),
			'post_type' => $this->input->post('post_type'),
			'image_url' => $this->input->post('image_url'),
			'video_embed_code' => $this->input->post('video_embed_code'),
			'user_id' => $this->input->post('user_id'),
			'created_at' => $this->input->post('created_at'),
			'status' => $this->input->post('status'),
		];

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
		echo json_encode($ret);
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

}

/* End of file Post.php */
/* Location: ./application/controllers/Admin/Post.php */