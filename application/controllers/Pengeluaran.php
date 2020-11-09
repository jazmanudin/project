<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengeluaran extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_login();
        $this->load->Model('Model_pengeluaran');
    }

    public function view_pengeluaran()
    {
        $data['no_pengeluaran']   = $this->input->post('no_pengeluaran');
        $data['dari']           = $this->input->post('dari');
        $data['sampai']         = $this->input->post('sampai');
        $data['data']           = $this->Model_pengeluaran->view_pengeluaran()->result();
        $this->template->load('template/template', 'pengeluaran/view_pengeluaran', $data);
    }

    public function detail_pengeluaran()
    {
        $data['data'] = $this->Model_pengeluaran->detail_pengeluaran()->result();
        $this->load->view('pengeluaran/detail_pengeluaran', $data);
    }

    public function input_bayar_hutang()
    {
        $data['getbayar'] = $this->Model_pengeluaran->bayar_hutang()->row_array();
        $this->load->view('pengeluaran/input_bayar_hutang', $data);
    }

    public function input_pengeluaran()
    {
        $kode_kategori = $this->input->post('kode_kategori');
        $data['kategori'] = $this->Model_pengeluaran->kategori_barang();
        $data['supplier'] = $this->Model_pengeluaran->view_supplier();
        $data['barang'] = $this->Model_pengeluaran->view_barang($kode_kategori);
        $this->template->load('template/template', 'pengeluaran/input_pengeluaran', $data);
    }


    public function view_barang()
    {
        $data['barang'] = $this->Model_pengeluaran->view_barang()->result();
        $this->load->view('pengeluaran/view_barang', $data);
    }

    public function view_pengeluaran_temp()
    {
        $data['data'] = $this->Model_pengeluaran->view_pengeluaran_temp();
        $this->load->view('pengeluaran/view_pengeluaran_temp', $data);
    }

    public function insert_hutang()
    {
        $this->Model_pengeluaran->insert_hutang();
    }

    public function insert_pengeluaran()
    {
        $this->Model_pengeluaran->insert_pengeluaran();
    }

    public function insert_bayar_hutang()
    {
        $this->Model_pengeluaran->insert_bayar_hutang();
    }

    public function insert_pengeluaran_temp()
    {
        $this->Model_pengeluaran->insert_pengeluaran_temp();
    }

    public function hapus_pengeluaran_temp()
    {
        $this->Model_pengeluaran->hapus_pengeluaran_temp();
    }

    public function hapus_pengeluaran()
    {
        $this->Model_pengeluaran->hapus_pengeluaran();
    }

    public function codeotomatis()
    {
        $this->Model_pengeluaran->codeotomatis();
    }

    public function cekbarang()
    {
        $this->Model_pengeluaran->cekbarang();
    }
}
