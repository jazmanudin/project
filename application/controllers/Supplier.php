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

	public function view_supplier()
	{
		$data['data']   = $this->Model_supplier->view_supplier()->result();
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
