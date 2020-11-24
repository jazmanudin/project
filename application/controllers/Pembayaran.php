<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembayaran extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_login();
        $this->load->Model('Model_pembayaran');
    }

    function view_pembayaran_hutang($rowno = 0)
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
        $allcount                     = $this->Model_pembayaran->getRecordPembayaranHutangCount($no_fak_pemb, $kode_supplier, $dari, $sampai);
        $users_record                 = $this->Model_pembayaran->getDataPembayaranHutang($rowno, $rowperpage, $no_fak_pemb, $kode_supplier, $dari, $sampai);
        $config['base_url']           = base_url() . 'pembayaran/view_histori_pembayaran';
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
        $data['supplier']             = $this->Model_pembayaran->view_supplier();
        $this->template->load('template/template', 'pembayaran/view_pembayaran_hutang', $data);
    }

    public function codeotomatispemb()
    {
        $this->Model_pembayaran->codeotomatispemb();
    }

    public function view_pembayaran_hutang_temp()
    {
        $data['data'] = $this->Model_pembayaran->view_pembayaran_hutang_temp();
        $this->load->view('pembayaran/view_pembayaran_hutang_temp', $data);
    }
    
    public function view_pembayaran_hutang_detail()
    {
        $data['data'] = $this->Model_pembayaran->view_pembayaran_hutang_detail();
        $this->load->view('pembayaran/view_pembayaran_hutang_detail', $data);
    }

    public function detail_pembayaran_hutang()
    {
        $data['detail'] = $this->Model_pembayaran->detail_pembayaran_hutang()->row_array();
        $data['data']   = $this->Model_pembayaran->detail_pembayaran_hutang()->result();
        $this->load->view('pembayaran/detail_pembayaran_hutang', $data);
    }

    public function detail_pembelian()
    {
        $data['data']   = $this->Model_pembayaran->detail_pembelian()->result();
        $this->load->view('pembayaran/detail_pembelian', $data);
    }

    public function input_bayar_hutang()
    {
        $data['supplier']   = $this->Model_pembayaran->view_supplier();
        $this->template->load('template/template', 'pembayaran/input_bayar_hutang', $data);
    }

    public function edit_pembayaran_hutang()
    {
        $data['supplier']   = $this->Model_pembayaran->view_supplier();
        $data['edit']       = $this->Model_pembayaran->getPembayaranHutang()->row_array();
        $this->template->load('template/template', 'pembayaran/edit_pembayaran_hutang', $data);
    }

    public function insert_pembayaran_hutang()
    {
        $this->Model_pembayaran->insert_pembayaran_hutang();
    }
    
    public function update_pembayaran_hutang()
    {
        $this->Model_pembayaran->update_pembayaran_hutang();
    }

    public function insert_pembayaran_hutang_temp()
    {
        $this->Model_pembayaran->insert_pembayaran_hutang_temp();
    }

    public function insert_pembayaran_hutang_detail()
    {
        $this->Model_pembayaran->insert_pembayaran_hutang_detail();
    }

    public function hapus_pembayaran_hutang_temp()
    {
        $this->Model_pembayaran->hapus_pembayaran_hutang_temp();
    }

    public function hapus_pembayaran_hutang_detail()
    {
        $this->Model_pembayaran->hapus_pembayaran_hutang_detail();
    }

    public function hapus_pembayaran_hutang()
    {
        $this->Model_pembayaran->hapus_pembayaran_hutang();
    }

    public function get_supplier()
    {
        $this->Model_pembayaran->get_supplier();
    }

    public function get_faktur_pembelian()
    {
        $this->Model_pembayaran->get_faktur_pembelian();
    }


    function view_pembayaran_piutang($rowno = 0)
    {

        $no_fak_pemb          = "";
        $kode_pelanggan        = "";
        $dari                 = "";
        $sampai               = "";

        if ($this->input->post('submit') != NULL) {
            $no_fak_pemb      = $this->input->post('no_fak_pemb');
            $kode_pelanggan    = $this->input->post('kode_pelanggan');
            $dari             = $this->input->post('dari');
            $sampai           = $this->input->post('sampai');
            $data             = array(
                'no_fak_pemb'        => $no_fak_pemb,
                'kode_pelanggan'      => $kode_pelanggan,
                'dari'               => $dari,
                'sampai'             => $sampai,
            );
            $this->session->set_userdata($data);
        } else {

            if ($this->session->userdata('no_fak_pemb') != NULL) {
                $no_fak_pemb             = $this->session->userdata('no_fak_pemb');
            }

            if ($this->session->userdata('kode_pelanggan') != NULL) {
                $data['kode_pelanggan']    = $this->input->post('kode_pelanggan');
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
        $allcount                     = $this->Model_pembayaran->getRecordPembayaranpiutangCount($no_fak_pemb, $kode_pelanggan, $dari, $sampai);
        $users_record                 = $this->Model_pembayaran->getDataPembayaranpiutang($rowno, $rowperpage, $no_fak_pemb, $kode_pelanggan, $dari, $sampai);
        $config['base_url']           = base_url() . 'pembayaran/view_histori_pembayaran';
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
        $data['kode_pelanggan']        = $kode_pelanggan;
        $data['dari']                 = $dari;
        $data['sampai']               = $sampai;
        $data['pelanggan']             = $this->Model_pembayaran->view_pelanggan();
        $this->template->load('template/template', 'pembayaran/view_pembayaran_piutang', $data);
    }

    public function codeotomatispenj()
    {
        $this->Model_pembayaran->codeotomatispenj();
    }

    public function view_pembayaran_piutang_temp()
    {
        $data['data'] = $this->Model_pembayaran->view_pembayaran_piutang_temp();
        $this->load->view('pembayaran/view_pembayaran_piutang_temp', $data);
    }
    
    public function view_pembayaran_piutang_detail()
    {
        $data['data'] = $this->Model_pembayaran->view_pembayaran_piutang_detail();
        $this->load->view('pembayaran/view_pembayaran_piutang_detail', $data);
    }

    public function detail_pembayaran_piutang()
    {
        $data['detail'] = $this->Model_pembayaran->detail_pembayaran_piutang()->row_array();
        $data['data']   = $this->Model_pembayaran->detail_pembayaran_piutang()->result();
        $this->load->view('pembayaran/detail_pembayaran_piutang', $data);
    }

    public function detail_penjualan()
    {
        $data['data']   = $this->Model_pembayaran->detail_penjualan()->result();
        $this->load->view('pembayaran/detail_penjualan', $data);
    }

    public function input_bayar_piutang()
    {
        $data['pelanggan']   = $this->Model_pembayaran->view_pelanggan();
        $this->template->load('template/template', 'pembayaran/input_bayar_piutang', $data);
    }

    public function edit_pembayaran_piutang()
    {
        $data['pelanggan']   = $this->Model_pembayaran->view_pelanggan();
        $data['edit']       = $this->Model_pembayaran->getPembayaranpiutang()->row_array();
        $this->template->load('template/template', 'pembayaran/edit_pembayaran_piutang', $data);
    }

    public function insert_pembayaran_piutang()
    {
        $this->Model_pembayaran->insert_pembayaran_piutang();
    }
    
    public function update_pembayaran_piutang()
    {
        $this->Model_pembayaran->update_pembayaran_piutang();
    }

    public function insert_pembayaran_piutang_temp()
    {
        $this->Model_pembayaran->insert_pembayaran_piutang_temp();
    }

    public function insert_pembayaran_piutang_detail()
    {
        $this->Model_pembayaran->insert_pembayaran_piutang_detail();
    }

    public function hapus_pembayaran_piutang_temp()
    {
        $this->Model_pembayaran->hapus_pembayaran_piutang_temp();
    }

    public function hapus_pembayaran_piutang_detail()
    {
        $this->Model_pembayaran->hapus_pembayaran_piutang_detail();
    }

    public function hapus_pembayaran_piutang()
    {
        $this->Model_pembayaran->hapus_pembayaran_piutang();
    }

    public function get_pelanggan()
    {
        $this->Model_pembayaran->get_pelanggan();
    }

    public function get_faktur_penjualan()
    {
        $this->Model_pembayaran->get_faktur_penjualan();
    }
}
