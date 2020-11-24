<?php

class Model_dashboard extends CI_Model
{
    function jml_penj_bulan_ini()
    {
        $bulanini           = date('m');
        $query = "SELECT no_fak_penj FROM penjualan WHERE MONTH(tgl_transaksi) = '$bulanini' ";
        return $this->db->query($query);
    }

    function total_penj_bulan_ini()
    {
        $bulanini           = date('m');

        $query = "SELECT 
        penjualan.no_fak_penj,
        penjualan.potongan,
        penjualan.keterangan,
        penjualan.kode_pelanggan,
        SUM(penjualan.total) AS total,
        penjualan.tgl_transaksi
        
        FROM penjualan
    
        WHERE MONTH(tgl_transaksi) = '$bulanini'
    ";
        return $this->db->query($query);
    }

    function get_minstok_barang()
    {
        $query = $this->db->query("SELECT min_stok,db.stok,barang.kode_barang,nama_barang,satuan,nama_kategori,harga_modal,grosir,eceran,tidak_tetap,pelanggan_tetap,lainnya,keterangan 
        FROM barang
        INNER JOIN kategori ON kategori.kode_kategori=barang.kode_kategori
        
        LEFT JOIN(SELECT kode_barang,SUM(stok) AS stok 
        FROM barang_detail 
        GROUP BY kode_barang) db ON (barang.kode_barang=db.kode_barang)

        ORDER BY nama_barang
        LIMIT 15
        ");

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_barang_exp()
    {
        $query = $this->db->query("SELECT exp_date,min_stok,stok,barang.kode_barang,nama_barang,satuan,nama_kategori,keterangan 
        FROM barang
        INNER JOIN kategori ON kategori.kode_kategori=barang.kode_kategori
        INNER JOIN barang_detail ON barang.kode_barang=barang_detail.kode_barang
        WHERE barang_detail.stok != '0'
        ORDER BY nama_barang,exp_date
        LIMIT 15
        ");

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }
}
