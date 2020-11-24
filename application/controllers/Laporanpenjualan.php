<?php
defined('BASEPATH') or exit('No direct script access allowed');

class laporanpenjualan extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_login();
        $this->load->Model('Model_laporanpenjualan');
    }

    function rekap_penjualan_barang()
    {
        $kode_barang                    = $this->input->post('kode_barang');
        $data['barang']               = $this->Model_laporanpenjualan->getBarang($kode_barang);
        $this->template->load('template/template', 'laporanpenjualan/rekap_penjualan_barang', $data);
    }

    function cetak_rekap_penjualan_barang()
    {

        $dari                   = $this->input->post('dari');
        $sampai                 = $this->input->post('sampai');
        $kode_barang            = $this->input->post('kode_barang');
        $data['sampai']         = $sampai;
        $data['dari']           = $dari;
        $data['kode_barang']    = $kode_barang;
        $data['data']           = $this->Model_laporanpenjualan->list_rekap_penjualan_barang($dari, $sampai, $kode_barang)->result();
        if (isset($_POST['export'])) {
            // Fungsi header dengan mengirimkan raw data excel
            header("Content-type: application/vnd-ms-excel");

            // Mendefinisikan nama file ekspor "hasil-export.xls"
            header("Content-Disposition: attachment; filename=Laporan Rekap Penjualan Per-Sales.xls");
        }
        $this->load->view('laporanpenjualan/cetak_rekap_penjualan_barang', $data);
    }

    function rekap_penjualan_sales()
    {
        $nik                    = $this->input->post('nik');
        $data['karyawan']       = $this->Model_laporanpenjualan->getKaryawan($nik);
        $this->template->load('template/template', 'laporanpenjualan/rekap_penjualan_sales', $data);
    }

    function cetak_rekap_penjualan_sales()
    {

        $dari              = $this->input->post('dari');
        $sampai              = $this->input->post('sampai');
        $id_sales              = $this->input->post('nik');
        $data['sampai']      = $sampai;
        $data['dari']      = $dari;
        $data['id_sales']      = $id_sales;
        $data['data']       = $this->Model_laporanpenjualan->list_rekap_penjualan_sales($dari, $sampai, $id_sales)->result();
        if (isset($_POST['export'])) {
            // Fungsi header dengan mengirimkan raw data excel
            header("Content-type: application/vnd-ms-excel");

            // Mendefinisikan nama file ekspor "hasil-export.xls"
            header("Content-Disposition: attachment; filename=Laporan Rekap Penjualan Per-Sales.xls");
        }
        $this->load->view('laporanpenjualan/cetak_rekap_penjualan_sales', $data);
    }

    function penjualan()
    {
        $kode_pelanggan            = $this->input->post('kode_pelanggan');
        $data['pelanggan']  = $this->Model_laporanpenjualan->getpelanggan($kode_pelanggan);
        $this->template->load('template/template', 'laporanpenjualan/penjualan', $data);
    }

    function cetak_penjualan()
    {

        $dari              = $this->input->post('dari');
        $sampai              = $this->input->post('sampai');
        $kode_pelanggan      = $this->input->post('kode_pelanggan');
        $data['sampai']      = $sampai;
        $data['dari']      = $dari;
        $data['kode_pelanggan']      = $kode_pelanggan;
        $data['pelanggan']  = $this->Model_laporanpenjualan->getpelanggan($kode_pelanggan)->row_array();
        $data['data']       = $this->Model_laporanpenjualan->list_penjualan($dari, $sampai, $kode_pelanggan)->result();
        if (isset($_POST['export'])) {
            // Fungsi header dengan mengirimkan raw data excel
            header("Content-type: application/vnd-ms-excel");

            // Mendefinisikan nama file ekspor "hasil-export.xls"
            header("Content-Disposition: attachment; filename=Laporan penjualan.xls");
        }
        $this->load->view('laporanpenjualan/cetak_penjualan', $data);
    }

    function kartu_piutang()
    {
        $kode_pelanggan            = $this->input->post('kode_pelanggan');
        $data['pelanggan']  = $this->Model_laporanpenjualan->getpelanggan($kode_pelanggan);
        $this->template->load('template/template', 'laporanpenjualan/kartu_piutang', $data);
    }

    function cetak_kartu_piutang()
    {

        $dari              = $this->input->post('dari');
        $sampai              = $this->input->post('sampai');
        $kode_pelanggan      = $this->input->post('kode_pelanggan');
        $data['sampai']      = $sampai;
        $data['dari']      = $dari;
        $data['kode_pelanggan']      = $kode_pelanggan;
        $data['pelanggan']  = $this->Model_laporanpenjualan->getpelanggan($kode_pelanggan)->row_array();
        $data['data']       = $this->Model_laporanpenjualan->list_kartu_piutang($dari, $sampai, $kode_pelanggan)->result();
        if (isset($_POST['export'])) {
            // Fungsi header dengan mengirimkan raw data excel
            header("Content-type: application/vnd-ms-excel");

            // Mendefinisikan nama file ekspor "hasil-export.xls"
            header("Content-Disposition: attachment; filename=Laporan Kartu piutang.xls");
        }
        $this->load->view('laporanpenjualan/cetak_kartu_piutang', $data);
    }

    function penjualan_detail()
    {
        $kode_barang      = $this->input->post('kode_barang');
        $data['barang']   = $this->Model_laporanpenjualan->getBarang($kode_barang);
        $this->template->load('template/template', 'laporanpenjualan/penjualan_detail', $data);
    }

    function cetak_penjualan_detail()
    {

        $dari                   = $this->input->post('dari');
        $sampai                 = $this->input->post('sampai');
        $kode_barang            = $this->input->post('kode_barang');
        $data['sampai']         = $sampai;
        $data['dari']           = $dari;
        $data['kode_barang']    = $kode_barang;
        $data['barang']         = $this->Model_laporanpenjualan->getBarang($kode_barang)->row_array();
        $data['data']           = $this->Model_laporanpenjualan->list_detailpenjualan($dari, $sampai, $kode_barang)->result();
        if (isset($_POST['export'])) {
            // Fungsi header dengan mengirimkan raw data excel
            header("Content-type: application/vnd-ms-excel");

            // Mendefinisikan nama file ekspor "hasil-export.xls"
            header("Content-Disposition: attachment; filename=Laporan penjualan Per-Barang.xls");
        }
        $this->load->view('laporanpenjualan/cetak_penjualan_detail', $data);
    }
}
