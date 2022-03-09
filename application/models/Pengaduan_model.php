<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengaduan_model extends CI_Model
{

	var $table = "pengaduan";

	public function get_data()
	{
		$this->db->select('pengaduan.*, YEAR(waktu_lapor) as tahun, MONTH(waktu_lapor) as bulan, users.nama, users.nomor_telp, users.alamat, kategori_laporan.nama_kategori, status_pengaduan.id_status, kecamatan.nama_kecamatan as nama_kecamatan, layanan.nama_layanan');
		$this->db->from($this->table);
		$this->db->join('users', 'pengaduan.id_user = users.id_user', 'left');
		$this->db->join('kategori_laporan', 'pengaduan.id_kategori = kategori_laporan.id_kategori', 'left');
		$this->db->join('status_pengaduan', 'pengaduan.status = status_pengaduan.id_status', 'left');
		$this->db->join('layanan', 'pengaduan.layanan = layanan.id_layanan', 'left');
		$this->db->join('kecamatan', 'pengaduan.kecamatan = kecamatan.id_kecamatan', 'left');
		$this->db->where('pengaduan.status !=', 5);
		// $this->db->group_by('bulan, nama_kategori, kecamatan');
		$this->db->order_by('waktu_lapor', 'desc');

		$query = $this->db->get();
		return $query->result();
	}

	public function get_data_report($kecamatan = null, $year = null)
	{
		$this->db->select('pengaduan.*,YEAR(waktu_lapor) as tahun, MONTH(waktu_lapor) as bulan, kecamatan.nama_kecamatan,
			SUM(CASE WHEN nama_kategori ="Fisik" THEN 1 ELSE 0 END) Fisik
			, SUM(CASE WHEN nama_kategori ="Psikis" THEN 1 ELSE 0 END) Psikis
			, SUM(CASE WHEN nama_kategori ="Seksual" THEN 1 ELSE 0 END) Seksual
			, SUM(CASE WHEN nama_kategori ="Eksploitasi" THEN 1 ELSE 0 END) Eksploitasi
			, SUM(CASE WHEN nama_kategori ="Trafficking" THEN 1 ELSE 0 END) Trafficking
			, SUM(CASE WHEN nama_kategori ="Penelantaran" THEN 1 ELSE 0 END) Penelantaran
			, SUM(CASE WHEN nama_kategori ="Lainnya" THEN 1 ELSE 0 END) Lainnya
			, SUM(CASE WHEN nama_kategori ="Fisik" THEN 1 ELSE 0 END)
			+ SUM(CASE WHEN nama_kategori ="Psikis" THEN 1  ELSE 0 END)
			+ SUM(CASE WHEN nama_kategori ="Seksual" THEN 1 ELSE 0 END)
			+ SUM(CASE WHEN nama_kategori ="Eksploitasi" THEN 1 ELSE 0 END)
			+ SUM(CASE WHEN nama_kategori ="Trafficking" THEN 1 ELSE 0 END)
			+ SUM(CASE WHEN nama_kategori ="Penelantaran" THEN 1 ELSE 0 END) 
			+ SUM(CASE WHEN nama_kategori ="Lainnya" THEN 1 ELSE 0 END) Total');
		$this->db->from($this->table);
		$this->db->join('kategori_laporan', 'pengaduan.id_kategori = kategori_laporan.id_kategori', 'left');
		$this->db->join('kecamatan', 'pengaduan.kecamatan = kecamatan.id_kecamatan', 'left');

		$this->db->where('pengaduan.status !=', 5);
		// $this->db->order_by('waktu_lapor','desc');
		$this->db->group_by('bulan');
		$this->db->order_by('bulan', 'asc');
		if ($kecamatan != null) {
			$this->db->where('pengaduan.kecamatan', $kecamatan);
		}
		if ($year != null) {
			$this->db->where('year(pengaduan.waktu_lapor)', $year);
		}

		$query = $this->db->get();
		return $query->result();
	}

	public function get_data_date()
	{
		$this->db->select('DISTINCT(YEAR(waktu_lapor)) as tahun');
		$this->db->from('pengaduan');
		$this->db->order_by('tahun', 'desc');
		$query = $this->db->get()->result();
		return $query;
	}

	public function get1()
	{
		$result = $this->db->get('pengaduan')->result();
		return $result;
	}

	public function get_pie_pengaduan($tahun = null, $bulan = null)
	{
		$this->db->select('month(waktu_lapor), id_kategori, COUNT(id_kategori) as jml, waktu_lapor')
			->where('month(waktu_lapor)', $bulan)
			->where('year(waktu_lapor)', $tahun)
			->group_by('id_kategori');
		$query = $this->db->get($this->table);
		return $query->result();
	}

	public function get_chart_pengaduan($id_kategori = null, $tahun = null)
	{
		$this->db->select('concat(monthname(waktu_lapor)," ",year(waktu_lapor)) as date,
			SUM(CASE WHEN status = "0" THEN 1 ELSE 0 END) "Belum Direspon",
			SUM(CASE WHEN status = "1" THEN 1 ELSE 0 END) "Sudah Teratasi",
			SUM(CASE WHEN status = "2" THEN 1 ELSE 0 END) "Tidak Teratasi",
			SUM(CASE WHEN status = "3" THEN 1 ELSE 0 END) "Tidak Bisa Dihubungi",
			SUM(CASE WHEN status = "4" THEN 1 ELSE 0 END) "Sedang Diproses"');
		$this->db->from('pengaduan');
		$this->db->where('pengaduan.status !=', 5);
		if ($id_kategori != null) {
			$this->db->where('id_kategori', $id_kategori);
		}
		if ($tahun != null) {
			$this->db->where('year(waktu_lapor)', $tahun);
		}
		$this->db->group_by('year(waktu_lapor),month(waktu_lapor)');
		$result = $this->db->get()->result_array();

		$labels = [];
		foreach ($result as $key1 => $value1) {
			array_push($labels, $value1['date']);
		}

		$ds_label = [];
		$ds_data = [];

		if (count($result) != 0) {
			foreach ($result[0] as $key => $value) {
				if ($key != 'date') {
					array_push($ds_label, $key);
				}
			}
			for ($i = 1; $i < (count($result[0])); $i++) {
				$row_data = [];
				for ($j = 0; $j < count($result); $j++) {
					array_push($row_data, $result[$j][$ds_label[$i - 1]]);
				}
				array_push($ds_data, $row_data);
			}
		}

		$backgroundColor = [
			'rgb(255, 193, 7, 0.2)',
			'rgba(40, 167, 69, 0.2)',
			'rgb(255, 99, 132, 0.2)',
			'rgba(108, 117, 125, 0.2)',
			'rgb(253, 126, 20, 0.2)',
		];

		$borderColor = [
			'rgb(255, 193, 7)',
			'rgba(40, 167, 69)',
			'rgb(255, 99, 132)',
			'rgba(108, 117, 125)',
			'rgb(253, 126, 20)',
		];

		$ret = [
			'labels' => $labels,
			'label' => $ds_label,
			'data' => $ds_data,
			'backgroundColor' => $backgroundColor,
			'borderColor' => $borderColor,
			// 'query' => $this->db->last_query()
		];
		return $ret;
	}

	public function get_data_by_id($id)
	{
		$this->db->select('pengaduan.*, users.nama, users.nomor_telp, users.alamat, kategori_laporan.nama_kategori, status_pengaduan.id_status, kecamatan.nama_kecamatan as nama_kecamatan');
		$this->db->from($this->table);
		$this->db->join('users', 'pengaduan.id_user = users.id_user', 'left');
		$this->db->join('kategori_laporan', 'pengaduan.id_kategori = kategori_laporan.id_kategori', 'left');
		$this->db->join('kecamatan', 'pengaduan.kecamatan = kecamatan.id_kecamatan', 'left');
		$this->db->join('status_pengaduan', 'pengaduan.status = status_pengaduan.id_status', 'left');
		$this->db->where('pengaduan.status !=', 5);
		$this->db->where('id_pengaduan', $id);
		$query = $this->db->get();
		return $query->row(0);
	}

	public function insert($data)
	{
		$insert = $this->db->insert($this->table, $data);
		return $insert;
	}

	public function update($id, $data)
	{
		$this->db->where('id_pengaduan', $id);
		$update = $this->db->update($this->table, $data);
		return $update;
	}

	public function delete($id)
	{
		$this->db->where('id_pengaduan', $id);
		$data = array('status' => 5);
		$delete = $this->db->update($this->table, $data);
		return $delete;
	}

	public function count_pengaduan()
	{
		$jumlah = 0;
		$status = 0;
		$this->db->where('status =', 0);
		$query = $this->db->get($this->table)->result();
		foreach ($query as $key => $value) {
			if ($value->status == 0) {
				$jumlah++;
			}
		}
		return $jumlah;
	}

	public function count_pengaduan_all()
	{
		$jumlah = 0;
		$query = $this->db->get($this->table)->result();
		foreach ($query as $key => $value) {
			$jumlah++;
		}
		return $jumlah;
	}

	public function get_layanan()
	{
		$query = $this->db->get('layanan')->result();
		return $query;
	}

	public function get_status_pengaduan()
	{
		$this->db->where('id_status !=', 5);
		$query = $this->db->get('status_pengaduan')->result();
		return $query;
	}

	public function get_lokasi()
	{
		$query = $this->db->get('kecamatan')->result();
		return $query;
	}
}

/* End of file Pengaduan_model.php */
/* Location: ./application/models/Pengaduan_model.php */