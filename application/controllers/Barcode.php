<?php
defined('BASEPATH') or exit('No direct script access allowed');

class barcode extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_login();
        $this->load->Model('Model_barcode');
    }

    public function input_barcode()
    {
        $this->template->load('template/template', 'barcode/input_barcode');
    }

    public function insert_barcode()
    {
        $this->Model_barcode->insert_barcode();
    }

    function getdetailbarcode()
    {
        $data['data'] = $this->Model_barcode->getdetailbarcode();
        $this->load->view('barcode/view_barcode_temp', $data);
    }
}
