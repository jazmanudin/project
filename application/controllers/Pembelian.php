<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembelian extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_login();
        $this->load->Model('Model_pembelian');
    }

    public function view_pembelian()
    {
        $data['no_fak_pemb']    = $this->input->post('no_fak_pemb');
        $data['dari']           = $this->input->post('dari');
        $data['sampai']         = $this->input->post('sampai');
        $data['data']           = $this->Model_pembelian->view_pembelian()->result();
        $this->template->load('template/template', 'pembelian/view_pembelian', $data);
    }

    public function detail_pembelian()
    {
        $data['data'] = $this->Model_pembelian->detail_pembelian()->result();
        $this->load->view('pembelian/detail_pembelian', $data);
    }

    public function input_bayar_hutang()
    {
        $data['getbayar'] = $this->Model_pembelian->bayar_hutang()->row_array();
        $this->load->view('pembelian/input_bayar_hutang', $data);
    }

    public function input_pembelian()
    {
        $kode_kategori = $this->input->post('kode_kategori');
        $data['kategori'] = $this->Model_pembelian->kategori_barang();
        $data['supplier'] = $this->Model_pembelian->view_supplier();
        $data['barang'] = $this->Model_pembelian->view_barang($kode_kategori);
        $this->template->load('template/template', 'pembelian/input_pembelian', $data);
    }


    public function view_barang()
    {
        $data['barang'] = $this->Model_pembelian->view_barang()->result();
        $this->load->view('pembelian/view_barang', $data);
    }

    public function view_pembelian_temp()
    {
        $data['data'] = $this->Model_pembelian->view_pembelian_temp();
        $this->load->view('pembelian/view_pembelian_temp', $data);
    }

    public function insert_hutang()
    {
        $this->Model_pembelian->insert_hutang();
    }

    public function insert_pembelian()
    {
        $this->Model_pembelian->insert_pembelian();
    }

    public function insert_bayar_hutang()
    {
        $this->Model_pembelian->insert_bayar_hutang();
    }

    public function insert_pembelian_temp()
    {
        $this->Model_pembelian->insert_pembelian_temp();
    }

    public function hapus_pembelian_temp()
    {
        $this->Model_pembelian->hapus_pembelian_temp();
    }

    public function hapus_pembelian()
    {
        $this->Model_pembelian->hapus_pembelian();
    }

    public function codeotomatis()
    {
        $tahun    = date('y');
        $bulan    = date('m');
        $this->db->select('right(pembelian.no_fak_pemb,3) as kode ', false);
        $this->db->where('mid(no_fak_pemb,5,2)', $bulan);
        $this->db->where('mid(no_fak_pemb,7,2)', $tahun);
        $this->db->order_by('no_fak_pemb', 'desc');
        $this->db->limit('13');
        $query    = $this->db->get('pembelian');
        if ($query->num_rows() <> 0) {
            $data   = $query->row();
            $kode   = intval($data->kode) + 1;
        } else {
            $kode   = 1;
        }
        $kodemax  = str_pad($kode, 3, "0", STR_PAD_LEFT);
        echo "FAK-" . $bulan . "" . $tahun . "" . $kodemax;
    }
    
}
