<?php

class Auth extends CI_Controller
{

  function __construct()
  {
    parent::__construct();

    $this->load->Model('Model_auth');
  }

  function login()
  {
    check_log();
    if (isset($_POST['submit'])) {
      $username    = $this->input->post('username');
      $password    = md5($this->input->post('password'));
      $user        = $this->Model_auth->cek_user($username, $password);
      $cek_user    = $user->num_rows();
      $data_user   = $user->row_array();

      if ($cek_user != 0) {

        $data_session = array(

          'id_user'         => $data_user['id_user'],
          'nama_lengkap'    => $data_user['nama_lengkap'],
          'username'        => $data_user['username'],
          'password'        => $data_user['password'],
          'email'           => $data_user['email'],
          'no_hp'           => $data_user['no_hp'],
          'level_user'      => $data_user['level'],
          'id_member'       => $data_user['kode_perusahaan'],
          'bayar'           => $data_user['jenis_pembayaran']
        );
        $this->session->set_userdata($data_session);
        redirect('Penjualan/view_penjualan');
      } else {
        redirect('auth/login');
      }
    } else {

      $this->load->view('auth/login');
    }
  }

  function logout()
  {

    $this->session->sess_destroy();
    redirect('auth/login');
  }
}
