<?php
class Model_barang extends CI_Model
{


    public function getDataBarang($rowno, $rowperpage, $kode_barang = "", $nama_barang = "")
    {

        $this->db->select('barang.kode_barang,SUM(stok) AS stok,satuan,nama_barang,nama_kategori,harga_modal,pelanggan_tetap,tidak_tetap,grosir,eceran,lainnya,diskon,keterangan');
        $this->db->from('barang');
        $this->db->join('kategori', 'kategori.kode_kategori=barang.kode_barang', 'left');
        $this->db->join('barang_detail', 'barang_detail.kode_barang=barang.kode_barang', 'left');
        $this->db->group_by('barang.kode_barang,satuan,nama_barang,nama_kategori,harga_modal,pelanggan_tetap,tidak_tetap,grosir,eceran,lainnya,diskon,keterangan');
        $this->db->order_by('nama_barang', 'DESC');

        if ($kode_barang != '') {
            $this->db->like('barang.kode_barang', $kode_barang);
        }

        if ($nama_barang != '') {
            $this->db->like('barang.nama_barang', $nama_barang);
        }

        $this->db->limit($rowperpage, $rowno);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getRecordBarangCount($kode_barang = "", $nama_barang = "")
    {

        $this->db->select('count(*) as allcount');
        $this->db->from('barang');
        $this->db->join('kategori', 'kategori.kode_kategori=barang.kode_barang', 'left');
        $this->db->join('barang_detail', 'barang_detail.kode_barang=barang.kode_barang', 'left');
        $this->db->group_by('barang.kode_barang,satuan,nama_barang,nama_kategori,harga_modal,pelanggan_tetap,tidak_tetap,grosir,eceran,lainnya,diskon,keterangan');
        $this->db->order_by('barang.nama_barang', 'DESC');

        if ($kode_barang != '') {
            $this->db->like('barang.kode_barang', $kode_barang);
        }

        if ($nama_barang != '') {
            $this->db->like('barang.nama_barang', $nama_barang);
        }

        $query  = $this->db->get();
        $result = $query->result_array();
        return $result[0]['allcount'];
    }

    function get_barang()
    {

        $kode_barang = $this->uri->segment(3);
        return $this->db->get_where('barang', array('kode_barang' => $kode_barang));
    }

    function get_kategori()
    {

        return $this->db->get('kategori');
    }

    function detail_barang()
    {

        $kode_barang            = $this->input->post('kode_barang');
        return $this->db->get_where('barang', array('kode_barang' => $kode_barang));
    }

    function insert_barang($foto)
    {
        // $this->db->select('right(barang.kode_barang,4) as kode ', false);
        // $this->db->order_by('kode_barang', 'desc');
        // $this->db->limit('6');
        // $query    = $this->db->get('barang');
        // if ($query->num_rows() <> 0) {
        //     $data   = $query->row();
        //     $kode   = intval($data->kode) + 1;
        // } else {
        //     $kode   = 1;
        // }
        // $kodemax  = str_pad($kode, 4, "0", STR_PAD_LEFT);
        // $kode_barang = "B" . $kodemax;

        $kode_barang        = $this->input->post('kode_barang');
        $nama_barang        = $this->input->post('nama_barang');
        $satuan             = $this->input->post('satuan');
        $harga_modal        = str_replace(",", "", $this->input->post('harga_modal'));
        $pelanggan_tetap    = str_replace(",", "", $this->input->post('pelanggan_tetap'));
        $tidak_tetap        = str_replace(",", "", $this->input->post('tidak_tetap'));
        $eceran             = str_replace(",", "", $this->input->post('eceran'));
        $grosir             = str_replace(",", "", $this->input->post('grosir'));
        $lainnya            = str_replace(",", "", $this->input->post('lainnya'));
        $diskon             = str_replace(",", "", $this->input->post('diskon'));
        $kode_kategori      = $this->input->post('kode_kategori');
        $jenis_barang       = $this->input->post('jenis_barang');
        $keterangan         = $this->input->post('keterangan');
        $id_user            = $this->session->userdata('id_user');

        $data                   = array(
            'kode_barang'       => $kode_barang,
            'nama_barang'       => $nama_barang,
            'satuan'            => $satuan,
            'harga_modal'       => $harga_modal,
            'grosir'            => $grosir,
            'eceran'            => $eceran,
            'pelanggan_tetap'   => $pelanggan_tetap,
            'tidak_tetap'       => $tidak_tetap,
            'lainnya'           => $lainnya,
            'kode_kategori'     => $kode_kategori,
            'keterangan'        => $keterangan,
            'jenis_barang'      => $jenis_barang,
            'barangke'          => "1",
            'diskon'            => $diskon,
            'id_user'           => $id_user,
            'stok'              => 0,
            'foto'              => $foto
        );

        $this->db->insert('barang', $data);
    }

    function update_barang($foto)
    {

        $kode_barang        = $this->input->post('kode_barang');
        $nama_barang        = $this->input->post('nama_barang');
        $satuan             = $this->input->post('satuan');
        $harga_modal        = str_replace(",", "", $this->input->post('harga_modal'));
        $pelanggan_tetap    = str_replace(",", "", $this->input->post('pelanggan_tetap'));
        $tidak_tetap        = str_replace(",", "", $this->input->post('tidak_tetap'));
        $eceran             = str_replace(",", "", $this->input->post('eceran'));
        $grosir             = str_replace(",", "", $this->input->post('grosir'));
        $lainnya            = str_replace(",", "", $this->input->post('lainnya'));
        $diskon             = str_replace(",", "", $this->input->post('diskon'));
        $kode_kategori      = $this->input->post('kode_kategori');
        $keterangan         = $this->input->post('keterangan');
        $jenis_barang       = $this->input->post('jenis_barang');
        $id_user            = $this->session->userdata('id_user');

        $data                   = array(
            'nama_barang'              => $nama_barang,
            'satuan'                   => $satuan,
            'harga_modal'              => $harga_modal,
            'grosir'                   => $grosir,
            'eceran'                   => $eceran,
            'pelanggan_tetap'          => $pelanggan_tetap,
            'tidak_tetap'              => $tidak_tetap,
            'lainnya'                  => $lainnya,
            'kode_kategori'            => $kode_kategori,
            'keterangan'               => $keterangan,
            'jenis_barang'             => $jenis_barang,
            'diskon'                   => $diskon,
            'id_user'                  => $id_user,
            'foto'                     => $foto
        );

        $this->db->where('kode_barang', $kode_barang);
        $this->db->update('barang', $data);
    }
}
