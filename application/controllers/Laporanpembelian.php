<?php
defined('BASEPATH') or exit('No direct script access allowed');

class laporanpembelian extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_login();
        $this->load->Model('Model_laporanpembelian');
    }

    function pembelian()
    {
        $kode_supplier            = $this->input->post('kode_supplier');
        $data['supplier']  = $this->Model_laporanpembelian->getSupplier($kode_supplier);
        $this->template->load('template/template', 'laporanpembelian/pembelian', $data);
    }

    function cetak_pembelian()
    {

        $dari              = $this->input->post('dari');
        $sampai              = $this->input->post('sampai');
        $kode_supplier      = $this->input->post('kode_supplier');
        $data['sampai']      = $sampai;
        $data['dari']      = $dari;
        $data['kode_supplier']      = $kode_supplier;
        $data['supplier']  = $this->Model_laporanpembelian->getSupplier($kode_supplier)->row_array();
        $data['data']       = $this->Model_laporanpembelian->list_pembelian($dari, $sampai, $kode_supplier)->result();
        if (isset($_POST['export'])) {
            // Fungsi header dengan mengirimkan raw data excel
            header("Content-type: application/vnd-ms-excel");

            // Mendefinisikan nama file ekspor "hasil-export.xls"
            header("Content-Disposition: attachment; filename=Laporan Pembelian.xls");
        }
        $this->load->view('laporanpembelian/cetak_pembelian', $data);
    }

    function kartu_hutang()
    {
        $kode_supplier            = $this->input->post('kode_supplier');
        $data['supplier']  = $this->Model_laporanpembelian->getSupplier($kode_supplier);
        $this->template->load('template/template', 'laporanpembelian/kartu_hutang', $data);
    }

    function cetak_kartu_hutang()
    {

        $dari              = $this->input->post('dari');
        $sampai              = $this->input->post('sampai');
        $kode_supplier      = $this->input->post('kode_supplier');
        $data['sampai']      = $sampai;
        $data['dari']      = $dari;
        $data['kode_supplier']      = $kode_supplier;
        $data['supplier']  = $this->Model_laporanpembelian->getSupplier($kode_supplier)->row_array();
        $data['data']       = $this->Model_laporanpembelian->list_kartu_hutang($dari, $sampai, $kode_supplier)->result();
        if (isset($_POST['export'])) {
            // Fungsi header dengan mengirimkan raw data excel
            header("Content-type: application/vnd-ms-excel");

            // Mendefinisikan nama file ekspor "hasil-export.xls"
            header("Content-Disposition: attachment; filename=Laporan Kartu Hutang.xls");
        }
        $this->load->view('laporanpembelian/cetak_kartu_hutang', $data);
    }

    function pembelian_detail()
    {
        $kode_barang      = $this->input->post('kode_barang');
        $data['barang']   = $this->Model_laporanpembelian->getBarang($kode_barang);
        $this->template->load('template/template', 'laporanpembelian/pembelian_detail', $data);
    }

    function cetak_pembelian_detail()
    {

        $dari                   = $this->input->post('dari');
        $sampai                 = $this->input->post('sampai');
        $kode_barang            = $this->input->post('kode_barang');
        $data['sampai']         = $sampai;
        $data['dari']           = $dari;
        $data['kode_barang']    = $kode_barang;
        $data['barang']         = $this->Model_laporanpembelian->getBarang($kode_barang)->row_array();
        $data['data']           = $this->Model_laporanpembelian->list_detailpembelian($dari, $sampai, $kode_barang)->result();
        if (isset($_POST['export'])) {
            // Fungsi header dengan mengirimkan raw data excel
            header("Content-type: application/vnd-ms-excel");

            // Mendefinisikan nama file ekspor "hasil-export.xls"
            header("Content-Disposition: attachment; filename=Laporan Pembelian Per-Barang.xls");
        }
        $this->load->view('laporanpembelian/cetak_pembelian_detail', $data);
    }
}
