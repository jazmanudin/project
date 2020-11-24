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

    function view_pemasukan($rowno = 0)
    {

        $no_pemasukan                = "";
        $jenis_pemasukan                = "";
        $dari                 = "";
        $sampai               = "";

        if ($this->input->post('submit') != NULL) {
            $no_pemasukan            = $this->input->post('no_pemasukan');
            $jenis_pemasukan            = $this->input->post('jenis_pemasukan');
            $dari             = $this->input->post('dari');
            $sampai           = $this->input->post('sampai');
            $data             = array(
                'no_pemasukan'              => $no_pemasukan,
                'jenis_pemasukan'              => $jenis_pemasukan,
                'dari'               => $dari,
                'sampai'             => $sampai,
            );
            $this->session->set_userdata($data);
        } else {

            if ($this->session->userdata('no_pemasukan') != NULL) {
                $no_pemasukan                    = $this->session->userdata('no_pemasukan');
            }

            if ($this->session->userdata('jenis_pemasukan') != NULL) {
                $jenis_pemasukan                    = $this->session->userdata('jenis_pemasukan');
            }

            if ($this->session->userdata('dari') != NULL) {
                $data['dari']             = $this->input->post('dari');
            }

            if ($this->session->userdata('sampai') != NULL) {
                $data['sampai']           = $this->input->post('sampai');
            }
        }
        $rowperpage = 10;
        if ($rowno != 0) {
            $rowno = ($rowno - 1) * $rowperpage;
        }
        $allcount                     = $this->Model_pemasukan->getRecordPemasukanCount($no_pemasukan, $jenis_pemasukan, $dari, $sampai);
        $users_record                 = $this->Model_pemasukan->getDataPemasukan($rowno, $rowperpage, $no_pemasukan, $jenis_pemasukan, $dari, $sampai);
        $config['base_url']           = base_url() . 'pemasukan/view_pemasukan';
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
        $data['no_pemasukan']         = $no_pemasukan;
        $data['jenis_pemasukan']      = $jenis_pemasukan;
        $data['dari']                 = $dari;
        $data['sampai']               = $sampai;
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
        $this->template->load('template/template', 'pemasukan/input_pemasukan');
    }

    public function edit_pemasukan()
    {
        $data['getdata'] = $this->Model_pemasukan->getPemasukan()->row_array();
        $this->template->load('template/template', 'pemasukan/edit_pemasukan', $data);
    }

    public function view_pemasukan_temp()
    {
        $data['data'] = $this->Model_pemasukan->view_pemasukan_temp();
        $this->load->view('pemasukan/view_pemasukan_temp', $data);
    }

    public function view_pemasukan_detail()
    {
        $data['data'] = $this->Model_pemasukan->view_pemasukan_detail();
        $this->load->view('pemasukan/view_pemasukan_detail', $data);
    }

    public function insert_hutang()
    {
        $this->Model_pemasukan->insert_hutang();
    }

    public function insert_pemasukan()
    {
        $this->Model_pemasukan->insert_pemasukan();
    }

    public function update_pemasukan()
    {
        $this->Model_pemasukan->update_pemasukan();
    }

    public function insert_pemasukan_temp()
    {
        $this->Model_pemasukan->insert_pemasukan_temp();
    }

    public function insert_pemasukan_detail()
    {
        $this->Model_pemasukan->insert_pemasukan_detail();
    }

    public function hapus_pemasukan_temp()
    {
        $this->Model_pemasukan->hapus_pemasukan_temp();
    }

    public function hapus_pemasukan_detail()
    {
        $this->Model_pemasukan->hapus_pemasukan_detail();
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

    public function get_barang()
    {
        $this->Model_pemasukan->get_barang();
    }

    public function get_barangbarcode()
    {
        $this->Model_pemasukan->get_barangbarcode();
    }
}
