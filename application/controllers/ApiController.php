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
	public function registrasi()
	{
		$arr = array();
		$data = array(
            'password' => $this->input->post('password', true),
			'nama' => $this->input->post('nama', true),
			'nomor_telp' => $this->input->post('nomor_telp', true),
			'alamat' => $this->input->post('alamat', true),
			'tanggal_lahir' => $this->input->post('tanggal_lahir', true),
			'lat' => $this->input->post('lat', true),
			'long' => $this->input->post('long', true)		
        );
		//secure password
        $data['password'] = md5($data['password']);
        $data['status'] = 1;
		//$data['token'] = $this->generateToken(32);
		$cekNomor = $this->cekNomor($data['nomor_telp']);
		if($cekNomor==true){
		$register = $this->Api_model->register($data);
		if($register!=false){
			$arr = array(
				'status' => '0',
				'message'=>'sukses'
			);
		}else{
			$arr = array(
				'status' => '1',
                'message'=>'gagal'
			);
		}
	}else{
		$arr = array(
			'status' => '1',
			'message'=>'nomor telp sudah digunakan'
		);
	}
		echo json_encode($arr);
		
	}
	private function cekNomor($nomer){
		$data = $this->Api_model->cekNomor($nomer);
		if($data->row()->id>0){
			$res = true;
		}else{
			$res = false;
		}
		return $res;

	}
	public function login()
	{
		error_reporting(1);
		$arr = array();
		 $nomor = $this->input->post('nomor_telp');
		 $password = $this->input->post('password');

		  	$sql = $this->Api_model->LoginCheck($nomor,$password);
		 	if($sql->status == '1')
		 	{
				$arr = array(
		 			'status' => '0',
                    'message'=>'sukses',
					'data'=>Array('id' => $sql->id_user
					)
		 		);
		 	}
		 	elseif($sql->status == '0')
		 	{
		 		$arr = array('status' => '1','message' => 'Akun Anda Tidak Aktif');	
		 	}
		 	else
		 	{
		 		$arr = array('status' => '1','message' => 'Kombinasi nomor telepon dan password tidak sesuai');
		 	}
		 
		 echo json_encode($arr);
	}
	public function getProfile()
	{
		
	}
	public function UpdateProfile()
	{
		
	}
	public function history()
	{

	}
	public function postPengaduan(){

	}
	public function feed()
	{
		$arr = array();
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
