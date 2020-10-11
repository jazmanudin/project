<?php
class Model_perusahaan extends CI_Model
{

    function view_perusahaan()
    {

        return $this->db->get("perusahaan");
    }

    function get_perusahaan()
    {

        $kode_perusahaan = $this->uri->segment(3);
        return $this->db->get_where('perusahaan', array('kode_perusahaan' => $kode_perusahaan));
    }

    function detail_perusahaan()
    {

        $kode_perusahaan            = $this->input->post('kode_perusahaan');
        return $this->db->get_where('perusahaan', array('kode_perusahaan' => $kode_perusahaan));
    }

    function insert_perusahaan($foto)
    {

        $kode_perusahaan    = $this->input->post('kode_perusahaan');
        $nama_perusahaan    = $this->input->post('nama_perusahaan');
        $alamat             = $this->input->post('alamat');
        $provinsi           = $this->input->post('provinsi');
        $kota               = $this->input->post('kota');
        $kecamatan          = $this->input->post('kecamatan');
        $no_hp              = $this->input->post('no_hp');
        $desa               = $this->input->post('desa');
        $email              = $this->input->post('email');
        $exp_date           = $this->input->post('exp_date');

        $data                   = array(
            'kode_perusahaan'   => $kode_perusahaan,
            'nama_perusahaan'   => $nama_perusahaan,
            'alamat'            => $alamat,
            'provinsi'          => $provinsi,
            'kota'              => $kota,
            'kecamatan'         => $kecamatan,
            'desa'              => $desa,
            'no_hp'             => $no_hp,
            'email'             => $email,
            'exp_date'          => $exp_date,
            'foto'              => $foto
        );

        $this->db->insert('perusahaan', $data);
    }

    function update_perusahaan($foto)
    {

        $kode_perusahaan    = $this->input->post('kode_perusahaan');
        $nama_perusahaan    = $this->input->post('nama_perusahaan');
        $alamat             = $this->input->post('alamat');
        $provinsi           = $this->input->post('provinsi');
        $kota               = $this->input->post('kota');
        $kecamatan          = $this->input->post('kecamatan');
        $desa               = $this->input->post('desa');
        $no_hp              = $this->input->post('no_hp');
        $email              = $this->input->post('email');
        $exp_date           = $this->input->post('exp_date');

        $data                   = array(
            'nama_perusahaan'   => $nama_perusahaan,
            'alamat'            => $alamat,
            'provinsi'          => $provinsi,
            'kota'              => $kota,
            'kecamatan'         => $kecamatan,
            'desa'              => $desa,
            'no_hp'             => $no_hp,
            'email'             => $email,
            'exp_date'          => $exp_date,
            'foto'              => $foto
        );

        $this->db->where('kode_perusahaan', $kode_perusahaan);
        $this->db->update('perusahaan', $data);
    }
}
