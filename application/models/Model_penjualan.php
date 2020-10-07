<?php

class Model_penjualan extends CI_Model
{

  function kategori_barang()
  {

    return $this->db->query("SELECT * FROM kategori");
  }

  function hapus_temp()
  {

    $kode_barang    = $this->input->post('kode_barang');
    return $this->db->query("DELETE FROM penjualan_temp WHERE kode_barang = '$kode_barang' ");
  }

  function view_penjualan_temp()
  {

    return $this->db->query("SELECT penjualan_temp.kode_barang,SUM(qty) AS qty,nama_barang,barang.harga FROM penjualan_temp INNER JOIN barang ON penjualan_temp.kode_barang=barang.kode_barang GROUP BY penjualan_temp.kode_barang");
  }

  function insert_temp()
  {

    $kode_barang    = $this->input->post('kode_barang');
    $qty            = $this->input->post('qty');
    $harga          = $this->input->post('harga');

    $data = array(
      'kode_barang' => $kode_barang,
      'qty'     => $qty,
      'harga'   => $harga
    );
    $this->db->insert('penjualan_temp',$data);
  }

  function view_barang($kode_kategori)
  {

    if ($kode_kategori != "") {
      $kode_kategori = "WHERE barang.kode_kategori = '$kode_kategori' ";
    }

    $query = "SELECT * FROM barang 
    INNER JOIN kategori ON kategori.kode_kategori=barang.kode_kategori
    "
      . $kode_kategori
      . "
    ";

    return $this->db->query($query);
  }
}
