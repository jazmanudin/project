<?php
class Model_kategori extends CI_Model
{

    function view_kategori()
    {
        return $this->db->query("SELECT * FROM kategori ");
    }

    function insert_kategori()
    {
        $this->db->select('right(kategori.kode_kategori,4) as kode ', false);
        $this->db->order_by('kode_kategori', 'desc');
        $this->db->limit('6');
        $query    = $this->db->get('kategori');
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->kode) + 1;
        } else {
            $kode = 1;
        }
        $kodemax          = str_pad($kode, 4, "0", STR_PAD_LEFT);
        $kode_kategori    = "K" . $kodemax;

        $nama_kategori    = $this->input->post('nama_kategori');
        $kodekategori     = $this->input->post('kode_kategori');
        $ket              = $this->input->post('ket');
        $id_user          = $this->session->userdata('id_user');

        if ($kodekategori != "") {
            $data             = array(
                'nama_kategori'              => $nama_kategori,
                'ket'                        => $ket,
                'id_user'                    => $id_user,
            );

            $this->db->where('kode_kategori', $kodekategori);
            $this->db->update('kategori', $data);
        } else {

            $data             = array(
                'kode_kategori'              => $kode_kategori,
                'nama_kategori'              => $nama_kategori,
                'ket'                        => $ket,
                'id_user'                    => $id_user,
            );

            $this->db->insert('kategori', $data);
        }
    }
}
