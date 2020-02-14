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
				$arr = array('status' => '1','message' => 'Data Profil tidak ditemukan', 'total' => 0, 'data' => 0);
			}
		//}
		echo json_encode($arr);
	}
	public function UpdateProfile()
	{
		$arr = array();
		$id = $this->input->post('id');
		//$cek = $this->Api_model->checkId($token);
		$password=$this->input->post('password');
		if($password!=null){
			$update['password']=md5($password);
		}
		//$update['nama']=$this->input->post('nama');
		//$update['alamat']=$this->input->post('alamat');
		$sql = $this->Api_model->get_user($id);
			if($sql->num_rows() > 0)
			{
				$updateProfile = $this->Api_model->postUpdateProfile($id,$update);
				if($updateProfile == true)
				{
					$arr = array(
						'status' => 0,
						'message' => 'Berhasil Merubah Data.',
					);
				}
				else
				{
					$arr = array('status' => 1,'message' => 'Ubah profil gagal.', 'total' => 0, 'data' => 0);		
				}
			}
			else
			{
				$arr = array('status' => 1,'message' => 'Profile Data Not Found..', 'total' => 0, 'data' => 0);
			}
		echo json_encode($arr);
	}
	public function history()
	{
		//$this->pusher("history");
		$id_user = $this->uri->segment(3);
		$sql = $this->Api_model->getHistPengaduan($id_user);
		$datas = array();
			if($sql->num_rows() > 0){
				foreach($sql->result() as $history){
					$datas[] = array(
						'id_pengaduan'=>$history->id_pengaduan,
						'kategori'=>$history->nama_kategori,
						'waktu_lapor'=>$this->format_tanggal($history->waktu_lapor),
						'id_status'=>$history->id_status,
						'status'=>$history->nama_status
					);
				}
				$arr = array(
						'status' => "0",
						'message' => "sukses",
						'push'=>$data,
						'total' => $sql->num_rows(),
						'data' => $datas
				);
			}
			else
			{
				$arr = array('status' => "1",'message' => 'Tidak ada riwayat pengaduan','total' => 0, 'data' => $datas);
			}
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
				$arr = array('status' => '1','message' => 'Data Kategori Tidak Ditemukan','total' => 0, 'data' => 0);
			}
		}elseif($code=='kecamatan'){
			$sql = $this->Api_model->getKecamatan();
			if($sql->num_rows() > 0){
				foreach($sql->result() as $category){
					$datas[] = array(
						'id_kecamatan'=>$category->id_kecamatan,
						'nama_kecamatan'=>$category->nama_kecamatan
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
				$arr = array('status' => '1','message' => 'Data Kategori Tidak Ditemukan','total' => 0, 'data' => 0);
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
			'jenis_kelamin' => $this->input->post('jenis_kelamin', true),
			'usia' => $this->input->post('usia', true),
			'kecamatan' => $this->input->post('kecamatan', true),
			'desa' => $this->input->post('desa', true),
			'dusun' => $this->input->post('dusun', true),
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
			$this->pusher("data Pengaduan Baru Masuk");
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
							'image'=>base_url().$pop->image_url,
							'category_id' => $pop->category_id,
							'content' => substr($pop->content,0,60).'...',
							'date' => $this->format_tanggal($pop->created_at),
							'post_category'=>$type
							);
				}
				$arr = array(
					'status' => 0,
					'total' => $popular->num_rows(),
					'articles' => $data
				);
			}
			else
			{
				$arr = array('status' => 0,'message' => 'Artikel Tidak Ditemukan','total' => 0, 'articles' => 0);	
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
					'status' => 0,
					'total' => $popular->num_rows(),
					'articles' => $data
				);
			}
			else
			{
				$arr = array('status' => 0,'message' => 'Artikel Tidak Ditemukan','total' => 0, 'articles' => 0);	
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
					'status' => 0,
					'total' => $popular->num_rows(),
					'articles' => $data
				);
			}
			else
			{
				$arr = array('status' => 0,'message' => 'Artikel Tidak Ditemukan', 'total' => 0, 'articles' => 0);	
			}
		}elseif($type == 'video')
		{
			$popular = $this->Api_model->getArtikel($type, $total);
			if($popular->num_rows() > 0){
				foreach($popular->result() as $pop)
				{
					$data[] = array(
							'id' => $pop->id,
							'image'=>$pop->image_thumbnail,
							'title' => $pop->title,
							'category_id' => $pop->category_id,
							'content' => substr($pop->content,0,60).'...',
							'date' => $this->format_tanggal($pop->created_at),
							'post_category'=>$type
							);
				}
				$arr = array(
					'status' => 0,
					'total' => $popular->num_rows(),
					'articles' => $data
				);
			}
			else
			{
				$arr = array('status' => 0,'message' => 'Artikel Tidak Ditemukan','total' => 0, 'articles' => 0);	
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
					'status' => 0,
					'total' => $popular->num_rows(),
					'articles' => $data
				);
			}
			else
			{
				$arr = array('status' => 0,'message' => 'No Articles Found..','total' => 0, 'articles' => 0);	
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
					if($pop->category_id==4){
						$image = $pop->image_thumbnail;
						$content = $pop->video_embed_code;
					}else{
						$image = base_url().$pop->image_url;
						$content = $pop->content;
					}
					$data = array(
							'id' => $pop->id,
							'title' => $pop->title,
							'image'=>$image,
							'category_id' => $pop->category_id,
							'content' => $content,
							'date' => $this->format_tanggal($pop->created_at),
							'post_category'=>$pop->nama_kategori
					);
				}
				$arr = array(
						'status' => 0,
						'total' => $sql->num_rows(),
						'articles' => $data
				);
			}
			else
			{
				$arr = array('status' => 0,'message' => 'No Articles Found..','total' => 0, 'articles' => 0);
			}
		echo json_encode($arr);
	}
	public function profilDinas(){
		$arr = array();
		$data = array(
			'nama_dinas'=> 'Dinas Pemberdayaan Perempuan dan Perlindungan Anak',
			'nama_kabupaten'=> 'Kabupaten Malang',
			'logo'=>base_url().'uploads/images/logo.jpg',
			'alamat'=>'Jl. Nusa Barong 13 Kota Malang',
			'no_telp'=>'+6281313060661',
			'no_wa'=>'+6281313060661',
			'template_wa'=>'Salam, saya ingin berkonsultasi tentang perlindungan perempuan dan kekerasan anak'
		);
		$arr = array(
			'status' => 0,
			'message' => 'Berhasil mengambil data profil dinas',
			'data' => $data
		);
		echo json_encode($arr);
	}
	public function info(){
		$tipe = $this->uri->segment(3);
		if($tipe == 'bantuan'){
			$this->load->view('info/bantuan');
		}elseif($tipe=='lupa'){
			$this->load->view('info/lupa');
		}
	}
	public function laporanKekerasan(){
		$tahun = $this->uri->segment(4);
		$tipe = $this->uri->segment(3);
		$bulan = array(1=>'Januari', 2=>"Februari",3=>'Maret', 4=>'April', 5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus', 9=>'September',	10=>'Oktober', 11=>'Nopember',	12=>'Desember');
		if($tipe=='tahun'){
			$tahun = array();
			$sql = $this->Api_model->getTahunLaporan();
			foreach($sql->result() as $report)
				{
					$tahun[]=$report->tahun;
				}
				$arr = array(
					'status' => 0,
					'total' => $sql->num_rows(),
					'data' => $tahun
			);
		}else{
		$sql = $this->Api_model->getLaporanKekerasan($tahun, $tipe);
		$sql_grafik = $this->Api_model->getGrafikKekerasan($tahun, $tipe);
		if($sql->num_rows() > 0){
		foreach($sql->result() as $report)
				{
					if($tipe=='usia'){
					$data[] = array(
							'bulan' => $bulan[$report->bulan],
							'tahun' => $report->tahun,
							'usia_1'=>$report->usia_1,
							'usia_2' => $report->usia_2,
							'usia_3' => $report->usia_3
							);
					}elseif($tipe=='bentuk'){
						$data[] = array(
							'bulan' => $bulan[$report->bulan],
							'tahun' => $report->tahun,
							'fisik'=>$report->fsk,
							'psikologi' => $report->psi,
							'seksual' => $report->seks,
							'eksploitasi' => $report->eks,
							'penelantaran' => $report->penelantaran,
							'lain' => $report->lain,
							);
					}
				}
				foreach($sql_grafik->result() as $report)
				{
					if($tipe=='usia'){
					$grafik[] = array(
							'usia_1'=>$report->usia_1,
							'usia_2' => $report->usia_2,
							'usia_3' => $report->usia_3
							);
					}elseif($tipe=='bentuk'){
						$grafik[] = array(
							'fisik'=>$report->fisik,
							'psikologi' => $report->psikologi,
							'seksual' => $report->seksual,
							'eksploitasi' => $report->eksploitasi,
							'penelantaran' => $report->penelantaran,
							'lain' => $report->lain,
							);
					}
				}

				$arr = array(
					'status' => true,
					'total' => $sql->num_rows(),
					'grafik'=>$grafik,
					'data' => $data
			);
		}else{
			$arr = array('status' => true,'message' => 'Data Tidak ditemukan','count' => '0');
		}
	}
		echo json_encode($arr);
	}
	public function pusher($message){
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
		
		  $data['message'] = $message;
		  $pusher->trigger('my-channel', 'my-event', $data);
	}
	public function logout()
	{
		$arr = array();
		$token = $_SERVER['HTTP_TOKEN'];
		$id = $_SERVER['HTTP_USERID'];
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
	public function report(){
		$arr = array();
		$kategori = $this->uri->segment(3);
		$tahun = $this->uri->segment(4);
		$status = $this->uri->segment(5);
		//echo "data post".$id.$token;
			if($kategori=='status'){
			$sql = $this->Api_model->getLaporanBySatus($tahun.$status);
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
				$arr = array('status' => '1','message' => 'Data Kategori Tidak Ditemukan','total' => 0, 'data' => 0);
			}
		}
		
		//$arr = array('data'=>'saya');
		
		echo json_encode($arr);
	}
}
