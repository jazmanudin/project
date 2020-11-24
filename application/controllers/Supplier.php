<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supplier extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		check_login();
		$this->load->Model('Model_supplier');
	}
	function view_supplier($rowno    = 0)
	{

		$kode_supplier               = "";
		$nama_supplier               = "";

		if ($this->input->post('submit') != NULL) {
			$kode_supplier           = $this->input->post('kode_supplier');
			$nama_supplier       	   = $this->input->post('nama_supplier');
		}
		$rowperpage                   = 10;
		if ($rowno != 0) {
			$rowno = ($rowno - 1) * $rowperpage;
		}
		$allcount                     = $this->Model_supplier->getRecordSupplierCount($kode_supplier, $nama_supplier,);
		$users_record                 = $this->Model_supplier->getDataSupplier($rowno, $rowperpage, $kode_supplier, $nama_supplier);
		$config['base_url']           = base_url() . 'supplier/view_supplier';
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
		$data['kode_supplier']        = $kode_supplier;
		$data['nama_supplier']        = $nama_supplier;
		$this->template->load('template/template', 'supplier/view_supplier', $data);
	}

	public function hapus_supplier()
	{
		$kode_supplier = $this->uri->segment(3);
		$this->db->query("DELETE FROM supplier WHERE kode_supplier = '$kode_supplier' ");
		redirect('supplier/view_supplier');
	}

	function insert_supplier()
	{
		$this->Model_supplier->insert_supplier();
	}
}
