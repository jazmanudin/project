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

    $kode_supplier    = $this->uri->segment(4);
    $id_member        = $this->session->userdata('id_member');

    if ($kode_supplier != "") {
      $kode_supplier = "AND supplier.kode_supplier = '" . $kode_supplier . "' ";
    }

    return $this->db->query("SELECT * FROM supplier WHERE id_member = '$id_member' "
      . $kode_supplier
      . "
    ");
  }

  function getSupplier()
  {

    $kode_supplier    = $this->input->post('kode_supplier');
    $id_member        = $this->session->userdata('id_member');
    return $this->db->query("SELECT * FROM supplier WHERE id_member = '$id_member' AND supplier.kode_supplier ='$kode_supplier'
    ");
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
    // $this->db->query("DELETE FROM pembayaran_hutang_detail WHERE no_fak_pemb = '$no_fak_pemb' AND id_member = '$id_member' ");
    redirect('pembelian/view_pembelian');
  }

  function hapus_pembelian_temp()
  {

    $kode_barang    = $this->input->post('kode_barang');
    $id_user        = $this->session->userdata('id_user');
    return $this->db->query("DELETE FROM pembelian_temp WHERE kode_barang = '$kode_barang' AND id_user = '$id_user' ");
  }

  public function getDataPembelian($rowno, $rowperpage, $no_fak_pemb = "", $kode_supplier = "", $dari = "", $sampai = "")
  {

    $id_member          = $this->session->userdata('id_member');
    $this->db->select('v_bayar_hutang.jumlahbayar,pembelian.jenis_transaksi,pembelian.ppn,pembelian.no_po,pembelian.no_fak_pemb,potongan,tgl_transaksi,nama_supplier,pembelian.kode_supplier,pembelian.total,pembelian.keterangan');
    $this->db->from('pembelian');
    $this->db->join('v_bayar_hutang', 'pembelian.no_fak_pemb = v_bayar_hutang.no_fak_pemb','left');
    $this->db->join('supplier', 'pembelian.kode_supplier = supplier.kode_supplier');
    $this->db->where('pembelian.id_member', $id_member);
    $this->db->order_by('tgl_transaksi,no_fak_pemb', 'DESC');

    if ($no_fak_pemb != '') {
      $this->db->like('pembelian.no_fak_pemb', $no_fak_pemb);
    }

    if ($kode_supplier != '') {
      $this->db->where('pembelian.kode_supplier', $kode_supplier);
    }

    if ($dari != '') {
      $this->db->where('pembelian.tgl_transaksi BETWEEN "' . $dari . '" AND "' . $sampai . '"');
    }

    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function getRecordPembelianCount($no_fak_pemb = "", $kode_supplier = "", $dari = "", $sampai = "")
  {

    $id_member          = $this->session->userdata('id_member');
    $this->db->select('count(*) as allcount');
    $this->db->from('pembelian');
    $this->db->join('v_bayar_hutang', 'pembelian.no_fak_pemb = v_bayar_hutang.no_fak_pemb','left');
    $this->db->join('supplier', 'pembelian.kode_supplier = supplier.kode_supplier');
    $this->db->where('pembelian.id_member', $id_member);
    $this->db->order_by('tgl_transaksi,pembelian.no_fak_pemb', 'DESC');

    if ($no_fak_pemb != '') {
      $this->db->like('pembelian.no_fak_pemb', $no_fak_pemb);
    }

    if ($kode_supplier != '') {
      $this->db->where('pembelian.kode_supplier', $kode_supplier);
    }

    if ($dari != '') {
      $this->db->where('pembelian.tgl_transaksi BETWEEN "' . $dari . '" AND "' . $sampai . '"');
    }

    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  function view_histori_bayar()
  {
    $id_member          = $this->session->userdata('id_member');
    $no_fak_pemb        = $this->input->post('no_fak_pemb');

    $query = "SELECT *
    FROM pembayaran_hutang_detail
    INNER JOIN pembayaran_hutang ON pembayaran_hutang.nobukti=pembayaran_hutang_detail.nobukti 
    WHERE pembayaran_hutang_detail.no_fak_pemb = '$no_fak_pemb' AND pembayaran_hutang.id_member = '$id_member' AND pembayaran_hutang_detail.jumlah != '0'
    ";
    return $this->db->query($query);
  }

  function getPembelian()
  {
    $id_member          = $this->session->userdata('id_member');
    $no_fak_pemb        = $this->uri->segment(3);

    $query = "SELECT 
    pembelian.no_fak_pemb,
    pembelian.potongan,
    pembelian.jenis_transaksi,
    pembelian.ppn,
    pembelian.keterangan,
    pembelian.kode_supplier,
    pembelian.total,
    pembelian.no_po,
    supplier.nama_supplier,
    pembelian.tgl_transaksi
    FROM pembelian
    INNER JOIN supplier ON supplier.kode_supplier=pembelian.kode_supplier
    WHERE pembelian.id_member = '$id_member' AND pembelian.no_fak_pemb = '$no_fak_pemb'
    ";
    return $this->db->query($query);
  }

  function view_pembelian()
  {
    $id_member          = $this->session->userdata('id_member');
    $no_fak_pemb        = $this->input->post('no_fak_pemb');

    $query = "SELECT 
    pembelian.no_fak_pemb,
    pembelian.potongan,
    pembelian.keterangan,
    pembelian.kode_supplier,
    pembelian.total,
    pembelian.no_po,
    supplier.nama_supplier,
    pembelian.tgl_transaksi
    
    FROM pembelian
    INNER JOIN supplier ON supplier.kode_supplier=pembelian.kode_supplier
    WHERE pembelian.id_member = '$id_member' AND pembelian.no_fak_pemb = '$no_fak_pemb'
    ";
    return $this->db->query($query);
  }

  function detail_pembelian()
  {
    $no_fak_pemb        = $this->input->post('no_fak_pemb');
    $id_member          = $this->session->userdata('id_member');

    $query = "SELECT pembelian_detail.exp_date,pembelian_detail.kode_barang,satuan,SUM(qty) AS qty,nama_barang,pembelian_detail.harga_modal,pembelian_detail.keterangan 
    FROM pembelian_detail 
    INNER JOIN barang ON pembelian_detail.kode_barang=barang.kode_barang 
    WHERE pembelian_detail.id_member = '$id_member' AND pembelian_detail.no_fak_pemb = '$no_fak_pemb'
    GROUP BY pembelian_detail.kode_barang,pembelian_detail.no_fak_pemb";
    return $this->db->query($query);
  }

  function view_pembelian_temp()
  {
    $id_member          = $this->session->userdata('id_member');
    $no_po              = $this->input->post('no_po');

    if ($no_po != "") {
      $no_po = "AND pembelian_temp.no_po = '" . $no_po . "' ";
    } else {
      $no_po = "AND pembelian_temp.no_po = '-' ";
    }

    $query = "SELECT pembelian_temp.exp_date,pembelian_temp.kode_barang,satuan,pembelian_temp.keterangan,SUM(qty) AS qty,nama_barang,pembelian_temp.harga_modal
    FROM pembelian_temp 
    LEFT JOIN barang ON pembelian_temp.kode_barang=barang.kode_barang 
    WHERE pembelian_temp.id_member = '$id_member' "
      . $no_po
      . "
    GROUP BY pembelian_temp.kode_barang";
    return $this->db->query($query);
  }

  function cekbarang()
  {
    $kode_barang    = $this->input->post('kode_barang');
    $query = "SELECT pembelian_temp.kode_barang
    FROM pembelian_temp 
    INNER JOIN barang ON pembelian_temp.kode_barang=barang.kode_barang 
    WHERE pembelian_temp.kode_barang = '$kode_barang'
    GROUP BY pembelian_temp.kode_barang";
    echo $this->db->query($query)->num_rows();
  }

  function insert_pembelian_temp()
  {

    $kode_barang    = $this->input->post('kode_barang');
    $harga_modal    = str_replace(",", "", $this->input->post('harga_modal'));
    $qty            = str_replace(",", "", $this->input->post('qty'));
    $keterangan     = $this->input->post('keterangan');
    $exp_date       = $this->input->post('exp_date');
    $kode_edit      = $this->input->post('kode_edit');
    $id_user        = $this->session->userdata('id_user');
    $id_member      = $this->session->userdata('id_member');

    
    if ($kode_edit == "0") {
      $data = array(
        'kode_barang'       => $kode_barang,
        'no_po'             => "-",
        'qty'               => $qty,
        'harga_modal'       => $harga_modal,
        'exp_date'          => $exp_date,
        'keterangan'        => $keterangan,
        'id_user'           => $id_user,
        'id_member'         => $id_member
      );
  
      $this->db->insert('pembelian_temp', $data);
    } else {
      $data = array(
        'kode_barang'       => $kode_barang,
        'qty'               => $qty,
        'harga_modal'       => $harga_modal,
        'exp_date'          => $exp_date,
        'keterangan'        => $keterangan,
        'id_user'           => $id_user,
        'id_member'         => $id_member
      );
      $this->db->where('id_user', $id_user);
      $this->db->where('id_member', $id_member);
      $this->db->where('kode_barang', $kode_barang);
      $this->db->update('pembelian_temp', $data);
    }
  }

  function insert_pembelian_detail()
  {

    $kode_barang    = $this->input->post('kode_barang');
    $no_fak_pemb    = $this->input->post('no_fak_pemb');
    $harga_modal    = str_replace(",", "", $this->input->post('harga_modal'));
    $qty            = str_replace(",", "", $this->input->post('qty'));
    $exp_date       = $this->input->post('exp_date');
    $keterangan     = $this->input->post('keterangan');
    $kode_edit      = $this->input->post('kode_edit');
    $id_member      = $this->session->userdata('id_member');

    $data = array(
      'no_fak_pemb'       => $no_fak_pemb,
      'kode_barang'       => $kode_barang,
      'exp_date'          => $exp_date,
      'qty'               => $qty,
      'harga_modal'       => $harga_modal,
      'keterangan'        => $keterangan,
      'id_member'         => $id_member
    );

    if ($kode_edit == "0") {
      $this->db->insert('pembelian_detail', $data);
    } else {
      $this->db->where('id_member', $id_member);
      $this->db->where('kode_barang', $kode_barang);
      $this->db->where('no_fak_pemb', $no_fak_pemb);
      $this->db->update('pembelian_detail', $data);
    }
  }

  function update_pembelian()
  {

    $id_member          = $this->session->userdata('id_member');
    $potongan           = str_replace(",", "", $this->input->post('potongan'));
    $subtotal           = str_replace(",", "", $this->input->post('subtotal'));
    $no_fak_pemb        = $this->input->post('no_fak_pemb');
    $tgl_transaksi      = $this->input->post('tgl_transaksi');
    $jenis_transaksi    = $this->input->post('jenis_transaksi');
    $kode_supplier      = $this->input->post('kode_supplier');
    $ppn                = $this->input->post('ppn');
    $keterangan         = $this->input->post('keterangan');

    $data = array(
      'kode_supplier'   => $kode_supplier,
      'tgl_transaksi'   => $tgl_transaksi,
      'total'           => $subtotal,
      'potongan'        => $potongan,
      'ppn'             => $ppn,
      'jenis_transaksi' => $jenis_transaksi,
      'jatuh_tempo'     => $tgl_transaksi,
      'keterangan'      => $keterangan,
      'id_member'       => $id_member
    );
    $this->db->where('no_fak_pemb', $no_fak_pemb);
    $this->db->update('pembelian', $data);
  }

  function insert_pembelian()
  {

    $id_member          = $this->session->userdata('id_member');
    $id_user            = $this->session->userdata('id_user');
    $potongan           = str_replace(",", "", $this->input->post('potongan'));
    $subtotal           = str_replace(",", "", $this->input->post('subtotal'));
    $tgl_transaksi      = $this->input->post('tgl_transaksi');
    $jenis_transaksi    = $this->input->post('jenis_transaksi');
    $kode_supplier      = $this->input->post('kode_supplier');
    $ppn                = $this->input->post('ppn');
    $keterangan         = $this->input->post('keterangan');
    $no_po              = $this->input->post('no_po');
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

    $data = array(
      'no_fak_pemb'     => $no_fak_pemb,
      'kode_supplier'   => $kode_supplier,
      'total'           => $subtotal,
      'no_po'           => $no_po,
      'potongan'        => $potongan,
      'ppn'             => $ppn,
      'tgl_transaksi'   => $tgl_transaksi,
      'jenis_transaksi' => $jenis_transaksi,
      'jatuh_tempo'     => $tgl_transaksi,
      'keterangan'      => $keterangan,
      'id_member'       => $id_member
    );
    $this->db->insert('pembelian', $data);

    $this->db->select('right(pembayaran_hutang.nobukti,3) as kode ', false);
    $this->db->where('left(nobukti,2)', $bulan);
    $this->db->where('mid(nobukti,3,2)', $tahun);
    $this->db->order_by('nobukti', 'desc');
    $this->db->limit('13');
    $query    = $this->db->get('pembayaran_hutang');
    if ($query->num_rows() <> 0) {
      $data   = $query->row();
      $kode   = intval($data->kode) + 1;
    } else {
      $kode   = 1;
    }
    $kodemaxs = str_pad($kode, 3, "0", STR_PAD_LEFT);
    $nobukti  = $bulan  . $tahun . $kodemaxs;

    if ($jenis_transaksi == "Tunai") {
      $data = array(
        'nobukti'         => $nobukti,
        'kode_supplier'   => $kode_supplier,
        'tgl_bayar'       => $tgl_transaksi,
        'jumlah'          => $subtotal - $potongan,
        'keterangan'      => "-",
        'jenis_pembayaran'=> "Tunai",
        'id_member'       => $id_member
      );
      $this->db->insert('pembayaran_hutang', $data);

      $data2 = array(
        'nobukti'         => $nobukti,
        'no_fak_pemb'     => $no_fak_pemb,
        'jumlah'          => $subtotal - $potongan,
        'keterangan'      => "-",
        'id_member'       => $id_member
      );
      $this->db->insert('pembayaran_hutang_detail', $data2);
    }

    if ($no_po != "-") {
      $this->db->query("UPDATE purchaseorder SET status = '1' WHERE no_po = '$no_po' AND id_member = '$id_member'");
    }

    $datapemb = $this->db->query("SELECT * FROM pembelian_temp WHERE id_user = '$id_user' AND no_po = '$no_po' ");
    foreach ($datapemb->result() as $d) {

      $datapemb = array(
        'no_fak_pemb'     => $no_fak_pemb,
        'kode_barang'     => $d->kode_barang,
        'qty'             => $d->qty,
        'exp_date'        => $d->exp_date,
        'harga_modal'     => $d->harga_modal,
        'keterangan'      => $d->keterangan,
        'id_member'       => $id_member
      );
      $this->db->insert('pembelian_detail', $datapemb);

      $databarang = array(
        'kode_barang'     => $d->kode_barang,
        'stok'            => $d->qty,
        'exp_date'        => $d->exp_date,
        'id_member'       => $id_member,
        'id_user'         => $id_user
      );
      $this->db->insert('barang_detail', $databarang);
    
      $updateharga = array(
        'harga_modal'     => $d->harga_modal
      );
      $this->db->where('kode_barang', $d->kode_barang);
      $this->db->where('id_member', $id_member);
      $this->db->update('pembelian_detail', $updateharga);

      $this->db->query("DELETE FROM pembelian_temp WHERE id_user = '$id_user' AND id_member = '$id_member'  AND no_po = '$no_po' AND kode_barang = '$d->kode_barang'");
    }
  }

  public function codeotomatis()
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
    echo "FAK-" . $bulan . "" . $tahun . "" . $kodemax;
  }
}
