<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perusahaan extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		check_login();
		$this->load->Model('Model_perusahaan');
	}

	public function view_perusahaan()
	{
		$data['data']   = $this->Model_perusahaan->view_perusahaan()->result();
		$this->template->load('template/template', 'perusahaan/view_perusahaan', $data);
	}

	public function detail_perusahaan()
	{
		$data['detail'] = $this->Model_perusahaan->detail_perusahaan()->row_array();
		$this->load->view('perusahaan/detail_perusahaan', $data);
	}

	public function hapus_perusahaan()
	{
		$kode_perusahaan = $this->uri->segment(3);
		return $this->db->query("DELETE FROM perusahaan WHERE kode_perusahaan = '$kode_perusahaan' ");
	}

	function input_perusahaan()
	{
		if (isset($_POST['submit'])) {

			if (!empty($_FILES['foto']['name'])) {
				$config['upload_path']    	= './assets/images/perusahaan/';
				$config['allowed_types']    = 'gif|jpg|png|jpeg|bmp';
				$config['file_name']       = $this->input->post('kode_perusahaan');
				$this->upload->initialize($config);
				if ($this->upload->do_upload('foto')) {
					$_data                     = array('upload_data' => $this->upload->data());
					$foto                      = $_data['upload_data']['file_name'];
					// unlink(base_url("assets/perusahaan/images/".$foto));
					$config['image_library']   = 'gd2';
					$config['source_image']    = './assets/images/perusahaan' . $foto;
					$config['create_thumb']    = FALSE;
					$config['maintain_ratio']  = FALSE;
					$config['quality']         = '100%';
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();
					$this->Model_perusahaan->insert_perusahaan($foto);
					redirect('perusahaan/view_perusahaan');
				}
			} else {
				$this->Model_perusahaan->insert_perusahaan();
				redirect('perusahaan/view_perusahaan');
			}
		} else {
			$this->template->load('template/template', 'perusahaan/input_perusahaan');
		}
	}

	function edit_perusahaan()
	{
		if (isset($_POST['submit'])) {

			if (!empty($_FILES['foto']['name'])) {
				$config['upload_path']    	= './assets/images/perusahaan/';
				$config['allowed_types']    = 'gif|jpg|png|jpeg|bmp';
				$config['file_name']       = $this->input->post('kode_perusahaan');
				$this->upload->initialize($config);
				if ($this->upload->do_upload('foto')) {
					$_data                     = array('upload_data' => $this->upload->data());
					$foto                      = $_data['upload_data']['file_name'];
					$config['image_library']   = 'gd2';
					$config['source_image']    = './assets/images/perusahaan' . $foto;
					$config['create_thumb']    = FALSE;
					$config['maintain_ratio']  = FALSE;
					$config['quality']         = '100%';
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();
					$this->Model_perusahaan->update_perusahaan($foto);
					redirect('perusahaan/view_perusahaan');
				}
			} else {
				$this->Model_perusahaan->update_perusahaan();
				redirect('perusahaan/view_perusahaan');
			}
		} else {
			$data['getdata'] = $this->Model_perusahaan->get_perusahaan()->row_array();
			$this->template->load('template/template', 'perusahaan/edit_perusahaan',$data);
		}
	}
}
