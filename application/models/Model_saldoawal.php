<?php

class Model_saldoawal extends CI_Model
{

  function hapus_saldoawal()
  {

    $id_member      = $this->session->userdata('id_member');
    $kode_saldoawal    = $this->uri->segment(3);
    $this->db->query("DELETE FROM saldoawal WHERE kode_saldoawal = '$kode_saldoawal' AND id_member = '$id_member' ");
    $this->db->query("DELETE FROM saldoawal_detail WHERE kode_saldoawal = '$kode_saldoawal' AND id_member = '$id_member' ");
    redirect('saldoawal/view_saldoawal');
  }

  function view_saldoawal()
  {
    $id_member          = $this->session->userdata('id_member');
    $kode_saldoawal        = $this->input->post('kode_saldoawal');
    $dari               = $this->input->post('dari');
    $sampai             = $this->input->post('sampai');

    if ($kode_saldoawal != "") {
      $kode_saldoawal = "AND saldoawal.kode_saldoawal = '" . $kode_saldoawal . "' ";
    }

    if ($dari != "") {
      $dari = "AND saldoawal.tgl_transaksi BETWEEN '" . $dari . "' AND '" . $sampai . "' ";
    }

    $query = "SELECT * FROM saldoawal WHERE id_member = '$id_member'
    ";
    return $this->db->query($query);
  }

  function ceksaldo($bulan, $tahun)
  {

    if ($bulan == 1) {
      $bulan = 12;
      $tahun = $tahun - 1;
    } else {
      $bulan = $bulan - 1;
      $tahun = $tahun;
    }

    return $this->db->get_where('saldoawal', array('bulan' => $bulan, 'tahun' => $tahun));
  }

  function ceksaldoall()
  {

    return $this->db->get('saldoawal');
  }

  function ceksaldoSkrg($bulan, $tahun)
  {

    return $this->db->get_where('saldoawal', array('bulan' => $bulan, 'tahun' => $tahun));
  }

  function getdetailsaldo($bulan, $tahun)
  {

    if ($bulan == 1) {
      $bulan = 12;
      $tahun = $tahun - 1;
    } else {
      $bulan = $bulan - 1;
      $tahun = $tahun;
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
    SUM( IF( pemasukan.asal_barang = 'Pengembalian Retur' , qty ,0 )) AS qtyreturkembali,
    SUM( IF( pemasukan.asal_barang = 'Lainnya' , qty ,0 )) AS qtymasuklainnya
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
    SUM( IF( pengeluaran.jenis_keluar = 'Retur' , qty ,0 )) AS qtyretur,
    SUM( IF( pengeluaran.jenis_keluar = 'Buang' , qty ,0 )) AS qtybuang,
    SUM( IF( pengeluaran.jenis_keluar = 'Lainnya' , qty ,0 )) AS qtykeluarlainnya
    FROM pengeluaran_detail 
    INNER JOIN pengeluaran ON pengeluaran_detail.no_pengeluaran = pengeluaran.no_pengeluaran 
    WHERE MONTH(tgl_transaksi) = '$bulan' AND YEAR(tgl_transaksi) = '$tahun' 
    GROUP BY pengeluaran_detail.kode_barang) kl ON (barang.kode_barang = kl.kode_barang)

    WHERE barang.id_member = '$id_member'
    ORDER BY barang.jenis_barang,barang.nama_barang ");
  }

  public function insert_saldoawal()
  {
    $kode_saldoawal   = $this->input->post('kode_saldoawal');
    $bulan            = $this->input->post('bulan');
    $tahun            = $this->input->post('tahun');
    $tgl_transaksi    = $this->input->post('tgl_transaksi');
    $kode_barang      = $this->input->post('kode_barang');
    $qty              = $this->input->post('qty');
    $id_member        = $this->session->userdata('id_member');
    $id_user          = $this->session->userdata('id_user');

    $data = array(
      'kode_saldoawal'    => $kode_saldoawal,
      'bulan'             => $bulan,
      'tahun'             => $tahun,
      'tgl_transaksi'     => $tgl_transaksi,
      'id_member'         => $id_member,
      'id_user'           => $id_user
    );
    $this->db->insert('saldoawal', $data);

    $result = array();
    $index  = 0;
    foreach ($kode_barang as $kode) {
      array_push($result, array(
        'kode_saldoawal'  => $kode_saldoawal,
        'kode_barang'     => $kode,
        'qty'             => $qty[$index],
        'id_member'       => $id_member,
        'id_user'         => $id_user
      ));
      $index++;
    }
    $this->db->insert_batch('saldoawal_detail', $result);

    redirect('saldoawal/view_saldoawal');
  }

  function detail_saldoawal()
  {
    $kode_saldoawal        = $this->input->post('kode_saldoawal');
    $id_member             = $this->session->userdata('id_member');

    $query = "SELECT saldoawal_detail.kode_barang,nama_barang,satuan,jenis_barang,saldoawal_detail.qty FROM saldoawal_detail 
    INNER JOIN barang ON saldoawal_detail.kode_barang=barang.kode_barang 
    WHERE saldoawal_detail.id_member = '$id_member' AND saldoawal_detail.kode_saldoawal = '$kode_saldoawal'
    GROUP BY saldoawal_detail.kode_barang,saldoawal_detail.kode_saldoawal";
    return $this->db->query($query);
  }
}
