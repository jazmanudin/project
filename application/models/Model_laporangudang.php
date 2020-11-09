<?php

class Model_laporangudang extends CI_Model
{

  function getSupplier()
  {
    $id_member      = $this->session->userdata('id_member');
    return $this->db->query("SELECT * FROM supplier WHERE id_member = '$id_member' ");
  }

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
  
  function saldoAwal($bulan, $tahun, $kode_barang)
  {
    if ($kode_barang != "") {

      $kode_barang = "AND saldoawal_detail.kode_barang = '" . $kode_barang . "' ";
    }
    $query = "SELECT 
    SUM( qty ) AS qtysaldoawal
    FROM saldoawal_detail 
    INNER JOIN saldoawal ON saldoawal.kode_saldoawal=saldoawal_detail.kode_saldoawal
    WHERE bulan = '$bulan' AND tahun = '$tahun' "
    .$kode_barang
    ."
    ";
    return $this->db->query($query);
  }
  
  function list_pengeluaran($dari, $sampai, $kode_barang)
  {

    if ($kode_barang != "") {
      $kode_barang = "AND barang.kode_barang = '" . $kode_barang . "' ";
    }

    $id_member      = $this->session->userdata('id_member');
    return $this->db->query("SELECT 
    * FROM pengeluaran_detail
    INNER JOIN pengeluaran ON pengeluaran.no_pengeluaran=pengeluaran_detail.no_pengeluaran
    INNER JOIN barang ON barang.kode_barang=pengeluaran_detail.kode_barang
    WHERE pengeluaran.id_member = '$id_member' AND pengeluaran.tgl_transaksi BETWEEN '$dari' AND '$sampai' "
    .$kode_barang
    ."
    ORDER BY pengeluaran.tgl_transaksi,pengeluaran.no_pengeluaran
     ");
  }

  function list_pemasukan($dari, $sampai, $kode_barang)
  {

    if ($kode_barang != "") {
      $kode_barang = "AND barang.kode_barang = '" . $kode_barang . "' ";
    }

    $id_member      = $this->session->userdata('id_member');
    return $this->db->query("SELECT 
    * FROM pemasukan_detail
    INNER JOIN pemasukan ON pemasukan.no_pemasukan=pemasukan_detail.no_pemasukan
    INNER JOIN barang ON barang.kode_barang=pemasukan_detail.kode_barang
    WHERE pemasukan.id_member = '$id_member' AND pemasukan.tgl_transaksi BETWEEN '$dari' AND '$sampai' "
    .$kode_barang
    ."
    ORDER BY pemasukan.tgl_transaksi,pemasukan.no_pemasukan
     ");
  }

  function list_persediaan_barang($bulan, $tahun, $kode_barang)
  {

    // if ($bulan == 1) {
    //   $bulan    = 12;
    //   $tahun    = $tahun - 1;
    // } else {
    //   $bulan    = $bulan;
    //   $tahun    = $tahun;
    // }

    if ($kode_barang != "") {
      $kode_barang = "AND barang.kode_barang = '" . $kode_barang . "' ";
    }

    $id_member      = $this->session->userdata('id_member');
    return $this->db->query("SELECT 
    barang.kode_barang,
    barang.nama_barang,
    barang.satuan,
    barang.jenis_barang,
    pm.qtypembelian,
    jl.qtypenjualan,
    ms.qtyreturkembali,
    ms.qtymasuklainnya,
    kl.qtyretur,
    kl.qtybuang,
    kl.qtykeluarlainnya,
    sa.qtysaldoawal
    
    FROM barang

    LEFT JOIN (SELECT 
    saldoawal_detail.kode_barang,
    SUM(qty) AS qtysaldoawal
    FROM saldoawal_detail 
    INNER JOIN saldoawal ON saldoawal_detail.kode_saldoawal = saldoawal.kode_saldoawal 
    WHERE bulan = '$bulan' AND tahun = '$tahun' 
    GROUP BY saldoawal_detail.kode_barang) sa ON (barang.kode_barang = sa.kode_barang)

    LEFT JOIN (SELECT 
    pembelian_detail.kode_barang,
    SUM(qty) AS qtypembelian
    FROM pembelian_detail 
    INNER JOIN pembelian ON pembelian_detail.no_fak_pemb = pembelian.no_fak_pemb 
    WHERE MONTH(tgl_transaksi) = '$bulan' AND YEAR(tgl_transaksi) = '$tahun' 
    GROUP BY pembelian_detail.kode_barang) pm ON (barang.kode_barang = pm.kode_barang)
    
    LEFT JOIN (SELECT 
    pemasukan_detail.kode_barang,
    SUM( IF( pemasukan.jenis_pemasukan = 'Pengembalian Retur' , qty ,0 )) AS qtyreturkembali,
    SUM( IF( pemasukan.jenis_pemasukan = 'Lainnya' , qty ,0 )) AS qtymasuklainnya
    FROM pemasukan_detail 
    INNER JOIN pemasukan ON pemasukan_detail.no_pemasukan = pemasukan.no_pemasukan 
    WHERE MONTH(tgl_transaksi) = '$bulan' AND YEAR(tgl_transaksi) = '$tahun' 
    GROUP BY pemasukan_detail.kode_barang) ms ON (barang.kode_barang = ms.kode_barang)

    LEFT JOIN (SELECT 
    penjualan_detail.kode_barang,
    SUM(qty) AS qtypenjualan
    FROM penjualan_detail 
    INNER JOIN penjualan ON penjualan_detail.no_fak_penj = penjualan.no_fak_penj 
    WHERE MONTH(tgl_transaksi) = '$bulan' AND YEAR(tgl_transaksi) = '$tahun' 
    GROUP BY penjualan_detail.kode_barang) jl ON (barang.kode_barang = jl.kode_barang)

    LEFT JOIN (SELECT 
    pengeluaran_detail.kode_barang,
    SUM( IF( pengeluaran.jenis_pengeluaran = 'Retur' , qty ,0 )) AS qtyretur,
    SUM( IF( pengeluaran.jenis_pengeluaran = 'Buang' , qty ,0 )) AS qtybuang,
    SUM( IF( pengeluaran.jenis_pengeluaran = 'Lainnya' , qty ,0 )) AS qtykeluarlainnya
    FROM pengeluaran_detail 
    INNER JOIN pengeluaran ON pengeluaran_detail.no_pengeluaran = pengeluaran.no_pengeluaran 
    WHERE MONTH(tgl_transaksi) = '$bulan' AND YEAR(tgl_transaksi) = '$tahun' 
    GROUP BY pengeluaran_detail.kode_barang) kl ON (barang.kode_barang = kl.kode_barang)

    WHERE barang.id_member = '$id_member' "
      . $kode_barang
      . "
    ORDER BY barang.jenis_barang,barang.nama_barang ");
  }
}
