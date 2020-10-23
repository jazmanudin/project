<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		check_login();
		$this->load->Model('Model_kategori');
	}

	public function view_kategori()
	{
		$data['data']   = $this->Model_kategori->view_kategori()->result();
		$this->template->load('template/template', 'kategori/view_kategori', $data);
	}

	public function hapus_kategori()
	{
		$kode_kategori = $this->uri->segment(3);
		$this->db->query("DELETE FROM kategori WHERE kode_kategori = '$kode_kategori' ");
		redirect('kategori/view_kategori');
	}

	function insert_kategori()
	{
		$this->Model_kategori->insert_kategori();
	}
}
