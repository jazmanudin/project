<?php

class Model_penjualan extends CI_Model
{

  function kategori_barang()
  {

    return $this->db->query("SELECT * FROM kategori");
  }

  function hapus_penjualan_temp()
  {

    $kode_barang    = $this->input->post('kode_barang');
    return $this->db->query("DELETE FROM penjualan_temp WHERE kode_barang = '$kode_barang' LIMIT 1");
  }

  function view_penjualan()
  {
    $id_member          = $this->session->userdata('id_member');

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
  
    WHERE penjualan.id_member = '$id_member'
    GROUP BY 
    penjualan.no_fak_penj,
    penjualan.potongan,
    penjualan.keterangan,
    penjualan.kode_pelanggan,
    penjualan.tgl_transaksi,
    penjualan.total,
    hs.jumlahbayar
    ";
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

  function insert_penjualaan()
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
    $potongan           = str_replace(",","",$this->input->post('potongan'));
    $total              = str_replace(",","",$this->input->post('total'));
    $jmlbayar           = str_replace(",","",$this->input->post('jmlbayar'));
    $kembalian          = str_replace(",","",$this->input->post('kembalian'));
    $keterangan         = str_replace(",","",$this->input->post('keterangan'));

    $data = array(
      'no_fak_penj'     => $no_fak_penj,
      'kode_pelanggan'  => "-",
      'potongan'        => $potongan,
      'total'           => $total,
      'tgl_transaksi'   => $tgl_transaksi,
      'keterangan'      => $keterangan,
      'id_member'       => $id_member
    );
    $this->db->insert('penjualan', $data);

    $data = array(
      'no_fak_penj'     => $no_fak_penj,
      'tgl_bayar'       => $tgl_transaksi,
      'jumlah'          => $jmlbayar-$kembalian,
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
    }
    $datapenj = $this->db->query("DELETE FROM penjualan_temp WHERE id_user = '$id_user'");
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
