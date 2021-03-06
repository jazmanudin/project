<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_login();
        $this->load->Model(array('Model_dashboard', 'Model_penjualan'));
    }

    public function view_dashboard()
    {
        $data['no_fak_penj']    = $this->input->post('no_fak_penj');
        $data['tgl_transaksi']  = $this->input->post('tgl_transaksi');
        $data['hariini']        = $this->Model_dashboard->jml_penj_bulan_ini()->num_rows();
        $data['totbulan']       = $this->Model_dashboard->total_penj_bulan_ini()->row_array();
        $data['data']       = $this->Model_dashboard->get_minstok_barang();
        $data['data']       = $this->Model_dashboard->get_barang_exp();
        $this->template->load('template/template', 'dashboard/view_dashboard', $data);
    }

}
