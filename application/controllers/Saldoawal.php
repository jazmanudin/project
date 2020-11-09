<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Saldoawal extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_login();
        $this->load->Model('Model_saldoawal');
    }

    public function view_saldoawal()
    {
        $data['kode_saldoawal']     = $this->input->post('kode_saldoawal');
        $data['bulans']             = $this->input->post('bulan');
        $data['tahuns']             = $this->input->post('tahun');
        $data['bulan']              = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        $data['data']               = $this->Model_saldoawal->view_saldoawal()->result();
        $this->template->load('template/template', 'saldoawal/view_saldoawal', $data);
    }

    public function detail_saldoawal()
    {
        $data['data'] = $this->Model_saldoawal->detail_saldoawal()->result();
        $this->load->view('saldoawal/detail_saldoawal', $data);
    }

    public function input_saldoawal()
    {
        $data['tahun']     = date("Y");
        $data['bulan']     = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        $this->template->load('template/template', 'saldoawal/input_saldoawal', $data);
    }


    function getdetailsaldo()
    {

        $bulan          = $this->input->post('bulan');
        $tahun          = $this->input->post('tahun');
        $ceksaldo       = $this->Model_saldoawal->ceksaldo($bulan, $tahun)->num_rows();
        $cekall         = $this->Model_saldoawal->ceksaldoall()->num_rows();
        $data['cek']    = $ceksaldo;
        $ceknow         = $this->Model_saldoawal->ceksaldoSkrg($bulan, $tahun)->num_rows();
        if (empty($ceksaldo) && !empty($cekall) || !empty($ceknow)) {
            echo "1";
        } else {
            $data['data'] = $this->Model_saldoawal->getdetailsaldo($bulan, $tahun);
            $this->load->view('saldoawal/view_saldoawal_temp', $data);
        }
    }

    public function view_saldoawal_temp()
    {
        $data['data'] = $this->Model_saldoawal->view_saldoawal_temp();
        $this->load->view('saldoawal/view_saldoawal_temp', $data);
    }

    public function insert_saldoawal()
    {
        $this->Model_saldoawal->insert_saldoawal();
    }
}
