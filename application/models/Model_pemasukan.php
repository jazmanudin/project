<?php

class Model_pemasukan extends CI_Model
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

  function hapus_pemasukan()
  {

    $id_member      = $this->session->userdata('id_member');
    $no_pemasukan    = $this->uri->segment(3);
    $this->db->query("DELETE FROM pemasukan WHERE no_pemasukan = '$no_pemasukan' AND id_member = '$id_member' ");
    $this->db->query("DELETE FROM pemasukan_detail WHERE no_pemasukan = '$no_pemasukan' AND id_member = '$id_member' ");
    redirect('pemasukan/view_pemasukan');
  }

  function hapus_pemasukan_temp()
  {

    $kode_barang    = $this->input->post('kode_barang');
    $id_user        = $this->session->userdata('id_user');
    return $this->db->query("DELETE FROM pemasukan_temp WHERE kode_barang = '$kode_barang' AND id_user = '$id_user' ");
  }

  function view_pemasukan()
  {
    $id_member      = $this->session->userdata('id_member');
    $no_pemasukan        = $this->input->post('no_pemasukan');
    $dari               = $this->input->post('dari');
    $sampai             = $this->input->post('sampai');

    if ($no_pemasukan != "") {
      $no_pemasukan = "AND pemasukan.no_pemasukan = '" . $no_pemasukan . "' ";
    }

    if ($dari != "") {
      $dari = "AND pemasukan.tgl_transaksi BETWEEN '" . $dari . "' AND '" . $sampai . "' ";
    }

    $query = "SELECT 
    pemasukan.no_pemasukan,
    pemasukan.keterangan,
    pemasukan.asal_barang,
    pemasukan.tgl_transaksi
    
    FROM pemasukan
  
    WHERE pemasukan.id_member = '$id_member' "
      . $no_pemasukan
      . $dari
      . "
    GROUP BY 
    pemasukan.no_pemasukan,
    pemasukan.keterangan,
    pemasukan.asal_barang,
    pemasukan.tgl_transaksi
    LIMIT 20
    ";
    return $this->db->query($query);
  }

  function detail_pemasukan()
  {
    $no_pemasukan        = $this->input->post('no_pemasukan');
    $id_member          = $this->session->userdata('id_member');

    $query = "SELECT pemasukan_detail.kode_barang,SUM(qty) AS qty,nama_barang,keterangan,satuan
    FROM pemasukan_detail 
    INNER JOIN barang ON pemasukan_detail.kode_barang=barang.kode_barang 
    WHERE pemasukan_detail.id_member = '$id_member' AND pemasukan_detail.no_pemasukan = '$no_pemasukan'
    GROUP BY pemasukan_detail.kode_barang,pemasukan_detail.no_pemasukan";
    return $this->db->query($query);
  }

  function view_pemasukan_temp()
  {
    $query = "SELECT pemasukan_temp.kode_barang,satuan,pemasukan_temp.keterangan,SUM(qty) AS qty,nama_barang
    FROM pemasukan_temp 
    INNER JOIN barang ON pemasukan_temp.kode_barang=barang.kode_barang 
    GROUP BY pemasukan_temp.kode_barang";
    return $this->db->query($query);
  }

  function cekbarang()
  {
    $kode_barang    = $this->input->post('kode_barang');
    $query = "SELECT pemasukan_temp.kode_barang
    FROM pemasukan_temp 
    INNER JOIN barang ON pemasukan_temp.kode_barang=barang.kode_barang 
    WHERE pemasukan_temp.kode_barang = '$kode_barang'
    GROUP BY pemasukan_temp.kode_barang";
    echo $this->db->query($query)->num_rows();
  }

  function insert_pemasukan_temp()
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
    $this->db->insert('pemasukan_temp', $data);
  }

  function insert_pemasukan()
  {

    $tahun    = date('y');
    $bulan    = date('m');
    $this->db->select('right(pemasukan.no_pemasukan,3) as kode ', false);
    $this->db->where('mid(no_pemasukan,5,2)', $bulan);
    $this->db->where('mid(no_pemasukan,7,2)', $tahun);
    $this->db->order_by('no_pemasukan', 'desc');
    $this->db->limit('13');
    $query    = $this->db->get('pemasukan');
    if ($query->num_rows() <> 0) {
      $data   = $query->row();
      $kode   = intval($data->kode) + 1;
    } else {
      $kode   = 1;
    }
    $kodemax  = str_pad($kode, 3, "0", STR_PAD_LEFT);
    $no_pemasukan   = "MSK-" . $bulan . "" . $tahun . "" . $kodemax;

    $id_member          = $this->session->userdata('id_member');
    $id_user            = $this->session->userdata('id_user');
    $tgl_transaksi      = $this->input->post('tgl_transaksi');
    $asal_barang      = $this->input->post('asal_barang');
    $keterangan         = $this->input->post('keterangan');

    $data = array(
      'no_pemasukan'    => $no_pemasukan,
      'asal_barang'     => $asal_barang,
      'tgl_transaksi'   => $tgl_transaksi,
      'keterangan'      => $keterangan,
      'id_member'       => $id_member
    );
    $this->db->insert('pemasukan', $data);

    $datapenj = $this->db->query("SELECT * FROM pemasukan_temp WHERE id_user = '$id_user'");
    foreach ($datapenj->result() as $d) {

      $data = array(
        'no_pemasukan'    => $no_pemasukan,
        'kode_barang'     => $d->kode_barang,
        'qty'             => $d->qty,
        'id_member'       => $id_member
      );
      $this->db->insert('pemasukan_detail', $data);
      $this->db->query("UPDATE barang SET stok = stok+'$d->qty' WHERE kode_barang = '$d->kode_barang' AND id_member = '$id_member'");
    }
    $datapenj = $this->db->query("DELETE FROM pemasukan_temp WHERE id_user = '$id_user'");
  }

  public function codeotomatis()
  {
    $tahun    = date('y');
    $bulan    = date('m');
    $this->db->select('right(pemasukan.no_pemasukan,3) as kode ', false);
    $this->db->where('mid(no_pemasukan,5,2)', $bulan);
    $this->db->where('mid(no_pemasukan,7,2)', $tahun);
    $this->db->order_by('no_pemasukan', 'desc');
    $this->db->limit('13');
    $query    = $this->db->get('pemasukan');
    if ($query->num_rows() <> 0) {
      $data   = $query->row();
      $kode   = intval($data->kode) + 1;
    } else {
      $kode   = 1;
    }
    $kodemax  = str_pad($kode, 3, "0", STR_PAD_LEFT);
    echo "MSK-" . $bulan . "" . $tahun . "" . $kodemax;
  }
}
