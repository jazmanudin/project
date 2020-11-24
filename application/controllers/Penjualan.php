<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_login();
        $this->load->Model('Model_penjualan');
    }


    function view_penjualan($rowno = 0)
    {

        $no_fak_penj        = "";
        $kode_pelanggan     = "";
        $dari               = "";
        $sampai             = "";

        if ($this->input->post('submit') != NULL) {
            $no_fak_penj    = $this->input->post('no_fak_penj');
            $kode_pelanggan = $this->input->post('kode_pelanggan');
            $dari           = $this->input->post('dari');
            $sampai         = $this->input->post('sampai');
            $data           = array(
                'no_fak_penj'              => $no_fak_penj,
                'kode_pelanggan'           => $kode_pelanggan,
                'dari'                     => $dari,
                'sampai'                   => $sampai,
            );
            $this->session->set_userdata($data);
        } else {

            if ($this->session->userdata('no_fak_penj') != NULL) {
                $no_fak_penj                    = $this->session->userdata('no_fak_penj');
            }

            if ($this->session->userdata('kode_pelanggan') != NULL) {
                $data['kode_pelanggan']   = $this->input->post('kode_pelanggan');
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
        $allcount                     = $this->Model_penjualan->getRecordPenjualanCount($no_fak_penj, $kode_pelanggan, $dari, $sampai);
        $users_record                 = $this->Model_penjualan->getDataPenjualan($rowno, $rowperpage, $no_fak_penj, $kode_pelanggan, $dari, $sampai);
        $config['base_url']           = base_url() . 'penjualan/view_penjualan';
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
        $data['no_fak_penj']          = $no_fak_penj;
        $data['kode_pelanggan']       = $kode_pelanggan;
        $data['dari']                 = $dari;
        $data['sampai']               = $sampai;
        $data['pelanggan']            = $this->Model_penjualan->view_pelanggan();
        $this->template->load('template/template', 'penjualan/view_penjualan', $data);
    }

    
    function view_suratjalan($rowno = 0)
    {

        $no_fak_penj        = "";
        $kode_pelanggan     = "";
        $dari               = "";
        $sampai             = "";

        if ($this->input->post('submit') != NULL) {
            $no_fak_penj    = $this->input->post('no_fak_penj');
            $kode_pelanggan = $this->input->post('kode_pelanggan');
            $dari           = $this->input->post('dari');
            $sampai         = $this->input->post('sampai');
            $data           = array(
                'no_fak_penj'              => $no_fak_penj,
                'kode_pelanggan'           => $kode_pelanggan,
                'dari'                     => $dari,
                'sampai'                   => $sampai,
            );
            $this->session->set_userdata($data);
        } else {

            if ($this->session->userdata('no_fak_penj') != NULL) {
                $no_fak_penj                    = $this->session->userdata('no_fak_penj');
            }

            if ($this->session->userdata('kode_pelanggan') != NULL) {
                $data['kode_pelanggan']   = $this->input->post('kode_pelanggan');
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
        $allcount                     = $this->Model_penjualan->getRecordPenjualanCount($no_fak_penj, $kode_pelanggan, $dari, $sampai);
        $users_record                 = $this->Model_penjualan->getDataPenjualan($rowno, $rowperpage, $no_fak_penj, $kode_pelanggan, $dari, $sampai);
        $config['base_url']           = base_url() . 'penjualan/view_suratjalan';
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
        $data['no_fak_penj']          = $no_fak_penj;
        $data['kode_pelanggan']       = $kode_pelanggan;
        $data['dari']                 = $dari;
        $data['sampai']               = $sampai;
        $data['pelanggan']            = $this->Model_penjualan->view_pelanggan();
        $this->template->load('template/template', 'penjualan/view_suratjalan', $data);
    }

    public function detail_penjualan()
    {
        $data['penj']       = $this->Model_penjualan->view_penjualan()->row_array();
        $data['bayar']      = $this->Model_penjualan->view_histori_bayar()->result();
        $data['data']       = $this->Model_penjualan->detail_penjualan()->result();
        $this->load->view('penjualan/detail_penjualan', $data);
    }

    public function cetak_faktur()
    {
        $data['faktur']         = $this->Model_penjualan->cetak_faktur()->row_array();
        $data['data']           = $this->Model_penjualan->list_barang()->result();
        $this->load->view('penjualan/cetak_faktur', $data);
    }

    public function cetak_suratjalan()
    {
        $data['faktur']         = $this->Model_penjualan->cetak_faktur()->row_array();
        $data['data']           = $this->Model_penjualan->list_barang()->result();
        $this->load->view('penjualan/cetak_suratjalan', $data);
    }

    public function input_penjualan()
    {
        $data['salesorder'] = $this->Model_penjualan->view_salesorder()->row_array();
        $this->template->load('template/template', 'penjualan/input_penjualan', $data);
    }

    public function edit_penjualan()
    {
        $data['pelanggan']   = $this->Model_penjualan->view_pelanggan();
        $data['so']          = $this->Model_penjualan->getPenjualan();
        $this->template->load('template/template', 'penjualan/edit_penjualan', $data);
    }

    public function view_penjualan_temp()
    {
        $data['data'] = $this->Model_penjualan->view_penjualan_temp();
        $this->load->view('penjualan/view_penjualan_temp', $data);
    }

    public function view_penjualan_detail()
    {
        $data['data'] = $this->Model_penjualan->detail_penjualan();
        $this->load->view('penjualan/view_penjualan_detail', $data);
    }

    public function cetak_thermal()
    {
        $data['data'] = $this->Model_penjualan->cetak_thermal();
        $this->load->view('penjualan/cetak_thermal', $data);
    }

    public function insert_penjualan()
    {
        $this->Model_penjualan->insert_penjualan();
    }

    public function update_penjualan()
    {
        $this->Model_penjualan->update_penjualan();
    }

    public function insert_penjualan_temp()
    {
        $this->Model_penjualan->insert_penjualan_temp();
    }

    public function insert_penjualan_detail()
    {
        $this->Model_penjualan->insert_penjualan_detail();
    }

    public function hapus_penjualan_detail()
    {
        $this->Model_penjualan->hapus_penjualan_detail();
    }

    public function hapus_penjualan_temp()
    {
        $this->Model_penjualan->hapus_penjualan_temp();
    }

    public function hapus_penjualan()
    {
        $this->Model_penjualan->hapus_penjualan();
    }

    public function codeotomatis()
    {
        $this->Model_penjualan->codeotomatis();
    }

    public function cekbarang()
    {
        $this->Model_penjualan->cekbarang();
    }

    public function get_barang()
    {
        $this->Model_penjualan->get_barang();
    }

    public function get_barangbarcode()
    {
        $this->Model_penjualan->get_barangbarcode();
    }

    public function get_pelanggan()
    {
        $this->Model_penjualan->get_pelanggan();
    }
}
