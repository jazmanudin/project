<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_login();
        $this->load->Model('Model_penjualan');
    }

    public function view_penjualan()
    {
        $data['no_fak_penj']    = $this->input->post('no_fak_penj');
        $data['tgl_transaksi']  = $this->input->post('tgl_transaksi');
        $data['data']           = $this->Model_penjualan->view_penjualan()->result();
        $this->template->load('template/template', 'penjualan/view_penjualan', $data);
    }

    public function detail_penjualan()
    {
        $data['data'] = $this->Model_penjualan->detail_penjualan()->result();
        $this->load->view('penjualan/detail_penjualan', $data);
    }

    public function input_bayar_piutang()
    {
        $data['getbayar'] = $this->Model_penjualan->bayar_piutang()->row_array();
        $this->load->view('penjualan/input_bayar_piutang', $data);
    }

    public function input_penjualan()
    {
        $kode_kategori = $this->input->post('kode_kategori');
        $data['kategori'] = $this->Model_penjualan->kategori_barang();
        $data['barang'] = $this->Model_penjualan->view_barang($kode_kategori);
        $this->template->load('template/template', 'penjualan/input_penjualan', $data);
    }


    public function view_barang()
    {
        $kode_kategori = $this->input->post('kode_kategori');
        $data['kategori'] = $this->Model_penjualan->kategori_barang();
        $data['barang'] = $this->Model_penjualan->view_barang($kode_kategori);
        $this->load->view('penjualan/view_barang', $data);
    }

    public function view_penjualan_temp()
    {
        $data['data'] = $this->Model_penjualan->view_penjualan_temp();
        $this->load->view('penjualan/view_penjualan_temp', $data);
    }

    public function insert_piutang()
    {
        $this->Model_penjualan->insert_piutang();
    }

    public function insert_penjualan()
    {
        $this->Model_penjualan->insert_penjualan();
    }

    public function insert_bayar_piutang()
    {
        $this->Model_penjualan->insert_bayar_piutang();
    }

    public function insert_penjualan_temp()
    {
        $this->Model_penjualan->insert_penjualan_temp();
    }

    public function hapus_penjualan_temp()
    {
        $this->Model_penjualan->hapus_penjualan_temp();
    }

    public function hapus_penjualan()
    {
        $this->Model_penjualan->hapus_penjualan();
    }
}
