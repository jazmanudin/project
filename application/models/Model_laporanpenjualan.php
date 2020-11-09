<?php

class Model_laporanpenjualan extends CI_Model
{

  function getBarang($kode_barang)
  {
    $id_member      = $this->session->userdata('id_member');

    if ($kode_barang != "") {
      $kode_barang = "AND barang.kode_barang = '" . $kode_barang . "' ";
    }
    
    return $this->db->query("SELECT * FROM barang 
    WHERE id_member = '$id_member' AND jenis_barang != 'Produksi' "
      . $kode_barang
      . "
      ");
  }

  function getpelanggan($kode_pelanggan)
  {
    $id_member      = $this->session->userdata('id_member');

    if ($kode_pelanggan != "") {
      $kode_pelanggan = "AND pelanggan.kode_pelanggan = '" . $kode_pelanggan . "' ";
    }
    
    return $this->db->query("SELECT * FROM pelanggan 
    WHERE id_member = '$id_member' "
      . $kode_pelanggan
      . "
      ");
  }

  function list_detailpenjualan($dari, $sampai, $kode_barang)
  {

    if ($kode_barang != "") {
      $kode_barang = "AND barang.kode_barang = '" . $kode_barang . "' ";
    }

    $id_member      = $this->session->userdata('id_member');
    return $this->db->query("SELECT 
    penjualan.no_fak_penj,
    penjualan.tgl_transaksi,
    penjualan_detail.kode_barang,
    penjualan_detail.qty,
    penjualan_detail.harga,
    barang.nama_barang,
    barang.satuan

    FROM penjualan_detail
    INNER JOIN penjualan ON penjualan_detail.no_fak_penj=penjualan.no_fak_penj
    INNER JOIN pelanggan ON pelanggan.kode_pelanggan=penjualan.kode_pelanggan
    INNER JOIN barang ON barang.kode_barang=penjualan_detail.kode_barang
    WHERE penjualan.id_member = '$id_member' AND penjualan.tgl_transaksi BETWEEN '" . $dari . "' AND '" . $sampai . "' "
      . $kode_barang
      . "
    ORDER BY penjualan_detail.kode_barang ");
  }

  function list_penjualan($dari, $sampai, $kode_pelanggan)
  {

    if ($kode_pelanggan != "") {
      $kode_pelanggan = "AND penjualan.kode_pelanggan = '" . $kode_pelanggan . "' ";
    }

    $id_member      = $this->session->userdata('id_member');
    return $this->db->query("SELECT 
    penjualan.no_fak_penj,
    penjualan.potongan,
    penjualan.keterangan,
    penjualan.kode_pelanggan,
    penjualan.total,
    penjualan.tgl_transaksi,
    pelanggan.nama_pelanggan,
    penjualan.jatuh_tempo
    FROM penjualan
    INNER JOIN pelanggan ON pelanggan.kode_pelanggan=penjualan.kode_pelanggan
    WHERE penjualan.id_member = '$id_member' AND penjualan.tgl_transaksi BETWEEN '" . $dari . "' AND '" . $sampai . "' "
      . $kode_pelanggan
      . "
    ORDER BY penjualan.kode_pelanggan ");
  }

  function list_kartu_piutang($dari, $sampai, $kode_pelanggan)
  {

    if ($kode_pelanggan != "") {
      $kode_pelanggan = "AND penjualan.kode_pelanggan = '" . $kode_pelanggan . "' ";
    }

    $id_member      = $this->session->userdata('id_member');
    return $this->db->query("SELECT 
    penjualan.no_fak_penj,
    penjualan.potongan,
    penjualan.keterangan,
    penjualan.kode_pelanggan,
    penjualan.total,
    penjualan.tgl_transaksi,
    pelanggan.nama_pelanggan,
    penjualan.jatuh_tempo,
    hs.jumlahbayar
    
    FROM penjualan
    INNER JOIN pelanggan ON pelanggan.kode_pelanggan=penjualan.kode_pelanggan

    LEFT JOIN(
      SELECT no_fak_penj,SUM(jumlah) AS jumlahbayar FROM penjualan_histori_bayar 
      GROUP BY no_fak_penj
      ) hs ON (penjualan.no_fak_penj = hs.no_fak_penj)
  
    WHERE penjualan.id_member = '$id_member' AND penjualan.tgl_transaksi BETWEEN '" . $dari . "' AND '" . $sampai . "' "
      . $kode_pelanggan
      . "
    ORDER BY penjualan.kode_pelanggan ");
  }
}
