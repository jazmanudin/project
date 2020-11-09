<?php

class Model_pembayaran extends CI_Model
{

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

  function hapus_pembayaran_hutang_temp()
  {

    $no_fak_pemb    = $this->input->post('no_fak_pemb');
    $id_user        = $this->session->userdata('id_user');
    $id_member      = $this->session->userdata('id_member');
    return $this->db->query("DELETE FROM pembayaran_hutang_temp WHERE no_fak_pemb = '$no_fak_pemb' AND id_user = '$id_user' AND id_member = '$id_member' ");
  }

  function hapus_pembayaran_hutang()
  {

    $nobukti        = $this->uri->segment(3);
    $id_member      = $this->session->userdata('id_member');
    $this->db->query("DELETE FROM pembayaran_hutang WHERE nobukti = '$nobukti' AND id_member = '$id_member' ");
    $this->db->query("DELETE FROM pembayaran_hutang_detail WHERE nobukti = '$nobukti' AND id_member = '$id_member' ");
    redirect('pembayaran/view_pembayaran_hutang');
  }

  public function getDataPembayaranHutang($rowno, $rowperpage, $nobukti = "", $kode_supplier = "", $dari = "", $sampai = "")
  {

    $id_member          = $this->session->userdata('id_member');
    $this->db->select('nobukti,jumlah,pembayaran_hutang.keterangan,tgl_bayar,nama_supplier,jenis_pembayaran,pembayaran_hutang.kode_supplier');
    $this->db->from('pembayaran_hutang');
    $this->db->join('supplier', 'pembayaran_hutang.kode_supplier = supplier.kode_supplier', 'left');
    $this->db->where('pembayaran_hutang.id_member', $id_member);
    $this->db->order_by('pembayaran_hutang.nobukti', 'DESC');

    if ($nobukti != '') {
      $this->db->like('pembayaran_hutang.nobukti', $nobukti);
    }

    if ($kode_supplier != '') {
      $this->db->where('pembayaran_hutang.kode_supplier', $kode_supplier);
    }

    if ($dari != '') {
      $this->db->where('pembayaran_hutang.tgl_bayar BETWEEN "' . $dari . '" AND "' . $sampai . '"');
    }

    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function getRecordPembayaranHutangCount($nobukti = "", $kode_supplier = "", $dari = "", $sampai = "")
  {

    $id_member          = $this->session->userdata('id_member');
    $this->db->select('count(*) as allcount');
    $this->db->from('pembayaran_hutang');
    $this->db->join('supplier', 'pembayaran_hutang.kode_supplier = supplier.kode_supplier', 'left');
    $this->db->where('pembayaran_hutang.id_member', $id_member);
    $this->db->order_by('pembayaran_hutang.nobukti', 'DESC');

    if ($nobukti != '') {
      $this->db->like('pembayaran_hutang.nobukti', $nobukti);
    }

    if ($kode_supplier != '') {
      $this->db->where('pembayaran_hutang.kode_supplier', $kode_supplier);
    }

    if ($dari != '') {
      $this->db->where('pembayaran_hutang.tgl_bayar BETWEEN "' . $dari . '" AND "' . $sampai . '"');
    }

    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  function view_pembayaran_hutang_temp()
  {
    $id_member          = $this->session->userdata('id_member');
    $id_user            = $this->session->userdata('id_user');
    $kode_supplier      = $this->input->post('kode_supplier');

    $query = "SELECT 
    v_bayar_hutang.jumlahbayar,
    pembelian.potongan,
    pembelian.kode_supplier,
    pembelian.total,
    pembayaran_hutang_temp.no_fak_pemb,
    pembayaran_hutang_temp.jumlah,
    pembayaran_hutang_temp.keterangan

    FROM pembayaran_hutang_temp
    INNER JOIN pembelian ON pembelian.no_fak_pemb=pembayaran_hutang_temp.no_fak_pemb
    LEFT JOIN v_bayar_hutang ON v_bayar_hutang.no_fak_pemb=pembayaran_hutang_temp.no_fak_pemb

    WHERE pembayaran_hutang_temp.id_member = '$id_member' AND pembayaran_hutang_temp.id_user = '$id_user' AND pembelian.kode_supplier = '$kode_supplier'
    GROUP BY no_fak_pemb";
    return $this->db->query($query);
  }

  function view_pembayaran_hutang_detail()
  {
    $id_member          = $this->session->userdata('id_member');
    $nobukti            = $this->input->post('nobukti');

    $query = "SELECT 
    v_bayar_hutang.jumlahbayar,
    pembelian.potongan,
    pembelian.kode_supplier,
    pembelian.total,
    pembayaran_hutang_detail.no_fak_pemb,
    pembayaran_hutang_detail.jumlah,
    pembayaran_hutang_detail.keterangan

    FROM pembayaran_hutang_detail
    INNER JOIN pembelian ON pembelian.no_fak_pemb=pembayaran_hutang_detail.no_fak_pemb
    LEFT JOIN v_bayar_hutang ON v_bayar_hutang.no_fak_pemb=pembelian.no_fak_pemb

    WHERE pembayaran_hutang_detail.id_member = '$id_member' AND pembayaran_hutang_detail.nobukti = '$nobukti'
    GROUP BY no_fak_pemb";
    return $this->db->query($query);
  }

  function view_faktur_pemb()
  {
    $id_member          = $this->session->userdata('id_member');
    $kode_supplier      = $this->input->post('kode_supplier');

    $query = "SELECT 
    pembelian.no_fak_pemb,
    pembelian.potongan,
    pembelian.keterangan,
    pembelian.kode_supplier,
    pembelian.total,
    pembelian.no_po,
    supplier.nama_supplier,
    pembelian.tgl_transaksi,
    v_bayar_hutang.jumlahbayar
    
    FROM pembelian
    INNER JOIN supplier ON supplier.kode_supplier=pembelian.kode_supplier
    LEFT JOIN v_bayar_hutang ON v_bayar_hutang.no_fak_pemb=pembelian.no_fak_pemb

    WHERE pembelian.id_member = '$id_member' 
    AND pembelian.kode_supplier = '$kode_supplier' 

    ";
    return $this->db->query($query);
  }

  function detail_pembayaran_hutang()
  {
    $id_member          = $this->session->userdata('id_member');
    $nobukti            = $this->input->post('nobukti');

    $query = "SELECT *,pembayaran_hutang_detail.jumlah
    FROM pembayaran_hutang_detail
    LEFT JOIN v_bayar_hutang ON v_bayar_hutang.no_fak_pemb=pembayaran_hutang_detail.no_fak_pemb
    LEFT JOIN pembayaran_hutang ON pembayaran_hutang.nobukti=pembayaran_hutang_detail.nobukti
    INNER JOIN supplier ON supplier.kode_supplier=pembayaran_hutang.kode_supplier

    WHERE pembayaran_hutang_detail.id_member = '$id_member' 
    AND pembayaran_hutang_detail.nobukti = '$nobukti' 
    ORDER BY pembayaran_hutang_detail.no_fak_pemb ASC
    ";
    return $this->db->query($query);
  }

  function getPembayaranHutang()
  {
    $id_member          = $this->session->userdata('id_member');
    $nobukti            = $this->uri->segment(3);

    $query = "SELECT *
    FROM pembayaran_hutang
    INNER JOIN supplier ON supplier.kode_supplier=pembayaran_hutang.kode_supplier

    WHERE pembayaran_hutang.id_member = '$id_member' 
    AND pembayaran_hutang.nobukti = '$nobukti' 
    ";
    return $this->db->query($query);
  }

  function detail_pembelian()
  {
    $id_member      = $this->session->userdata('id_member');
    $no_fak_pemb    = $this->input->post('no_fak_pemb');
    return $this->db->query("SELECT * FROM pembelian_detail
    INNER JOIN barang ON barang.kode_barang=pembelian_detail.kode_barang
    WHERE pembelian_detail.id_member = '$id_member' AND pembelian_detail.no_fak_pemb = '$no_fak_pemb' ");
  }

  function insert_pembayaran_hutang_temp()
  {

    $no_fak_pemb    = $this->input->post('no_fak_pemb');
    $jumlah_bayar   = str_replace(",", "", $this->input->post('jumlah_bayar'));
    $keterangan     = $this->input->post('keterangan');
    $kode_edit      = $this->input->post('kode_edit');
    $id_user        = $this->session->userdata('id_user');
    $id_member      = $this->session->userdata('id_member');

    $data = array(
      'no_fak_pemb'       => $no_fak_pemb,
      'jumlah'            => $jumlah_bayar,
      'keterangan'        => $keterangan,
      'id_user'           => $id_user,
      'id_member'         => $id_member
    );

    if ($kode_edit == "0") {
      $this->db->insert('pembayaran_hutang_temp', $data);
    } else {
      $this->db->where('id_user', $id_user);
      $this->db->where('id_member', $id_member);
      $this->db->where('no_fak_pemb', $no_fak_pemb);
      $this->db->update('pembayaran_hutang_temp', $data);
    }
  }

  function insert_pembayaran_hutang_detail()
  {

    $nobukti        = $this->input->post('nobukti');
    $no_fak_pemb    = $this->input->post('no_fak_pemb');
    $jumlah_bayar   = str_replace(",", "", $this->input->post('jumlah_bayar'));
    $keterangan     = $this->input->post('keterangan');
    $kode_edit      = $this->input->post('kode_edit');
    $id_member      = $this->session->userdata('id_member');

    $data = array(
      'nobukti'           => $nobukti,
      'no_fak_pemb'       => $no_fak_pemb,
      'jumlah'            => $jumlah_bayar,
      'keterangan'        => $keterangan,
      'id_member'         => $id_member
    );

    if ($kode_edit == "0") {
      $this->db->insert('pembayaran_hutang_detail', $data);
    } else {
      $this->db->where('id_member', $id_member);
      $this->db->where('nobukti', $nobukti);
      $this->db->where('no_fak_pemb', $no_fak_pemb);
      $this->db->update('pembayaran_hutang_detail', $data);
    }
  }

  function update_pembayaran_hutang()
  {

    $nobukti        = $this->input->post('nobukti');
    $tgl_bayar        = $this->input->post('tgl_bayar');
    $kode_supplier    = $this->input->post('kode_supplier');
    $jenis_pembayaran = $this->input->post('jenis_pembayaran');
    $total            = str_replace(",", "", $this->input->post('total'));
    $id_member        = $this->session->userdata('id_member');

    $data = array(
      'nobukti'           => $nobukti,
      'jenis_pembayaran'  => $jenis_pembayaran,
      'tgl_bayar'         => $tgl_bayar,
      'jumlah'            => $total,
      'id_member'         => $id_member
    );

    $this->db->where('id_member', $id_member);
    $this->db->where('nobukti', $nobukti);
    $this->db->update('pembayaran_hutang', $data);
  }

  function insert_pembayaran_hutang()
  {
    $tahun    = date('y');
    $bulan    = date('m');
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
    $kodemax  = str_pad($kode, 3, "0", STR_PAD_LEFT);
    $nobukti  = $bulan  . $tahun . $kodemax;

    $tgl_bayar        = $this->input->post('tgl_bayar');
    $kode_supplier    = $this->input->post('kode_supplier');
    $jenis_pembayaran = $this->input->post('jenis_pembayaran');
    $total            = str_replace(",", "", $this->input->post('total'));
    $id_member        = $this->session->userdata('id_member');
    $id_user          = $this->session->userdata('id_user');

    $data = array(
      'nobukti'           => $nobukti,
      'kode_supplier'     => $kode_supplier,
      'jenis_pembayaran'  => $jenis_pembayaran,
      'tgl_bayar'         => $tgl_bayar,
      'jumlah'            => $total,
      'id_member'         => $id_member
    );
    $this->db->insert('pembayaran_hutang', $data);

    $databayar = $this->db->query("SELECT * FROM pembayaran_hutang_temp 
    INNER JOIN pembelian ON pembelian.no_fak_pemb=pembayaran_hutang_temp.no_fak_pemb
    WHERE pembayaran_hutang_temp.id_user = '$id_user' AND pembayaran_hutang_temp.id_member = '$id_member' AND kode_supplier = '$kode_supplier' 
    GROUP BY pembayaran_hutang_temp.no_fak_pemb
    ");
    foreach ($databayar->result() as $d) {

      $databayar = array(
        'nobukti'         => $nobukti,
        'no_fak_pemb'     => $d->no_fak_pemb,
        'jumlah'          => $d->jumlah,
        'keterangan'      => $d->keterangan,
        'id_member'       => $id_member
      );
      $this->db->insert('pembayaran_hutang_detail', $databayar);

      $this->db->query("DELETE FROM pembayaran_hutang_temp WHERE id_user = '$id_user' AND id_member = '$id_member'  AND no_fak_pemb = '$d->no_fak_pemb'");
    }
  }

  public function codeotomatispemb()
  {
    $tahun    = date('y');
    $bulan    = date('m');
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
    $kodemax  = str_pad($kode, 3, "0", STR_PAD_LEFT);
    echo $bulan  . $tahun . $kodemax;
  }
}
