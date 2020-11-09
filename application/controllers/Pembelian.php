<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembelian extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_login();
        $this->load->Model('Model_pembelian');
    }

    function view_pembelian($rowno = 0)
    {

        $no_fak_pemb                = "";
        $kode_supplier        = "";
        $dari                 = "";
        $sampai               = "";

        if ($this->input->post('submit') != NULL) {
            $no_fak_pemb            = $this->input->post('no_fak_pemb');
            $kode_supplier    = $this->input->post('kode_supplier');
            $dari             = $this->input->post('dari');
            $sampai           = $this->input->post('sampai');
            $data             = array(
                'no_fak_pemb'              => $no_fak_pemb,
                'kode_supplier'      => $kode_supplier,
                'dari'               => $dari,
                'sampai'             => $sampai,
            );
            $this->session->set_userdata($data);
        } else {

            if ($this->session->userdata('no_fak_pemb') != NULL) {
                $no_fak_pemb                    = $this->session->userdata('no_fak_pemb');
            }

            if ($this->session->userdata('kode_supplier') != NULL) {
                $data['kode_supplier']    = $this->input->post('kode_supplier');
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
        $allcount                     = $this->Model_pembelian->getRecordPembelianCount($no_fak_pemb, $kode_supplier, $dari, $sampai);
        $users_record                 = $this->Model_pembelian->getDataPembelian($rowno, $rowperpage, $no_fak_pemb, $kode_supplier, $dari, $sampai);
        $config['base_url']           = base_url() . 'pembelian/view_pembelian';
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
        $data['no_fak_pemb']          = $no_fak_pemb;
        $data['kode_supplier']        = $kode_supplier;
        $data['dari']                 = $dari;
        $data['sampai']               = $sampai;
        $data['supplier']             = $this->Model_pembelian->view_supplier();
        $this->template->load('template/template', 'pembelian/view_pembelian', $data);
    }

    function view_histori_pembayaran($rowno = 0)
    {

        $no_fak_pemb          = "";
        $kode_supplier        = "";
        $dari                 = "";
        $sampai               = "";

        if ($this->input->post('submit') != NULL) {
            $no_fak_pemb      = $this->input->post('no_fak_pemb');
            $kode_supplier    = $this->input->post('kode_supplier');
            $dari             = $this->input->post('dari');
            $sampai           = $this->input->post('sampai');
            $data             = array(
                'no_fak_pemb'        => $no_fak_pemb,
                'kode_supplier'      => $kode_supplier,
                'dari'               => $dari,
                'sampai'             => $sampai,
            );
            $this->session->set_userdata($data);
        } else {

            if ($this->session->userdata('no_fak_pemb') != NULL) {
                $no_fak_pemb             = $this->session->userdata('no_fak_pemb');
            }

            if ($this->session->userdata('kode_supplier') != NULL) {
                $data['kode_supplier']    = $this->input->post('kode_supplier');
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
        $allcount                     = $this->Model_pembelian->getRecordPembayaranCount($no_fak_pemb, $kode_supplier, $dari, $sampai);
        $users_record                 = $this->Model_pembelian->getDataPembayaran($rowno, $rowperpage, $no_fak_pemb, $kode_supplier, $dari, $sampai);
        $config['base_url']           = base_url() . 'pembelian/view_histori_pembayaran';
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
        $data['no_fak_pemb']          = $no_fak_pemb;
        $data['kode_supplier']        = $kode_supplier;
        $data['dari']                 = $dari;
        $data['sampai']               = $sampai;
        $data['supplier']             = $this->Model_pembelian->view_supplier();
        $this->template->load('template/template', 'pembelian/view_histori_pembayaran', $data);
    }

    public function detail_pembelian()
    {
        $data['pemb']       = $this->Model_pembelian->view_pembelian()->row_array();
        $data['bayar']      = $this->Model_pembelian->view_histori_bayar()->result();
        $data['data']       = $this->Model_pembelian->detail_pembelian()->result();
        $this->load->view('pembelian/detail_pembelian', $data);
    }

    public function input_pembelian()
    {
        $data['supplier'] = $this->Model_pembelian->view_supplier();
        $this->template->load('template/template', 'pembelian/input_pembelian', $data);
    }

    public function edit_pembelian()
    {
        $data['supplier']   = $this->Model_pembelian->view_supplier();
        $data['getpemb']    = $this->Model_pembelian->getPembelian()->row_array();
        $this->template->load('template/template', 'pembelian/edit_pembelian', $data);
    }

    public function view_barang()
    {
        $data['barang'] = $this->Model_pembelian->view_barang()->result();
        $this->load->view('pembelian/view_barang', $data);
    }
  
    public function view_pembelian_temp()
    {
        $data['data'] = $this->Model_pembelian->view_pembelian_temp();
        $this->load->view('pembelian/view_pembelian_temp', $data);
    }

    public function view_pembelian_detail()
    {
        $data['data'] = $this->Model_pembelian->detail_pembelian();
        $this->load->view('pembelian/view_pembelian_detail', $data);
    }

    public function update_pembelian()
    {
        $this->Model_pembelian->update_pembelian();
    }

    public function insert_pembelian()
    {
        $this->Model_pembelian->insert_pembelian();
    }

    public function insert_bayar_hutang()
    {
        $this->Model_pembelian->insert_bayar_hutang();
    }

    public function insert_pembelian_temp()
    {
        $this->Model_pembelian->insert_pembelian_temp();
    }

    public function insert_pembelian_detail()
    {
        $this->Model_pembelian->insert_pembelian_detail();
    }

    public function hapus_pembelian_temp()
    {
        $this->Model_pembelian->hapus_pembelian_temp();
    }

    public function hapus_pembelian()
    {
        $this->Model_pembelian->hapus_pembelian();
    }

    public function codeotomatis()
    {
        $this->Model_pembelian->codeotomatis();
    }
 
    public function codeotomatispemb()
    {
        $this->Model_pembelian->codeotomatispemb();
    }

    public function cekbarang()
    {
        $this->Model_pembelian->cekbarang();
    }
}
