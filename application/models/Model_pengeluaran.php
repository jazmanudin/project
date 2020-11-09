<?php

class Model_pengeluaran extends CI_Model
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

  function hapus_pengeluaran()
  {

    $id_member      = $this->session->userdata('id_member');
    $no_pengeluaran    = $this->uri->segment(3);
    $this->db->query("DELETE FROM pengeluaran WHERE no_pengeluaran = '$no_pengeluaran' AND id_member = '$id_member' ");
    $this->db->query("DELETE FROM pengeluaran_detail WHERE no_pengeluaran = '$no_pengeluaran' AND id_member = '$id_member' ");
    redirect('pengeluaran/view_pengeluaran');
  }

  function hapus_pengeluaran_temp()
  {

    $kode_barang    = $this->input->post('kode_barang');
    $id_user        = $this->session->userdata('id_user');
    return $this->db->query("DELETE FROM pengeluaran_temp WHERE kode_barang = '$kode_barang' AND id_user = '$id_user' ");
  }

  function view_pengeluaran()
  {
    $id_member      = $this->session->userdata('id_member');
    $no_pengeluaran        = $this->input->post('no_pengeluaran');
    $dari               = $this->input->post('dari');
    $sampai             = $this->input->post('sampai');

    if ($no_pengeluaran != "") {
      $no_pengeluaran = "AND pengeluaran.no_pengeluaran = '" . $no_pengeluaran . "' ";
    }

    if ($dari != "") {
      $dari = "AND pengeluaran.tgl_transaksi BETWEEN '" . $dari . "' AND '" . $sampai . "' ";
    }

    $query = "SELECT 
    pengeluaran.no_pengeluaran,
    pengeluaran.keterangan,
    pengeluaran.jenis_pengeluaran,
    pengeluaran.tgl_transaksi
    
    FROM pengeluaran
  
    WHERE pengeluaran.id_member = '$id_member' "
      . $no_pengeluaran
      . $dari
      . "
    GROUP BY 
    pengeluaran.no_pengeluaran,
    pengeluaran.keterangan,
    pengeluaran.jenis_pengeluaran,
    pengeluaran.tgl_transaksi
    LIMIT 20
    ";
    return $this->db->query($query);
  }

  function detail_pengeluaran()
  {
    $no_pengeluaran        = $this->input->post('no_pengeluaran');
    $id_member          = $this->session->userdata('id_member');

    $query = "SELECT pengeluaran_detail.kode_barang,SUM(qty) AS qty,nama_barang,keterangan,satuan
    FROM pengeluaran_detail 
    INNER JOIN barang ON pengeluaran_detail.kode_barang=barang.kode_barang 
    WHERE pengeluaran_detail.id_member = '$id_member' AND pengeluaran_detail.no_pengeluaran = '$no_pengeluaran'
    GROUP BY pengeluaran_detail.kode_barang,pengeluaran_detail.no_pengeluaran";
    return $this->db->query($query);
  }

  function view_pengeluaran_temp()
  {
    $query = "SELECT pengeluaran_temp.kode_barang,satuan,pengeluaran_temp.keterangan,SUM(qty) AS qty,nama_barang
    FROM pengeluaran_temp 
    INNER JOIN barang ON pengeluaran_temp.kode_barang=barang.kode_barang 
    GROUP BY pengeluaran_temp.kode_barang";
    return $this->db->query($query);
  }

  function cekbarang()
  {
    $kode_barang    = $this->input->post('kode_barang');
    $query = "SELECT pengeluaran_temp.kode_barang
    FROM pengeluaran_temp 
    INNER JOIN barang ON pengeluaran_temp.kode_barang=barang.kode_barang 
    WHERE pengeluaran_temp.kode_barang = '$kode_barang'
    GROUP BY pengeluaran_temp.kode_barang";
    echo $this->db->query($query)->num_rows();
  }

  function insert_pengeluaran_temp()
  {

    $kode_barang    = $this->input->post('kode_barang');
    $qty            = str_replace(",", "", $this->input->post('qty'));
    $keterangan     = $this->input->post('keterangan');
    $id_user        = $this->session->userdata('id_user');

    $data = array(
      'kode_barang'       => $kode_barang,
      'qty'               => $qty,
      'keterangan'        => $keterangan,
      'id_user'           => $id_user
    );
    $this->db->insert('pengeluaran_temp', $data);
  }

  function insert_pengeluaran()
  {

    $tahun    = date('y');
    $bulan    = date('m');
    $this->db->select('right(pengeluaran.no_pengeluaran,3) as kode ', false);
    $this->db->where('mid(no_pengeluaran,5,2)', $bulan);
    $this->db->where('mid(no_pengeluaran,7,2)', $tahun);
    $this->db->order_by('no_pengeluaran', 'desc');
    $this->db->limit('13');
    $query    = $this->db->get('pengeluaran');
    if ($query->num_rows() <> 0) {
      $data   = $query->row();
      $kode   = intval($data->kode) + 1;
    } else {
      $kode   = 1;
    }
    $kodemax  = str_pad($kode, 3, "0", STR_PAD_LEFT);
    $no_pengeluaran   = "KLR-" . $bulan . "" . $tahun . "" . $kodemax;

    $id_member          = $this->session->userdata('id_member');
    $id_user            = $this->session->userdata('id_user');
    $tgl_transaksi      = $this->input->post('tgl_transaksi');
    $jenis_pengeluaran      = $this->input->post('jenis_pengeluaran');
    $keterangan         = $this->input->post('keterangan');

    $data = array(
      'no_pengeluaran'    => $no_pengeluaran,
      'jenis_pengeluaran'     => $jenis_pengeluaran,
      'tgl_transaksi'   => $tgl_transaksi,
      'keterangan'      => $keterangan,
      'id_member'       => $id_member
    );
    $this->db->insert('pengeluaran', $data);

    $datapenj = $this->db->query("SELECT * FROM pengeluaran_temp WHERE id_user = '$id_user'");
    foreach ($datapenj->result() as $d) {

      $data = array(
        'no_pengeluaran'    => $no_pengeluaran,
        'kode_barang'     => $d->kode_barang,
        'qty'             => $d->qty,
        'id_member'       => $id_member
      );
      $this->db->insert('pengeluaran_detail', $data);
      $this->db->query("UPDATE barang SET stok = stok-'$d->qty' WHERE kode_barang = '$d->kode_barang' AND id_member = '$id_member'");
    }
    $datapenj = $this->db->query("DELETE FROM pengeluaran_temp WHERE id_user = '$id_user'");
  }

  public function codeotomatis()
  {
    $tahun    = date('y');
    $bulan    = date('m');
    $this->db->select('right(pengeluaran.no_pengeluaran,3) as kode ', false);
    $this->db->where('mid(no_pengeluaran,5,2)', $bulan);
    $this->db->where('mid(no_pengeluaran,7,2)', $tahun);
    $this->db->order_by('no_pengeluaran', 'desc');
    $this->db->limit('13');
    $query    = $this->db->get('pengeluaran');
    if ($query->num_rows() <> 0) {
      $data   = $query->row();
      $kode   = intval($data->kode) + 1;
    } else {
      $kode   = 1;
    }
    $kodemax  = str_pad($kode, 3, "0", STR_PAD_LEFT);
    echo "KLR-" . $bulan . "" . $tahun . "" . $kodemax;
  }
}
