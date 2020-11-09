<?php
class Model_pelanggan extends CI_Model
{

    function view_pelanggan()
    {
        $id_member = $this->session->userdata('id_member');
        return $this->db->query("SELECT * FROM pelanggan 
        WHERE pelanggan.id_member = '$id_member'
        ORDER BY nama_pelanggan
        ");
    }

    function get_pelanggan()
    {

        $id_member = $this->session->userdata('id_member');
        return $this->db->get_where('pelanggan', array('id_member' => $id_member));
    }

    function insert_pelanggan()
    {
        $this->db->select('right(pelanggan.kode_pelanggan,4) as kode ', false);
        $this->db->order_by('kode_pelanggan', 'desc');
        $this->db->limit('6');
        $query    = $this->db->get('pelanggan');
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->kode) + 1;
        } else {
            $kode = 1;
        }
        $kodemax          = str_pad($kode, 4, "0", STR_PAD_LEFT);
        $kode_pelanggan    = "K" . $kodemax;

        $kodepelanggan   = $this->input->post('kode_pelanggan');
        $nama_pelanggan  = $this->input->post('nama_pelanggan');
        $alamat         = $this->input->post('alamat');
        $no_hp          = $this->input->post('no_hp');
        $jatuh_tempo    = $this->input->post('jatuh_tempo');
        $keterangan     = $this->input->post('keterangan');
        $id_member      = $this->session->userdata('id_member');
        $id_user        = $this->session->userdata('id_user');

        if ($kodepelanggan != "") {
            $data             = array(
                'nama_pelanggan'                     => $nama_pelanggan,
                'alamat'                            => $alamat,
                'no_hp'                             => $no_hp,
                'jatuh_tempo'                       => $jatuh_tempo,
                'keterangan'                        => $keterangan,
                'id_member'                         => $id_member,
                'id_user'                           => $id_user,
            );

            $this->db->where('kode_pelanggan', $kodepelanggan);
            $this->db->update('pelanggan', $data);
        } else {

            $data             = array(
                'kode_pelanggan'                     => $kode_pelanggan,
                'nama_pelanggan'                     => $nama_pelanggan,
                'alamat'                            => $alamat,
                'no_hp'                             => $no_hp,
                'jatuh_tempo'                       => $jatuh_tempo,
                'keterangan'                        => $keterangan,
                'id_member'                         => $id_member,
                'id_user'                           => $id_user,
            );

            $this->db->insert('pelanggan', $data);
        }
    }
}
