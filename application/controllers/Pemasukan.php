<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pemasukan extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_login();
        $this->load->Model('Model_pemasukan');
    }

    public function view_pemasukan()
    {
        $data['no_pemasukan']   = $this->input->post('no_pemasukan');
        $data['dari']           = $this->input->post('dari');
        $data['sampai']         = $this->input->post('sampai');
        $data['data']           = $this->Model_pemasukan->view_pemasukan()->result();
        $this->template->load('template/template', 'pemasukan/view_pemasukan', $data);
    }

    public function detail_pemasukan()
    {
        $data['data'] = $this->Model_pemasukan->detail_pemasukan()->result();
        $this->load->view('pemasukan/detail_pemasukan', $data);
    }

    public function input_bayar_hutang()
    {
        $data['getbayar'] = $this->Model_pemasukan->bayar_hutang()->row_array();
        $this->load->view('pemasukan/input_bayar_hutang', $data);
    }

    public function input_pemasukan()
    {
        $kode_kategori = $this->input->post('kode_kategori');
        $data['kategori'] = $this->Model_pemasukan->kategori_barang();
        $data['supplier'] = $this->Model_pemasukan->view_supplier();
        $data['barang'] = $this->Model_pemasukan->view_barang($kode_kategori);
        $this->template->load('template/template', 'pemasukan/input_pemasukan', $data);
    }


    public function view_barang()
    {
        $data['barang'] = $this->Model_pemasukan->view_barang()->result();
        $this->load->view('pemasukan/view_barang', $data);
    }

    public function view_pemasukan_temp()
    {
        $data['data'] = $this->Model_pemasukan->view_pemasukan_temp();
        $this->load->view('pemasukan/view_pemasukan_temp', $data);
    }

    public function insert_hutang()
    {
        $this->Model_pemasukan->insert_hutang();
    }

    public function insert_pemasukan()
    {
        $this->Model_pemasukan->insert_pemasukan();
    }

    public function insert_bayar_hutang()
    {
        $this->Model_pemasukan->insert_bayar_hutang();
    }

    public function insert_pemasukan_temp()
    {
        $this->Model_pemasukan->insert_pemasukan_temp();
    }

    public function hapus_pemasukan_temp()
    {
        $this->Model_pemasukan->hapus_pemasukan_temp();
    }

    public function hapus_pemasukan()
    {
        $this->Model_pemasukan->hapus_pemasukan();
    }

    public function codeotomatis()
    {
        $this->Model_pemasukan->codeotomatis();
    }

    public function cekbarang()
    {
        $this->Model_pemasukan->cekbarang();
    }
}
