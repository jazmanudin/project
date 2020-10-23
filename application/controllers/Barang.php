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

	public function view_barang()
	{
		$data['data']   = $this->Model_barang->view_barang()->result();
		$this->template->load('template/template', 'barang/view_barang', $data);
	}

	public function detail_barang()
	{
		$data['detail'] = $this->Model_barang->detail_barang()->row_array();
		$this->load->view('barang/detail_barang', $data);
	}

	public function hapus_barang()
	{
		$kode_barang = $this->uri->segment(3);
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
				$this->Model_barang->insert_barang();
				redirect('barang/view_barang');
			}
		} else {
			$data['kategori'] = $this->Model_barang->get_kategori()->result();
			$this->template->load('template/template', 'barang/input_barang',$data);
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
