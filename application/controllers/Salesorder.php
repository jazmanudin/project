<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Salesorder extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_login();
        $this->load->Model('Model_salesorder');
    }


    function view_salesorder($rowno = 0)
    {

        $no_so                = "";
        $kode_pelanggan       = "";
        $dari                 = "";
        $sampai               = "";

        if ($this->input->post('submit') != NULL) {
            $no_so            = $this->input->post('no_so');
            $kode_pelanggan    = $this->input->post('kode_pelanggan');
            $dari             = $this->input->post('dari');
            $sampai           = $this->input->post('sampai');
        }
        $rowperpage = 10;
        if ($rowno != 0) {
            $rowno = ($rowno - 1) * $rowperpage;
        }
        $allcount                     = $this->Model_salesorder->getRecordSalesOrderCount($no_so, $kode_pelanggan, $dari, $sampai);
        $users_record                 = $this->Model_salesorder->getDataSalesOrder($rowno, $rowperpage, $no_so, $kode_pelanggan, $dari, $sampai);
        $config['base_url']           = base_url() . 'salesorder/view_salesorder';
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
        $data['no_so']                = $no_so;
        $data['kode_pelanggan']       = $kode_pelanggan;
        $data['dari']                 = $dari;
        $data['sampai']               = $sampai;
        $data['pelanggan']             = $this->Model_salesorder->view_pelanggan();
        $this->template->load('template/template', 'salesorder/view_salesorder', $data);
    }

    public function detail_salesorder()
    {
        $data['data'] = $this->Model_salesorder->detail_salesorder()->result();
        $this->load->view('salesorder/detail_salesorder', $data);
    }

    public function input_salesorder()
    {
        $data['pelanggan'] = $this->Model_salesorder->view_pelanggan();
        $this->template->load('template/template', 'salesorder/input_salesorder', $data);
    }

    public function edit_salesorder()
    {
        $data['pelanggan']   = $this->Model_salesorder->view_pelanggan();
        $data['so']         = $this->Model_salesorder->getSalesOrder();
        $this->template->load('template/template', 'salesorder/edit_salesorder', $data);
    }

    public function view_barang()
    {
        $data['barang'] = $this->Model_salesorder->view_barang();
        $this->load->view('salesorder/view_barang', $data);
    }

    public function view_salesorder_temp()
    {
        $data['data'] = $this->Model_salesorder->view_salesorder_temp();
        $this->load->view('salesorder/view_salesorder_temp', $data);
    }

    public function view_salesorder_detail()
    {
        $data['data'] = $this->Model_salesorder->detail_salesorder();
        $this->load->view('salesorder/view_salesorder_detail', $data);
    }

    public function insert_salesorder()
    {
        $this->Model_salesorder->insert_salesorder();
    }

    public function update_salesorder()
    {
        $this->Model_salesorder->update_salesorder();
    }

    public function insert_salesorder_temp()
    {
        $this->Model_salesorder->insert_salesorder_temp();
    }

    public function insert_salesorder_detail()
    {
        $this->Model_salesorder->insert_salesorder_detail();
    }

    public function hapus_salesorder_detail()
    {
        $this->Model_salesorder->hapus_salesorder_detail();
    }

    public function hapus_salesorder_temp()
    {
        $this->Model_salesorder->hapus_salesorder_temp();
    }

    public function hapus_salesorder()
    {
        $this->Model_salesorder->hapus_salesorder();
    }

    public function codeotomatis()
    {
        $this->Model_salesorder->codeotomatis();
    }

    public function get_barang()
    {
        $this->Model_salesorder->get_barang();
    }

    public function get_pelanggan()
    {
        $this->Model_salesorder->get_pelanggan();
    }
}
