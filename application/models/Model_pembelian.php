<?php

class Model_pembelian extends CI_Model
{

  function kategori_barang()
  {
    $id_member      = $this->session->userdata('id_member');
    return $this->db->query("SELECT * FROM kategori WHERE id_member = '$id_member' ");
  }

  function view_supplier()
  {
    $id_member      = $this->session->userdata('id_member');
    return $this->db->query("SELECT * FROM supplier WHERE id_member = '$id_member' ");
  }

  function view_barang()
  {
    $id_member      = $this->session->userdata('id_member');
    return $this->db->query("SELECT * FROM barang WHERE id_member = '$id_member' ");
  }

  function hapus_pembelian()
  {

    $id_member      = $this->session->userdata('id_member');
    $no_fak_pemb    = $this->uri->segment(3);
    $this->db->query("DELETE FROM pembelian WHERE no_fak_pemb = '$no_fak_pemb' AND id_member = '$id_member' ");
    $this->db->query("DELETE FROM pembelian_detail WHERE no_fak_pemb = '$no_fak_pemb' AND id_member = '$id_member' ");
    redirect('pembelian/view_pembelian');
  }

  function hapus_pembelian_temp()
  {

    $kode_barang    = $this->input->post('kode_barang');
    return $this->db->query("DELETE FROM pembelian_temp WHERE kode_barang = '$kode_barang' LIMIT 1");
  }

  function view_pembelian()
  {
    $id_member          = $this->session->userdata('id_member');
    $no_fak_pemb        = $this->input->post('no_fak_pemb');
    $dari               = $this->input->post('dari');
    $sampai             = $this->input->post('sampai');

    if ($no_fak_pemb != "") {
      $no_fak_pemb = "AND pembelian.no_fak_pemb = '" . $no_fak_pemb . "' ";
    }

    if ($dari != "") {
      $dari = "AND pembelian.tgl_transaksi BETWEEN '" . $dari . "' AND '" . $sampai . "' ";
    }

    $query = "SELECT 
    pembelian.no_fak_pemb,
    pembelian.potongan,
    pembelian.keterangan,
    pembelian.kode_supplier,
    pembelian.total,
    pembelian.tgl_transaksi,
    hs.jumlahbayar
    
    FROM pembelian
    LEFT JOIN(
      SELECT no_fak_pemb,SUM(jumlah) AS jumlahbayar FROM pembelian_histori_bayar 
      GROUP BY no_fak_pemb
      ) hs ON (pembelian.no_fak_pemb = hs.no_fak_pemb)
  
    WHERE pembelian.id_member = '$id_member' "
      . $no_fak_pemb
      . $dari
      . "
    GROUP BY 
    pembelian.no_fak_pemb,
    pembelian.potongan,
    pembelian.keterangan,
    pembelian.kode_supplier,
    pembelian.tgl_transaksi,
    pembelian.total,
    hs.jumlahbayar
    LIMIT 20
    ";
    return $this->db->query($query);
  }

  function bayar_hutang()
  {
    $id_member          = $this->session->userdata('id_member');
    $no_fak_pemb        = $this->input->post('no_fak_pemb');

    $query = "SELECT 
    pembelian.no_fak_pemb,
    pembelian.potongan,
    pembelian.keterangan,
    pembelian.kode_supplier,
    pembelian.total,
    pembelian.tgl_transaksi,
    hs.jumlahbayar
    
    FROM pembelian
    LEFT JOIN(
      SELECT no_fak_pemb,SUM(jumlah) AS jumlahbayar FROM pembelian_histori_bayar 
      GROUP BY no_fak_pemb
      ) hs ON (pembelian.no_fak_pemb = hs.no_fak_pemb)
  
    WHERE pembelian.id_member = '$id_member' AND pembelian.no_fak_pemb = '$no_fak_pemb'
    GROUP BY 
    pembelian.no_fak_pemb,
    pembelian.potongan,
    pembelian.keterangan,
    pembelian.kode_supplier,
    pembelian.tgl_transaksi,
    pembelian.total,
    hs.jumlahbayar
    LIMIT 1
    ";
    return $this->db->query($query);
  }

  function detail_pembelian()
  {
    $no_fak_pemb        = $this->input->post('no_fak_pemb');
    $id_member          = $this->session->userdata('id_member');

    $query = "SELECT pembelian_detail.kode_barang,SUM(qty) AS qty,nama_barang,pembelian_detail.harga 
    FROM pembelian_detail 
    INNER JOIN barang ON pembelian_detail.kode_barang=barang.kode_barang 
    WHERE pembelian_detail.id_member = '$id_member' AND pembelian_detail.no_fak_pemb = '$no_fak_pemb'
    GROUP BY pembelian_detail.kode_barang";
    return $this->db->query($query);
  }

  function view_pembelian_temp()
  {
    $query = "SELECT pembelian_temp.kode_barang,SUM(qty) AS qty,nama_barang,barang.harga 
    FROM pembelian_temp 
    INNER JOIN barang ON pembelian_temp.kode_barang=barang.kode_barang 
    GROUP BY pembelian_temp.kode_barang";
    return $this->db->query($query);
  }

  function insert_pembelian_temp()
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
    $this->db->insert('pembelian_temp', $data);
  }

  function insert_pembelian()
  {

    $tahun    = date('y');
    $bulan    = date('m');
    $this->db->select('right(pembelian.no_fak_pemb,3) as kode ', false);
    $this->db->where('mid(no_fak_pemb,5,2)', $bulan);
    $this->db->where('mid(no_fak_pemb,7,2)', $tahun);
    $this->db->order_by('no_fak_pemb', 'desc');
    $this->db->limit('13');
    $query    = $this->db->get('pembelian');
    if ($query->num_rows() <> 0) {
      $data   = $query->row();
      $kode   = intval($data->kode) + 1;
    } else {
      $kode   = 1;
    }
    $kodemax  = str_pad($kode, 3, "0", STR_PAD_LEFT);
    $no_fak_pemb   = "FAK-" . $bulan . "" . $tahun . "" . $kodemax;

    $tgl_transaksi      = Date('Y-m-d');
    $id_member          = $this->session->userdata('id_member');
    $id_user            = $this->session->userdata('id_user');
    $potongan           = str_replace(",", "", $this->input->post('potongan'));
    $total              = str_replace(",", "", $this->input->post('total'));
    $jmlbayar           = str_replace(",", "", $this->input->post('jmlbayar'));
    $kembalian          = str_replace(",", "", $this->input->post('kembalian'));
    $keterangan         = str_replace(",", "", $this->input->post('keterangan'));

    $data = array(
      'no_fak_pemb'     => $no_fak_pemb,
      'kode_supplier'  => "-",
      'potongan'        => $potongan,
      'total'           => $total,
      'tgl_transaksi'   => $tgl_transaksi,
      'keterangan'      => $keterangan,
      'id_member'       => $id_member
    );
    $this->db->insert('pembelian', $data);

    $this->db->select('right(pembelian_histori_bayar.nobukti,3) as kode ', false);
    $this->db->where('left(nobukti,2)', $bulan);
    $this->db->where('mid(nobukti,3,2)', $tahun);
    $this->db->order_by('nobukti', 'desc');
    $this->db->limit('13');
    $query    = $this->db->get('pembelian_histori_bayar');
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
      'no_fak_pemb'     => $no_fak_pemb,
      'tgl_bayar'       => $tgl_transaksi,
      'jumlah'          => $jmlbayar - $kembalian,
      'id_member'       => $id_member
    );
    $this->db->insert('pembelian_histori_bayar', $data);

    $datapenj = $this->db->query("SELECT * FROM pembelian_temp WHERE id_user = '$id_user'");
    foreach ($datapenj->result() as $d) {

      $data = array(
        'no_fak_pemb'     => $no_fak_pemb,
        'kode_barang'     => $d->kode_barang,
        'qty'             => $d->qty,
        'harga'           => $d->harga,
        'id_member'       => $id_member
      );
      $this->db->insert('pembelian_detail', $data);
    }
    $datapenj = $this->db->query("DELETE FROM pembelian_temp WHERE id_user = '$id_user'");
  }

  function insert_hutang()
  {
    $tahun    = date('y');
    $bulan    = date('m');
    $this->db->select('right(pembelian_histori_bayar.nobukti,3) as kode ', false);
    $this->db->where('left(nobukti,2)', $bulan);
    $this->db->where('mid(nobukti,3,2)', $tahun);
    $this->db->order_by('nobukti', 'desc');
    $this->db->limit('13');
    $query    = $this->db->get('pembelian_histori_bayar');
    if ($query->num_rows() <> 0) {
      $data   = $query->row();
      $kode   = intval($data->kode) + 1;
    } else {
      $kode   = 1;
    }
    $kodemax  = str_pad($kode, 3, "0", STR_PAD_LEFT);
    $nobukti  = $bulan  . $tahun . $kodemax;

    $no_fak_pemb    = $this->input->post('no_fak_pemb');
    $jmlbayar       = str_replace(",", "", $this->input->post('jmlbayar'));
    $tgl_bayar      = date('Y-m-d');
    $id_member      = $this->session->userdata('id_member');

    $data = array(
      'nobukti'          => $nobukti,
      'no_fak_pemb'       => $no_fak_pemb,
      'tgl_bayar'         => $tgl_bayar,
      'jumlah'            => $jmlbayar,
      'id_member'         => $id_member
    );
    $this->db->insert('pembelian_histori_bayar', $data);
  }

}