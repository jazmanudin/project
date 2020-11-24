<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		check_login();
		$this->load->Model('Model_barang');
	}

	function view_barang($rowno    = 0)
	{

		$kode_barang               = "";
		$nama_barang               = "";

		if ($this->input->post('submit') != NULL) {
			$kode_barang           = $this->input->post('kode_barang');
			$nama_barang       	   = $this->input->post('nama_barang');
		}
		$rowperpage                   = 10;
		if ($rowno != 0) {
			$rowno = ($rowno - 1) * $rowperpage;
		}
		$allcount                     = $this->Model_barang->getRecordBarangCount($kode_barang, $nama_barang,);
		$users_record                 = $this->Model_barang->getDataBarang($rowno, $rowperpage, $kode_barang, $nama_barang);
		$config['base_url']           = base_url() . 'barang/view_barang';
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
		$data['kode_barang']          = $kode_barang;
		$data['nama_barang']          = $nama_barang;
		$this->template->load('template/template', 'barang/view_barang', $data);
	}

	public function detail_barang()
	{
		$data['detail'] = $this->Model_barang->detail_barang()->row_array();
		$this->load->view('barang/detail_barang', $data);
	}

	public function hapus_barang()
	{
		$kode_barang 	= $this->uri->segment(3);
		$this->db->query("DELETE FROM barang WHERE kode_barang = '$kode_barang' ");
	}

	function input_barang()
	{
		if (isset($_POST['submit'])) {

			if (!empty($_FILES['foto']['name'])) {
				$config['upload_path']    	= './assets/images/barang/';
				$config['allowed_types']    = 'gif|jpg|png|jpeg|bmp';
				$config['file_name']       = $this->input->post('kode_barang');
				$this->upload->initialize($config);
				if ($this->upload->do_upload('foto')) {
					$_data                     = array('upload_data' => $this->upload->data());
					$foto                      = $_data['upload_data']['file_name'];
					// unlink(base_url("assets/barang/images/".$foto0	$config['image_library']   = 'gd2';
					$config['source_image']    = './assets/images/barang' . $foto;
					$config['create_thumb']    = FALSE;
					$config['maintain_ratio']  = FALSE;
					$config['quality']         = '100%';
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();
					$this->Model_barang->insert_barang($foto);
					redirect('barang/view_barang');
				}
			} else {
				$foto = "";
				$this->Model_barang->insert_barang($foto);
				redirect('barang/view_barang');
			}
		} else {
			$data['kategori'] = $this->Model_barang->get_kategori()->result();
			$this->template->load('template/template', 'barang/input_barang', $data);
		}
	}

	function edit_barang()
	{
		if (isset($_POST['submit'])) {
			if (!empty($_FILES['foto']['name'])) {
				$fotoold = $this->input->post('fotoold');
				unlink("./assets/images/barang/$fotoold");
				$config['upload_path']    	= './assets/images/barang/';
				$config['allowed_types']    = 'gif|jpg|png|jpeg|bmp';
				$config['file_name']       	= $this->input->post('kode_barang');
				$this->upload->initialize($config);
				if ($this->upload->do_upload('foto')) {
					$_data                     = array('upload_data' => $this->upload->data());
					$foto                      = $_data['upload_data']['file_name'];
					$config['image_library']   = 'gd2';
					$config['source_image']    = './assets/images/barang' . $foto;
					$config['create_thumb']    = FALSE;
					$config['maintain_ratio']  = FALSE;
					$config['quality']         = '100%';
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();
					$this->Model_barang->update_barang($foto);
					redirect('barang/view_barang');
				}
			} else {
				$foto = $this->input->post('fotoold');
				$this->Model_barang->update_barang($foto);
				redirect('barang/view_barang');
			}
		} else {
			$data['kategori'] = $this->Model_barang->get_kategori()->result();
			$data['getdata'] = $this->Model_barang->get_barang()->row_array();
			$this->template->load('template/template', 'barang/edit_barang', $data);
		}
	}
}
