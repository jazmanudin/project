<?php

class Model_penjualan extends CI_Model
{

  function kategori_barang()
  {

    return $this->db->query("SELECT * FROM kategori");
  }

  function hapus_penjualan()
  {

    $id_member      = $this->session->userdata('id_member');
    $no_fak_penj    = $this->uri->segment(3);
    $this->db->query("DELETE FROM penjualan WHERE no_fak_penj = '$no_fak_penj' AND id_member = '$id_member' ");
    $this->db->query("DELETE FROM penjualan_detail WHERE no_fak_penj = '$no_fak_penj' AND id_member = '$id_member' ");
    $this->db->query("DELETE FROM penjualan_histori_bayar WHERE no_fak_penj = '$no_fak_penj' AND id_member = '$id_member' ");
    redirect('penjualan/view_penjualan');
  }

  function hapus_penjualan_temp()
  {

    $kode_barang    = $this->input->post('kode_barang');
    return $this->db->query("DELETE FROM penjualan_temp WHERE kode_barang = '$kode_barang' LIMIT 1");
  }

  function view_penjualan()
  {
    $id_member          = $this->session->userdata('id_member');
    $no_fak_penj        = $this->input->post('no_fak_penj');
    $dari               = $this->input->post('dari');
    $sampai             = $this->input->post('sampai');

    if ($no_fak_penj != "") {
      $no_fak_penj = "AND penjualan.no_fak_penj = '" . $no_fak_penj . "' ";
    }

    if ($dari != "") {
      $dari = "AND penjualan.tgl_transaksi BETWEEN '" . $dari . "' AND '" . $sampai . "' ";
    }

    $query = "SELECT 
    penjualan.no_fak_penj,
    penjualan.potongan,
    penjualan.keterangan,
    penjualan.kode_pelanggan,
    penjualan.total,
    penjualan.tgl_transaksi,
    penjualan.no_meja,
    hs.jumlahbayar
    
    FROM penjualan
    LEFT JOIN(
      SELECT no_fak_penj,SUM(jumlah) AS jumlahbayar FROM penjualan_histori_bayar 
      GROUP BY no_fak_penj
      ) hs ON (penjualan.no_fak_penj = hs.no_fak_penj)
  
    WHERE penjualan.id_member = '$id_member' "
      . $no_fak_penj
      . $dari
      . "
    GROUP BY 
    penjualan.no_fak_penj,
    penjualan.potongan,
    penjualan.keterangan,
    penjualan.kode_pelanggan,
    penjualan.tgl_transaksi,
    penjualan.total,
    hs.jumlahbayar
    ORDER BY penjualan.tgl_transaksi DESC
    LIMIT 100
    ";
    return $this->db->query($query);
  }

  function bayar_piutang()
  {
    $id_member          = $this->session->userdata('id_member');
    $no_fak_penj        = $this->input->post('no_fak_penj');

    $query = "SELECT 
    penjualan.no_fak_penj,
    penjualan.potongan,
    penjualan.keterangan,
    penjualan.kode_pelanggan,
    penjualan.total,
    penjualan.tgl_transaksi,
    penjualan.no_meja,
    hs.jumlahbayar
    
    FROM penjualan
    LEFT JOIN(
      SELECT no_fak_penj,SUM(jumlah) AS jumlahbayar FROM penjualan_histori_bayar 
      GROUP BY no_fak_penj
      ) hs ON (penjualan.no_fak_penj = hs.no_fak_penj)
  
    WHERE penjualan.id_member = '$id_member' AND penjualan.no_fak_penj = '$no_fak_penj'
    GROUP BY 
    penjualan.no_fak_penj,
    penjualan.potongan,
    penjualan.keterangan,
    penjualan.kode_pelanggan,
    penjualan.tgl_transaksi,
    penjualan.total,
    hs.jumlahbayar
    LIMIT 1
    ";
    return $this->db->query($query);
  }

  function detail_penjualan()
  {
    $no_fak_penj        = $this->input->post('no_fak_penj');
    $id_member          = $this->session->userdata('id_member');

    $query = "SELECT penjualan_detail.kode_barang,SUM(qty) AS qty,nama_barang,penjualan_detail.harga 
    FROM penjualan_detail 
    INNER JOIN barang ON penjualan_detail.kode_barang=barang.kode_barang 
    WHERE penjualan_detail.id_member = '$id_member' AND penjualan_detail.no_fak_penj = '$no_fak_penj'
    GROUP BY penjualan_detail.kode_barang";
    return $this->db->query($query);
  }

  function view_penjualan_temp()
  {
    $query = "SELECT penjualan_temp.kode_barang,SUM(qty) AS qty,nama_barang,barang.harga 
    FROM penjualan_temp 
    INNER JOIN barang ON penjualan_temp.kode_barang=barang.kode_barang 
    GROUP BY penjualan_temp.kode_barang";
    return $this->db->query($query);
  }

  function insert_penjualan_temp()
  {

    $kode_barang    = $this->input->post('kode_barang');
    $qty            = $this->input->post('qty');
    $harga          = $this->input->post('harga');
    $id_user        = $this->session->userdata('id_user');

    $data = array(
      'kode_barang' => $kode_barang,
      'qty'         => $qty,
      'harga'       => $harga,
      'id_user'     => $id_user
    );
    $this->db->insert('penjualan_temp', $data);
  }

  function insert_penjualan()
  {

    $tahun    = date('y');
    $bulan    = date('m');
    $this->db->select('right(penjualan.no_fak_penj,3) as kode ', false);
    $this->db->where('mid(no_fak_penj,5,2)', $bulan);
    $this->db->where('mid(no_fak_penj,7,2)', $tahun);
    $this->db->order_by('no_fak_penj', 'desc');
    $this->db->limit('13');
    $query    = $this->db->get('penjualan');
    if ($query->num_rows() <> 0) {
      $data   = $query->row();
      $kode   = intval($data->kode) + 1;
    } else {
      $kode   = 1;
    }
    $kodemax  = str_pad($kode, 3, "0", STR_PAD_LEFT);
    $no_fak_penj   = "FAK-" . $bulan . "" . $tahun . "" . $kodemax;

    $tgl_transaksi      = Date('Y-m-d');
    $id_member          = $this->session->userdata('id_member');
    $id_user            = $this->session->userdata('id_user');
    $potongan           = str_replace(",", "", $this->input->post('potongan'));
    $total              = str_replace(",", "", $this->input->post('total'));
    $jmlbayar           = str_replace(",", "", $this->input->post('jmlbayar'));
    $kembalian          = str_replace(",", "", $this->input->post('kembalian'));
    $no_meja            = str_replace(",", "", $this->input->post('no_meja'));
    $keterangan         = $this->input->post('keterangan');

    $data = array(
      'no_fak_penj'     => $no_fak_penj,
      'kode_pelanggan'  => "-",
      'potongan'        => $potongan,
      'total'           => $total,
      'tgl_transaksi'   => $tgl_transaksi,
      'keterangan'      => $keterangan,
      'no_meja'         => $no_meja,
      'id_member'       => $id_member
    );
    $this->db->insert('penjualan', $data);

    $this->db->select('right(penjualan_histori_bayar.nobukti,3) as kode ', false);
    $this->db->where('left(nobukti,2)', $bulan);
    $this->db->where('mid(nobukti,3,2)', $tahun);
    $this->db->order_by('nobukti', 'desc');
    $this->db->limit('13');
    $query    = $this->db->get('penjualan_histori_bayar');
    if ($query->num_rows() <> 0) {
      $data   = $query->row();
      $kode   = intval($data->kode) + 1;
    } else {
      $kode   = 1;
    }
    $kodemaxs = str_pad($kode, 3, "0", STR_PAD_LEFT);
    $nobukti  = $bulan  . $tahun . $kodemaxs;

    $data = array(
      'nobukti'         => $nobukti,
      'no_fak_penj'     => $no_fak_penj,
      'tgl_bayar'       => $tgl_transaksi,
      'jumlah'          => $jmlbayar - $kembalian,
      'id_member'       => $id_member
    );
    $this->db->insert('penjualan_histori_bayar', $data);

    $datapenj = $this->db->query("SELECT * FROM penjualan_temp WHERE id_user = '$id_user'");
    foreach ($datapenj->result() as $d) {

      $data = array(
        'no_fak_penj'     => $no_fak_penj,
        'kode_barang'     => $d->kode_barang,
        'qty'             => $d->qty,
        'harga'           => $d->harga,
        'id_member'       => $id_member
      );
      $this->db->insert('penjualan_detail', $data);
      $this->db->query("UPDATE barang SET stok = stok-'$d->qty' WHERE kode_barang = '$d->kode_barang' AND id_member = '$id_member'");
    }
    $datapenj = $this->db->query("DELETE FROM penjualan_temp WHERE id_user = '$id_user'");
  }

  function insert_piutang()
  {
    $tahun    = date('y');
    $bulan    = date('m');
    $this->db->select('right(penjualan_histori_bayar.nobukti,3) as kode ', false);
    $this->db->where('left(nobukti,2)', $bulan);
    $this->db->where('mid(nobukti,3,2)', $tahun);
    $this->db->order_by('nobukti', 'desc');
    $this->db->limit('13');
    $query    = $this->db->get('penjualan_histori_bayar');
    if ($query->num_rows() <> 0) {
      $data   = $query->row();
      $kode   = intval($data->kode) + 1;
    } else {
      $kode   = 1;
    }
    $kodemax  = str_pad($kode, 3, "0", STR_PAD_LEFT);
    $nobukti  = $bulan  . $tahun . $kodemax;

    $no_fak_penj    = $this->input->post('no_fak_penj');
    $jmlbayar       = str_replace(",", "", $this->input->post('jmlbayar'));
    $tgl_bayar      = date('Y-m-d');
    $id_member      = $this->session->userdata('id_member');

    $data = array(
      'nobukti'          => $nobukti,
      'no_fak_penj'       => $no_fak_penj,
      'tgl_bayar'         => $tgl_bayar,
      'jumlah'            => $jmlbayar,
      'id_member'         => $id_member
    );
    $this->db->insert('penjualan_histori_bayar', $data);
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
