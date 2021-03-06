<?php

class Model_purchaseorder extends CI_Model
{

  function view_supplier()
  {
    return $this->db->query("SELECT * FROM supplier ");
  }

  function get_barangbarcode()
  {

    $year         = date('Y');
    $month         = date('m');
    $date         = date('d') + 01;
    $tglnow       = $year . "-" . $month . "-" . $date;

    $kode_barang     = $this->input->post('kode_barang');
    $jenis_harga     = $this->input->post('jenis_harga');
    $barang = $this->db->query("SELECT  *
    FROM barang 
    WHERE barang.kode_barang = '$kode_barang'
    ");

    if ($barang->num_rows() > 0) {

      $barang = $barang->row_array();
      echo $barang['nama_barang'] . "|" . $barang['satuan'] . "|" . $barang['harga_modal'] ;
    }
  }

  function hapus_purchaseorder()
  {

    $id_member      = $this->session->userdata('id_member');
    $no_po    = $this->uri->segment(3);
    $this->db->query("DELETE FROM purchaseorder WHERE no_po = '$no_po' ");
    $this->db->query("DELETE FROM purchaseorder_detail WHERE no_po = '$no_po' ");
    $this->db->query("DELETE FROM pembelian_temp WHERE no_po = '$no_po' ");
    redirect('purchaseorder/view_purchaseorder');
  }

  function hapus_purchaseorder_temp()
  {

    $kode_barang    = $this->input->post('kode_barang');
    $id_user        = $this->session->userdata('id_user');
    return $this->db->query("DELETE FROM purchaseorder_temp WHERE kode_barang = '$kode_barang' AND id_user = '$id_user' ");
  }

  function hapus_purchaseorder_detail()
  {

    $kode_barang      = $this->input->post('kode_barang');
    return $this->db->query("DELETE FROM purchaseorder_detail WHERE kode_barang = '$kode_barang'");
  }

  public function getPurchase()
  {

    $no_po    = $this->uri->segment(3);

    $this->db->select('purchaseorder.ppn,purchaseorder.no_po,tgl_transaksi,nama_supplier,purchaseorder.kode_supplier,purchaseorder.total,purchaseorder.keterangan');
    $this->db->from('purchaseorder');
    $this->db->join('supplier', 'purchaseorder.kode_supplier = supplier.kode_supplier');
    $this->db->where('purchaseorder.no_po', $no_po);
    $this->db->order_by('tgl_transaksi,no_po', 'DESC');

    $query = $this->db->get();
    return $query->row_array();
  }

  public function getDataPurchase($rowno, $rowperpage, $no_po = "", $kode_supplier = "", $dari = "", $sampai = "")
  {

    $this->db->select('purchaseorder.no_po,tgl_transaksi,status,ppn,nama_supplier,purchaseorder.kode_supplier,purchaseorder.total,purchaseorder.keterangan');
    $this->db->from('purchaseorder');
    $this->db->join('supplier', 'purchaseorder.kode_supplier = supplier.kode_supplier');
    $this->db->order_by('tgl_transaksi,no_po', 'DESC');

    if ($no_po != '') {
      $this->db->like('purchaseorder.no_po', $no_po);
    }

    if ($kode_supplier != '') {
      $this->db->like('purchaseorder.kode_supplier', $kode_supplier);
    }

    if ($dari != '') {
      $this->db->where('purchaseorder.tgl_transaksi BETWEEN "' . $dari . '" AND "' . $sampai . '"');
    }

    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function getRecordPurchaseCount($no_po = "", $kode_supplier = "", $dari = "", $sampai = "")
  {

    $this->db->select('count(*) as allcount');
    $this->db->from('purchaseorder');
    $this->db->join('supplier', 'purchaseorder.kode_supplier = supplier.kode_supplier');
    $this->db->order_by('tgl_transaksi,purchaseorder.no_po', 'DESC');

    if ($no_po != '') {
      $this->db->like('purchaseorder.no_po', $no_po);
    }

    if ($kode_supplier != '') {
      $this->db->like('purchaseorder.kode_supplier', $kode_supplier);
    }

    if ($dari != '') {
      $this->db->where('purchaseorder.tgl_transaksi BETWEEN "' . $dari . '" AND "' . $sampai . '"');
    }

    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  function detail_purchaseorder()
  {
    $no_po              = $this->input->post('no_po');

    $query = "SELECT barang.satuan,purchaseorder_detail.kode_barang,SUM(qty) AS qty,nama_barang,purchaseorder_detail.harga_modal,purchaseorder_detail.keterangan 
    FROM purchaseorder_detail 
    INNER JOIN barang ON purchaseorder_detail.kode_barang=barang.kode_barang 
    WHERE purchaseorder_detail.no_po = '$no_po'
    GROUP BY purchaseorder_detail.kode_barang,purchaseorder_detail.no_po";
    return $this->db->query($query);
  }

  function view_purchaseorder_temp()
  {
    $query = "SELECT purchaseorder_temp.kode_barang,satuan,purchaseorder_temp.keterangan,SUM(qty) AS qty,nama_barang,purchaseorder_temp.harga_modal
    FROM purchaseorder_temp 
    INNER JOIN barang ON purchaseorder_temp.kode_barang=barang.kode_barang 
    GROUP BY purchaseorder_temp.kode_barang";
    return $this->db->query($query);
  }

  function insert_purchaseorder_temp()
  {

    $kode_barang    = $this->input->post('kode_barang');
    $kode_edit      = $this->input->post('kode_edit');
    $harga_modal    = str_replace(",", "", $this->input->post('harga_modal'));
    $qty            = str_replace(",", "", $this->input->post('qty'));
    $keterangan     = $this->input->post('keterangan');
    $id_user        = $this->session->userdata('id_user');

    $data = array(
      'kode_barang'       => $kode_barang,
      'qty'               => $qty,
      'harga_modal'       => $harga_modal,
      'keterangan'        => $keterangan,
      'id_user'           => $id_user
    );
    if ($kode_edit == "1") {
      $this->db->query("DELETE FROM purchaseorder_temp WHERE kode_barang = '$kode_barang' AND id_user = '$id_user' ");
      $this->db->insert('purchaseorder_temp', $data);
    } else {
      $this->db->insert('purchaseorder_temp', $data);
    }
  }

  function insert_purchaseorder_detail()
  {

    $no_po          = $this->input->post('no_po');
    $kode_barang    = $this->input->post('kode_barang');
    $kode_edit      = $this->input->post('kode_edit');
    $harga_modal    = str_replace(",", "", $this->input->post('harga_modal'));
    $qty            = str_replace(",", "", $this->input->post('qty'));
    $keterangan     = $this->input->post('keterangan');

    $data = array(
      'no_po'             => $no_po,
      'kode_barang'       => $kode_barang,
      'qty'               => $qty,
      'harga_modal'       => $harga_modal,
      'keterangan'        => $keterangan
    );
    if ($kode_edit == "1") {
      $this->db->query("DELETE FROM purchaseorder_detail WHERE kode_barang = '$kode_barang' AND no_po = '$no_po' ");
      $this->db->query("DELETE FROM pembelian_temp WHERE kode_barang = '$kode_barang' AND no_po = '$no_po' ");
      $this->db->insert('purchaseorder_detail', $data);
      $this->db->insert('pembelian_temp', $data);

    } else {
      $this->db->insert('purchaseorder_detail', $data);
      $this->db->insert('pembelian_temp', $data);
    }
  }

  function insert_purchaseorder()
  {

    $tahun    = date('y');
    $bulan    = date('m');
    $this->db->select('right(purchaseorder.no_po,3) as kode ', false);
    $this->db->where('mid(no_po,4,2)', $bulan);
    $this->db->where('mid(no_po,6,2)', $tahun);
    $this->db->order_by('no_po', 'desc');
    $this->db->limit('13');
    $query    = $this->db->get('purchaseorder');
    if ($query->num_rows() <> 0) {
      $data   = $query->row();
      $kode   = intval($data->kode) + 1;
    } else {
      $kode   = 1;
    }
    $kodemax  = str_pad($kode, 3, "0", STR_PAD_LEFT);
    $no_po   = "PO-" . $bulan . "" . $tahun . "" . $kodemax;

    $id_user            = $this->session->userdata('id_user');
    $subtotal           = str_replace(",", "", $this->input->post('subtotal'));
    $tgl_transaksi      = $this->input->post('tgl_transaksi');
    $kode_supplier      = $this->input->post('kode_supplier');
    $ppn                = $this->input->post('ppn');
    $keterangan         = $this->input->post('keterangan');

    $data = array(
      'no_po'           => $no_po,
      'kode_supplier'   => $kode_supplier,
      'total'           => $subtotal,
      'ppn'             => $ppn,
      'tgl_transaksi'   => $tgl_transaksi,
      'status'          => "0",
      'keterangan'      => $keterangan,
      'id_user'         => $id_user
    );
    $this->db->insert('purchaseorder', $data);

    $datapenj = $this->db->query("SELECT * FROM purchaseorder_temp WHERE id_user = '$id_user'");
    foreach ($datapenj->result() as $d) {

      $data = array(
        'no_po'           => $no_po,
        'kode_barang'     => $d->kode_barang,
        'qty'             => $d->qty,
        'harga_modal'     => $d->harga_modal,
        'keterangan'      => $d->keterangan
      );
      $this->db->insert('purchaseorder_detail', $data);

      $datapemb = array(
        'no_po'           => $no_po,
        'kode_barang'     => $d->kode_barang,
        'qty'             => $d->qty,
        'harga_modal'     => $d->harga_modal,
        'keterangan'      => $d->keterangan,
        'id_user'         => $id_user
      );
      $this->db->insert('pembelian_temp', $datapemb);
    }
    $datapenj = $this->db->query("DELETE FROM purchaseorder_temp WHERE id_user = '$id_user'");
  }

  function update_purchaseorder()
  {

    $id_user            = $this->session->userdata('id_user');
    $subtotal           = str_replace(",", "", $this->input->post('subtotal'));
    $no_po              = $this->input->post('no_po');
    $tgl_transaksi      = $this->input->post('tgl_transaksi');
    $kode_supplier      = $this->input->post('kode_supplier');
    $ppn                = $this->input->post('ppn');
    $keterangan         = $this->input->post('keterangan');

    $data = array(
      'no_po'           => $no_po,
      'kode_supplier'   => $kode_supplier,
      'total'           => $subtotal,
      'ppn'             => $ppn,
      'tgl_transaksi'   => $tgl_transaksi,
      'keterangan'      => $keterangan,
      'id_user'         => $id_user
    );

    $this->db->where('no_po', $no_po);
    $this->db->update('purchaseorder', $data);
  }

  public function codeotomatis()
  {
    $tahun    = date('y');
    $bulan    = date('m');
    $this->db->select('right(purchaseorder.no_po,3) as kode ', false);
    $this->db->where('mid(no_po,4,2)', $bulan);
    $this->db->where('mid(no_po,6,2)', $tahun);
    $this->db->order_by('no_po', 'desc');
    $this->db->limit('13');
    $query    = $this->db->get('purchaseorder');
    if ($query->num_rows() <> 0) {
      $data   = $query->row();
      $kode   = intval($data->kode) + 1;
    } else {
      $kode   = 1;
    }
    $kodemax  = str_pad($kode, 3, "0", STR_PAD_LEFT);
    echo "PO-" . $bulan . "" . $tahun . "" . $kodemax;
  }

  function get_supplier()
  {
    $keyword      = $this->uri->segment(3);
    $data         = $this->db->from('supplier')->like('nama_supplier', $keyword)->get();
    foreach ($data->result() as $d) {

      $supplier['query'] = $keyword;
      $supplier['suggestions'][] = array(
        'value'                   =>    $d->nama_supplier,
        'kode_supplier'           =>    $d->kode_supplier,
        'nama_supplier'           =>    $d->nama_supplier
      );
    }
    echo json_encode($supplier);
  }

  function get_barang()
  {
    $keyword    = $this->uri->segment(3);

    $year       = date('Y');
    $month      = date('m');
    $date       = date('d') + 01;
    $tglnow     = $year . "-" . $month . "-" . $date;

    $data = $this->db->query("SELECT 
    barang.kode_barang,
    barang.nama_barang,
    barang.satuan,
    barang.harga_modal

    FROM barang 
    
    WHERE barang.nama_barang LIKE '%$keyword%' AND barang.kode_barang NOT IN (SELECT kode_barang FROM purchaseorder_temp)");
    foreach ($data->result() as $d) {

      $supplier['query'] = $keyword;
      $supplier['suggestions'][] = array(
        'value'                   =>    $d->nama_barang,
        'kode_barang'             =>    $d->kode_barang,
        'nama_barang'             =>    $d->nama_barang,
        'satuan'                  =>    $d->satuan,
        'harga_modal'             =>    $d->harga_modal
      );
    }
    echo json_encode($supplier);
  }
}
