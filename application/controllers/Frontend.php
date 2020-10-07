<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Frontend extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_login();
        $this->load->Model('Model_frontend');
    }

    public function index()
    {
        $kode_kategori = $this->input->post('kode_kategori');
        $data['kategori'] = $this->Model_frontend->kategori_barang();
        $data['barang'] = $this->Model_frontend->view_barang($kode_kategori);
        $this->template->load('template/template', 'frontend/view_frontend', $data);
    }

    public function view_barang()
    {
        $kode_kategori = $this->input->post('kode_kategori');
        $data['kategori'] = $this->Model_frontend->kategori_barang();
        $data['barang'] = $this->Model_frontend->view_barang($kode_kategori);
        $this->load->view('frontend/view_barang', $data);
    }

    public function view_penjualan_temp()
    {
        $data['data'] = $this->Model_frontend->view_penjualan_temp();
        $this->load->view('frontend/view_penjualan_temp', $data);
    }

    public function input_temp()
    {
         $this->Model_frontend->insert_temp();
    }

    public function hapus_temp()
    {
         $this->Model_frontend->hapus_temp();
    }
}
