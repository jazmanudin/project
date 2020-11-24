<?php
defined('BASEPATH') or exit('No direct script access allowed');

class pengeluaran extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_login();
        $this->load->Model('Model_pengeluaran');
    }

    function view_pengeluaran($rowno = 0)
    {

        $no_pengeluaran                = "";
        $jenis_pengeluaran                = "";
        $dari                 = "";
        $sampai               = "";

        if ($this->input->post('submit') != NULL) {
            $no_pengeluaran            = $this->input->post('no_pengeluaran');
            $jenis_pengeluaran            = $this->input->post('jenis_pengeluaran');
            $dari             = $this->input->post('dari');
            $sampai           = $this->input->post('sampai');
            $data             = array(
                'no_pengeluaran'              => $no_pengeluaran,
                'jenis_pengeluaran'              => $jenis_pengeluaran,
                'dari'               => $dari,
                'sampai'             => $sampai,
            );
            $this->session->set_userdata($data);
        } else {

            if ($this->session->userdata('no_pengeluaran') != NULL) {
                $no_pengeluaran                    = $this->session->userdata('no_pengeluaran');
            }

            if ($this->session->userdata('jenis_pengeluaran') != NULL) {
                $jenis_pengeluaran                    = $this->session->userdata('jenis_pengeluaran');
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
        $allcount                     = $this->Model_pengeluaran->getRecordpengeluaranCount($no_pengeluaran, $jenis_pengeluaran, $dari, $sampai);
        $users_record                 = $this->Model_pengeluaran->getDatapengeluaran($rowno, $rowperpage, $no_pengeluaran, $jenis_pengeluaran, $dari, $sampai);
        $config['base_url']           = base_url() . 'pengeluaran/view_pengeluaran';
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
        $data['no_pengeluaran']         = $no_pengeluaran;
        $data['jenis_pengeluaran']      = $jenis_pengeluaran;
        $data['dari']                 = $dari;
        $data['sampai']               = $sampai;
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
        $this->template->load('template/template', 'pengeluaran/input_pengeluaran');
    }

    public function edit_pengeluaran()
    {
        $data['getdata'] = $this->Model_pengeluaran->getpengeluaran()->row_array();
        $this->template->load('template/template', 'pengeluaran/edit_pengeluaran', $data);
    }

    public function view_pengeluaran_temp()
    {
        $data['data'] = $this->Model_pengeluaran->view_pengeluaran_temp();
        $this->load->view('pengeluaran/view_pengeluaran_temp', $data);
    }

    public function view_pengeluaran_detail()
    {
        $data['data'] = $this->Model_pengeluaran->view_pengeluaran_detail();
        $this->load->view('pengeluaran/view_pengeluaran_detail', $data);
    }

    public function insert_hutang()
    {
        $this->Model_pengeluaran->insert_hutang();
    }

    public function insert_pengeluaran()
    {
        $this->Model_pengeluaran->insert_pengeluaran();
    }

    public function update_pengeluaran()
    {
        $this->Model_pengeluaran->update_pengeluaran();
    }

    public function insert_pengeluaran_temp()
    {
        $this->Model_pengeluaran->insert_pengeluaran_temp();
    }

    public function insert_pengeluaran_detail()
    {
        $this->Model_pengeluaran->insert_pengeluaran_detail();
    }

    public function hapus_pengeluaran_temp()
    {
        $this->Model_pengeluaran->hapus_pengeluaran_temp();
    }

    public function hapus_pengeluaran_detail()
    {
        $this->Model_pengeluaran->hapus_pengeluaran_detail();
    }

    public function hapus_pengeluaran()
    {
        $this->Model_pengeluaran->hapus_pengeluaran();
    }

    public function codeotomatis()
    {
        $this->Model_pengeluaran->codeotomatis();
    }

    public function get_barang()
    {
        $this->Model_pengeluaran->get_barang();
    }

    public function get_barangbarcode()
    {
        $this->Model_pengeluaran->get_barangbarcode();
    }
}
