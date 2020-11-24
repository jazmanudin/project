<?php

class Model_laporanpembelian extends CI_Model
{

  function getBarang($kode_barang)
  {

    if ($kode_barang != "") {
      $kode_barang = "WHERE barang.kode_barang = '" . $kode_barang . "' ";
    }
    
    return $this->db->query("SELECT * FROM barang "
      . $kode_barang
      . "
      ");
  }

  function getSupplier($kode_supplier)
  {
    $id_member      = $this->session->userdata('id_member');

    if ($kode_supplier != "") {
      $kode_supplier = "WHERE supplier.kode_supplier = '" . $kode_supplier . "' ";
    }
    
    return $this->db->query("SELECT * FROM supplier 
    "
      . $kode_supplier
      . "
      ");
  }

  function list_detailpembelian($dari, $sampai, $kode_barang)
  {

    if ($kode_barang != "") {
      $kode_barang = "AND barang.kode_barang = '" . $kode_barang . "' ";
    }

    return $this->db->query("SELECT 
    pembelian.no_fak_pemb,
    pembelian.tgl_transaksi,
    pembelian_detail.kode_barang,
    pembelian_detail.qty,
    pembelian_detail.harga_modal,
    pembelian_detail.exp_date,
    pembelian_detail.keterangan,
    barang.nama_barang,
    barang.satuan

    FROM pembelian_detail
    INNER JOIN pembelian ON pembelian_detail.no_fak_pemb=pembelian.no_fak_pemb
    INNER JOIN supplier ON supplier.kode_supplier=pembelian.kode_supplier
    INNER JOIN barang ON barang.kode_barang=pembelian_detail.kode_barang
    WHERE pembelian.tgl_transaksi BETWEEN '" . $dari . "' AND '" . $sampai . "' "
      . $kode_barang
      . "
    ORDER BY pembelian_detail.kode_barang ");
  }

  function list_pembelian($dari, $sampai, $kode_supplier)
  {

    if ($kode_supplier != "") {
      $kode_supplier = "AND pembelian.kode_supplier = '" . $kode_supplier . "' ";
    }

    return $this->db->query("SELECT 
    pembelian.no_fak_pemb,
    pembelian.potongan,
    pembelian.keterangan,
    pembelian.kode_supplier,
    pembelian.total,
    pembelian.tgl_transaksi,
    pembelian.no_po,
    pembelian.ppn,
    pembelian.jenis_transaksi,
    supplier.nama_supplier,
    pembelian.jatuh_tempo
    FROM pembelian
    INNER JOIN supplier ON supplier.kode_supplier=pembelian.kode_supplier
    WHERE pembelian.tgl_transaksi BETWEEN '" . $dari . "' AND '" . $sampai . "' "
      . $kode_supplier
      . "
    ORDER BY pembelian.kode_supplier ");
  }

  function list_kartu_hutang($dari, $sampai, $kode_supplier)
  {

    if ($kode_supplier != "") {
      $kode_supplier = "AND pembelian.kode_supplier = '" . $kode_supplier . "' ";
    }

    return $this->db->query("SELECT 
    pembelian.no_fak_pemb,
    pembelian.potongan,
    pembelian.keterangan,
    pembelian.kode_supplier,
    pembelian.total,
    pembelian.tgl_transaksi,
    supplier.nama_supplier,
    pembelian.jatuh_tempo,
    hs.jumlahbayar
    
    FROM pembelian
    INNER JOIN supplier ON supplier.kode_supplier=pembelian.kode_supplier

    LEFT JOIN(
      SELECT no_fak_pemb,SUM(jumlah) AS jumlahbayar FROM pembayaran_hutang_detail 
      GROUP BY no_fak_pemb
      ) hs ON (pembelian.no_fak_pemb = hs.no_fak_pemb)
  
    WHERE pembelian.tgl_transaksi BETWEEN '" . $dari . "' AND '" . $sampai . "' "
      . $kode_supplier
      . "
    ORDER BY supplier.nama_supplier ");
  }
}
