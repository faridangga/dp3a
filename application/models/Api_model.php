<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Api_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
		$this->load->model('Auth_model');
		$this->load->library('bcrypt');
	}
	public function wa_cekUser($nomor){
	    $this->db->where('nomor_user', $nomor);
        $query = $this->db->get('m_user');
        return $query;
	}
	public function wa_insertUser($data){
		if ($this->db->insert('m_user', $data)) {
            return true;
        } else {
            return false;
        }
	}
	public function wa_updateUser($id,$data)
	{
		$sql = $this->db->where('nomor_user', $id)
							->update('m_user',$data);
		if($sql)
		{
			return true;
		}
		else
		{
			return false;
		}
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
	public function insPengaduan($data){
		if ($this->db->insert('pengaduan', $data)) {
            return true;
        } else {
            return false;
        }
	}
	public function getHistPengaduan($id){
		$sql = $this->db->select("*")
						->from("pengaduan")
						->join("kategori_laporan","pengaduan.id_kategori = kategori_laporan.id_kategori")
						->join("status_pengaduan","pengaduan.status = status_pengaduan.id_status")
						->order_by("waktu_lapor","DESC")
						->where("id_user",$id)
						->where("pengaduan.status !=",5)
						->get();
		return $sql;
	}
	public function postUpdateProfile($id,$update)
	{
		$sql = $this->db->where('id_user',$id)
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

	public function getArtikel($type, $count)
	{
		if($type=='berita'){
			$type=1;
		}elseif($type=='artikel'){
			$type=2;
		}elseif($type=='kegiatan'){
			$type=3;
		}elseif($type=='video'){
			$type=4;
		}
		$sql = $this->db->select("*")
						->from("posts")
						->join('kategori_post','posts.category_id = kategori_post.id_kategori')
						->where('kategori_post.id_kategori', $type)
						->where('posts.status',1)
						->order_by('created_at','DESC')
						->limit($count)
						->get();
		return $sql;
	}
	public function getSlider($count)
	{
		$sql = $this->db->select("*")
						->from("posts")
						->join('kategori_post','posts.category_id = kategori_post.id_kategori')
						->where('posts.is_slider', 1)
						->order_by('created_at','DESC')
						->limit($count)
						->get();
		return $sql;
	}
	public function getShowArticles($id)
	{
		$sql = $this->db->select("*")
						->from("posts")
						->join('kategori_post','posts.category_id = kategori_post.id_kategori')
						->where('posts.id', $id)
						->order_by('created_at','DESC')
						->limit($count)
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
	public function getLaporanKekerasan($tahun, $tipe)
	{
		if($tipe=='usia')
		$this->db->select("bulan, tahun, usia_1, usia_2, usia_3");
		elseif($tipe=='bentuk')
		$this->db->select("bulan, tahun, fsk, psi, seks, eks, penelantaran, lain");
		$sql = 	$this->db->from("data_kekerasan")
						->where('tahun',$tahun)
						->get();
		return $sql;
	}
	public function getGrafikKekerasan($tahun, $tipe)
	{
		if($tipe=='usia')
		$this->db->select("sum(usia_1) as usia_1, sum(usia_2) as usia_2, sum(usia_3) as usia_3");
		elseif($tipe=='bentuk')
		$this->db->select("SUM(fsk) AS fisik, SUM(psi) AS psikologi, SUM(seks) AS seksual, SUM(eks) AS eksploitasi, SUM(penelantaran) AS penelantaran, SUM(lain) AS lain ");
		$sql = 	$this->db->from("data_kekerasan")
						->where('tahun',$tahun)
						->get();
		return $sql;
	}
	public function getTahunLaporan(){
		$sql = $this->db->select("tahun")
						->from("data_kekerasan")
						->group_by('tahun')
						->order_by('tahun', 'asc')
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
	public function getKategori(){
		$sql = $this->db->select("*")
						->from("kategori_laporan")
						->order_by('id_kategori','asc')
						->where('status',1)
						->get();
		return $sql;
	}
	public function getKecamatan(){
		$sql = $this->db->select("*")
						->from("kecamatan")
						->order_by('id_kecamatan','asc')
						->where('status',1)
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
	public function getLaporanBySatus($tahun, $status){
		$sql = $this->db->query("SELECT MONTH(p.waktu_lapor), COUNT(p.id_pengaduan) AS jumlah FROM pengaduan p RIGHT JOIN status_pengaduan sp ON sp.id_status = p.status WHERE YEAR(waktu_lapor) = '$tahun' AND p.status = '$status' GROUP BY MONTH(p.waktu_lapor)");
		return $sql;
	}
}