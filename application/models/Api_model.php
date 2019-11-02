<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Api_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
		$this->load->model('Auth_model');
		$this->load->library('bcrypt');
	}
	public function LoginCheck($nomor,$password)
	{
		$this->db->where('nomor_telp', $nomor);
        $this->db->where('password', md5($password));
        $query = $this->db->get('users');
        return $query->row();
		
	}
	public function register($data){
		if ($this->db->insert('users', $data)) {
            $last_id = $this->db->insert_id();
            return $this->get_user($last_id);
        } else {
            return false;
        }
	}
	public function get_user($id)
    {
        $this->db->where('id_user', $id);
        $query = $this->db->get('users');
        return $query;
	}
	public function cekNomor($nomor)
	{
		$sql = $this->db->select("*")
							->from("users")
							->where("nomor_telp",$nomor)
							->where("status",1)
							->get();
		return $sql;
	}
	public function checkToken($id)
	{
		$sql = $this->db->select("*")
							->from("users")
							->where("id",$id)
							->get();
		return $sql;
	}
	public function updateUser($id,$data)
	{
		$sql = $this->db->where($id)
							->update('users',$data);
		if($sql)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function createToken($id,$token)
	{
		$data = array('token' => $token);
		$sql = $this->db->where('id',$id)
							->update('users',$data);
		if($sql)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function checkId($token)
	{
		$sql = $this->db->select("*")
						->from("users")
						->where('token',$token)
						->get();
		return $sql->row();
	}
	public function getProfile($id,$token)
	{
		$sql = $this->db->select("*")
						->from("users")
						->where("id",$id)
						->where("token",$token)
						->get();
		return $sql;
	}
	public function getBadges(){
		$sql = $this->db->select("*")
						->from("badges")
						->order_by("min_point","DESC")
						->get();
		return $sql;
	}
	public function getHistory($id){
		$sql = $this->db->select("COUNT(post_id) AS total_view, SUM(user_reading_time) AS jml_detik")
						->from("user_reading_history")
						->where("user_id",$id)
						->get();
		return $sql;
	}
	public function postUpdateProfile($id,$update)
	{
		$sql = $this->db->where('id',$id)
			->update('users',$update);
		if($sql)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function subscribers($id)
	{
		$sql = $this->db->select("*")
						->from("reading_lists")
						->join("users","reading_lists.user_id = users.id")
						->join("posts","reading_lists.post_id = posts.id")
						->where("reading_lists.post_id",$id)
						->get();
		return $sql;
	}
	public function getPopularArticles($count)
	{
		$sql = $this->db->select("*, posts.id AS ids")
						->from("posts")
						->join('categories','posts.category_id = categories.id')
						->where('posts.hit <=1000')
						->order_by('hit','DESC')
						->limit($count)
						->get();
		return $sql;
	}
	//Recommended
	public function getEditorPickArticles($count)
	{
		//$start = ($page-1)*6;
		$sql = $this->db->select("*, posts.id AS ids")
						->from("posts")
						->join('categories','posts.category_id = categories.id')
						->order_by('posts.created_at', 'DESC')
						->where('posts.lang_id','2')
						->where('posts.is_recommended',1)
						->limit($count)
						->get();
		return $sql;
	}
	//latest post
	public function getArticles($count)
	{
		$sql = $this->db->select("*, posts.id AS ids")
						->from("posts")
						->join('categories','posts.category_id = categories.id')
						->order_by('posts.id','desc')
						->limit($count)
						->get();
		return $sql;
	}
	public function getTag($id)
	{
		$sql = $this->db->select("*")
						->from("tags")
						->order_by('tag','asc')
						->where('post_id', $id)
						->get();
		return $sql;
	}
	//latest post
	public function getVideo($count, $page)
	{
		$start = ($page-1)*$count;
		$sql = $this->db->select("*, posts.id AS ids")
						->from("posts")
						->join('categories','posts.category_id = categories.id')
						->order_by('posts.id','desc')
						->where('post_type','video')
						->limit($count, $start)
						->get();
		return $sql;
	}
	public function getPodcast($count, $page)
	{
		$start = ($page-1)*$count;
		$sql = $this->db->select("*, posts.id AS ids")
						->from("posts")
						->join('categories','posts.category_id = categories.id')
						->order_by('posts.id','desc')
						->where('post_type','audio')
						->limit($count, $start)
						->get();
		return $sql;
	}
	public function getInfografik($count, $page)
	{
		$start = ($page-1)*$count;
		$sql = $this->db->select("*, posts.id AS ids")
						->from("posts")
						->join('categories','posts.category_id = categories.id')
						->order_by('posts.id','desc')
						->where('category_id','21')
						->limit($count, $start)
						->get();
		return $sql;
	}
	public function getPagePopularArticles($count, $page)
	{
		$start = ($page-1)*$count;
		$sql = $this->db->select("*, posts.id AS ids")
						->from("posts")
						->join('categories','posts.category_id = categories.id')
						->where('posts.hit <=1000')
						->order_by('hit','DESC')
						->limit($count, $start)
						->get();
		return $sql;
	}
	//Recommended
	public function getPageEditorPickArticles($count, $page)
	{
		$start = ($page-1)*6;
		$sql = $this->db->select("*, posts.id AS ids")
						->from("posts")
						->join('categories','posts.category_id = categories.id')
						->order_by('posts.created_at', 'DESC')
						->where('posts.lang_id','2')
						->where('posts.is_recommended',1)
						->limit($count, $start)
						->get();
		return $sql;
	}
	//latest post
	public function getPageArticles($count, $page)
	{
		$start = ($page-1)*$count;
		$sql = $this->db->select("*, posts.id AS ids")
						->from("posts")
						->join('categories','posts.category_id = categories.id')
						->order_by('posts.id','desc')
						->limit($count, $start)
						->get();
		return $sql;
	}
	public function getPageFavorite($count, $page, $user)
	{
		$start = ($page-1)*$count;
		$sql = $this->db->select("*, posts.id AS ids")
						->from("posts")
						->join('categories','posts.category_id = categories.id')
						->join('favorite','posts.id = favorite.id_post')
						->where('favorite.id_user', $user)
						->order_by('posts.id','desc')
						//->limit($count, $start)
						->get();
		return $sql;
	}
	public function getSearchResult($search, $count, $page)
	{
		$start = ($page-1)*$count;
		$this->set_filter_query();
		$this->db->select("posts.id AS ids");
		$this->db->from("posts");
		$this->db->order_by('posts.id','desc');
		$this->db->group_start();
		$this->db->like('posts.title', $search);
		$this->db->or_like('posts.content', $search);
		$this->db->or_like('posts.summary', $search);
		$this->db->group_end();
		$this->db->limit($count, $start);
		$sql = $this->db->get();
		return $sql;
	}
	
	public function getShowArticles($id)
	{
		$sql = $this->db->select("*")
						->from("posts")
						->join('categories','posts.category_id = categories.id')
						->where('posts.id',$id)
						->get();
		return $sql;
	}
	public function getCategory()
	{
		$sql = $this->db->select("*")
						->from("categories")
						->where("parent_id",0)
						->get();
		return $sql;
	}
	public function getSubcategory($id)
	{
		$sql = $this->db->select("*")
						->from("categories")
						->where("parent_id",$id)
						->get();
		return $sql;
	}
	public function getPosition()
	{
		$sql = $this->db->select("*")
						->from("position")
						->where("status",1)
						->get();
		return $sql;
	}
	public function getArticleComments($id)
	{
		$sql = $this->db->select("*")
						->from("comments")
						->join('users','comments.user_id = users.id')
						->where('comments.post_id',$id)
						->where('parent_id',null)
						->get();
		return $sql;
	}
	public function getComments($id)
	{
		$sql = $this->db->select("comments.id as id,
				users.id as users_id,
				comments.user_id as userId,
				comments.parent_id as parentId,
				comments.comment,
				comments.created_at as date,
				users.username as username")
						->from("comments")
						->join('users','comments.user_id = users.id')
						->where('comments.parent_id',$id)
						->get();
		return $sql;
	}
	public function getLikesComment($id)
	{
		$sql = $this->db->select("*")
						->from("comment_likes")
						->where('comment_id',$id)
						->get();
		return $sql->num_rows();
	}
	public function CommentCount($id)
	{
		$sql = $this->db->select("*")
						->from("comments")
						->where('post_id',$id)
						->where('parent_id',null)
						->get();
		return $sql->num_rows();		
	}
	public function logout($id)
	{
		$data = array('token' => '');
		$sql = $this->db->where('id',$id)
						->update('users',$data);
		if($sql)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function getCountry(){
		$sql = $this->db->select("*")
						->from("country")
						->order_by('country_name','asc')
						->where('is_active',1)
						->get();
		return $sql;
	}
	public function getCategorys(){
		$sql = $this->db->select("*")
						->from("departments")
						->order_by('name','asc')
						->get();
		return $sql;
	}
	public function isFavorite($id_post,  $id_user){
		$sql = $this->db->select("*")
						->from("favorite")
						->where('id_user', $id_user)
						->where('id_post', $id_post)
						->get();
		return $sql;
	}
	public function isPreference($id_category,  $id_user){
		$sql = $this->db->select("*")
						->from('preference')
						->where('id_user', $id_user)
						->where('id_category', $id_category)
						->get();
		return $sql;
	}
	public function addFavorite($id_post,$id_user)
	{
		$data = array('id_user' => $id_user, 'id_post'=>$id_post);
		$sql = $this->db->insert('favorite',$data);
		if($sql)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function addPreference($id_category,$id_user)
	{
		$data = array('id_user' => $id_user, 'id_category'=>$id_category);
		$sql = $this->db->insert('preference',$data);
		if($sql)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function delFavorite($id_post,$id_user)
	{
		$sql = $this->db->where('id_post', $id_post)
					->where('id_user', $id_user)
					->delete('favorite');
		if($sql)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function delPreference($id_category,$id_user)
	{
		$sql = $this->db->where('id_category', $id_category)
					->where('id_user', $id_user)
					->delete('preference');
		if($sql)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function rank(){
		$sql = $this->db->query("select id, `name`, avatar, `point`,  @curRank := @curRank + 1 AS myrank from users u, (select @curRank := 0) r ORDER BY `point` DESC limit 3;");
		return $sql;
	}
	public function myRank($id){
		$sql = $this->db->query('select myrank, id, `name`, avatar, `point` FROM (SELECT id, avatar, `name`, `point`,  @curRank := @curRank + 1 AS myrank FROM users u, (SELECT @curRank := 0) r ORDER BY `point` DESC) rank WHERE id='.$id.';');
		return $sql;
	}
}