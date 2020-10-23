<?php
class Model_barang extends CI_Model
{

    function view_barang()
    {
        $id_member = $this->session->userdata('id_member');
        return $this->db->query("SELECT * FROM barang 
        INNER JOIN kategori ON kategori.kode_kategori=barang.kode_kategori
        WHERE barang.id_member = '$id_member'
        ");
    }

    function get_barang()
    {

        $kode_barang = $this->uri->segment(3);
        return $this->db->get_where('barang', array('kode_barang' => $kode_barang));
    }

    function get_kategori()
    {

        $id_member = $this->session->userdata('id_member');
        return $this->db->get_where('kategori', array('id_member' => $id_member));
    }

    function detail_barang()
    {

        $kode_barang            = $this->input->post('kode_barang');
        return $this->db->get_where('barang', array('kode_barang' => $kode_barang));
    }

    function insert_barang($foto)
    {
        $this->db->select('right(barang.kode_barang,4) as kode ', false);
        $this->db->order_by('kode_barang', 'desc');
        $this->db->limit('6');
        $query    = $this->db->get('barang');
        if ($query->num_rows() <> 0) {
            $data   = $query->row();
            $kode   = intval($data->kode) + 1;
        } else {
            $kode   = 1;
        }
        $kodemax  = str_pad($kode, 4, "0", STR_PAD_LEFT);
        $kode_barang = "B" . $kodemax;

        $nama_barang    = $this->input->post('nama_barang');
        $satuan         = $this->input->post('satuan');
        $harga_modal    = str_replace(",", "", $this->input->post('harga_modal'));
        $harga          = str_replace(",", "", $this->input->post('harga'));
        $diskon         = str_replace(",", "", $this->input->post('diskon'));
        $kode_kategori  = $this->input->post('kode_kategori');
        $jenis_barang   = $this->input->post('jenis_barang');
        $keterangan     = $this->input->post('keterangan');
        $id_member      = $this->session->userdata('id_member');
        $id_user        = $this->session->userdata('id_user');

        $data                   = array(
            'kode_barang'              => $kode_barang,
            'nama_barang'              => $nama_barang,
            'satuan'                   => $satuan,
            'harga_modal'              => $harga_modal,
            'harga'                    => $harga,
            'kode_kategori'            => $kode_kategori,
            'keterangan'               => $keterangan,
            'jenis_barang'             => $jenis_barang,
            'diskon'                   => $diskon,
            'id_member'                => $id_member,
            'id_user'                  => $id_user,
            'stok'                     => 0,
            'foto'                     => $foto
        );

        $this->db->insert('barang', $data);
    }

    function update_barang($foto)
    {

        $kode_barang    = $this->input->post('kode_barang');
        $nama_barang    = $this->input->post('nama_barang');
        $satuan         = $this->input->post('satuan');
        $harga_modal    = str_replace(",", "", $this->input->post('harga_modal'));
        $harga          = str_replace(",", "", $this->input->post('harga'));
        $diskon         = str_replace(",", "", $this->input->post('diskon'));
        $kode_kategori  = $this->input->post('kode_kategori');
        $keterangan     = $this->input->post('keterangan');
        $jenis_barang   = $this->input->post('jenis_barang');
        $id_member      = $this->session->userdata('id_member');
        $id_user        = $this->session->userdata('id_user');

        $data                   = array(
            'nama_barang'              => $nama_barang,
            'satuan'                   => $satuan,
            'harga_modal'              => $harga_modal,
            'harga'                    => $harga,
            'kode_kategori'            => $kode_kategori,
            'keterangan'               => $keterangan,
            'jenis_barang'             => $jenis_barang,
            'diskon'                   => $diskon,
            'id_member'                => $id_member,
            'id_user'                  => $id_user,
            'foto'                     => $foto
        );

        $this->db->where('kode_barang', $kode_barang);
        $this->db->update('barang', $data);
    }
}
