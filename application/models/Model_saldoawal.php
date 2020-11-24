<?php

class Model_saldoawal extends CI_Model
{

  function hapus_saldoawal()
  {

    $kode_saldoawal    = $this->uri->segment(3);
    $this->db->query("DELETE FROM saldoawal WHERE kode_saldoawal = '$kode_saldoawal'");
    $this->db->query("DELETE FROM saldoawal_detail WHERE kode_saldoawal = '$kode_saldoawal'");
    redirect('saldoawal/view_saldoawal');
  }


  public function getDataSaldoawal($rowno, $rowperpage, $kode_saldoawal = "", $bulan = "", $tahun = "")
  {

    $this->db->select('*');
    $this->db->from('saldoawal');
    $this->db->order_by('tgl_transaksi,kode_saldoawal', 'DESC');

    if ($kode_saldoawal != '') {
      $this->db->like('saldoawal.kode_saldoawal', $kode_saldoawal);
    }

    if ($bulan != '') {
      $this->db->like('saldoawal.bulan', $bulan);
    }

    if ($tahun != '') {
      $this->db->like('saldoawal.tahun', $tahun);
    }

    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function getRecordSaldoawalCount($kode_saldoawal = "", $bulan = "", $tahun = "")
  {

    $this->db->select('count(*) as allcount');
    $this->db->from('saldoawal');
    $this->db->order_by('tgl_transaksi,saldoawal.kode_saldoawal', 'DESC');

    if ($kode_saldoawal != '') {
      $this->db->like('saldoawal.kode_saldoawal', $kode_saldoawal);
    }

    if ($bulan != '') {
      $this->db->like('saldoawal.bulan', $bulan);
    }

    if ($tahun != '') {
      $this->db->like('saldoawal.tahun', $tahun);
    }

    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }


  function ceksaldo($bulan, $tahun)
  {

    if ($bulan == 1) {
      $bulan = 12;
      $tahun = $tahun - 1;
    } else {
      $bulan = $bulan - 1;
      $tahun = $tahun;
    }

    return $this->db->get_where('saldoawal', array('bulan' => $bulan, 'tahun' => $tahun));
  }

  function ceksaldoall()
  {

    return $this->db->get('saldoawal');
  }

  function ceksaldoSkrg($bulan, $tahun)
  {

    return $this->db->get_where('saldoawal', array('bulan' => $bulan, 'tahun' => $tahun));
  }

  function getdetailsaldo($bulan, $tahun)
  {

    if ($bulan == 1) {
      $bulan = 12;
      $tahun = $tahun - 1;
    } else {
      $bulan = $bulan - 1;
      $tahun = $tahun;
    }


    return $this->db->query("SELECT 
    barang.kode_barang,
    barang.nama_barang,
    barang.satuan,
    barang.jenis_barang,
    pm.qtypembelian,
    jl.qtypenjualan,
    ms.qtyreturkembali,
    ms.qtymasuklainnya,
    kl.qtyretur,
    kl.qtybuang,
    kl.qtykeluarlainnya,
    sa.qtysaldoawal
    
    FROM barang

    LEFT JOIN (SELECT 
    saldoawal_detail.kode_barang,
    SUM(qty) AS qtysaldoawal
    FROM saldoawal_detail 
    INNER JOIN saldoawal ON saldoawal_detail.kode_saldoawal = saldoawal.kode_saldoawal 
    WHERE bulan = '$bulan' AND tahun = '$tahun' 
    GROUP BY saldoawal_detail.kode_barang) sa ON (barang.kode_barang = sa.kode_barang)

    LEFT JOIN (SELECT 
    pembelian_detail.kode_barang,
    SUM(qty) AS qtypembelian
    FROM pembelian_detail 
    INNER JOIN pembelian ON pembelian_detail.no_fak_pemb = pembelian.no_fak_pemb 
    WHERE MONTH(tgl_transaksi) = '$bulan' AND YEAR(tgl_transaksi) = '$tahun' 
    GROUP BY pembelian_detail.kode_barang) pm ON (barang.kode_barang = pm.kode_barang)
    
    LEFT JOIN (SELECT 
    pemasukan_detail.kode_barang,
    SUM( IF( pemasukan.jenis_pemasukan = 'Pengembalian Retur' , qty ,0 )) AS qtyreturkembali,
    SUM( IF( pemasukan.jenis_pemasukan = 'Lainnya' , qty ,0 )) AS qtymasuklainnya
    FROM pemasukan_detail 
    INNER JOIN pemasukan ON pemasukan_detail.no_pemasukan = pemasukan.no_pemasukan 
    WHERE MONTH(tgl_transaksi) = '$bulan' AND YEAR(tgl_transaksi) = '$tahun' 
    GROUP BY pemasukan_detail.kode_barang) ms ON (barang.kode_barang = ms.kode_barang)

    LEFT JOIN (SELECT 
    penjualan_detail.kode_barang,
    SUM(qty) AS qtypenjualan
    FROM penjualan_detail 
    INNER JOIN penjualan ON penjualan_detail.no_fak_penj = penjualan.no_fak_penj 
    WHERE MONTH(tgl_transaksi) = '$bulan' AND YEAR(tgl_transaksi) = '$tahun' 
    GROUP BY penjualan_detail.kode_barang) jl ON (barang.kode_barang = jl.kode_barang)

    LEFT JOIN (SELECT 
    pengeluaran_detail.kode_barang,
    SUM( IF( pengeluaran.jenis_pengeluaran = 'Retur' , qty ,0 )) AS qtyretur,
    SUM( IF( pengeluaran.jenis_pengeluaran = 'Buang' , qty ,0 )) AS qtybuang,
    SUM( IF( pengeluaran.jenis_pengeluaran = 'Lainnya' , qty ,0 )) AS qtykeluarlainnya
    FROM pengeluaran_detail 
    INNER JOIN pengeluaran ON pengeluaran_detail.no_pengeluaran = pengeluaran.no_pengeluaran 
    WHERE MONTH(tgl_transaksi) = '$bulan' AND YEAR(tgl_transaksi) = '$tahun' 
    GROUP BY pengeluaran_detail.kode_barang) kl ON (barang.kode_barang = kl.kode_barang)

    ORDER BY barang.jenis_barang,barang.nama_barang ");
  }

  public function insert_saldoawal()
  {
    $kode_saldoawal   = $this->input->post('kode_saldoawal');
    $bulan            = $this->input->post('bulan');
    $tahun            = $this->input->post('tahun');
    $tgl_transaksi    = $this->input->post('tgl_transaksi');
    $kode_barang      = $this->input->post('kode_barang');
    $qty              = $this->input->post('qty');
    $id_user          = $this->session->userdata('id_user');

    $data = array(
      'kode_saldoawal'    => $kode_saldoawal,
      'bulan'             => $bulan,
      'tahun'             => $tahun,
      'tgl_transaksi'     => $tgl_transaksi,
      'id_user'           => $id_user
    );
    $this->db->insert('saldoawal', $data);

    $result = array();
    $index  = 0;
    foreach ($kode_barang as $kode) {
      array_push($result, array(
        'kode_saldoawal'  => $kode_saldoawal,
        'kode_barang'     => $kode,
        'qty'             => $qty[$index]
      ));
      $index++;
    }
    $this->db->insert_batch('saldoawal_detail', $result);

    redirect('saldoawal/view_saldoawal');
  }

  function insert_saldoawal_detail()
  {

    $kode_saldoawal     = $this->input->post('kode_saldoawal');
    $kode_barang        = $this->input->post('kode_barang');
    $qty                = str_replace(",", "", $this->input->post('qty'));

    $data = array(
      'kode_saldoawal'    => $kode_saldoawal,
      'kode_barang'       => $kode_barang,
      'qty'               => $qty
    );
    $this->db->query("DELETE FROM saldoawal_detail WHERE kode_barang = '$kode_barang' AND kode_saldoawal = '$kode_saldoawal' ");
    $this->db->insert('saldoawal_detail', $data);
  }

  function detail_saldoawal()
  {
    $kode_saldoawal        = $this->input->post('kode_saldoawal');

    $query = "SELECT saldoawal_detail.kode_barang,nama_barang,satuan,jenis_barang,saldoawal_detail.qty FROM saldoawal_detail 
    INNER JOIN barang ON saldoawal_detail.kode_barang=barang.kode_barang 
    WHERE saldoawal_detail.kode_saldoawal = '$kode_saldoawal'
    GROUP BY saldoawal_detail.kode_barang,saldoawal_detail.kode_saldoawal";
    return $this->db->query($query);
  }

  function getSaldoawal()
  {
    $kode_saldoawal        = $this->uri->segment(3);

    $query = "SELECT * FROM saldoawal WHERE saldoawal.kode_saldoawal = '$kode_saldoawal'";
    return $this->db->query($query);
  }
}
