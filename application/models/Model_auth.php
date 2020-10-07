<?php

class Model_auth extends CI_Model{

    function cek_user($username=null,$password=null){

      $this->db->where(array('username'=>$username,'password'=>$password));
      return $this->db->get('users');

    }
}
