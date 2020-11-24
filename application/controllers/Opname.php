<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Opname extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_login();
        $this->load->Model('Model_opname');
    }

    function view_opname($rowno = 0)
    {

        $kode_opname                = "";
        $bulan                 = "";
        $tahun               = "";

        if ($this->input->post('submit') != NULL) {
            $kode_opname            = $this->input->post('kode_opname');
            $bulan             = $this->input->post('bulan');
            $tahun           = $this->input->post('tahun');
        }
        $rowperpage = 10;
        if ($rowno != 0) {
            $rowno = ($rowno - 1) * $rowperpage;
        }
        $allcount                     = $this->Model_opname->getRecordOpnameCount($kode_opname, $bulan, $tahun);
        $users_record                 = $this->Model_opname->getDataOpname($rowno, $rowperpage, $kode_opname, $bulan, $tahun);
        $config['base_url']           = base_url() . 'opname/view_opname';
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
        $data['kode_opname']         = $kode_opname;
        $data['bulans']                 = $bulan;
        $data['tahun']                  = $tahun;
        $data['bulan']                  = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        $this->template->load('template/template', 'opname/view_opname', $data);
    }

    public function detail_opname()
    {
        $data['data'] = $this->Model_opname->detail_opname()->result();
        $this->load->view('opname/detail_opname', $data);
    }

    public function input_opname()
    {
        $data['tahun']     = date("Y");
        $data['bulan']     = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        $this->template->load('template/template', 'opname/input_opname', $data);
    }

    public function edit_opname()
    {
        $data['getdata']    = $this->Model_opname->getopname()->row_array();
        $data['bulan']     = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        $data['tahun']     = date("Y");
        $this->template->load('template/template', 'opname/edit_opname', $data);
    }

    function getdetailopname()
    {

        $bulan          = $this->input->post('bulan');
        $tahun          = $this->input->post('tahun');
        $cekopname       = $this->Model_opname->cekopname($bulan, $tahun)->num_rows();
        $cekall         = $this->Model_opname->cekopnameall()->num_rows();
        $data['cek']    = $cekopname;
        $ceknow         = $this->Model_opname->cekopnameSkrg($bulan, $tahun)->num_rows();
        if (empty($cekopname) && !empty($cekall) || !empty($ceknow)) {
            echo "1";
        } else {
            $data['data'] = $this->Model_opname->getdetailopname($bulan, $tahun);
            $this->load->view('opname/view_opname_temp', $data);
        }
    }

    public function view_opname_detail()
    {
        $data['data'] = $this->Model_opname->detail_opname();
        $this->load->view('opname/view_opname_detail', $data);
    }

    public function insert_opname()
    {
        $this->Model_opname->insert_opname();
    }

    public function hapus_opname()
    {
        $this->Model_opname->hapus_opname();
    }

    public function insert_opname_detail()
    {
        $this->Model_opname->insert_opname_detail();
    }
}
