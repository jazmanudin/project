<?php

class Model_penjualan extends CI_Model
{

  function view_pelanggan()
  {

    $this->db->select('*');
    $this->db->from('pelanggan');
    $this->db->order_by('nama_pelanggan', 'ASC');

    return $this->db->get();
  }

  function view_penjualan()
  {
    $no_fak_penj        = $this->input->post('no_fak_penj');

    $query = "SELECT 
    penjualan.no_fak_penj,
    penjualan.potongan,
    penjualan.keterangan,
    penjualan.kode_pelanggan,
    penjualan.total,
    penjualan.no_so,
    pelanggan.nama_pelanggan,
    pelanggan.alamat,
    penjualan.tgl_transaksi
    
    FROM penjualan
    INNER JOIN pelanggan ON pelanggan.kode_pelanggan=penjualan.kode_pelanggan
    WHERE penjualan.no_fak_penj = '$no_fak_penj'
    ";
    return $this->db->query($query);
  }

  function cetak_faktur()
  {
    $no_fak_penj        = $this->uri->segment(3);

    $query = "SELECT 
    penjualan.no_fak_penj,
    penjualan.potongan,
    penjualan.keterangan,
    penjualan.kode_pelanggan,
    penjualan.total,
    penjualan.no_so,
    pelanggan.alamat,
    pelanggan.nama_pelanggan,
    penjualan.tgl_transaksi,
    v_bayar_piutang.jumlahbayar
    
    FROM penjualan
    INNER JOIN pelanggan ON pelanggan.kode_pelanggan=penjualan.kode_pelanggan
    LEFT JOIN v_bayar_piutang ON v_bayar_piutang.no_fak_penj=penjualan.no_fak_penj
    WHERE penjualan.no_fak_penj = '$no_fak_penj'
    ";
    return $this->db->query($query);
  }

  function view_histori_bayar()
  {
    $no_fak_penj        = $this->input->post('no_fak_penj');

    $query = "SELECT *
    FROM pembayaran_piutang_detail
    INNER JOIN pembayaran_piutang ON pembayaran_piutang.nobukti=pembayaran_piutang_detail.nobukti 
    WHERE pembayaran_piutang_detail.no_fak_penj = '$no_fak_penj' AND pembayaran_piutang_detail.jumlah != '0'
    ";
    return $this->db->query($query);
  }

  function view_salesorder()
  {

    $kode_pelanggan = $this->uri->segment(4);

    $this->db->select('pelanggan.jatuh_tempo,salesorder.ppn,jenis_harga,karyawan.nama_karyawan,salesorder.id_sales,salesorder.no_so,tgl_transaksi,nama_pelanggan,salesorder.kode_pelanggan,salesorder.total,salesorder.keterangan');
    $this->db->from('salesorder');
    $this->db->join('pelanggan', 'salesorder.kode_pelanggan = pelanggan.kode_pelanggan');
    $this->db->join('karyawan', 'pelanggan.id_sales = karyawan.nik', 'left');
    $this->db->where('salesorder.kode_pelanggan', $kode_pelanggan);
    $this->db->order_by('tgl_transaksi,kode_pelanggan', 'DESC');

    return $this->db->get();
  }

  function get_barangbarcode()
  {

    $year         = date('Y');
    $month         = date('m');
    $date         = date('d') + 01;
    $tglnow       = $year . "-" . $month . "-" . $date;

    $kode_barang     = $this->input->post('kode_barang');
    $jenis_harga     = $this->input->post('jenis_harga');
    $barang = $this->db->query("SELECT 
    barang.kode_barang,
    barang.nama_barang,
    barang.satuan,
    barang.keterangan,
    barang.pelanggan_tetap,
    barang.tidak_tetap,
    barang.eceran,
    barang.harga_modal,
    barang.grosir,
    barang.lainnya,
    barang.kode_kategori,
    kategori.nama_kategori,
    db.stok,
    db.stoks,
    db.barangke,
    db.exp_date

    FROM barang 
    INNER JOIN kategori ON kategori.kode_kategori=barang.kode_kategori
   
    LEFT JOIN (SELECT SUM( IF( exp_date >= '$tglnow' , stok ,0 )) AS stok, SUM(stok) AS stoks,
    kode_barang,exp_date,barangke FROM barang_detail 
    WHERE stok != '0'
    GROUP BY kode_barang
    ORDER BY exp_date ASC) db ON (barang.kode_barang=db.kode_barang)

    WHERE barang.kode_barang = '$kode_barang'
    ");

    if ($barang->num_rows() > 0) {

      $barang = $barang->row_array();

      if ($jenis_harga == "Pelanggan Tetap") {
        $hargajual = $barang['pelanggan_tetap'];
      } else if ($jenis_harga == "Tidak Tetap") {
        $hargajual = $barang['tidak_tetap'];
      } else if ($jenis_harga == "Grosir") {
        $hargajual = $barang['grosir'];
      } else if ($jenis_harga == "Eceran") {
        $hargajual = $barang['exeran'];
      } else if ($jenis_harga == "Lainnya") {
        $hargajual = $barang['lainnya'];
      }

      echo $barang['nama_barang'] . "|" . $barang['satuan'] . "|" . $barang['exp_date'] . "|" . $barang['harga_modal'] . "|" . $hargajual . "|" . $barang['barangke'] . "|" . $barang['stok'] . "|" . $barang['stoks'];
    }
  }

  function view_sales()
  {
    $kode_pelanggan     = $this->input->post('kode_pelanggan');
    return $this->db->query("SELECT kode_pelanggan,jenis_harga,id_sales,nama_karyawan,nama_pelanggan FROM pelanggan 
    INNER JOIN karyawan ON karyawan.nik AND pelanggan.id_sales 
    WHERE kode_pelanggan = '$kode_pelanggan' ");
  }

  function view_barang()
  {

    $year         = date('Y');
    $month         = date('m');
    $date         = date('d') + 01;
    $tglnow       = $year . "-" . $month . "-" . $date;

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
    db.barangke,
    db.exp_date

    FROM barang 
    INNER JOIN kategori ON kategori.kode_kategori=barang.kode_kategori
   
    LEFT JOIN (SELECT SUM( IF( exp_date >= '$tglnow' , stok ,0 )) AS stok, SUM(stok) AS stoks,
    kode_barang,exp_date,barangke FROM barang_detail 
    WHERE stok != '0'
    GROUP BY kode_barang
    ORDER BY exp_date ASC) db ON (barang.kode_barang=db.kode_barang)

    WHERE ");
  }

  function hapus_penjualan()
  {

    $no_fak_penj    = $this->uri->segment(3);
    $no_so          = $this->uri->segment(4);
    $id_user        = $this->session->userdata('id_user');
    $datapenj = $this->db->query("SELECT * FROM penjualan_detail WHERE no_fak_penj = '$no_fak_penj'");
    foreach ($datapenj->result() as $d) {

      $datapemb = array(
        'no_so'           => $no_so,
        'kode_barang'     => $d->kode_barang,
        'qty'             => $d->qty,
        'harga_jual'      => $d->harga_jual,
        'barangke'        => $d->barangke,
        'exp_date'        => $d->exp_date,
        'keterangan'      => $d->keterangan,
        'id_user'         => $id_user
      );

      if ($no_so != "-") {
        $this->db->insert('penjualan_temp', $datapemb);
      }

      // $this->db->query("UPDATE barang_details SET stok = stok + '$d->qty' WHERE kode_barang = '$d->kode_barang' ");

      $datastok   = $this->db->query("SELECT * FROM barang_detail 
      WHERE kode_barang = '$d->kode_barang' AND barangke = '$d->barangke' AND exp_date = '$d->exp_date' ")->row_array();

      if ($datastok['stok'] < $d->qty) {

        $stok   = $datastok['stok'];
        $qty    = $d->qty;
        $sisa   = $stok + $qty;

        $this->db->query("UPDATE barang_detail SET stok = '$sisa'+stok WHERE kode_barang = '$d->kode_barang' AND barangke = '$d->barangke'+1 ");

        $this->db->query("UPDATE barang_detail SET stok = 0 WHERE kode_barang = '$d->kode_barang' AND barangke = '$d->barangke' AND exp_date = '$d->exp_date'");
      } else {

        $this->db->query("UPDATE barang_detail SET stok = stok+'$d->qty' WHERE kode_barang = '$d->kode_barang' AND barangke = '$d->barangke' AND exp_date = '$d->exp_date'");
      }
    }

    $this->db->query("DELETE FROM penjualan WHERE no_fak_penj = '$no_fak_penj' ");
    $this->db->query("DELETE FROM penjualan_detail WHERE no_fak_penj = '$no_fak_penj' ");
    $this->db->query("DELETE FROM pembayaran_piutang_detail WHERE no_fak_penj = '$no_fak_penj' ");

    $this->db->query("UPDATE salesorder SET status = '0' WHERE no_so = '$no_so' ");

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

    $no_fak_penj      = $this->input->post('no_fak_penj');
    $kode_barang      = $this->input->post('kode_barang');
    return $this->db->query("DELETE FROM penjualan_detail WHERE kode_barang = '$kode_barang' AND no_fak_penj = '$no_fak_penj'");
  }

  public function getPenjualan()
  {

    $no_fak_penj    = $this->uri->segment(3);

    $this->db->select('penjualan.potongan,pelanggan.jatuh_tempo,penjualan.ppn,jenis_harga,karyawan.nama_karyawan,penjualan.id_sales,penjualan.no_fak_penj,tgl_transaksi,nama_pelanggan,penjualan.kode_pelanggan,penjualan.total,penjualan.keterangan');
    $this->db->from('penjualan');
    $this->db->join('pelanggan', 'penjualan.kode_pelanggan = pelanggan.kode_pelanggan');
    $this->db->join('karyawan', 'pelanggan.id_sales = karyawan.nik', 'left');
    $this->db->where('penjualan.no_fak_penj', $no_fak_penj);
    $this->db->order_by('tgl_transaksi,no_fak_penj', 'DESC');

    $query = $this->db->get();
    return $query->row_array();
  }

  public function getDatapenjualan($rowno, $rowperpage, $no_fak_penj = "", $kode_pelanggan = "", $dari = "", $sampai = "")
  {

    $this->db->select('penjualan.no_so,v_bayar_piutang.jumlahbayar,penjualan.no_fak_penj,nama_karyawan,penjualan.id_sales,potongan,tgl_transaksi,status,ppn,nama_pelanggan,penjualan.kode_pelanggan,penjualan.total,penjualan.keterangan');
    $this->db->from('penjualan');
    $this->db->join('v_bayar_piutang', 'penjualan.no_fak_penj = v_bayar_piutang.no_fak_penj', 'left');
    $this->db->join('pelanggan', 'penjualan.kode_pelanggan = pelanggan.kode_pelanggan');
    $this->db->join('karyawan', 'penjualan.id_sales = karyawan.nik');
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
    $this->db->join('v_bayar_piutang', 'penjualan.no_fak_penj = v_bayar_piutang.no_fak_penj', 'left');
    $this->db->join('pelanggan', 'penjualan.kode_pelanggan = pelanggan.kode_pelanggan');
    $this->db->join('karyawan', 'penjualan.id_sales = karyawan.nik');
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

  function list_barang()
  {
    $no_fak_penj    = $this->uri->segment(3);

    $year           = date('Y');
    $month          = date('m');
    $date           = date('d') + 01;
    $tglnow         = $year . "-" . $month . "-" . $date;

    $query = "SELECT db.exp_date,penjualan_detail.keterangan,barang.satuan,penjualan_detail.kode_barang,db.stok,SUM(qty) AS qty,nama_barang,penjualan_detail.harga_jual
    FROM penjualan_detail 
    INNER JOIN barang ON penjualan_detail.kode_barang=barang.kode_barang 

    LEFT JOIN (SELECT SUM( IF( exp_date >= '$tglnow' , stok ,0 )) AS stok,
    kode_barang,exp_date FROM barang_detail 
    GROUP BY kode_barang
    ORDER BY exp_date ASC) db ON (penjualan_detail.kode_barang=db.kode_barang)

    WHERE penjualan_detail.no_fak_penj = '$no_fak_penj'
    GROUP BY penjualan_detail.kode_barang,penjualan_detail.no_fak_penj";
    return $this->db->query($query);
  }

  function detail_penjualan()
  {
    $no_fak_penj    = $this->input->post('no_fak_penj');

    $year           = date('Y');
    $month          = date('m');
    $date           = date('d') + 01;
    $tglnow         = $year . "-" . $month . "-" . $date;

    $query = "SELECT db.exp_date,penjualan_detail.keterangan,barang.satuan,penjualan_detail.kode_barang,db.stok,SUM(qty) AS qty,nama_barang,penjualan_detail.harga_jual
    FROM penjualan_detail 
    INNER JOIN barang ON penjualan_detail.kode_barang=barang.kode_barang 

    LEFT JOIN (SELECT SUM( IF( exp_date >= '$tglnow' , stok ,0 )) AS stok,
    kode_barang,exp_date FROM barang_detail 
    GROUP BY kode_barang
    ORDER BY exp_date ASC) db ON (penjualan_detail.kode_barang=db.kode_barang)

    WHERE penjualan_detail.no_fak_penj = '$no_fak_penj'
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
    $no_so              = $this->input->post('no_so');
    // $kode_pelanggan     = $this->input->post('kode_pelanggan');

    $query = "SELECT penjualan_temp.kode_barang,satuan,db.stok,penjualan_temp.keterangan,SUM(qty) AS qty,
    nama_barang,penjualan_temp.harga_jual,db.exp_date,penjualan_temp.barangke,barang.harga_modal
    FROM penjualan_temp 
    INNER JOIN barang ON penjualan_temp.kode_barang=barang.kode_barang 

    LEFT JOIN (SELECT SUM( IF( exp_date >= '$tglnow' , stok ,0 )) AS stok,
    kode_barang,exp_date FROM barang_detail 
    GROUP BY kode_barang
    ORDER BY exp_date ASC) db ON (penjualan_temp.kode_barang=db.kode_barang)

    WHERE penjualan_temp.id_user = '$id_user' AND penjualan_temp.no_so = '$no_so' 
    GROUP BY penjualan_temp.kode_barang";
    return $this->db->query($query);
  }

  function cekbarang()
  {
    $kode_barang    = $this->input->post('kode_barang');
    $query = "SELECT penjualan_temp.kode_barang
    FROM penjualan_temp 
    WHERE penjualan_temp.kode_barang = '$kode_barang'
    GROUP BY penjualan_temp.kode_barang";
    echo $this->db->query($query)->num_rows();
  }

  function insert_penjualan_temp()
  {

    $kode_barang    = $this->input->post('kode_barang');
    $no_so          = $this->input->post('no_so');
    $barangke       = $this->input->post('barangke');
    $kode_pelanggan = $this->input->post('kode_pelanggan');
    $exp_date       = $this->input->post('exp_date');
    $barcode        = $this->input->post('barcode');
    $harga_jual     = str_replace(",", "", $this->input->post('harga_jual'));
    $qty            = str_replace(",", "", $this->input->post('qty'));
    $keterangan     = $this->input->post('keterangan');
    $id_user        = $this->session->userdata('id_user');

    $data = array(
      'kode_barang'       => $kode_barang,
      'qty'               => $qty,
      'harga_jual'        => $harga_jual,
      'kode_pelanggan'    => $kode_pelanggan,
      'keterangan'        => $keterangan,
      'exp_date'          => $exp_date,
      'no_so'             => $no_so,
      'barangke'          => $barangke,
      'id_user'           => $id_user
    );
    if ($barcode != "1") {
      $this->db->query("DELETE FROM penjualan_temp WHERE kode_barang = '$kode_barang' AND no_so = '$no_so' AND id_user = '$id_user' ");
    }
    $this->db->insert('penjualan_temp', $data);
  }

  function insert_penjualan_detail()
  {

    $no_fak_penj    = $this->input->post('no_fak_penj');
    $kode_barang    = $this->input->post('kode_barang');
    $harga_jual     = str_replace(",", "", $this->input->post('harga_jual'));
    $qty            = str_replace(",", "", $this->input->post('qty'));
    $keterangan     = $this->input->post('keterangan');

    $data = array(
      'no_fak_penj'       => $no_fak_penj,
      'kode_barang'       => $kode_barang,
      'qty'               => $qty,
      'harga_jual'        => $harga_jual,
      'keterangan'        => $keterangan
    );
    $this->db->query("DELETE FROM penjualan_detail WHERE kode_barang = '$kode_barang' AND no_fak_penj = '$no_fak_penj' ");
    $this->db->insert('penjualan_detail', $data);
  }

  function insert_penjualan()
  {

    $tahun    = date('y');
    $bulan    = date('m');
    $this->db->select('right(penjualan.no_fak_penj,3) as kode ', false);
    $this->db->where('mid(no_fak_penj,4,2)', $bulan);
    $this->db->where('mid(no_fak_penj,6,2)', $tahun);
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
    $no_fak_penj   = "FK-" . $bulan . "" . $tahun . "" . $kodemax;

    $id_user          = $this->session->userdata('id_user');
    $tgl_transaksi    = $this->input->post('tgl_transaksi');
    $id_sales         = $this->input->post('id_sales');
    $kode_pelanggan   = $this->input->post('kode_pelanggan');
    $ppn              = $this->input->post('ppn');
    $keterangan       = $this->input->post('keterangan');
    $jatuh_tempo      = $this->input->post('jatuh_tempo');
    $no_so            = $this->input->post('no_so');
    $subtotal         = str_replace(",", "", $this->input->post('subtotal'));
    $potongan         = str_replace(",", "", $this->input->post('potongan'));
    $jumlah_bayar     = str_replace(",", "", $this->input->post('jumlah_bayar'));
    $kembalian        = str_replace(",", "", $this->input->post('kembalian'));
    $sisa_bayar       = str_replace(",", "", $this->input->post('sisa_bayar'));

    if ($sisa_bayar == "0") {
      $jenis_transaksi = "Tunai";
    } else {
      $jenis_transaksi = "Kredit";
    }

    $data = array(
      'no_fak_penj'     => $no_fak_penj,
      'kode_pelanggan'  => $kode_pelanggan,
      'id_sales'        => $id_sales,
      'potongan'        => $potongan,
      'total'           => $subtotal,
      'ppn'             => $ppn,
      'jatuh_tempo'     => $jatuh_tempo,
      'jenis_transaksi' => $jenis_transaksi,
      'tgl_transaksi'   => $tgl_transaksi,
      'status'          => "0",
      'keterangan'      => $keterangan,
      'no_so'           => $no_so,
      'id_user'         => $id_user
    );
    $this->db->insert('penjualan', $data);

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
    $kodemaxs = str_pad($kode, 3, "0", STR_PAD_LEFT);
    $nobukti  = $bulan  . $tahun . $kodemaxs;


    if ($sisa_bayar == "0") {
      $jenis_bayar = "Tunai";
    } else {
      $jenis_bayar = "";
    }

    $data = array(
      'nobukti'         => $nobukti,
      'kode_pelanggan'  => $kode_pelanggan,
      'tgl_bayar'       => $tgl_transaksi,
      'jumlah'          => $jumlah_bayar - $kembalian,
      'keterangan'      => "-",
      'jenis_pembayaran' => $jenis_bayar,
      'id_user'         => $id_user
    );
    $this->db->insert('pembayaran_piutang', $data);

    $data2 = array(
      'nobukti'         => $nobukti,
      'no_fak_penj'     => $no_fak_penj,
      'jumlah'          => $jumlah_bayar - $kembalian,
      'keterangan'      => "-"
    );
    $this->db->insert('pembayaran_piutang_detail', $data2);

    if ($no_so != "-") {
      $this->db->query("UPDATE salesorder SET status = '1' WHERE no_so = '$no_so' ");
    }

    $datapenj = $this->db->query("SELECT *,SUM(qty) AS qty FROM penjualan_temp 
    WHERE id_user = '$id_user' AND no_so = '$no_so' GROUP BY kode_barang");
    foreach ($datapenj->result() as $d) {

      $data = array(
        'no_fak_penj'     => $no_fak_penj,
        'kode_barang'     => $d->kode_barang,
        'qty'             => $d->qty,
        'barangke'        => $d->barangke,
        'exp_date'        => $d->exp_date,
        'harga_jual'      => $d->harga_jual,
        'keterangan'      => "-"
      );
      $this->db->insert('penjualan_detail', $data);

      $datastok   = $this->db->query("SELECT * FROM barang_detail 
      WHERE kode_barang = '$d->kode_barang' AND barangke = '$d->barangke' AND exp_date = '$d->exp_date' ")->row_array();

      if ($datastok['stok'] < $d->qty) {

        $stok   = $datastok['stok'];
        $qty    = $d->qty;
        $sisa   = $stok - $qty;

        $this->db->query("UPDATE barang_detail SET stok = '$sisa'+stok WHERE kode_barang = '$d->kode_barang' AND barangke = '$d->barangke'+1 ");

        $this->db->query("UPDATE barang_detail SET stok = 0 WHERE kode_barang = '$d->kode_barang' AND barangke = '$d->barangke' AND exp_date = '$d->exp_date'");
      } else {

        $this->db->query("UPDATE barang_detail SET stok = stok-'$d->qty' WHERE kode_barang = '$d->kode_barang' AND barangke = '$d->barangke' AND exp_date = '$d->exp_date'");
      }

      // $this->db->query("UPDATE barang_detail SET stok = stok-'$d->qty' WHERE kode_barang = '$d->kode_barang'  AND barangke = '$d->barangke' AND exp_date = '$d->exp_date'");
    }

    $datapenj = $this->db->query("DELETE FROM penjualan_temp WHERE id_user = '$id_user' AND no_so = '$no_so' ");
  }

  function update_penjualan()
  {

    $id_user            = $this->session->userdata('id_user');
    $subtotal           = str_replace(",", "", $this->input->post('subtotal'));
    $no_fak_penj              = $this->input->post('no_fak_penj');
    $id_sales           = $this->input->post('id_sales');
    $tgl_transaksi      = $this->input->post('tgl_transaksi');
    $kode_pelanggan     = $this->input->post('kode_pelanggan');
    $ppn                = $this->input->post('ppn');
    $keterangan         = $this->input->post('keterangan');

    $data = array(
      'no_fak_penj'     => $no_fak_penj,
      'kode_pelanggan'  => $kode_pelanggan,
      'total'           => $subtotal,
      'ppn'             => $ppn,
      'id_sales'        => $id_sales,
      'tgl_transaksi'   => $tgl_transaksi,
      'keterangan'      => $keterangan,
      'id_user'         => $id_user
    );

    $this->db->where('no_fak_penj', $no_fak_penj);
    $this->db->update('penjualan', $data);
  }

  function get_pelanggan()
  {
    $keyword      = $this->uri->segment(3);
    $data         = $this->db->from('pelanggan')
      ->join('karyawan', 'karyawan.nik=pelanggan.id_sales')
      ->like('nama_pelanggan', $keyword)
      ->get();
    foreach ($data->result() as $d) {

      // $tanggal        = Date('Y-m-d');
      // $jatuhtempo     = Date('Y-m-d', strtotime('+' . $d->jatuh_tempo . ' days', strtotime($tanggal)));

      $pelanggan['query'] = $keyword;
      $pelanggan['suggestions'][] = array(
        'value'                   =>    $d->nama_pelanggan,
        'id_sales'                =>    $d->id_sales,
        'nama_karyawan'           =>    $d->nama_karyawan,
        'jatuh_tempo'             =>    $d->jatuh_tempo,
        'kode_pelanggan'          =>    $d->kode_pelanggan,
        'jenis_harga'             =>    $d->jenis_harga,
        'nama_pelanggan'          =>    $d->nama_pelanggan
      );
    }
    echo json_encode($pelanggan);
  }

  function get_barang()
  {
    $keyword    = $this->uri->segment(4);
    $no_so      = $this->uri->segment(3);

    $year       = date('Y');
    $month      = date('m');
    $date       = date('d') + 01;
    $tglnow     = $year . "-" . $month . "-" . $date;

    $data = $this->db->query("SELECT 
    barang.kode_barang,
    barang.nama_barang,
    barang.satuan,
    barang.keterangan,
    barang.pelanggan_tetap,
    barang.tidak_tetap,
    barang.eceran,
    barang.grosir,
    barang.harga_modal,
    barang.lainnya,
    barang.kode_kategori,
    kategori.nama_kategori,
    db.stok,
    db.stoks,
    db.barangke,
    db.exp_date

    FROM barang 
    INNER JOIN kategori ON kategori.kode_kategori=barang.kode_kategori
   
    LEFT JOIN (SELECT SUM( IF( exp_date >= '$tglnow' , stok ,0 )) AS stok, SUM(stok) AS stoks,
    kode_barang,exp_date,barangke FROM barang_detail 
    WHERE stok != '0'
    GROUP BY kode_barang
    ORDER BY exp_date ASC) db ON (barang.kode_barang=db.kode_barang)

    WHERE barang.nama_barang LIKE '%$keyword%' AND barang.kode_barang NOT IN (SELECT kode_barang FROM penjualan_temp WHERE no_so = '$no_so')");
    foreach ($data->result() as $d) {

      if ($d->stok > 0) {
        $pelanggan['query'] = $keyword;
        $pelanggan['suggestions'][] = array(
          'value'                   =>    $d->nama_barang,
          'kode_barang'             =>    $d->kode_barang,
          'nama_barang'             =>    $d->nama_barang,
          'satuan'                  =>    $d->satuan,
          'stok'                    =>    $d->stok,
          'stoks'                   =>    $d->stoks,
          'grosir'                  =>    $d->grosir,
          'eceran'                  =>    $d->eceran,
          'harga_modal'             =>    $d->harga_modal,
          'lainnya'                 =>    $d->lainnya,
          'exp_date'                =>    $d->exp_date,
          'pelanggan_tetap'         =>    $d->pelanggan_tetap,
          'barangke'                =>    $d->barangke,
          'tidak_tetap'             =>    $d->tidak_tetap
        );
      }
    }
    echo json_encode($pelanggan);
  }


  public function codeotomatis()
  {
    $tahun    = date('y');
    $bulan    = date('m');
    $this->db->select('right(penjualan.no_fak_penj,3) as kode ', false);
    $this->db->where('mid(no_fak_penj,4,2)', $bulan);
    $this->db->where('mid(no_fak_penj,6,2)', $tahun);
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
    echo "FK-" . $bulan . "" . $tahun . "" . $kodemax;
  }
}
