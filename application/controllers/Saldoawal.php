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

    function view_saldoawal($rowno    = 0)
    {

        $kode_saldoawal               = "";
        $bulan                        = "";
        $tahun                        = "";

        if ($this->input->post('submit') != NULL) {
            $kode_saldoawal           = $this->input->post('kode_saldoawal');
            $bulan                    = $this->input->post('bulan');
            $tahun                    = $this->input->post('tahun');
        }
        $rowperpage                   = 10;
        if ($rowno != 0) {
            $rowno = ($rowno - 1) * $rowperpage;
        }
        $allcount                     = $this->Model_saldoawal->getRecordSaldoawalCount($kode_saldoawal, $bulan, $tahun);
        $users_record                 = $this->Model_saldoawal->getDataSaldoawal($rowno, $rowperpage, $kode_saldoawal, $bulan, $tahun);
        $config['base_url']           = base_url() . 'saldoawal/view_saldoawal';
        $config['use_page_numbers']   = TRUE;
        $config['total_rows']         = $allcount;
        $config['per_page']           = $rowperpage;
        $config['first_link']         = 'First';
        $config['last_link']          = 'Last';
        $config['next_link']          = 'Next';
        $config['prev_link']          = 'Prev';
        $config['full_tag_open']      = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $config['full_tag_close']     = '</ul></nav></div>';
        $config['num_tag_open']       = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']      = '</span></li>';
        $config['cur_tag_open']       = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']      = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']      = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']    = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']      = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']    = '</span>Next</li>';
        $config['first_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close']   = '</span></li>';
        $config['last_tag_open']      = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']    = '</span></li>';
        $this->pagination->initialize($config);
        $data['pagination']           = $this->pagination->create_links();
        $data['data']                 = $users_record;
        $data['row']                  = $rowno;
        $data['kode_saldoawal']         = $kode_saldoawal;
        $data['bulans']                 = $bulan;
        $data['tahun']                  = $tahun;
        $data['bulan']                  = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
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

    public function edit_saldoawal()
    {
        $data['getdata']    = $this->Model_saldoawal->getSaldoawal()->row_array();
        $data['bulan']     = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        $data['tahun']     = date("Y");
        $this->template->load('template/template', 'saldoawal/edit_saldoawal', $data);
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

    public function view_saldoawal_detail()
    {
        $data['data'] = $this->Model_saldoawal->detail_saldoawal();
        $this->load->view('saldoawal/view_saldoawal_detail', $data);
    }

    public function insert_saldoawal()
    {
        $this->Model_saldoawal->insert_saldoawal();
    }

    public function hapus_saldoawal()
    {
        $this->Model_saldoawal->hapus_saldoawal();
    }

    public function insert_saldoawal_detail()
    {
        $this->Model_saldoawal->insert_saldoawal_detail();
    }
}
