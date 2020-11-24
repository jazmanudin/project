<?php

class Model_auth extends CI_Model{

    function cek_user($username=null,$password=null){

      return $this->db->query("SELECT * FROM users WHERE username = '$username'  AND password = '$password' ");

    }
}
