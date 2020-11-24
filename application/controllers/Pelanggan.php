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
	
	function view_pelanggan($rowno    = 0)
	{

		$kode_pelanggan               = "";
		$nama_pelanggan               = "";

		if ($this->input->post('submit') != NULL) {
			$kode_pelanggan           = $this->input->post('kode_pelanggan');
			$nama_pelanggan       	   = $this->input->post('nama_pelanggan');
		}
		$rowperpage                   = 10;
		if ($rowno != 0) {
			$rowno = ($rowno - 1) * $rowperpage;
		}
		$allcount                     = $this->Model_pelanggan->getRecordpelangganCount($kode_pelanggan, $nama_pelanggan,);
		$users_record                 = $this->Model_pelanggan->getDatapelanggan($rowno, $rowperpage, $kode_pelanggan, $nama_pelanggan);
		$config['base_url']           = base_url() . 'pelanggan/view_pelanggan';
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
		$data['kode_pelanggan']        = $kode_pelanggan;
		$data['nama_pelanggan']        = $nama_pelanggan;
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
