<?php

class Model_barcode extends CI_Model
{

  public function insert_barcode()
  {
    $kode_barang        = $this->input->post('kode_barang');
    $id_user            = $this->session->userdata('id_user');

    $this->load->library('zend');
    $this->zend->load('Zend/Barcode');

    $result = array();
    $index  = 0;
    foreach ($kode_barang as $kode) {
      $image_resource = Zend_Barcode::factory('code128', 'image', array('text' => $kode), array())->draw();
      $image_name     = $kode . '.jpg';
      $image_dir      = './assets/images/barcode/';
      imagejpeg($image_resource, $image_dir . $image_name);

      array_push($result, array(
        'kode_barang'       => $kode,
        'barcode'           => $kode . ".jpg",
        'id_user'           => $id_user
      ));
      $index++;
    }
    $this->db->insert_batch('barcode', $result);

    redirect('barcode/input_barcode');
  }

  function getdetailbarcode()
  {

    return $this->db->query("SELECT 
    barang.kode_barang,
    barang.nama_barang,
    barang.satuan,
    barang.jenis_barang,
    kategori.nama_kategori

    FROM barang
    INNER JOIN kategori ON kategori.kode_kategori=barang.kode_kategori
    WHERE kode_barang NOT IN (SELECT kode_barang FROM barcode)
    ORDER BY barang.jenis_barang,barang.nama_barang ");
  }
}
