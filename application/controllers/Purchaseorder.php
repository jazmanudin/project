<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Purchaseorder extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_login();
        $this->load->Model('Model_purchaseorder');
    }


    function view_purchaseorder($rowno = 0)
    {

        $no_po                = "";
        $kode_supplier        = "";
        $dari                 = "";
        $sampai               = "";

        if ($this->input->post('submit') != NULL) {
            $no_po            = $this->input->post('no_po');
            $kode_supplier    = $this->input->post('kode_supplier');
            $dari             = $this->input->post('dari');
            $sampai           = $this->input->post('sampai');
            $data             = array(
                'no_po'              => $no_po,
                'kode_supplier'      => $kode_supplier,
                'dari'               => $dari,
                'sampai'             => $sampai,
            );
            $this->session->set_userdata($data);
        } else {

            if ($this->session->userdata('no_po') != NULL) {
                $no_po                    = $this->session->userdata('no_po');
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
        $allcount                     = $this->Model_purchaseorder->getRecordPurchaseCount($no_po, $kode_supplier, $dari, $sampai);
        $users_record                 = $this->Model_purchaseorder->getDataPurchase($rowno, $rowperpage, $no_po, $kode_supplier, $dari, $sampai);
        $config['base_url']           = base_url() . 'purchaseorder/view_purchaseorder';
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
        $data['no_po']                = $no_po;
        $data['kode_supplier']        = $kode_supplier;
        $data['dari']                 = $dari;
        $data['sampai']               = $sampai;
        $data['supplier']             = $this->Model_purchaseorder->view_supplier();
        $this->template->load('template/template', 'purchaseorder/view_purchaseorder', $data);
    }

    public function detail_purchaseorder()
    {
        $data['data'] = $this->Model_purchaseorder->detail_purchaseorder()->result();
        $this->load->view('purchaseorder/detail_purchaseorder', $data);
    }

    public function input_purchaseorder()
    {
        $data['supplier'] = $this->Model_purchaseorder->view_supplier();
        $this->template->load('template/template', 'purchaseorder/input_purchaseorder', $data);
    }

    public function edit_purchaseorder()
    {
        $data['supplier']   = $this->Model_purchaseorder->view_supplier();
        $data['po']         = $this->Model_purchaseorder->getPurchase();
        $this->template->load('template/template', 'purchaseorder/edit_purchaseorder', $data);
    }

    public function view_purchaseorder_temp()
    {
        $data['data'] = $this->Model_purchaseorder->view_purchaseorder_temp();
        $this->load->view('purchaseorder/view_purchaseorder_temp', $data);
    }

    public function view_purchaseorder_detail()
    {
        $data['data'] = $this->Model_purchaseorder->detail_purchaseorder();
        $this->load->view('purchaseorder/view_purchaseorder_detail', $data);
    }

    public function insert_purchaseorder()
    {
        $this->Model_purchaseorder->insert_purchaseorder();
    }

    public function update_purchaseorder()
    {
        $this->Model_purchaseorder->update_purchaseorder();
    }

    public function insert_purchaseorder_temp()
    {
        $this->Model_purchaseorder->insert_purchaseorder_temp();
    }

    public function insert_purchaseorder_detail()
    {
        $this->Model_purchaseorder->insert_purchaseorder_detail();
    }

    public function hapus_purchaseorder_detail()
    {
        $this->Model_purchaseorder->hapus_purchaseorder_detail();
    }

    public function hapus_purchaseorder_temp()
    {
        $this->Model_purchaseorder->hapus_purchaseorder_temp();
    }

    public function hapus_purchaseorder()
    {
        $this->Model_purchaseorder->hapus_purchaseorder();
    }

    public function codeotomatis()
    {
        $this->Model_purchaseorder->codeotomatis();
    }

    public function get_supplier()
    {
        $this->Model_purchaseorder->get_supplier();
    }

    public function get_barang()
    {
        $this->Model_purchaseorder->get_barang();
    }

    public function get_barangbarcode()
    {
        $this->Model_purchaseorder->get_barangbarcode();
    }
}
