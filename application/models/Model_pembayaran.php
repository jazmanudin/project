<?php

class Model_pembayaran extends CI_Model
{

  function view_supplier()
  {

    $kode_supplier    = $this->uri->segment(4);

    if ($kode_supplier != "") {
      $kode_supplier = "WHERE supplier.kode_supplier = '" . $kode_supplier . "' ";
    }

    return $this->db->query("SELECT * FROM supplier "
      . $kode_supplier
      . "
    ");
  }

  function hapus_pembayaran_hutang_temp()
  {

    $no_fak_pemb    = $this->input->post('no_fak_pemb');
    $id_user        = $this->session->userdata('id_user');
    return $this->db->query("DELETE FROM pembayaran_hutang_temp WHERE no_fak_pemb = '$no_fak_pemb' AND id_user = '$id_user' ");
  }

  function hapus_pembayaran_hutang()
  {

    $nobukti        = $this->uri->segment(3);
    $this->db->query("DELETE FROM pembayaran_hutang WHERE nobukti = '$nobukti' ");
    $this->db->query("DELETE FROM pembayaran_hutang_detail WHERE nobukti = '$nobukti' ");
    redirect('pembayaran/view_pembayaran_hutang');
  }

  public function getDataPembayaranHutang($rowno, $rowperpage, $nobukti = "", $kode_supplier = "", $dari = "", $sampai = "")
  {

    $this->db->select('nobukti,jumlah,pembayaran_hutang.keterangan,tgl_bayar,nama_supplier,pembayaran_hutang.jenis_pembayaran,pembayaran_hutang.kode_supplier');
    $this->db->from('pembayaran_hutang');
    $this->db->join('supplier', 'pembayaran_hutang.kode_supplier = supplier.kode_supplier', 'left');
    $this->db->order_by('pembayaran_hutang.nobukti', 'DESC');
    $this->db->where('pembayaran_hutang.jumlah!=', '0');

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

    $this->db->select('count(*) as allcount');
    $this->db->from('pembayaran_hutang');
    $this->db->join('supplier', 'pembayaran_hutang.kode_supplier = supplier.kode_supplier', 'left');
    $this->db->order_by('pembayaran_hutang.nobukti', 'DESC');
    $this->db->where('pembayaran_hutang.jumlah!=', '0');

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

    WHERE pembayaran_hutang_temp.id_user = '$id_user' AND pembelian.kode_supplier = '$kode_supplier'
    GROUP BY no_fak_pemb";
    return $this->db->query($query);
  }

  function view_pembayaran_hutang_detail()
  {
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

    WHERE pembayaran_hutang_detail.nobukti = '$nobukti'
    GROUP BY no_fak_pemb";
    return $this->db->query($query);
  }

  function get_faktur_pembelian()
  {
    $keyword          = $this->uri->segment(4);
    $kode_supplier    = $this->uri->segment(3);

    $data = $this->db->query("SELECT 
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

    WHERE pembelian.no_fak_pemb LIKE '%$keyword%' AND pembelian.kode_supplier = '$kode_supplier'");
    foreach ($data->result() as $d) {

      $sisabayar = $d->total - $d->potongan - $d->jumlahbayar;
      if ($sisabayar > 0) {
        $supplier['query'] = $keyword;
        $supplier['suggestions'][] = array(
          'value'                   =>    $d->no_fak_pemb,
          'no_fak_pemb'             =>    $d->no_fak_pemb,
          'total'                   =>    $d->total,
          'potongan'                =>    $d->potongan,
          'jumlahbayar'             =>    $d->jumlahbayar,
          'sisa_bayar'              =>    $sisabayar
        );
      }
    }
    echo json_encode($supplier);
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


  function detail_pembayaran_hutang()
  {
    $nobukti            = $this->input->post('nobukti');

    $query = "SELECT *,pembayaran_hutang_detail.jumlah
    FROM pembayaran_hutang_detail
    LEFT JOIN v_bayar_hutang ON v_bayar_hutang.no_fak_pemb=pembayaran_hutang_detail.no_fak_pemb
    LEFT JOIN pembayaran_hutang ON pembayaran_hutang.nobukti=pembayaran_hutang_detail.nobukti
    INNER JOIN supplier ON supplier.kode_supplier=pembayaran_hutang.kode_supplier

    WHERE pembayaran_hutang_detail.nobukti = '$nobukti' 
    ORDER BY pembayaran_hutang_detail.no_fak_pemb ASC
    ";
    return $this->db->query($query);
  }

  function getPembayaranHutang()
  {
    $nobukti            = $this->uri->segment(3);

    $query = "SELECT *
    FROM pembayaran_hutang
    INNER JOIN supplier ON supplier.kode_supplier=pembayaran_hutang.kode_supplier

    WHERE pembayaran_hutang.nobukti = '$nobukti' 
    ";
    return $this->db->query($query);
  }

  function detail_pembelian()
  {
    $no_fak_pemb    = $this->input->post('no_fak_pemb');
    return $this->db->query("SELECT * FROM pembelian_detail
    INNER JOIN barang ON barang.kode_barang=pembelian_detail.kode_barang
    WHERE pembelian_detail.no_fak_pemb = '$no_fak_pemb' ");
  }

  function insert_pembayaran_hutang_temp()
  {

    $no_fak_pemb    = $this->input->post('no_fak_pemb');
    $jumlah_bayar   = str_replace(",", "", $this->input->post('jumlah_bayar'));
    $keterangan     = $this->input->post('keterangan');
    $kode_edit      = $this->input->post('kode_edit');
    $id_user        = $this->session->userdata('id_user');

    $data = array(
      'no_fak_pemb'       => $no_fak_pemb,
      'jumlah'            => $jumlah_bayar,
      'keterangan'        => $keterangan,
      'id_user'           => $id_user
    );

    if ($kode_edit == "0") {
      $this->db->insert('pembayaran_hutang_temp', $data);
    } else {
      $this->db->where('id_user', $id_user);
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

    $data = array(
      'nobukti'           => $nobukti,
      'no_fak_pemb'       => $no_fak_pemb,
      'jumlah'            => $jumlah_bayar,
      'keterangan'        => $keterangan
    );

    if ($kode_edit == "0") {
      $this->db->insert('pembayaran_hutang_detail', $data);
    } else {
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
    $id_user        = $this->session->userdata('id_user');

    $data = array(
      'nobukti'           => $nobukti,
      'jenis_pembayaran'  => $jenis_pembayaran,
      'tgl_bayar'         => $tgl_bayar,
      'jumlah'            => $total,
      'id_user'           => $id_user
    );

    $this->db->where('id_user', $id_user);
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
    $id_user          = $this->session->userdata('id_user');

    $data = array(
      'nobukti'           => $nobukti,
      'kode_supplier'     => $kode_supplier,
      'jenis_pembayaran'  => $jenis_pembayaran,
      'tgl_bayar'         => $tgl_bayar,
      'jumlah'            => $total,
      'id_user'           => $id_user
    );
    $this->db->insert('pembayaran_hutang', $data);

    $databayar = $this->db->query("SELECT * FROM pembayaran_hutang_temp 
    INNER JOIN pembelian ON pembelian.no_fak_pemb=pembayaran_hutang_temp.no_fak_pemb
    WHERE pembayaran_hutang_temp.id_user = '$id_user' AND kode_supplier = '$kode_supplier' 
    GROUP BY pembayaran_hutang_temp.no_fak_pemb
    ");
    foreach ($databayar->result() as $d) {

      $databayar = array(
        'nobukti'         => $nobukti,
        'no_fak_pemb'     => $d->no_fak_pemb,
        'jumlah'          => $d->jumlah,
        'keterangan'      => $d->keterangan
      );
      $this->db->insert('pembayaran_hutang_detail', $databayar);

      $this->db->query("DELETE FROM pembayaran_hutang_temp WHERE id_user = '$id_user' AND no_fak_pemb = '$d->no_fak_pemb'");
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

  
  function view_pelanggan()
  {

    $kode_pelanggan    = $this->uri->segment(4);

    if ($kode_pelanggan != "") {
      $kode_pelanggan = "WHERE pelanggan.kode_pelanggan = '" . $kode_pelanggan . "' ";
    }

    return $this->db->query("SELECT * FROM pelanggan "
      . $kode_pelanggan
      . "
    ");
  }

  function hapus_pembayaran_piutang_temp()
  {

    $no_fak_penj    = $this->input->post('no_fak_penj');
    $id_user        = $this->session->userdata('id_user');
    return $this->db->query("DELETE FROM pembayaran_piutang_temp WHERE no_fak_penj = '$no_fak_penj' AND id_user = '$id_user' ");
  }

  function hapus_pembayaran_piutang()
  {

    $nobukti        = $this->uri->segment(3);
    $this->db->query("DELETE FROM pembayaran_piutang WHERE nobukti = '$nobukti' ");
    $this->db->query("DELETE FROM pembayaran_piutang_detail WHERE nobukti = '$nobukti' ");
    redirect('pembayaran/view_pembayaran_piutang');
  }

  public function getDataPembayaranPiutang($rowno, $rowperpage, $nobukti = "", $kode_pelanggan = "", $dari = "", $sampai = "")
  {

    $this->db->select('nobukti,jumlah,pembayaran_piutang.keterangan,tgl_bayar,nama_pelanggan,jenis_pembayaran,pembayaran_piutang.kode_pelanggan');
    $this->db->from('pembayaran_piutang');
    $this->db->join('pelanggan', 'pembayaran_piutang.kode_pelanggan = pelanggan.kode_pelanggan', 'left');
    $this->db->order_by('pembayaran_piutang.nobukti', 'DESC');
    $this->db->where('pembayaran_piutang.jumlah!=', '0');

    if ($nobukti != '') {
      $this->db->like('pembayaran_piutang.nobukti', $nobukti);
    }

    if ($kode_pelanggan != '') {
      $this->db->where('pembayaran_piutang.kode_pelanggan', $kode_pelanggan);
    }

    if ($dari != '') {
      $this->db->where('pembayaran_piutang.tgl_bayar BETWEEN "' . $dari . '" AND "' . $sampai . '"');
    }

    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function getRecordPembayaranPiutangCount($nobukti = "", $kode_pelanggan = "", $dari = "", $sampai = "")
  {

    $this->db->select('count(*) as allcount');
    $this->db->from('pembayaran_piutang');
    $this->db->join('pelanggan', 'pembayaran_piutang.kode_pelanggan = pelanggan.kode_pelanggan', 'left');
    $this->db->order_by('pembayaran_piutang.nobukti', 'DESC');
    $this->db->where('pembayaran_piutang.jumlah!=', '0');

    if ($nobukti != '') {
      $this->db->like('pembayaran_piutang.nobukti', $nobukti);
    }

    if ($kode_pelanggan != '') {
      $this->db->where('pembayaran_piutang.kode_pelanggan', $kode_pelanggan);
    }

    if ($dari != '') {
      $this->db->where('pembayaran_piutang.tgl_bayar BETWEEN "' . $dari . '" AND "' . $sampai . '"');
    }

    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  function view_pembayaran_piutang_temp()
  {
    $id_user            = $this->session->userdata('id_user');
    $kode_pelanggan      = $this->input->post('kode_pelanggan');

    $query = "SELECT 
    v_bayar_piutang.jumlahbayar,
    penjualan.potongan,
    penjualan.kode_pelanggan,
    penjualan.total,
    pembayaran_piutang_temp.no_fak_penj,
    pembayaran_piutang_temp.jumlah,
    pembayaran_piutang_temp.keterangan

    FROM pembayaran_piutang_temp
    INNER JOIN penjualan ON penjualan.no_fak_penj=pembayaran_piutang_temp.no_fak_penj
    LEFT JOIN v_bayar_piutang ON v_bayar_piutang.no_fak_penj=pembayaran_piutang_temp.no_fak_penj

    WHERE pembayaran_piutang_temp.id_user = '$id_user' AND penjualan.kode_pelanggan = '$kode_pelanggan'
    GROUP BY no_fak_penj";
    return $this->db->query($query);
  }

  function view_pembayaran_piutang_detail()
  {
    $nobukti            = $this->input->post('nobukti');

    $query = "SELECT 
    v_bayar_piutang.jumlahbayar,
    penjualan.potongan,
    penjualan.kode_pelanggan,
    penjualan.total,
    pembayaran_piutang_detail.no_fak_penj,
    pembayaran_piutang_detail.jumlah,
    pembayaran_piutang_detail.keterangan

    FROM pembayaran_piutang_detail
    INNER JOIN penjualan ON penjualan.no_fak_penj=pembayaran_piutang_detail.no_fak_penj
    LEFT JOIN v_bayar_piutang ON v_bayar_piutang.no_fak_penj=penjualan.no_fak_penj

    WHERE pembayaran_piutang_detail.nobukti = '$nobukti'
    GROUP BY no_fak_penj";
    return $this->db->query($query);
  }

  function get_faktur_penjualan()
  {
    $keyword          = $this->uri->segment(4);
    $kode_pelanggan    = $this->uri->segment(3);

    $data = $this->db->query("SELECT 
    penjualan.no_fak_penj,
    penjualan.potongan,
    penjualan.keterangan,
    penjualan.kode_pelanggan,
    penjualan.total,
    penjualan.no_so,
    pelanggan.nama_pelanggan,
    penjualan.tgl_transaksi,
    v_bayar_piutang.jumlahbayar
    
    FROM penjualan
    INNER JOIN pelanggan ON pelanggan.kode_pelanggan=penjualan.kode_pelanggan
    LEFT JOIN v_bayar_piutang ON v_bayar_piutang.no_fak_penj=penjualan.no_fak_penj

    WHERE penjualan.no_fak_penj LIKE '%$keyword%' AND penjualan.kode_pelanggan = '$kode_pelanggan'");
    foreach ($data->result() as $d) {

      $sisabayar = $d->total - $d->potongan - $d->jumlahbayar;
      if ($sisabayar > 0) {
        $pelanggan['query'] = $keyword;
        $pelanggan['suggestions'][] = array(
          'value'                   =>    $d->no_fak_penj,
          'no_fak_penj'             =>    $d->no_fak_penj,
          'total'                   =>    $d->total,
          'potongan'                =>    $d->potongan,
          'jumlahbayar'             =>    $d->jumlahbayar,
          'sisa_bayar'              =>    $sisabayar
        );
      }
    }
    echo json_encode($pelanggan);
  }

  function get_pelanggan()
  {
    $keyword      = $this->uri->segment(3);
    $data         = $this->db->from('pelanggan')->like('nama_pelanggan', $keyword)->get();
    foreach ($data->result() as $d) {

      $pelanggan['query'] = $keyword;
      $pelanggan['suggestions'][] = array(
        'value'                   =>    $d->nama_pelanggan,
        'kode_pelanggan'           =>    $d->kode_pelanggan,
        'nama_pelanggan'           =>    $d->nama_pelanggan
      );
    }
    echo json_encode($pelanggan);
  }


  function detail_pembayaran_piutang()
  {
    $nobukti            = $this->input->post('nobukti');

    $query = "SELECT *,pembayaran_piutang_detail.jumlah
    FROM pembayaran_piutang_detail
    LEFT JOIN v_bayar_piutang ON v_bayar_piutang.no_fak_penj=pembayaran_piutang_detail.no_fak_penj
    LEFT JOIN pembayaran_piutang ON pembayaran_piutang.nobukti=pembayaran_piutang_detail.nobukti
    INNER JOIN pelanggan ON pelanggan.kode_pelanggan=pembayaran_piutang.kode_pelanggan

    WHERE pembayaran_piutang_detail.nobukti = '$nobukti' 
    ORDER BY pembayaran_piutang_detail.no_fak_penj ASC
    ";
    return $this->db->query($query);
  }

  function getPembayaranpiutang()
  {
    $nobukti            = $this->uri->segment(3);

    $query = "SELECT *
    FROM pembayaran_piutang
    INNER JOIN pelanggan ON pelanggan.kode_pelanggan=pembayaran_piutang.kode_pelanggan

    WHERE pembayaran_piutang.nobukti = '$nobukti' 
    ";
    return $this->db->query($query);
  }

  function detail_penjualan()
  {
    $no_fak_penj    = $this->input->post('no_fak_penj');
    return $this->db->query("SELECT * FROM penjualan_detail
    INNER JOIN barang ON barang.kode_barang=penjualan_detail.kode_barang
    WHERE penjualan_detail.no_fak_penj = '$no_fak_penj' ");
  }

  function insert_pembayaran_piutang_temp()
  {

    $no_fak_penj    = $this->input->post('no_fak_penj');
    $jumlah_bayar   = str_replace(",", "", $this->input->post('jumlah_bayar'));
    $keterangan     = $this->input->post('keterangan');
    $kode_edit      = $this->input->post('kode_edit');
    $id_user        = $this->session->userdata('id_user');

    $data = array(
      'no_fak_penj'       => $no_fak_penj,
      'jumlah'            => $jumlah_bayar,
      'keterangan'        => $keterangan,
      'id_user'           => $id_user
    );

    if ($kode_edit == "0") {
      $this->db->insert('pembayaran_piutang_temp', $data);
    } else {
      $this->db->where('id_user', $id_user);
      $this->db->where('no_fak_penj', $no_fak_penj);
      $this->db->update('pembayaran_piutang_temp', $data);
    }
  }

  function insert_pembayaran_piutang_detail()
  {

    $nobukti        = $this->input->post('nobukti');
    $no_fak_penj    = $this->input->post('no_fak_penj');
    $jumlah_bayar   = str_replace(",", "", $this->input->post('jumlah_bayar'));
    $keterangan     = $this->input->post('keterangan');
    $kode_edit      = $this->input->post('kode_edit');

    $data = array(
      'nobukti'           => $nobukti,
      'no_fak_penj'       => $no_fak_penj,
      'jumlah'            => $jumlah_bayar,
      'keterangan'        => $keterangan
    );

    if ($kode_edit == "0") {
      $this->db->insert('pembayaran_piutang_detail', $data);
    } else {
      $this->db->where('nobukti', $nobukti);
      $this->db->where('no_fak_penj', $no_fak_penj);
      $this->db->update('pembayaran_piutang_detail', $data);
    }
  }

  function update_pembayaran_piutang()
  {

    $nobukti        = $this->input->post('nobukti');
    $tgl_bayar        = $this->input->post('tgl_bayar');
    $kode_pelanggan    = $this->input->post('kode_pelanggan');
    $jenis_pembayaran = $this->input->post('jenis_pembayaran');
    $total            = str_replace(",", "", $this->input->post('total'));
    $id_user        = $this->session->userdata('id_user');

    $data = array(
      'nobukti'           => $nobukti,
      'jenis_pembayaran'  => $jenis_pembayaran,
      'tgl_bayar'         => $tgl_bayar,
      'jumlah'            => $total,
      'id_user'           => $id_user
    );

    $this->db->where('id_user', $id_user);
    $this->db->where('nobukti', $nobukti);
    $this->db->update('pembayaran_piutang', $data);
  }

  function insert_pembayaran_piutang()
  {
    $tahun    = date('y');
    $bulan    = date('m');
    $this->db->select('right(pembayaran_piutang.nobukti,3) as kode ', false);
    $this->db->where('left(nobukti,2)', $bulan);
    $this->db->where('mid(nobukti,3,2)', $tahun);
    $this->db->order_by('nobukti', 'desc');
    $this->db->limit('13');
    $query    = $this->db->get('pembayaran_piutang');
    if ($query->num_rows() <> 0) {
      $data   = $query->row();
      $kode   = intval($data->kode) + 1;
    } else {
      $kode   = 1;
    }
    $kodemax  = str_pad($kode, 3, "0", STR_PAD_LEFT);
    $nobukti  = $bulan  . $tahun . $kodemax;

    $tgl_bayar        = $this->input->post('tgl_bayar');
    $kode_pelanggan    = $this->input->post('kode_pelanggan');
    $jenis_pembayaran = $this->input->post('jenis_pembayaran');
    $total            = str_replace(",", "", $this->input->post('total'));
    $id_user          = $this->session->userdata('id_user');

    $data = array(
      'nobukti'           => $nobukti,
      'kode_pelanggan'     => $kode_pelanggan,
      'jenis_pembayaran'  => $jenis_pembayaran,
      'tgl_bayar'         => $tgl_bayar,
      'jumlah'            => $total,
      'id_user'           => $id_user
    );
    $this->db->insert('pembayaran_piutang', $data);

    $databayar = $this->db->query("SELECT * FROM pembayaran_piutang_temp 
    INNER JOIN penjualan ON penjualan.no_fak_penj=pembayaran_piutang_temp.no_fak_penj
    WHERE pembayaran_piutang_temp.id_user = '$id_user' AND kode_pelanggan = '$kode_pelanggan' 
    GROUP BY pembayaran_piutang_temp.no_fak_penj
    ");
    foreach ($databayar->result() as $d) {

      $databayar = array(
        'nobukti'         => $nobukti,
        'no_fak_penj'     => $d->no_fak_penj,
        'jumlah'          => $d->jumlah,
        'keterangan'      => $d->keterangan
      );
      $this->db->insert('pembayaran_piutang_detail', $databayar);

      $this->db->query("DELETE FROM pembayaran_piutang_temp WHERE id_user = '$id_user' AND no_fak_penj = '$d->no_fak_penj'");
    }
  }

  public function codeotomatispenj()
  {
    $tahun    = date('y');
    $bulan    = date('m');
    $this->db->select('right(pembayaran_piutang.nobukti,3) as kode ', false);
    $this->db->where('left(nobukti,2)', $bulan);
    $this->db->where('mid(nobukti,3,2)', $tahun);
    $this->db->order_by('nobukti', 'desc');
    $this->db->limit('13');
    $query    = $this->db->get('pembayaran_piutang');
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
