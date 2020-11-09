<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporangudang extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_login();
        $this->load->Model('Model_laporangudang');
    }

    function persediaan_barang()
    {
        $data['tahun']     = date("Y");
        $data['bulan']     = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        $kode_barang      = $this->input->post('kode_barang');
        $data['barang']  = $this->Model_laporangudang->getBarang($kode_barang);
        $this->template->load('template/template', 'laporangudang/persediaan_barang', $data);
    }

    function cetak_persediaan_barang()
    {

        $bulan           = $this->input->post('bulan');
        $tahun         = $this->input->post('tahun');
        $kode_barang    = $this->input->post('kode_barang');
        $data['tahun'] = $tahun;
        $data['bulan']   = $bulan;
        $data['kode_barang'] = $kode_barang;
        $data['barang']  = $this->Model_laporangudang->getBarang($kode_barang)->row_array();
        $data['data']   = $this->Model_laporangudang->list_persediaan_barang($bulan, $tahun, $kode_barang)->result();
        if (isset($_POST['export'])) {
            // Fungsi header dengan mengirimkan raw data excel
            header("Content-type: application/vnd-ms-excel");

            // Mendefinisikan nama file ekspor "hasil-export.xls"
            header("Content-Disposition: attachment; filename=Laporan Rekap Persediaan Barang.xls");
        }
        $this->load->view('laporangudang/cetak_persediaan_barang', $data);
    }

    function kartu_gudang()
    {
        $data['tahun']     = date("Y");
        $data['bulan']     = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        $kode_barang      = $this->input->post('kode_barang');
        $data['barang']  = $this->Model_laporangudang->getBarang($kode_barang);
        $this->template->load('template/template', 'laporangudang/kartu_gudang', $data);
    }

    function cetak_kartu_gudang()
    {

        $kode_kategori        = $this->input->post('kode_kategori');
        $kode_barang          = $this->input->post('kode_barang');
        $bulan                = $this->input->post('bulan');
        $tahun                = $this->input->post('tahun');
        $data['bulan']        = $bulan;
        $data['tahun']        = $tahun;
        $data['kode_barang']  = $kode_barang;
        $dari                 = $tahun . "-" . $bulan . "-" . "01";
        $data['saldoawal']    = $this->Model_laporangudang->saldoAwal($bulan, $tahun, $kode_barang)->row_array();
        $data['barang']       = $this->Model_laporangudang->getbarang($kode_barang)->row_array();
        $data['dari']         = $dari;
        $ceknextbulan = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        if (empty($tglnextbulan)) {
            $data['sampai']     = date("Y-m-t", strtotime($dari));
        } else {
            $data['sampai']     = $ceknextbulan;
        }

        $data['tglakhirpenerimaan'] = $tahun . "-" . $bulan . "-31";

        if (isset($_POST['export'])) {
            // Fungsi header dengan mengirimkan raw data excel
            header("Content-type: application/vnd-ms-excel");

            // Mendefinisikan nama file ekspor "hasil-export.xls"
            header("Content-Disposition: attachment; filename=Laporan Kartu Gudang.xls");
        }
        $this->load->view('laporangudang/cetak_kartu_gudang', $data);
    }

    function pemasukan()
    {
        $kode_barang      = $this->input->post('kode_barang');
        $data['barang']  = $this->Model_laporangudang->getBarang($kode_barang);
        $this->template->load('template/template', 'laporangudang/pemasukan', $data);
    }

    function cetak_pemasukan()
    {

        $dari                   = $this->input->post('dari');
        $sampai                 = $this->input->post('sampai');
        $kode_barang            = $this->input->post('kode_barang');
        $data['sampai']         = $sampai;
        $data['dari']           = $dari;
        $data['kode_barang']    = $kode_barang;
        $data['barang']         = $this->Model_laporangudang->getBarang($kode_barang)->row_array();
        $data['data']           = $this->Model_laporangudang->list_pemasukan($dari, $sampai, $kode_barang)->result();
        if (isset($_POST['export'])) {
            // Fungsi header dengan mengirimkan raw data excel
            header("Content-type: application/vnd-ms-excel");

            // Mendefinisikan nama file ekspor "hasil-export.xls"
            header("Content-Disposition: attachment; filename=Laporan Pemasukan Barang.xls");
        }
        $this->load->view('laporangudang/cetak_pemasukan', $data);
    }

    function pengeluaran()
    {
        $kode_barang      = $this->input->post('kode_barang');
        $data['barang']  = $this->Model_laporangudang->getBarang($kode_barang);
        $this->template->load('template/template', 'laporangudang/pengeluaran', $data);
    }

    function cetak_pengeluaran()
    {

        $dari                   = $this->input->post('dari');
        $sampai                 = $this->input->post('sampai');
        $kode_barang            = $this->input->post('kode_barang');
        $data['sampai']         = $sampai;
        $data['dari']           = $dari;
        $data['kode_barang']    = $kode_barang;
        $data['barang']         = $this->Model_laporangudang->getBarang($kode_barang)->row_array();
        $data['data']           = $this->Model_laporangudang->list_pengeluaran($dari, $sampai, $kode_barang)->result();
        if (isset($_POST['export'])) {
            // Fungsi header dengan mengirimkan raw data excel
            header("Content-type: application/vnd-ms-excel");

            // Mendefinisikan nama file ekspor "hasil-export.xls"
            header("Content-Disposition: attachment; filename=Laporan Pengeluaran Barang.xls");
        }
        $this->load->view('laporangudang/cetak_pengeluaran', $data);
    }
}
