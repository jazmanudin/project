<?php

class Model_auth extends CI_Model{

    function cek_user($username=null,$password=null){

      $this->db->where(array('username'=>$username,'password'=>$password));
      $this->db->join('perusahaan','perusahaan.kode_perusahaan=users.kode_perusahaan');
      return $this->db->get('users');

    }
}
