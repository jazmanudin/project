<?php

class Model_opname extends CI_Model
{

  function hapus_opname()
  {

    $kode_opname    = $this->uri->segment(3);
    $this->db->query("DELETE FROM opname WHERE kode_opname = '$kode_opname'");
    $this->db->query("DELETE FROM opname_detail WHERE kode_opname = '$kode_opname'");
    redirect('opname/view_opname');
  }


  public function getDataOpname($rowno, $rowperpage, $kode_opname = "", $bulan = "", $tahun = "")
  {

    $this->db->select('*');
    $this->db->from('opname');
    $this->db->order_by('tgl_transaksi,kode_opname', 'DESC');

    if ($kode_opname != '') {
      $this->db->like('opname.kode_opname', $kode_opname);
    }

    if ($bulan != '') {
      $this->db->like('opname.bulan', $bulan);
    }

    if ($tahun != '') {
      $this->db->like('opname.tahun', $tahun);
    }

    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function getRecordOpnameCount($kode_opname = "", $bulan = "", $tahun = "")
  {

    $this->db->select('count(*) as allcount');
    $this->db->from('opname');
    $this->db->order_by('tgl_transaksi,opname.kode_opname', 'DESC');

    if ($kode_opname != '') {
      $this->db->like('opname.kode_opname', $kode_opname);
    }

    if ($bulan != '') {
      $this->db->like('opname.bulan', $bulan);
    }

    if ($tahun != '') {
      $this->db->like('opname.tahun', $tahun);
    }

    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }


  function cekopname($bulan, $tahun)
  {

    if ($bulan == 1) {
      $bulan = 12;
      $tahun = $tahun - 1;
    } else {
      $bulan = $bulan - 1;
      $tahun = $tahun;
    }

    return $this->db->get_where('opname', array('bulan' => $bulan, 'tahun' => $tahun));
  }

  function cekopnameall()
  {

    return $this->db->get('opname');
  }

  function cekopnameSkrg($bulan, $tahun)
  {

    return $this->db->get_where('opname', array('bulan' => $bulan, 'tahun' => $tahun));
  }

  function getdetailopname($bulan, $tahun)
  {

    // if ($bulan == 1) {
    //   $bulan = 12;
    //   $tahun = $tahun - 1;
    // } else {
    //   $bulan = $bulan - 1;
    //   $tahun = $tahun;
    // }

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

  public function insert_opname()
  {
    $kode_opname   = $this->input->post('kode_opname');
    $bulan            = $this->input->post('bulan');
    $tahun            = $this->input->post('tahun');
    $tgl_transaksi    = $this->input->post('tgl_transaksi');
    $kode_barang      = $this->input->post('kode_barang');
    $qty              = $this->input->post('qty');
    $id_user          = $this->session->userdata('id_user');

    $data = array(
      'kode_opname'    => $kode_opname,
      'bulan'             => $bulan,
      'tahun'             => $tahun,
      'tgl_transaksi'     => $tgl_transaksi,
      'id_user'           => $id_user
    );
    $this->db->insert('opname', $data);

    $result = array();
    $index  = 0;
    foreach ($kode_barang as $kode) {
      array_push($result, array(
        'kode_opname'  => $kode_opname,
        'kode_barang'     => $kode,
        'qty'             => $qty[$index]
      ));
      $index++;
    }
    $this->db->insert_batch('opname_detail', $result);

    redirect('opname/view_opname');
  }

  function insert_opname_detail()
  {

    $kode_opname     = $this->input->post('kode_opname');
    $kode_barang        = $this->input->post('kode_barang');
    $qty                = str_replace(",", "", $this->input->post('qty'));

    $data = array(
      'kode_opname'    => $kode_opname,
      'kode_barang'       => $kode_barang,
      'qty'               => $qty
    );
    $this->db->query("DELETE FROM opname_detail WHERE kode_barang = '$kode_barang' AND kode_opname = '$kode_opname' ");
    $this->db->insert('opname_detail', $data);
  }

  function detail_opname()
  {
    $kode_opname        = $this->input->post('kode_opname');

    $query = "SELECT opname_detail.kode_barang,nama_barang,satuan,jenis_barang,opname_detail.qty FROM opname_detail 
    INNER JOIN barang ON opname_detail.kode_barang=barang.kode_barang 
    WHERE opname_detail.kode_opname = '$kode_opname'
    GROUP BY opname_detail.kode_barang,opname_detail.kode_opname";
    return $this->db->query($query);
  }

  function getopname()
  {
    $kode_opname        = $this->uri->segment(3);

    $query = "SELECT * FROM opname WHERE opname.kode_opname = '$kode_opname'";
    return $this->db->query($query);
  }
}
