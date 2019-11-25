<?php
error_reporting(1);
defined('BASEPATH') OR exit('No direct script access allowed');

class ApiApps extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('Api_model');
		$this->load->library('bcrypt');
	}
	public function format_tanggal($date){
		$date = date_create($date);
		$dates = date_format($date, 'M j, Y');
		return $dates;
	}
	public function register(){
		$arr = array();
		$data = array(
            'username' => $this->input->post('username', true),
            'email' => $this->input->post('email', true),
			'password' => $this->input->post('password', true),
			'name' => $this->input->post('name', true)
        );
		//secure password
        $data['password'] = $this->bcrypt->hash_password($data['password']);
        $data['user_type'] = "unregistred";
        $data["slug"] = str_slug($data["username"] . "-" . uniqid());
        $data['handphone'] = $this->input->post('handphone', true);
		$data['position'] = $this->input->post('position', true);
		$data['status'] = 0;
		$data['token'] = $this->generateToken(32);
		$register = $this->Api_model->register($data);
		if($register!=false){
			$arr = array(
				'status' => '0',
				'message'=>'sukses',
				'token'=>$data['token']
			);
		}else{
			$arr = array(
				'status' => '1',
                'message'=>'gagal'
			);
		}
		echo json_encode($arr);    
	}

	public function postLogin()
	{
		error_reporting(1);
		$arr = array();
		 $email = $this->input->post('email');
		 $password = $this->input->post('password');

		 $this->form_validation->set_rules('email','Email','required');
		 $this->form_validation->set_rules('password','Password','required');
		 if($this->form_validation->run() == false)
		 {
		 	$arr = array(
		 		'status' => '1',
				 'message' => 'Please fill out this fields'
		 	);
		 }
		 else
		 {
		 	$sql = $this->Api_model->LoginCheck($email,$password);
		 	if($sql->status == '1')
		 	{
				$token = $this->generateToken(32);
				$sql = $this->Api_model->createToken($sql->id, $token); 
				$sql = $this->Api_model->LoginCheck($email,$password);
				$arr = array(
		 			'status' => '0',
                     'message'=>'sukses',
                    'data'=>Array('id' => $sql->id,
								//'token' => $this->checkToken($sql->id))
								'token'=>$sql->token)
		 		);
		 	}
		 	elseif($sql->status == '0')
		 	{
		 		$arr = array('status' => '1','message' => 'Your Access Are Blocked By Administrator.');	
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
		$id=$this->input->post('id');
		$token=$this->input->post('token');
		//$token = $_SERVER['HTTP_TOKEN'];
		//$id = $_SERVER['HTTP_USERID'];
		/*if(!isset($token) && !isset($id))
		{
			$arr = array('status' => false,'message' => 'Your Access Is Not Authorized.');
		}
		elseif($this->Api_model->checkId($token) != $id)
		{
			$arr = array('status' => false,'message' => 'Your Access Is Not Authorized.');	
		}*/
		//else{
			$sql = $this->Api_model->getProfile($id,$token);
			$sql1 = $this->Api_model->getHistory($id);
			$sql3 = $this->Api_model->getBadges();
			$avatar = $sql->row()->avatar;
			if(substr($avatar,0,4)!='http'){
				$avatar = base_url().$avatar;
			}
			$title=null;
			$img=null;
			foreach($sql3->result() as $badges){
				if($title==null && $img==null && $sql->row()->point >= $badges->min_point){
					$title=$badges->title;
					$img=$badges->img;
				}
			}
			if($sql->num_rows() > 0)
			{
				$bio[] = array(
					'username' => $sql->row()->username,
					'slug' => $sql->row()->slug,
					'name'=>$sql->row()->name,
					'email' => $sql->row()->email,
					'avatar' => $avatar,
					'about' => $sql->row()->about_me,
					'facebookUrl' => $sql->row()->facebook_url,
					'twitterUrl' => $sql->row()->twitter_url,
					'instagramUrl' => $sql->row()->instagram_url,
					'pinterestUrl' => $sql->row()->pinterest_url,
					'linkedinUrl' => $sql->row()->linkedin_url,
					'vkUrl' => $sql->row()->vk_url,
					'youtubeUrl' => $sql->row()->youtube_url,
					'point'=> $sql->row()->point,
					'badges_title'=>$title,
					'badges_img'=>base_url().$img,
					'total_view'=> $sql1->row()->total_view,
					'total_duration'=>ceil($sql1->row()->jml_detik/60)
				);
				$arr = array(
					'status' => '0',
                    'message'=> 'sukses',
                    'data' => $bio
				);
			}
			else
			{
				$arr = array('status' => '1','message' => 'Your Access Is Not Authorized.');
			}
		//}
		echo json_encode($arr);
	}
	public function activityReport(){
		$id = $total = $this->uri->segment(3);
		$arr = array();
		$sql = $this->Api_model->rank();
		foreach($sql->result() as $user){
			$avatar = $user->avatar;
			if(substr($avatar,0,4)!='http'){
				$avatar = base_url().$avatar;
			}
			$sql3 = $this->Api_model->getBadges();
			$title=null;
			$img=null;
			foreach($sql3->result() as $badges){
				if($title==null && $img==null && $user->point >= $badges->min_point){
					$title=$badges->title;
					$img=$badges->img;
				}
			}
			$data[] = array('name'=>$user->name, 'rank' => $user->myrank,'point' => $user->point, 'badges_title'=> $title, 'avatar'=>$avatar);
		}
		$sql1 = $this->Api_model->myRank($id);
		$sql2 = $this->Api_model->getHistory($id);
		foreach($sql1->result() as $me){
			$avatar = $me->avatar;
			if(substr($avatar,0,4)!='http'){
				$avatar = base_url().$avatar;
			}
		$title=null;
		$img=null;
			foreach($sql3->result() as $badges){
				if($title==null && $img==null && $me->point >= $badges->min_point){
					$title=$badges->title;
					$img=$badges->img;
				}
			}
			$myPosition[] = array('name'=>$me->name, 
			'rank' => $me->myrank,
			'point' => $me->point, 
			'badges_title'=> $title, 
			'avatar'=>$avatar, 
			'total_view'=> $sql2->row()->total_view,
			'total_duration'=>ceil($sql2->row()->jml_detik/60)
		);
		}
		$arr = array(
			'status' => true,
			'message' => 'Success Update Your Profile.',
			'data_rank' => $data,
			'my_position'=>$myPosition
		);
		echo json_encode($arr);
	}
	public function postUpdateProfile()
	{
		$arr = array();
		$data = file_get_contents('php://input'); 
		$data = json_decode($data,true);
		$token = $data['token'];
		$id = $data['id'];
		$cek = $this->Api_model->checkId($token);
		$update = array(
            'password' => $this->bcrypt->hash_password($data['password']),
			'name' => $data['name'],
			'position'=>$data['position']
        );
		if(!isset($token) && !isset($id))
		{
			$arr = array('status' => false,'message' => 'Your Access Is Not Authorizeds.');
		}
		elseif($cek->id != $id)
		{
			$arr = array('status' => false,'message' => 'Your Access Is Not Authorized.');	
		}
		else{
			$sql = $this->Api_model->getProfile($id,$token);
			if($sql->num_rows() > 0)
			{
				$updateProfile = $this->Api_model->postUpdateProfile($id,$update);
				if($updateProfile == true)
				{
					/*$sql = $this->Api_model->getProfile($id,$token);
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
					);*/
					$arr = array(
						'status' => true,
						'message' => 'Success Update Your Profile.',
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
					if($pop->category_id == '21'){
						$post_category = 'infografik';
					}elseif($pop->post_type=='video'){
						$post_category = 'video';
					}elseif($pop->post_type=='audio'){
						$post_category='podcast';
					}else{
						$post_category='artikel';
					}
					$data[] = array(
							'id' => $pop->ids,
							'title' => $pop->title,
							'slug' => $pop->title_slug,
							'summary' => $pop->summary,
							'category_id' => $pop->category_id,
							'category_title' => $pop->name,
							'total_comments' => $this->Api_model->CommentCount($pop->ids),
							'image' => $pop->image_small,
							'date' => $this->format_tanggal($pop->created_at),
							'post_category'=>$post_category
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
		elseif($type == 'recommended')
		{
			$sql = $this->Api_model->getEditorPickArticles($total);
			if($sql->num_rows() > 0){
				foreach($sql->result() as $pop)
				{
					if($pop->category_id == '21'){
						$post_category = 'infografik';
					}elseif($pop->post_type=='video'){
						$post_category = 'video';
					}elseif($pop->post_type=='audio'){
						$post_category='podcast';
					}else{
						$post_category='artikel';
					}
					$data[] = array(
							'id' => $pop->ids,
							'title' => $pop->title,
							'slug' => $pop->title_slug,
							'summary' => $pop->summary,
							'category_id' => $pop->category_id,
							'category_title' => $pop->name,
							'total_comments' => $this->Api_model->CommentCount($pop->ids),
							'image' => $pop->image_slider,
							'date' => $this->format_tanggal($pop->created_at),
							'post_category'=>$post_category
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
		elseif($type == 'editor')
		{
			$sql = $this->Api_model->getEditorPickArticles($total);
			if($sql->num_rows() > 0){
				foreach($sql->result() as $pop)
				{
					if($pop->category_id == '21'){
						$post_category = 'infografik';
					}elseif($pop->post_type=='video'){
						$post_category = 'video';
					}elseif($pop->post_type=='audio'){
						$post_category='podcast';
					}else{
						$post_category='artikel';
					}
					$data[] = array(
							'id' => $pop->ids,
							'title' => $pop->title,
							'slug' => $pop->title_slug,
							'summary' => $pop->summary,
							'category_id' => $pop->category_id,
							'category_title' => $pop->name,
							'total_comments' => $this->Api_model->CommentCount($pop->ids),
							'image' => $pop->image_slider,
							'date' => $this->format_tanggal($pop->created_at),
							'post_category'=>$post_category
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
					if($pop->category_id == '21'){
						$post_category = 'infografik';
					}elseif($pop->post_type=='video'){
						$post_category = 'video';
					}elseif($pop->post_type=='audio'){
						$post_category='podcast';
					}else{
						$post_category='artikel';
					}
					$data[] = array(
							'id' => $pop->ids,
							'title' => $pop->title,
							'slug' => $pop->title_slug,
							'summary' => $pop->summary,
							'category_id' => $pop->category_id,
							'category_title' => $pop->name,
							'total_comments' => $this->Api_model->CommentCount($pop->ids),
							'image' => $pop->image_slider,
							'date' => $this->format_tanggal($pop->created_at),
							'post_category'=>$post_category
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
	public function feedPage()
	{
		$arr = array();
		//$token = $_SERVER['HTTP_TOKEN'];
		//$id = $_SERVER['HTTP_USERID'];
		$type = $this->uri->segment(3);
		$total = $this->uri->segment(4);
		$page = $this->uri->segment(5);
		$data = array();
		if($type == 'popular')
		{
			$popular = $this->Api_model->getPagePopularArticles($total, $page);
			if($popular->num_rows() > 0){
				foreach($popular->result() as $pop)
				{
					if($pop->category_id == '21'){
						$post_category = 'infografik';
						$image = base_url().$pop->image_slider;
					}elseif($pop->post_type=='video'){
						$post_category = 'video';
						$image = $pop->image_url;
					}elseif($pop->post_type=='audio'){
						$post_category='podcast';
						$image = base_url().$pop->image_slider;
					}else{
						$post_category='artikel';
						$image = base_url().$pop->image_slider;
					}
					$data[] = array(
							'id' => $pop->ids,
							'title' => $pop->title,
							'slug' => $pop->title_slug,
							'summary' => $pop->summary,
							'category_id' => $pop->category_id,
							'category_title' => $pop->name,
							'total_comments' => $this->Api_model->CommentCount($pop->ids),
							'image' => $pop->image_slider,
							'date' => $this->format_tanggal($pop->created_at),
							'post_category'=>$post_category
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
				$arr = array('status' => true,'message' => 'No Articles Found..','total' => 0, 'articles' => $data);	
			}
		}
		elseif($type == 'recommended')
		{
			$sql = $this->Api_model->getPageEditorPickArticles($total, $page);
			if($sql->num_rows() > 0){
				foreach($sql->result() as $pop)
				{
					if($pop->category_id == '21'){
						$post_category = 'infografik';
						$image = base_url().$pop->image_slider;
					}elseif($pop->post_type=='video'){
						$post_category = 'video';
						$image = $pop->image_url;
					}elseif($pop->post_type=='audio'){
						$post_category='podcast';
						$image = base_url().$pop->image_slider;
					}else{
						$post_category='artikel';
						$image = base_url().$pop->image_slider;
					}
					$data[] = array(
							'id' => $pop->ids,
							'title' => $pop->title,
							'slug' => $pop->title_slug,
							'summary' => $pop->summary,
							'category_id' => $pop->category_id,
							'category_title' => $pop->name,
							'total_comments' => $this->Api_model->CommentCount($pop->ids),
							'image' => $image,
							'date' => $this->format_tanggal($pop->created_at),
							'post_category'=>$post_category
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
				$arr = array('status' => true,'message' => 'No Articles Found..','total' => 0, 'articles' => $data);	
			}
		}
		elseif($type == 'editor')
		{
			$sql = $this->Api_model->getPageEditorPickArticles($total, $page);
			if($sql->num_rows() > 0){
				foreach($sql->result() as $pop)
				{
					if($pop->category_id == '21'){
						$post_category = 'infografik';
						$image = base_url().$pop->image_slider;
					}elseif($pop->post_type=='video'){
						$post_category = 'video';
						$image = $pop->image_url;
					}elseif($pop->post_type=='audio'){
						$post_category='podcast';
						$image = base_url().$pop->image_slider;
					}else{
						$post_category='artikel';
						$image = base_url().$pop->image_slider;
					}
					$data[] = array(
							'id' => $pop->ids,
							'title' => $pop->title,
							'slug' => $pop->title_slug,
							'summary' => $pop->summary,
							'category_id' => $pop->category_id,
							'category_title' => $pop->name,
							'total_comments' => $this->Api_model->CommentCount($pop->ids),
							'image' => $image,
							'date' => $this->format_tanggal($pop->created_at),
							'post_category'=>$post_category
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
				$arr = array('status' => true,'message' => 'No Articles Found..','total' => 0, 'articles' => $data);	
			}
		}
		elseif($type == 'latest')
		{
			$sql = $this->Api_model->getPageArticles($total, $page);
			if($sql->num_rows() > 0){
				foreach($sql->result() as $pop)
				{
					if($pop->category_id == '21'){
						$post_category = 'infografik';
						$image = base_url().$pop->image_slider;
					}elseif($pop->post_type=='video'){
						$post_category = 'video';
						$image = $pop->image_url;
					}elseif($pop->post_type=='audio'){
						$post_category='podcast';
						$image = base_url().$pop->image_slider;
					}else{
						$post_category='artikel';
						$image = base_url().$pop->image_slider;
					}
					$data[] = array(
							'id' => $pop->ids,
							'title' => $pop->title,
							'slug' => $pop->title_slug,
							'summary' => $pop->summary,
							'category_id' => $pop->category_id,
							'category_title' => $pop->name,
							'total_comments' => $this->Api_model->CommentCount($pop->ids),
							'image' => $image,
							'date' => $this->format_tanggal($pop->created_at),
							'post_category'=>$post_category
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
				$arr = array('status' => true,'message' => 'No Articles Found..','total' => 0, 'articles' => $data);
			}
		}elseif($type == 'video'){
			$sql = $this->Api_model->getVideo($total, $page);
			if($sql->num_rows() > 0){
				foreach($sql->result() as $pop)
				{
					if($pop->category_id == '21'){
						$post_category = 'infografik';
					}elseif($pop->post_type=='video'){
						$post_category = 'video';
					}elseif($pop->post_type=='audio'){
						$post_category='podcast';
					}else{
						$post_category='artikel';
					}
					$data[] = array(
							'id' => $pop->ids,
							'title' => $pop->title,
							'slug' => $pop->title_slug,
							'summary' => $pop->summary,
							'category_id' => $pop->category_id,
							'category_title' => $pop->name,
							'total_comments' => $this->Api_model->CommentCount($pop->ids),
							'image' => $pop->image_url,
							'date' => $this->format_tanggal($pop->created_at),
							'post_category'=>$post_category
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
				$arr = array('status' => true,'message' => 'No Articles Found..','total' => 0, 'articles' => $data);
			}
		}elseif($type == 'infografik'){
			$sql = $this->Api_model->getinfografik($total, $page);
			if($sql->num_rows() > 0){
				foreach($sql->result() as $pop)
				{
					if($pop->category_id == '21'){
						$post_category = 'infografik';
					}elseif($pop->post_type=='video'){
						$post_category = 'video';
					}elseif($pop->post_type=='audio'){
						$post_category='podcast';
					}else{
						$post_category='artikel';
					}
					$data[] = array(
							'id' => $pop->ids,
							'title' => $pop->title,
							'slug' => $pop->title_slug,
							'summary' => $pop->summary,
							'category_id' => $pop->category_id,
							'category_title' => $pop->name,
							'total_comments' => $this->Api_model->CommentCount($pop->ids),
							'image' => base_url().$pop->image_slider,
							'date' => $this->format_tanggal($pop->created_at),
							'post_category'=>$post_category
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
				$arr = array('status' => true,'message' => 'No Articles Found..','total' => 0, 'articles' => $data);	
			}
		}elseif($type == 'podcast'){
			$sql = $this->Api_model->getpodcast($total, $page);
			if($sql->num_rows() > 0){
				foreach($sql->result() as $pop)
				{
					if($pop->category_id == '21'){
						$post_category = 'infografik';
					}elseif($pop->post_type=='video'){
						$post_category = 'video';
					}elseif($pop->post_type=='audio'){
						$post_category='podcast';
					}else{
						$post_category='artikel';
					}
					$data[] = array(
							'id' => $pop->ids,
							'title' => $pop->title,
							'slug' => $pop->title_slug,
							'summary' => $pop->summary,
							'category_id' => $pop->category_id,
							'category_title' => $pop->name,
							'total_comments' => $this->Api_model->CommentCount($pop->ids),
							'image' => base_url().$pop->image_slider,
							'date' => $this->format_tanggal($pop->created_at),
							'post_category'=>$post_category
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
				$arr = array('status' => true,'message' => 'No Articles Found..','total' => 0, 'articles' => $data);
			}
		}elseif($type == 'search')
		{
			$search = $this->input->post('search');
			$sql = $this->Api_model->getSearchResult($search, $total, $page);
			if($sql->num_rows() > 0){
				foreach($sql->result() as $pop)
				{
					if($pop->category_id == '21'){
						$post_category = 'infografik';
						$image = base_url().$pop->image_slider;
					}elseif($pop->post_type=='video'){
						$post_category = 'video';
						$image = $pop->image_url;
					}elseif($pop->post_type=='audio'){
						$post_category='podcast';
						$image = base_url().$pop->image_slider;
					}else{
						$post_category='artikel';
						$image = base_url().$pop->image_slider;
					}
					$data[] = array(
							'id' => $pop->ids,
							'title' => $pop->title,
							'slug' => $pop->title_slug,
							'summary' => $pop->summary,
							'category_id' => $pop->category_id,
							'category_title' => $pop->name,
							'total_comments' => $this->Api_model->CommentCount($pop->ids),
							'image' => $image,
							'date' => $this->format_tanggal($pop->created_at),
							'post_category'=>$post_category
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
				$arr = array('status' => true,'message' => 'No Articles Found..','total' => 0, 'articles' => $data);
			}
		}
		echo json_encode($arr);
	}
	public function search(){
		$arr = array();
		//$token = $_SERVER['HTTP_TOKEN'];
		//$id = $_SERVER['HTTP_USERID'];
		$searchs = trim($this->uri->segment(5), TRUE);
		$searchs = urldecode($searchs);
		$total = $this->uri->segment(3);
		$page = $this->uri->segment(4); 
		$data = array();
		$search = $this->input->post('search');
		$sql = $this->Api_model->getSearchResult($searchs, $total, $page);
		if($sql->num_rows() > 0){
			foreach($sql->result() as $pop)
			{
				if($pop->category_id == '21'){
					$post_category = 'infografik';
					$image = base_url().$pop->image_slider;
				}elseif($pop->post_type=='video'){
					$post_category = 'video';
					$image = $pop->image_url;
				}elseif($pop->post_type=='audio'){
					$post_category='podcast';
					$image = base_url().$pop->image_slider;
				}else{
					$post_category='artikel';
					$image = base_url().$pop->image_slider;
				}
				$data[] = array(
							'id' => $pop->ids,
							'title' => $pop->title,
							'slug' => $pop->title_slug,
							'summary' => $pop->summary,
							'category_id' => $pop->category_id,
							'category_title' => $pop->name,
							'total_comments' => $this->Api_model->CommentCount($pop->ids),
							'image' => $image,
							'date' => $this->format_tanggal($pop->created_at),
							'post_category'=>$post_category
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
				$arr = array('status' => true,'message' => 'No Articles Found..','total' => 0, 'articles' => $data);
			}
		echo json_encode($arr);
	}
	public function showArticle()
	{
		$arr = array();
		$id=$this->input->post('id');
		$token=$this->input->post('token');
		$postId = $this->uri->segment(3);
		//echo "data post".$id.$token;
		$favorite = $this->Api_model->isFavorite($postId, $id);
		$is_favorite = $favorite->num_rows();
		$data = $this->Api_model->checkId($token);
		if(!isset($token) && !isset($id))
		{
			$arr = array('status' => false,'message' => 'Your Access Is Not Authorized.');
		}
		elseif( $data->id!= $id)
		{
			$arr = array('status' => false,'message' => 'Your Access Is Not Authorizeds');	
		}
		else
		{
			$sql = $this->Api_model->getShowArticles($postId);
			$sql1 = $this->Api_model->getTag($postId);
			foreach($sql1->result() as $tags){
				$tag[]=array(
					'id'=>$tags->id,
					'tag'=>$tags->tag
				);
			}
			if($sql->num_rows() > 0){
				foreach($sql->result() as $pop){
					if($pop->category_id == '21'){
						$post_category = 'infografik';
						$image = base_url().$pop->image_default;
					}elseif($pop->post_type=='video'){
						$post_category = 'video';
						$image = $pop->image_url;
					}elseif($pop->post_type=='audio'){
						$post_category='podcast';
						$image = base_url().$pop->image_default;
					}else{
						$post_category='artikel';
						$image = base_url().$pop->image_default;
					}

					if($post_category=='infografik'){
						$konten = base_url().$pop->image_default;
					}else{
						$konten = $pop->content;
					}
					$data = array(
						'id' => $postId,
									'title' => $pop->title,
									'slug' => $pop->title_slug,
									'summary' => $pop->summary,
									'category_id' => $pop->category_id,
									'category_title' => $pop->name,
									'subcategory_id' => $pop->subcategory_id,
									'subcategory_title' => $this->Api_model->getSubcategory($pop->category_id)->name,
									'total_comments' => $this->Api_model->CommentCount($pop->id),
									'image' => $image,
									'content' => $konten,
									'video_embed'=>$pop->video_embed_code,
									'date' => $this->format_tanggal($pop->created_at),
									'post_type'=>$post_category,
									'is_favorite'=>$is_favorite,
									'tag'=>$tag
					);
				}
				$arr = array(
						'status' => "0",
						'message' => "sukses",
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
	
	public function logout()
	{
		$arr = array();
		//$token = $_SERVER['HTTP_TOKEN'];
		//$id = $_SERVER['HTTP_USERID'];
		$token = $this->input->post('token');
		$id = $this->input->post('id');
		$postId = $this->uri->segment(3);
		if(!isset($token) && !isset($id))
		{
			$arr = array('status' => 1,'message' => 'Your Access Is Not Authorized.');
		}
		elseif($this->Api_model->checkId($token) == $id)
		{
			$arr = array('status' => 1,'message' => 'Your Access Is Not Authorized.');	
		}
		else
		{
			$sql = $this->Api_model->logout($id);
			if($sql == true)
			{
				$arr = array('status' => 0,'message' => 'Berhasil Logout..');
			}
			else{
				$arr = array('status' => 1,'message' => 'Tidak Berhasil Logout..');
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
	public function masterData($code){
		$arr = array('data'=>'saya');
		$id=$this->input->post('id');
		$token=$this->input->post('token');
		$code = $this->uri->segment(3);
		//echo "data post".$id.$token;
		$data = $this->Api_model->checkId($token);
		if(!isset($token) && !isset($id))
		{
			$arr = array('status' => false,'message' => 'Your Access Is Not Authorized.');
		}
		elseif( $data->id!= $id)
		{
			$arr = array('status' => false,'message' => 'Your Access Is Not Authorizeds');	
		}
		else
		{
			if($code=='negara'){
			$sql = $this->Api_model->getCountry();
			if($sql->num_rows() > 0){
				foreach($sql->result() as $country){
					$datas[] = array(
						'country_code'=>$country->country_code,
						'country_name'=>$country->country_name,
						'country_code_number'=>$country->country_code_number
					);
				}
				$arr = array(
						'status' => "0",
						'message' => "sukses",
						'total' => $sql->num_rows(),
						'data' => $datas
				);
			}
			else
			{
				$arr = array('status' => true,'message' => 'No Country Found..','count' => '0');
			}
		}elseif($code=='department'){
			$sql = $this->Api_model->getCategory();
			if($sql->num_rows() > 0){
				foreach($sql->result() as $department){
					$datas[] = array(
						'id'=>$department->id,
						'name'=>$department->name
					);
				}
				$arr = array(
						'status' => "0",
						'message' => "sukses",
						'total' => $sql->num_rows(),
						'data' => $datas
				);
			}
			else
			{
				$arr = array('status' => true,'message' => 'No Department Found..','count' => '0');
			}
		}elseif($code=='kategori'){
			$id = $this->uri->segment(4);
			$sql = $this->Api_model->getCategory();
			if($sql->num_rows() > 0){
				foreach($sql->result() as $category){
					$dsubcategory = array();
					$sql1 = $this->Api_model->getSubcategory($category->id);
					foreach($sql1->result() as $subcategory){
						$dsubcategory[]=array(
							'id'=>$subcategory->id,
							'name'=>$subcategory->name,
							'icon'=>base_url().'uploads/icon/preference/'.$subcategory->icon
						);
					}

					$datas[] = array(
						'id'=>$category->id,
						'name'=>$category->name,
						'subcategory'=>$dsubcategory
					);
				}
				$arr = array(
						'status' => "0",
						'message' => "sukses",
						'total' => $sql->num_rows(),
						'data' => $datas
				);
			}
			else
			{
				$arr = array('status' => true,'message' => 'No Category Found..','count' => '0');
			}

		}elseif($code=='position'){
			$sql = $this->Api_model->getPosition();
			if($sql->num_rows() > 0){
				foreach($sql->result() as $department){
					$datas[] = array(
						'id'=>$department->id,
						'name'=>$department->name
					);
				}
				$arr = array(
						'status' => "0",
						'message' => "sukses",
						'total' => $sql->num_rows(),
						'data' => $datas
				);
			}
			else
			{
				$arr = array('status' => true,'message' => 'No Department Found..','count' => '0');
			}
		}
		} //$arr = array('data'=>'saya');
		
		echo json_encode($arr);
	}
	public function favorit(){
		$id_article = $this->uri->segment(3);
		$id_user = $this->uri->segment(4);
		$sql = $this->Api_model->isFavorite($id_article, $id_user);
		$total=$sql->num_rows();
		if($total == 0){
			$sql1 = $this->Api_model->addFavorite($id_article, $id_user);
			if($sql1){
			$message="favorite success";
			$is_favorite = 1;
		}else
			$message="favorite Failed";	
		}else{
			$sql1=$this->Api_model->delFavorite($id_article, $id_user);
			if($sql1){
				$is_favorite=0;
				$message="unfavorite success";
			}
			else
			$message="unfavorite Failed";
		}
		$arr = array(
			'status' => "0",
			'message' => $message,
			'data'=>array('is_favorite'=>$is_favorite)
	);
	echo json_encode($arr);
	}
	public function preference(){
		$id_category = $this->uri->segment(3);
		$id_user = $this->uri->segment(4);
		if($id_category==0){
			$data = file_get_contents('php://input'); 
			$data = json_decode($data,true);
			for($i=0;$i<count($data);$i++){
				$sql1 = $this->Api_model->addPreference($data[$i]['sub_category_id'], $id_user);
				if($sql1){
					$message="Preference success";
					$is_preference = 1;
				}
		}
	}else{
		$sql = $this->Api_model->isPreference($id_category, $id_user);
		$total=$sql->num_rows();
		if($total == 0){
			$sql1 = $this->Api_model->addPreference($id_category, $id_user);
			if($sql1){
			$message="Preference success";
			$is_preference = 1;
		}else
			$message="Preference Failed";	
		}else{
			$sql1=$this->Api_model->delPreference($id_category, $id_user);
			if($sql1){
				$is_preference=0;
				$message="unpreference success";
			}
			else
			$message="unpreference Failed";
		}
	}
		$arr = array(
			'status' => "0",
			'message' => $message,
			'data'=>array('is_preference'=>$is_preference)
	);
	echo json_encode($arr);
	}

	public function listFavorite(){
		$arr = array();
		//$token = $_SERVER['HTTP_TOKEN'];
		//$id = $_SERVER['HTTP_USERID'];
		$user = $this->uri->segment(3);
		$total = $this->uri->segment(4);
		$page = $this->uri->segment(5);
			$popular = $this->Api_model->getPageFavorite($total, $page, $user);
			if($popular->num_rows() > 0){
				foreach($popular->result() as $pop)
				{
					if($pop->category_id == '21'){
						$post_category = 'infografik';
						$image = base_url().$pop->image_slider;
					}elseif($pop->post_type=='video'){
						$post_category = 'video';
						$image = $pop->image_url;
					}elseif($pop->post_type=='audio'){
						$post_category='podcast';
						$image = base_url().$pop->image_slider;
					}else{
						$post_category='artikel';
						$image = base_url().$pop->image_slider;
					}
					$data[] = array(
							'id' => $pop->ids,
							'title' => $pop->title,
							'slug' => $pop->title_slug,
							'summary' => $pop->summary,
							'category_id' => $pop->category_id,
							'category_title' => $pop->name,
							'total_comments' => $this->Api_model->CommentCount($pop->ids),
							'image' => $image,
							'date' => $this->format_tanggal($pop->created_at),
							'post_category'=>$post_category
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
		echo json_encode($arr);
	}

	public function topLearner(){
		
		$data['top_learners'] = $this->auth_model->get_top_learner(3)->result();
	}
}
