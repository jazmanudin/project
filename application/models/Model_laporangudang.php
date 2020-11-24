<?php

class Model_laporangudang extends CI_Model
{

  function getSupplier()
  {
    return $this->db->query("SELECT * FROM supplier ");
  }

  function getBarang($kode_barang)
  {

    if ($kode_barang != "") {
      $kode_barang = "WHERE barang.kode_barang = '" . $kode_barang . "' ";
    }

    return $this->db->query("SELECT * FROM barang  "
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
      . $kode_barang
      . "
    ";
    return $this->db->query($query);
  }

  function list_pengeluaran($dari, $sampai, $kode_barang)
  {

    if ($kode_barang != "") {
      $kode_barang = "AND barang.kode_barang = '" . $kode_barang . "' ";
    }

    return $this->db->query("SELECT 
    * FROM pengeluaran_detail
    INNER JOIN pengeluaran ON pengeluaran.no_pengeluaran=pengeluaran_detail.no_pengeluaran
    INNER JOIN barang ON barang.kode_barang=pengeluaran_detail.kode_barang
    WHERE pengeluaran.tgl_transaksi BETWEEN '$dari' AND '$sampai' "
      . $kode_barang
      . "
    ORDER BY pengeluaran.tgl_transaksi,pengeluaran.no_pengeluaran
     ");
  }

  function list_pemasukan($dari, $sampai, $kode_barang)
  {

    if ($kode_barang != "") {
      $kode_barang = "AND barang.kode_barang = '" . $kode_barang . "' ";
    }

    return $this->db->query("SELECT 
    * FROM pemasukan_detail
    INNER JOIN pemasukan ON pemasukan.no_pemasukan=pemasukan_detail.no_pemasukan
    INNER JOIN barang ON barang.kode_barang=pemasukan_detail.kode_barang
    WHERE pemasukan.tgl_transaksi BETWEEN '$dari' AND '$sampai' "
      . $kode_barang
      . "
    ORDER BY pemasukan.tgl_transaksi,pemasukan.no_pemasukan
     ");
  }

  function list_barang_minimum($kode_barang)
  {

    if ($kode_barang != "") {
      $kode_barang = "WHERE barang.kode_barang = '" . $kode_barang . "' ";
    }

    return $this->db->query("SELECT min_stok,db.stok,barang.kode_barang,nama_barang,satuan,nama_kategori,harga_modal,grosir,eceran,tidak_tetap,pelanggan_tetap,lainnya,keterangan 
    FROM barang
    INNER JOIN kategori ON kategori.kode_kategori=barang.kode_kategori
    
    LEFT JOIN(SELECT kode_barang,SUM(stok) AS stok 
    FROM barang_detail 
    GROUP BY kode_barang) db ON (barang.kode_barang=db.kode_barang)
    "
      . $kode_barang
      . "
    ORDER BY nama_barang
     ");
  }

  function list_barang_exp($kode_barang)
  {

    if ($kode_barang != "") {
      $kode_barang = "AND barang.kode_barang = '" . $kode_barang . "' ";
    }

    return $this->db->query("SELECT exp_date,min_stok,stok,barang.kode_barang,nama_barang,satuan,nama_kategori,keterangan 
    FROM barang
    INNER JOIN kategori ON kategori.kode_kategori=barang.kode_kategori
    INNER JOIN barang_detail ON barang.kode_barang=barang_detail.kode_barang
    WHERE barang_detail.stok != '0'
    "
      . $kode_barang
      . "
    ORDER BY nama_barang,exp_date
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
      $kode_barang = "WHERE barang.kode_barang = '" . $kode_barang . "' ";
    }

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
    sa.qtysaldoawal,
    op.qtyopname
    
    FROM barang

    LEFT JOIN (SELECT 
    saldoawal_detail.kode_barang,
    SUM(qty) AS qtysaldoawal
    FROM saldoawal_detail 
    INNER JOIN saldoawal ON saldoawal_detail.kode_saldoawal = saldoawal.kode_saldoawal 
    WHERE bulan = '$bulan' AND tahun = '$tahun' 
    GROUP BY saldoawal_detail.kode_barang) sa ON (barang.kode_barang = sa.kode_barang)

    
    LEFT JOIN (SELECT 
    opname_detail.kode_barang,
    SUM(qty) AS qtyopname
    FROM opname_detail 
    INNER JOIN opname ON opname_detail.kode_opname = opname.kode_opname 
    WHERE bulan = '$bulan' AND tahun = '$tahun' 
    GROUP BY opname_detail.kode_barang) op ON (barang.kode_barang = op.kode_barang)

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
    "
      . $kode_barang
      . "
    ORDER BY barang.jenis_barang,barang.nama_barang ");
  }
}
