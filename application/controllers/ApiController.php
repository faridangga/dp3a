<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApiController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('Api_model');
		$this->load->library('bcrypt');
	}
	public function postLogin()
	{
		error_reporting(0);
		$arr = array();
		 $email = $this->input->post('email');
		 $password = $this->input->post('password');

		 $this->form_validation->set_rules('email','Email','required');
		 $this->form_validation->set_rules('password','Password','required');
		 if($this->form_validation->run() == false)
		 {
		 	$arr = array(
		 		'status' => false,
		 		'message' => 'Please fill out this fields'
		 	);
		 }
		 else
		 {
		 	$sql = $this->Api_model->LoginCheck($email,$password);
		 	if($sql->status == '1')
		 	{
		 		$arr = array(
		 			'status' => true,
		 			'id' => $sql->id,
		 			'token' => $this->checkToken($sql->id)
		 		);
		 	}
		 	elseif($sql->status == '0')
		 	{
		 		$arr = array('status' => false,'message' => 'Your Access Are Blocked By Administrator.');	
		 	}
		 	else
		 	{
		 		$arr = array('status' => false,'message' => 'User Credential Are Not Valid.');
		 	}
		 }
		 echo json_encode($arr);
	}
	private function checkToken($id)
	{
		//$token = bin2hex(random_bytes(32));
		$token = $this->generateToken(32);
		$sql = $this->Api_model->checkToken($id);
		if($sql->row()->token == '' || $sql->row()->token == null)
		{
			$create = $this->Api_model->createToken($id,$token);
			if($create == true)
			{
				$res = $token;
			}
		}
		else{
			$res = $sql->row()->token;
		}
		return $res;
	}
	public function getProfile()
	{
		$arr = array();
		$token = $_SERVER['HTTP_TOKEN'];
		$id = $_SERVER['HTTP_USERID'];
		if(!isset($token) && !isset($id))
		{
			$arr = array('status' => false,'message' => 'Your Access Is Not Authorized.');
		}
		elseif($this->Api_model->checkId($token) != $id)
		{
			$arr = array('status' => false,'message' => 'Your Access Is Not Authorized.');	
		}
		else{
			$sql = $this->Api_model->getProfile($id,$token);
			if($sql->num_rows() > 0)
			{
				$bio[] = array(
					'username' => $sql->row()->username,
					'slug' => $sql->row()->slug,
					'email' => $sql->row()->email,
					'avatar' => $sql->row()->avatar,
					'about' => $sql->row()->about_me,
					'facebookUrl' => $sql->row()->facebook_url,
					'twitterUrl' => $sql->row()->twitter_url,
					'instagramUrl' => $sql->row()->instagram_url,
					'pinterestUrl' => $sql->row()->pinterest_url,
					'linkedinUrl' => $sql->row()->linkedin_url,
					'vkUrl' => $sql->row()->vk_url,
					'youtubeUrl' => $sql->row()->youtube_url
				);
				$arr = array(
					'status' => true,
					'profile' => $bio
				);
			}
			else
			{
				$arr = array('status' => false,'message' => 'Your Access Is Not Authorized.');
			}
		}
		echo json_encode($arr);
	}
	public function postUpdateProfile()
	{
		$arr = array();
		$token = $_SERVER['HTTP_TOKEN'];
		$id = $_SERVER['HTTP_USERID'];
		if(!isset($token) && !isset($id))
		{
			$arr = array('status' => false,'message' => 'Your Access Is Not Authorized.');
		}
		elseif($this->Api_model->checkId($token) != $id)
		{
			$arr = array('status' => false,'message' => 'Your Access Is Not Authorized.');	
		}
		else{
			$sql = $this->Api_model->getProfile($id,$token);
			if($sql->num_rows() > 0)
			{
				$update = array(
					'username' => $this->input->post('username'),
					'slug' => $this->input->post('slug'),
					'email' => $this->input->post('email'),
					'avatar' => $this->input->post('avatar'),
					'about_me' => $this->input->post('about_me'),
					'facebook_url' => $this->input->post('facebook_url'),
					'twitter_url' => $this->input->post('twitter_url'),
					'instagram_url' => $this->input->post('instagram_url'),
					'google_url' => $this->input->post('google_url'),
					'pinterest_url' => $this->input->post('pinterest_url'),
					'linkedin_url' => $this->input->post('linkedin_url'),
					'vk_url' => $this->input->post('vk_url'),
					'youtube_url' => $this->input->post('youtube_url')
				);
				$updateProfile = $this->Api_model->postUpdateProfile($id,$update);
				if($updateProfile == true)
				{
					$sql = $this->Api_model->getProfile($id,$token);
					$bio[] = array(
						'username' => $sql->row()->username,
						'slug' => $sql->row()->slug,
						'email' => $sql->row()->email,
						'avatar' => $sql->row()->avatar,
						'about' => $sql->row()->about_me,
						'facebookUrl' => $sql->row()->facebook_url,
						'twitterUrl' => $sql->row()->twitter_url,
						'instagramUrl' => $sql->row()->instagram_url,
						'pinterestUrl' => $sql->row()->pinterest_url,
						'linkedinUrl' => $sql->row()->linkedin_url,
						'vkUrl' => $sql->row()->vk_url,
						'youtubeUrl' => $sql->row()->youtube_url
					);
					$arr = array(
						'status' => true,
						'message' => 'Success Update Your Profile.',
						'profile' => $bio
					);
				}
				else
				{
					$arr = array('status' => false,'message' => 'Update Your Profile Was Failed.');		
				}
			}
			else
			{
				$arr = array('status' => false,'message' => 'Profile Data Not Found..');
			}
		}
		echo json_encode($arr);
	}
	public function subscribersList()
	{
		$arr = array();
		$token = $_SERVER['HTTP_TOKEN'];
		$id = $_SERVER['HTTP_USERID'];
		$postId = $this->input->post('post_id');
		if(!isset($token) && !isset($id))
		{
			$arr = array('status' => false,'message' => 'Your Access Is Not Authorized.');
		}
		elseif($this->Api_model->checkId($token) != $id)
		{
			$arr = array('status' => false,'message' => 'Your Access Is Not Authorized.');	
		}
		else
		{
			$sql = $this->Api_model->subscribers($postId);
			if($sql->num_rows() > 0){
				$data = array();
				foreach($sql->result() as $user)
				{
					$data[] = array('id' => $user->user_id,'user_name' => $user->username);
				}
				$arr = array(
					'status' => true,
					'count' => $sql->num_rows(),
					'post_title' => $sql->row()->title,
					'users' => $data
				);
			}
			else
			{
				$arr = array('status' => true,'message' => 'No Articles Found..','count' => '0');
			}
		}
		echo json_encode($arr);
	}
	public function feed()
	{
		$arr = array();
		//$token = $_SERVER['HTTP_TOKEN'];
		//$id = $_SERVER['HTTP_USERID'];
		$type = $this->uri->segment(3);
		$total = $this->uri->segment(4);
		if($type == 'popular')
		{
			$popular = $this->Api_model->getPopularArticles($total);
			if($popular->num_rows() > 0){
				foreach($popular->result() as $pop)
				{
					$data[] = array(
							'id' => $pop->id,
							'title' => $pop->title,
							'slug' => $pop->title_slug,
							'summary' => $pop->summary,
							'category_id' => $pop->category_id,
							'category_title' => $pop->name,
							'total_comments' => $this->Api_model->CommentCount($pop->id),
							'image' => $pop->image_small,
							'date' => $pop->created_at
							);
				}
				$arr = array(
					'status' => true,
					'total' => $popular->num_rows(),
					'articles' => $data
				);
			}
			else
			{
				$arr = array('status' => true,'message' => 'No Articles Found..','count' => '0');	
			}
		}
		elseif($type == 'editorPick')
		{
			$sql = $this->Api_model->getEditorPickArticles($total);
			if($sql->num_rows() > 0){
				foreach($sql->result() as $pop)
				{
					$data[] = array(
							'id' => $pop->id,
							'title' => $pop->title,
							'slug' => $pop->title_slug,
							'summary' => $pop->summary,
							'category_id' => $pop->category_id,
							'category_title' => $pop->name,
							'total_comments' => $this->Api_model->CommentCount($pop->id),
							'image' => $pop->image_small,
							'date' => $pop->created_at
							);
				}
				$arr = array(
					'status' => true,
					'total' => $sql->num_rows(),
					'articles' => $data
				);
			}
			else
			{
				$arr = array('status' => true,'message' => 'No Articles Found..','count' => '0');	
			}
		}
		elseif($type == 'latest')
		{
			$sql = $this->Api_model->getArticles($total);
			if($sql->num_rows() > 0){
				foreach($sql->result() as $pop)
				{
					$data[] = array(
							'id' => $pop->id,
							'title' => $pop->title,
							'slug' => $pop->title_slug,
							'summary' => $pop->summary,
							'category_id' => $pop->category_id,
							'category_title' => $pop->name,
							'total_comments' => $this->Api_model->CommentCount($pop->id),
							'image' => $pop->image_small,
							'date' => $pop->created_at
							);
				}
				$arr = array(
					'status' => true,
					'total' => $sql->num_rows(),
					'articles' => $data
				);
			}
			else
			{
				$arr = array('status' => true,'message' => 'No Articles Found..','count' => '0');	
			}
		}
		echo json_encode($arr);
	}
	public function showArticle()
	{
		$arr = array();
		$token = $_SERVER['HTTP_TOKEN'];
		$id = $_SERVER['HTTP_USERID'];
		$postId = $this->uri->segment(3);
		if(!isset($token) && !isset($id))
		{
			$arr = array('status' => false,'message' => 'Your Access Is Not Authorized.');
		}
		elseif($this->Api_model->checkId($token) != $id)
		{
			$arr = array('status' => false,'message' => 'Your Access Is Not Authorized.');	
		}
		else
		{
			$sql = $this->Api_model->getShowArticles($postId);
			if($sql->num_rows() > 0){
				foreach($sql->result() as $pop){
					$data = array(
						'id' => $pop->id,
									'title' => $pop->title,
									'slug' => $pop->title_slug,
									'summary' => $pop->summary,
									'category_id' => $pop->category_id,
									'category_title' => $pop->name,
									'subcategory_id' => $pop->subcategory_id,
									'subcategory_title' => $this->Api_model->getSubcategory($pop->category_id)->name,
									'total_comments' => $this->Api_model->CommentCount($pop->id),
									'image' => $pop->image_default,
									'content' => $pop->content,
									'date' => $pop->created_at
					);
				}
				$arr = array(
						'status' => true,
						'total' => $sql->num_rows(),
						'articles' => $data
				);
			}
			else
			{
				$arr = array('status' => true,'message' => 'No Articles Found..','count' => '0');
			}
		}
		echo json_encode($arr);
	}
	public function articleComments()
	{
		$arr = array();
		$token = $_SERVER['HTTP_TOKEN'];
		$id = $_SERVER['HTTP_USERID'];
		$postId = $this->uri->segment(3);
		if(!isset($token) && !isset($id))
		{
			$arr = array('status' => false,'message' => 'Your Access Is Not Authorized.');
		}
		elseif($this->Api_model->checkId($token) != $id)
		{
			$arr = array('status' => false,'message' => 'Your Access Is Not Authorized.');	
		}
		else
		{
			$sql = $this->Api_model->getArticleComments($postId);
			if($sql->num_rows() > 0){
				foreach($sql->result() as $pop){
					$sql_comment = $this->Api_model->getComments($pop->id);
					foreach($sql_comment->result() as $sc){
						$comments[] = array(
							'id' => $sc->id,
										'username' => $sc->username,
										'comment' => $sc->comment,
										'likes_total' => $this->Api_model->getLikesComment($sc->id),
										'date' => $sc->date,
						);
					}
					$data = array(
						'id' => $pop->id,
									'username' => $pop->username,
									'comment' => $pop->comment,
									'likes_total' => $this->Api_model->getLikesComment($pop->id),
									'date' => $pop->created_at,
									'comments' => $comments
					);
				}
				$arr = array(
						'status' => true,
						'total' => $sql->num_rows(),
						'comments' => $data
				);
			}
			else
			{
				$arr = array('status' => true,'message' => 'No Article Comments Found..','count' => '0');
			}
		}
		echo json_encode($arr);
	}
	public function logout()
	{
		$arr = array();
		$token = $_SERVER['HTTP_TOKEN'];
		$id = $_SERVER['HTTP_USERID'];
		$postId = $this->uri->segment(3);
		if(!isset($token) && !isset($id))
		{
			$arr = array('status' => false,'message' => 'Your Access Is Not Authorized.');
		}
		elseif($this->Api_model->checkId($token) == $id)
		{
			$arr = array('status' => false,'message' => 'Your Access Is Not Authorized.');	
		}
		else
		{
			$sql = $this->Api_model->logout($id);
			if($sql == true)
			{
				$arr = array('status' => true,'message' => 'Berhasil Logout..');
			}
			else{
				$arr = array('status' => false,'message' => 'Tidak Berhasil Logout..');
			}
		}
		echo json_encode($arr);
	}
	private function generateToken($num)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $num; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}
}
