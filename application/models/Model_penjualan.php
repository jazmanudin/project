<?php

class Model_penjualan extends CI_Model
{

  function view_pelanggan()
  {
    $id_member      = $this->session->userdata('id_member');
    return $this->db->query("SELECT * FROM pelanggan WHERE id_member = '$id_member' ");
  }

  function view_sales()
  {
    $id_member          = $this->session->userdata('id_member');
    $kode_pelanggan     = $this->input->post('kode_pelanggan');
    return $this->db->query("SELECT kode_pelanggan,jenis_harga,id_sales,nama_karyawan,nama_pelanggan FROM pelanggan 
    INNER JOIN karyawan ON karyawan.nik AND pelanggan.id_sales 
    WHERE pelanggan.id_member = '$id_member' AND kode_pelanggan = '$kode_pelanggan' ");
  }

  function view_barang()
  {

    $year         = date('Y');
    $month         = date('m');
    $date         = date('d') + 01;
    $tglnow       = $year . "-" . $month . "-" . $date;

    $id_member      = $this->session->userdata('id_member');
    return $this->db->query("SELECT 
    barang.kode_barang,
    barang.nama_barang,
    barang.satuan,
    barang.keterangan,
    barang.pelanggan_tetap,
    barang.tidak_tetap,
    barang.eceran,
    barang.grosir,
    barang.lainnya,
    barang.kode_kategori,
    kategori.nama_kategori,
    db.stok,
    db.stoks,
    db.exp_date

    FROM barang 
    INNER JOIN kategori ON kategori.kode_kategori=barang.kode_kategori
   
    LEFT JOIN (SELECT SUM( IF( exp_date >= '$tglnow' , stok ,0 )) AS stok, SUM(stok) AS stoks,
    kode_barang,exp_date FROM barang_detail 
    WHERE id_member = '$id_member'
    GROUP BY kode_barang
    ORDER BY exp_date ASC) db ON (barang.kode_barang=db.kode_barang)

    WHERE barang.id_member = '$id_member' ");
  }

  function hapus_penjualan()
  {

    $id_member      = $this->session->userdata('id_member');
    $no_fak_penj    = $this->uri->segment(3);
    $this->db->query("DELETE FROM penjualan WHERE no_fak_penj = '$no_fak_penj' AND id_member = '$id_member' ");
    $this->db->query("DELETE FROM penjualan_detail WHERE no_fak_penj = '$no_fak_penj' AND id_member = '$id_member' ");
    $this->db->query("DELETE FROM penjualan_temp WHERE no_fak_penj = '$no_fak_penj' AND id_member = '$id_member' ");
    redirect('penjualan/view_penjualan');
  }

  function hapus_penjualan_temp()
  {

    $kode_barang    = $this->input->post('kode_barang');
    $id_user        = $this->session->userdata('id_user');
    return $this->db->query("DELETE FROM penjualan_temp WHERE kode_barang = '$kode_barang' AND id_user = '$id_user' ");
  }

  function hapus_penjualan_detail()
  {

    $kode_barang      = $this->input->post('kode_barang');
    $id_member        = $this->session->userdata('id_member');
    return $this->db->query("DELETE FROM penjualan_detail WHERE kode_barang = '$kode_barang' AND id_member = '$id_member' ");
  }

  public function getpenjualan()
  {

    $no_fak_penj    = $this->uri->segment(3);

    $this->db->select('penjualan.ppn,jenis_harga,karyawan.nama_karyawan,penjualan.id_sales,penjualan.no_fak_penj,tgl_transaksi,nama_pelanggan,penjualan.kode_pelanggan,penjualan.total,penjualan.keterangan');
    $this->db->from('penjualan');
    $this->db->join('pelanggan', 'penjualan.kode_pelanggan = pelanggan.kode_pelanggan');
    $this->db->join('karyawan', 'penjualan.id_sales = karyawan.nik', 'left');
    $this->db->where('penjualan.no_fak_penj', $no_fak_penj);
    $this->db->order_by('tgl_transaksi,no_fak_penj', 'DESC');

    $query = $this->db->get();
    return $query->row_array();
  }

  public function getDatapenjualan($rowno, $rowperpage, $no_fak_penj = "", $kode_pelanggan = "", $dari = "", $sampai = "")
  {

    $this->db->select('penjualan.no_fak_penj,tgl_transaksi,status,ppn,nama_pelanggan,penjualan.kode_pelanggan,penjualan.total,penjualan.keterangan');
    $this->db->from('penjualan');
    $this->db->join('pelanggan', 'penjualan.kode_pelanggan = pelanggan.kode_pelanggan');
    $this->db->order_by('tgl_transaksi,no_fak_penj', 'DESC');

    if ($no_fak_penj != '') {
      $this->db->like('penjualan.no_fak_penj', $no_fak_penj);
    }

    if ($kode_pelanggan != '') {
      $this->db->like('penjualan.kode_pelanggan', $kode_pelanggan);
    }

    if ($dari != '') {
      $this->db->where('penjualan.tgl_transaksi BETWEEN "' . $dari . '" AND "' . $sampai . '"');
    }

    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function getRecordpenjualanCount($no_fak_penj = "", $kode_pelanggan = "", $dari = "", $sampai = "")
  {

    $this->db->select('count(*) as allcount');
    $this->db->from('penjualan');
    $this->db->join('pelanggan', 'penjualan.kode_pelanggan = pelanggan.kode_pelanggan');
    $this->db->order_by('tgl_transaksi,penjualan.no_fak_penj', 'DESC');

    if ($no_fak_penj != '') {
      $this->db->like('penjualan.no_fak_penj', $no_fak_penj);
    }

    if ($kode_pelanggan != '') {
      $this->db->like('penjualan.kode_pelanggan', $kode_pelanggan);
    }

    if ($dari != '') {
      $this->db->where('penjualan.tgl_transaksi BETWEEN "' . $dari . '" AND "' . $sampai . '"');
    }

    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  function detail_penjualan()
  {
    $no_fak_penj              = $this->input->post('no_fak_penj');
    $id_member          = $this->session->userdata('id_member');

    $year         = date('Y');
    $month         = date('m');
    $date         = date('d') + 01;
    $tglnow       = $year . "-" . $month . "-" . $date;

    $query = "SELECT barang.satuan,penjualan_detail.kode_barang,db.stok,SUM(qty) AS qty,nama_barang,penjualan_detail.harga_jual,penjualan_detail.keterangan 
    FROM penjualan_detail 
    INNER JOIN barang ON penjualan_detail.kode_barang=barang.kode_barang 

    LEFT JOIN (SELECT SUM( IF( exp_date >= '$tglnow' , stok ,0 )) AS stok,
    kode_barang,exp_date FROM barang_detail 
    WHERE id_member = '$id_member'
    GROUP BY kode_barang
    ORDER BY exp_date ASC) db ON (penjualan_detail.kode_barang=db.kode_barang)

    WHERE penjualan_detail.id_member = '$id_member' AND penjualan_detail.no_fak_penj = '$no_fak_penj'
    GROUP BY penjualan_detail.kode_barang,penjualan_detail.no_fak_penj";
    return $this->db->query($query);
  }

  function view_penjualan_temp()
  {
    $year               = date('Y');
    $month              = date('m');
    $date               = date('d') + 01;
    $tglnow             = $year . "-" . $month . "-" . $date;
    $id_user            = $this->session->userdata('id_user');
    $id_member          = $this->session->userdata('id_member');
    $query = "SELECT penjualan_temp.kode_barang,satuan,db.stok,penjualan_temp.keterangan,SUM(qty) AS qty,nama_barang,penjualan_temp.harga_jual
    FROM penjualan_temp 
    INNER JOIN barang ON penjualan_temp.kode_barang=barang.kode_barang 

    LEFT JOIN (SELECT SUM( IF( exp_date >= '$tglnow' , stok ,0 )) AS stok,
    kode_barang,exp_date FROM barang_detail 
    WHERE id_member = '$id_member'
    GROUP BY kode_barang
    ORDER BY exp_date ASC) db ON (penjualan_temp.kode_barang=db.kode_barang)

    WHERE penjualan_temp.id_user = '$id_user'
    GROUP BY penjualan_temp.kode_barang";
    return $this->db->query($query);
  }

  function cekbarang()
  {
    $kode_barang    = $this->input->post('kode_barang');
    $query = "SELECT penjualan_temp.kode_barang
    FROM penjualan_temp 
    INNER JOIN barang ON penjualan_temp.kode_barang=barang.kode_barang 
    WHERE penjualan_temp.kode_barang = '$kode_barang'
    GROUP BY penjualan_temp.kode_barang";
    echo $this->db->query($query)->num_rows();
  }

  function insert_penjualan_temp()
  {

    $kode_barang    = $this->input->post('kode_barang');
    $kode_edit      = $this->input->post('kode_edit');
    $harga_jual     = str_replace(",", "", $this->input->post('harga_jual'));
    $qty            = str_replace(",", "", $this->input->post('qty'));
    $keterangan     = $this->input->post('keterangan');
    $id_user        = $this->session->userdata('id_user');

    $data = array(
      'kode_barang'       => $kode_barang,
      'qty'               => $qty,
      'harga_jual'        => $harga_jual,
      'keterangan'        => $keterangan,
      'id_user'           => $id_user
    );
    if ($kode_edit == "1") {
      $this->db->where('kode_barang', $kode_barang);
      $this->db->where('id_user', $id_user);
      $this->db->update('penjualan_temp', $data);
    } else {
      $this->db->insert('penjualan_temp', $data);
    }
  }

  function insert_penjualan_detail()
  {

    $no_fak_penj          = $this->input->post('no_fak_penj');
    $kode_barang    = $this->input->post('kode_barang');
    $kode_edit      = $this->input->post('kode_edit');
    $harga_jual    = str_replace(",", "", $this->input->post('harga_jual'));
    $qty            = str_replace(",", "", $this->input->post('qty'));
    $keterangan     = $this->input->post('keterangan');
    $id_member        = $this->session->userdata('id_member');

    $data = array(
      'no_fak_penj'             => $no_fak_penj,
      'kode_barang'       => $kode_barang,
      'qty'               => $qty,
      'harga_jual'       => $harga_jual,
      'keterangan'        => $keterangan,
      'id_member'         => $id_member
    );
    if ($kode_edit == "1") {
      $this->db->where('no_fak_penj', $no_fak_penj);
      $this->db->where('kode_barang', $kode_barang);
      $this->db->where('id_member', $id_member);
      $this->db->update('penjualan_detail', $data);
      $this->db->update('penjualan_temp', $data);
    } else {
      $this->db->insert('penjualan_detail', $data);
      $this->db->insert('penjualan_temp', $data);
    }
  }

  function insert_penjualan()
  {

    $tahun    = date('y');
    $bulan    = date('m');
    $this->db->select('right(penjualan.no_fak_penj,4) as kode ', false);
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
    $kodemax  = str_pad($kode, 4, "0", STR_PAD_LEFT);
    $no_fak_penj   = "FAK-" . $bulan . "" . $tahun . "" . $kodemax;

    $id_member          = $this->session->userdata('id_member');
    $id_user            = $this->session->userdata('id_user');
    $subtotal           = str_replace(",", "", $this->input->post('subtotal'));
    $tgl_transaksi      = $this->input->post('tgl_transaksi');
    $id_sales           = $this->input->post('id_sales');
    $kode_pelanggan     = $this->input->post('kode_pelanggan');
    $ppn                = $this->input->post('ppn');
    $keterangan         = $this->input->post('keterangan');

    $data = array(
      'no_fak_penj'           => $no_fak_penj,
      'kode_pelanggan'  => $kode_pelanggan,
      'id_sales'        => $id_sales,
      'total'           => $subtotal,
      'ppn'             => $ppn,
      'tgl_transaksi'   => $tgl_transaksi,
      'status'          => "0",
      'keterangan'      => $keterangan,
      'id_member'       => $id_member
    );
    $this->db->insert('penjualan', $data);

    $datapenj = $this->db->query("SELECT penjualan_temp.kode_barang,satuan,db.exp_date,penjualan_temp.keterangan,SUM(qty) AS qty,nama_barang,penjualan_temp.harga_jual
    FROM penjualan_temp 
    INNER JOIN barang ON penjualan_temp.kode_barang=barang.kode_barang 

    LEFT JOIN (SELECT 
    kode_barang,exp_date FROM barang_detail 
    WHERE id_member = '$id_member'
    GROUP BY kode_barang
    ORDER BY exp_date ASC) db ON (penjualan_temp.kode_barang=db.kode_barang)

    WHERE penjualan_temp.id_user = '$id_user'
    GROUP BY penjualan_temp.kode_barang");
    foreach ($datapenj->result() as $d) {

      $data = array(
        'no_fak_penj'           => $no_fak_penj,
        'kode_barang'     => $d->kode_barang,
        'qty'             => $d->qty,
        'harga_jual'      => $d->harga_jual,
        'keterangan'      => $d->keterangan,
        'id_member'       => $id_member
      );
      $this->db->insert('penjualan_detail', $data);

      $datapemb = array(
        'no_fak_penj'           => $no_fak_penj,
        'kode_barang'     => $d->kode_barang,
        'qty'             => $d->qty,
        'harga_jual'      => $d->harga_jual,
        'keterangan'      => $d->keterangan,
        'id_member'       => $id_member,
        'id_user'         => $id_user
      );
      $this->db->insert('penjualan_temp', $datapemb);
      $this->db->query("UPDATE barang_detail SET stok = stok-'$d->qty' WHERE kode_barang = '$d->kode_barang' AND id_member = '$id_member' ORDER BY id DESC LIMIT 1");
    }
    $datapenj = $this->db->query("DELETE FROM penjualan_temp WHERE id_user = '$id_user'");
  }

  function update_penjualan()
  {

    $id_member          = $this->session->userdata('id_member');
    $id_user            = $this->session->userdata('id_user');
    $subtotal           = str_replace(",", "", $this->input->post('subtotal'));
    $no_fak_penj              = $this->input->post('no_fak_penj');
    $id_sales           = $this->input->post('id_sales');
    $tgl_transaksi      = $this->input->post('tgl_transaksi');
    $kode_pelanggan     = $this->input->post('kode_pelanggan');
    $ppn                = $this->input->post('ppn');
    $keterangan         = $this->input->post('keterangan');

    $data = array(
      'no_fak_penj'           => $no_fak_penj,
      'kode_pelanggan'  => $kode_pelanggan,
      'total'           => $subtotal,
      'ppn'             => $ppn,
      'id_sales'        => $id_sales,
      'tgl_transaksi'   => $tgl_transaksi,
      'keterangan'      => $keterangan,
      'id_member'       => $id_member
    );

    $this->db->where('no_fak_penj', $no_fak_penj);
    $this->db->where('id_member', $id_member);
    $this->db->update('penjualan', $data);
  }

  public function codeotomatis()
  {
    $tahun    = date('y');
    $bulan    = date('m');
    $this->db->select('right(penjualan.no_fak_penj,4) as kode ', false);
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
    $kodemax  = str_pad($kode, 4, "0", STR_PAD_LEFT);
    echo "FAK-" . $bulan . "" . $tahun . "" . $kodemax;
  }
}
