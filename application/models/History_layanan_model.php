<?php
defined('BASEPATH') or exit('No direct script access allowed');

class History_layanan_model extends CI_Model
{

    var $table = 'history_layanan';

    public function get_data($id_pengaduan)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->join('layanan', 'history_layanan.id_layanan = layanan.id_layanan', 'left');
        $this->db->where('history_layanan.id_pengaduan', $id_pengaduan);
        $this->db->order_by('id_history', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    public function save_batch($data)
    {
        $insert = $this->db->insert_batch($this->table, $data);
        return $insert;
    }

    public function update($id, $data)
    {
        $this->db->where('id_jabatan', $id);
        $update = $this->db->update($this->table, $data);
        return $update;
    }

    public function delete($id)
    {
        $this->db->where('id_jabatan', $id);
        $data = array('status' => 2);
        $delete = $this->db->update($this->table, $data);
        return $delete;
    }
}

/* End of file Jabatan_model.php */
/* Location: ./application/models/Jabatan_model.php */