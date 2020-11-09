<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pelanggan extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		check_login();
		$this->load->Model('Model_pelanggan');
	}

	public function view_pelanggan()
	{
		$data['data']   = $this->Model_pelanggan->view_pelanggan()->result();
		$this->template->load('template/template', 'pelanggan/view_pelanggan', $data);
	}

	public function hapus_pelanggan()
	{
		$kode_pelanggan = $this->uri->segment(3);
		$this->db->query("DELETE FROM pelanggan WHERE kode_pelanggan = '$kode_pelanggan' ");
		redirect('pelanggan/view_pelanggan');
	}

	function insert_pelanggan()
	{
		$this->Model_pelanggan->insert_pelanggan();
	}
}
