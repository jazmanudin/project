<?php
class Model_pelanggan extends CI_Model
{

    public function getDataPelanggan($rowno, $rowperpage, $kode_pelanggan = "", $nama_pelanggan = "")
    {

        $this->db->select('*');
        $this->db->from('pelanggan');
        $this->db->order_by('nama_pelanggan', 'DESC');

        if ($kode_pelanggan != '') {
            $this->db->like('pelanggan.kode_pelanggan', $kode_pelanggan);
        }

        if ($nama_pelanggan != '') {
            $this->db->like('pelanggan.nama_pelanggan', $nama_pelanggan);
        }

        $this->db->limit($rowperpage, $rowno);
        $query = $this->db->get();
        return $query->result();
    }

    public function getRecordPelangganCount($kode_pelanggan = "", $nama_pelanggan = "")
    {

        $this->db->select('count(*) as allcount');
        $this->db->from('pelanggan');
        $this->db->order_by('pelanggan.nama_pelanggan', 'DESC');

        if ($kode_pelanggan != '') {
            $this->db->like('pelanggan.kode_pelanggan', $kode_pelanggan);
        }

        if ($nama_pelanggan != '') {
            $this->db->like('pelanggan.nama_pelanggan', $nama_pelanggan);
        }

        $query  = $this->db->get();
        $result = $query->result_array();
        return $result[0]['allcount'];
    }

    function get_pelanggan()
    {

        return $this->db->get('pelanggan');
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
        $id_user        = $this->session->userdata('id_user');

        if ($kodepelanggan != "") {
            $data             = array(
                'nama_pelanggan'                     => $nama_pelanggan,
                'alamat'                            => $alamat,
                'no_hp'                             => $no_hp,
                'jatuh_tempo'                       => $jatuh_tempo,
                'keterangan'                        => $keterangan,
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
                'id_user'                           => $id_user,
            );

            $this->db->insert('pelanggan', $data);
        }
    }
}
