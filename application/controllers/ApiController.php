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
		//$this->load->library('pusher');
	}
	public function format_tanggal($date){
		$date = date_create($date);
		$dates = date_format($date, 'M j, Y');
		return $dates;
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
		if($cekNomor==0){
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
		if($data->row()->id_user>0){
			$res = 1;
		}else{
			$res = 0;
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
		$arr = array();
		$id=$this->input->post('id');
		$sql = $this->Api_model->get_user($id);
		//$id = $total = $this->uri->segment(3);
		if($sql->num_rows() > 0)
		{
			$bio[] = array(
					'nama' => $sql->row()->nama,
					'nomor_telp' => $sql->row()->nomor_telp,
					'alamat'=>$sql->row()->alamat,
					'tanggal_lahir' => $sql->row()->tanggal_lahir
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
	public function UpdateProfile()
	{
		
	}
	public function history()
	{
		$id_user = $this->uri->segment(3);
		$sql = $this->Api_model->getHistPengaduan($id_user);
			if($sql->num_rows() > 0){
				foreach($sql->result() as $history){
					$datas[] = array(
						'id_pengaduan'=>$history->id_pengaduan,
						'kategori'=>$history->nama_kategori,
						'waktu_lapor'=>$this->format_tanggal($history->waktu_lapor),
						'id_status'=>$history->status,
						'status'=>$history->nama_status
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
				$arr = array('status' => true,'message' => 'Tidak ada riwayat pengaduan','count' => '0');
			}
  require_once APPPATH."/third_party/pusher/autoload.php";
  $options = array(
    'cluster' => 'ap1',
    'useTLS' => true
  );
  $pusher = new Pusher\Pusher(
    '71d114e69e897bd1d860',
    '779e4be0553e1f1779f2',
    '906672',
    $options
  );

  $data['message'] = 'hello world';
 //print_r($data); 
  $pusher->trigger('my-channel', 'my-event', $data);
			echo json_encode($arr);
	}
	public function masterData(){
		$arr = array();
		$code = $this->uri->segment(3);
		//echo "data post".$id.$token;
			if($code=='kategori'){
			$sql = $this->Api_model->getKategori();
			if($sql->num_rows() > 0){
				foreach($sql->result() as $category){
					$datas[] = array(
						'id_kategori'=>$category->id_kategori,
						'nama_kategori'=>$category->nama_kategori
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
		}
		//$arr = array('data'=>'saya');
		
		echo json_encode($arr);
	}
	public function postPengaduan(){
		$arr = array();
		date_default_timezone_set("Asia/Jakarta");
		$id_user = $this->input->post('id_user', true);
		$isi = $this->input->post('isi_laporan', true);
		$data = array(
            'id_user' => $id_user,
			'id_kategori' => $this->input->post('id_kategori', true),
			'isi_laporan' => $isi,
			'waktu_lapor' => date('Y-m-d H:i:s'),
			'status' => 0,
			'lat' => $this->input->post('lat', true),
			'long' => $this->input->post('long', true)		
		);
		if($id_user!=null && $isi!=null){
		$pengaduan = $this->Api_model->insPengaduan($data);
	
		//print_r($data);
		//$pengaduan;
		if($pengaduan!=false){
			$arr = array(
				'status' => '0',
				'message'=>'sukses mengirim pengaduan'
			);
		}else{
			$arr = array(
				'status' => '1',
                'message'=>'gagal mengirim pengaduan'
			);
		}
	}else{
		$arr = array(
			'status' => '1',
			'message'=>'gagal mengirim pengaduan'
		);
	}	
		echo json_encode($arr);

	}
	public function feed()
	{
		$arr = array();
		$type = $this->uri->segment(3);
		$total = $this->uri->segment(4);
		if($type == 'berita')
		{
			$popular = $this->Api_model->getArtikel($type, $total);
			if($popular->num_rows() > 0){
				foreach($popular->result() as $pop)
				{
					$data[] = array(
							'id' => $pop->id,
							'title' => $pop->title,
							'category_id' => $pop->category_id,
							'content' => substr($pop->content,0,60).'...',
							'date' => $this->format_tanggal($pop->created_at),
							'post_category'=>$type
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
		elseif($type == 'artikel')
		{
			$popular = $this->Api_model->getArtikel($type, $total);
			if($popular->num_rows() > 0){
				foreach($popular->result() as $pop)
				{
					$data[] = array(
							'id' => $pop->id,
							'title' => $pop->title,
							'image'=>base_url().$pop->image_url,
							'category_id' => $pop->category_id,
							'content' => substr($pop->content,0,60).'...',
							'date' => $this->format_tanggal($pop->created_at),
							'post_category'=>$type
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
		}elseif($type == 'kegiatan')
		{
			$popular = $this->Api_model->getArtikel($type, $total);
			if($popular->num_rows() > 0){
				foreach($popular->result() as $pop)
				{
					$data[] = array(
							'id' => $pop->id,
							'title' => $pop->title,
							'image'=>base_url().$pop->image_url,
							'category_id' => $pop->category_id,
							'content' => substr($pop->content,0,60).'...',
							'date' => $this->format_tanggal($pop->created_at),
							'post_category'=>$type
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
		}elseif($type == 'video')
		{
			$popular = $this->Api_model->getArtikel($type, $total);
			if($popular->num_rows() > 0){
				foreach($popular->result() as $pop)
				{
					$data[] = array(
							'id' => $pop->id,
							'image'=>base_url().$pop->image_url,
							'title' => $pop->title,
							'category_id' => $pop->category_id,
							'content' => substr($pop->content,0,60).'...',
							'date' => $this->format_tanggal($pop->created_at),
							'post_category'=>$type
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
		}elseif($type == 'slider')
		{
			$popular = $this->Api_model->getSlider($total);
			if($popular->num_rows() > 0){
				foreach($popular->result() as $pop)
				{
					$data[] = array(
							'id' => $pop->id,
							'title' => $pop->title,
							'image'=>base_url().$pop->image_url,
							'category_id' => $pop->category_id,
							'content' => substr($pop->content,0,60).'...',
							'date' => $this->format_tanggal($pop->created_at),
							'post_category'=>$type
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
		echo json_encode($arr);
	}
	public function showArticle()
	{
		$arr = array();
		$postId = $this->uri->segment(3);
			$sql = $this->Api_model->getShowArticles($postId);
			if($sql->num_rows() > 0){
				foreach($sql->result() as $pop){
					$data = array(
							'id' => $pop->id,
							'title' => $pop->title,
							'image'=>base_url().$pop->image_url,
							'category_id' => $pop->category_id,
							'content' => $pop->content,
							'date' => $this->format_tanggal($pop->created_at),
							'post_category'=>$pop->nama_kategori
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
