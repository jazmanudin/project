<?php

class Model_dashboard extends CI_Model
{
    function jml_penj_bulan_ini()
    {
        $id_member          = $this->session->userdata('id_member');
        $bulanini           = date('m');
        $query = "SELECT no_fak_penj FROM penjualan WHERE penjualan.id_member = '$id_member' AND MONTH(tgl_transaksi) = '$bulanini' ";
        return $this->db->query($query);
    }

    function total_penj_bulan_ini()
    {
        $id_member          = $this->session->userdata('id_member');
        $bulanini           = date('m');

        $query = "SELECT 
    penjualan.no_fak_penj,
    penjualan.potongan,
    penjualan.keterangan,
    penjualan.kode_pelanggan,
    SUM(penjualan.total) AS total,
    penjualan.tgl_transaksi
    
    FROM penjualan
   
    WHERE penjualan.id_member = '$id_member' AND MONTH(tgl_transaksi) = '$bulanini'
    ";
        return $this->db->query($query);
    }

    function total_penj_hari_ini()
    {
        $id_member          = $this->session->userdata('id_member');
        $hariini            = date('Y-m-d');

        $query = "SELECT 
    penjualan.no_fak_penj,
    penjualan.potongan,
    penjualan.keterangan,
    penjualan.kode_pelanggan,
    SUM(penjualan.total) AS total,
    penjualan.tgl_transaksi
    
    FROM penjualan
   
    WHERE penjualan.id_member = '$id_member' AND tgl_transaksi = '$hariini'
    ";
        return $this->db->query($query);
    }

    function view_penjualan()
    {
        $id_member          = $this->session->userdata('id_member');
        $hariini           = date('Y-m-d');

        $query = "SELECT 
    penjualan.no_fak_penj,
    penjualan.potongan,
    penjualan.keterangan,
    penjualan.kode_pelanggan,
    penjualan.total,
    penjualan.tgl_transaksi,
    hs.jumlahbayar
    
    FROM penjualan
    LEFT JOIN(
      SELECT no_fak_penj,SUM(jumlah) AS jumlahbayar FROM penjualan_histori_bayar 
      GROUP BY no_fak_penj
      ) hs ON (penjualan.no_fak_penj = hs.no_fak_penj)
  
    WHERE penjualan.id_member = '$id_member' AND tgl_transaksi = '$hariini'
    GROUP BY 
    penjualan.no_fak_penj,
    penjualan.potongan,
    penjualan.keterangan,
    penjualan.kode_pelanggan,
    penjualan.tgl_transaksi,
    penjualan.total,
    hs.jumlahbayar
    LIMIT 20
    ";
        return $this->db->query($query);
    }
}
