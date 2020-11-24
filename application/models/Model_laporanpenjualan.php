<?php

class Model_laporanpenjualan extends CI_Model
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

  function getpelanggan($kode_pelanggan)
  {

    if ($kode_pelanggan != "") {
      $kode_pelanggan = "WHERE pelanggan.kode_pelanggan = '" . $kode_pelanggan . "' ";
    }

    return $this->db->query("SELECT * FROM pelanggan 
      "
      . $kode_pelanggan
      . "
      ");
  }

  function getKaryawan($nik)
  {

    if ($nik != "") {
      $nik = "WHERE karyawan.nik = '" . $nik . "' ";
    }

    return $this->db->query("SELECT * FROM karyawan 
      "
      . $nik
      . "
      ");
  }

  function list_detailpenjualan($dari, $sampai, $kode_barang)
  {

    if ($kode_barang != "") {
      $kode_barang = "AND barang.kode_barang = '" . $kode_barang . "' ";
    }

    return $this->db->query("SELECT 
    penjualan.no_fak_penj,
    penjualan.tgl_transaksi,
    penjualan_detail.kode_barang,
    penjualan_detail.qty,
    penjualan_detail.harga_jual,
    barang.nama_barang,
    barang.satuan

    FROM penjualan_detail
    INNER JOIN penjualan ON penjualan_detail.no_fak_penj=penjualan.no_fak_penj
    INNER JOIN pelanggan ON pelanggan.kode_pelanggan=penjualan.kode_pelanggan
    INNER JOIN barang ON barang.kode_barang=penjualan_detail.kode_barang
    WHERE penjualan.tgl_transaksi BETWEEN '" . $dari . "' AND '" . $sampai . "' "
      . $kode_barang
      . "
    ORDER BY penjualan_detail.kode_barang ");
  }

  function list_penjualan($dari, $sampai, $kode_pelanggan)
  {

    if ($kode_pelanggan != "") {
      $kode_pelanggan = "AND penjualan.kode_pelanggan = '" . $kode_pelanggan . "' ";
    }

    return $this->db->query("SELECT 
    penjualan.no_fak_penj,
    penjualan.potongan,
    penjualan.keterangan,
    penjualan.kode_pelanggan,
    penjualan.total,
    penjualan.no_so,
    penjualan.tgl_transaksi,
    penjualan.jenis_transaksi,
    penjualan.ppn,
    pelanggan.nama_pelanggan,
    pelanggan.jatuh_tempo
    FROM penjualan
    INNER JOIN pelanggan ON pelanggan.kode_pelanggan=penjualan.kode_pelanggan
    WHERE penjualan.tgl_transaksi BETWEEN '" . $dari . "' AND '" . $sampai . "' "
      . $kode_pelanggan
      . "
    ORDER BY penjualan.kode_pelanggan ");
  }

  function list_rekap_penjualan_sales($dari, $sampai, $id_sales)
  {

    if ($id_sales != "") {
      $id_sales = "AND karyawan.nik = '" . $id_sales . "' ";
    }

    return $this->db->query("SELECT nik,nama_karyawan,total,potongan 
    FROM karyawan 
	
    LEFT JOIN(
      SELECT id_sales,no_fak_penj,SUM(total) AS total,SUM(potongan) AS potongan 
      FROM penjualan WHERE penjualan.tgl_transaksi BETWEEN '" . $dari . "' AND '" . $sampai . "'
      GROUP BY id_sales
    ) pj ON (karyawan.nik = pj.id_sales)
    
    WHERE jabatan = 'Sales' "
      . $id_sales
      . "
    ");
  }

  function list_rekap_penjualan_barang($dari, $sampai, $kode_barang)
  {

    if ($kode_barang != "") {
      $kode_barang = "AND barang.kode_barang = '" . $kode_barang . "' ";
    }

    return $this->db->query("SELECT barang.kode_barang,nama_barang,total,potongan 
    FROM barang 
	
    LEFT JOIN(
      SELECT kode_barang,penjualan_detail.no_fak_penj,SUM(total) AS total,SUM(potongan) AS potongan 
      FROM penjualan_detail
      LEFT JOIN penjualan ON penjualan.no_fak_penj=penjualan_detail.no_fak_penj
      WHERE penjualan.tgl_transaksi BETWEEN '" . $dari . "' AND '" . $sampai . "'
      GROUP BY kode_barang
    ) pj ON (barang.kode_barang = pj.kode_barang)
   
    "
      . $kode_barang
      . "
    ");
  }

  function list_kartu_piutang($dari, $sampai, $kode_pelanggan)
  {

    if ($kode_pelanggan != "") {
      $kode_pelanggan = "AND penjualan.kode_pelanggan = '" . $kode_pelanggan . "' ";
    }

    return $this->db->query("SELECT 
    penjualan.no_fak_penj,
    penjualan.potongan,
    penjualan.keterangan,
    penjualan.kode_pelanggan,
    penjualan.total,
    penjualan.tgl_transaksi,
    penjualan.jenis_transaksi,
    penjualan.ppn,
    pelanggan.nama_pelanggan,
    pelanggan.jatuh_tempo,
    hs.jumlahbayar
    
    FROM penjualan
    INNER JOIN pelanggan ON pelanggan.kode_pelanggan=penjualan.kode_pelanggan

    LEFT JOIN(
      SELECT no_fak_penj,SUM(jumlah) AS jumlahbayar FROM pembayaran_piutang_detail
      GROUP BY no_fak_penj
      ) hs ON (penjualan.no_fak_penj = hs.no_fak_penj)
  
    WHERE penjualan.tgl_transaksi BETWEEN '" . $dari . "' AND '" . $sampai . "' "
      . $kode_pelanggan
      . "
    ORDER BY pelanggan.nama_pelanggan ");
  }
}
