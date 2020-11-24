<?php

class Model_salesorder extends CI_Model
{

  function view_pelanggan()
  {
    return $this->db->query("SELECT * FROM pelanggan");
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
   ");
  }

  function hapus_salesorder()
  {

    $no_so    = $this->uri->segment(3);
    $this->db->query("DELETE FROM salesorder WHERE no_so = '$no_so' ");
    $this->db->query("DELETE FROM salesorder_detail WHERE no_so = '$no_so' ");
    $this->db->query("DELETE FROM penjualan_temp WHERE no_so = '$no_so' ");
    redirect('salesorder/view_salesorder');
  }

  function hapus_salesorder_temp()
  {

    $kode_barang    = $this->input->post('kode_barang');
    $id_user        = $this->session->userdata('id_user');
    return $this->db->query("DELETE FROM salesorder_temp WHERE kode_barang = '$kode_barang' AND id_user = '$id_user' ");
  }

  function hapus_salesorder_detail()
  {

    $kode_barang      = $this->input->post('kode_barang');
    return $this->db->query("DELETE FROM salesorder_detail WHERE kode_barang = '$kode_barang' ");
  }

  public function getSalesOrder()
  {

    $no_so    = $this->uri->segment(3);

    $this->db->select('salesorder.ppn,jenis_harga,karyawan.nama_karyawan,salesorder.id_sales,salesorder.no_so,tgl_transaksi,nama_pelanggan,salesorder.kode_pelanggan,salesorder.total,salesorder.keterangan');
    $this->db->from('salesorder');
    $this->db->join('pelanggan', 'salesorder.kode_pelanggan = pelanggan.kode_pelanggan');
    $this->db->join('karyawan', 'pelanggan.id_sales = karyawan.nik', 'left');
    $this->db->where('salesorder.no_so', $no_so);
    $this->db->order_by('tgl_transaksi,no_so', 'DESC');

    $query = $this->db->get();
    return $query->row_array();
  }

  public function getDataSalesOrder($rowno, $rowperpage, $no_so = "", $kode_pelanggan = "", $dari = "", $sampai = "")
  {

    $this->db->select('karyawan.nama_karyawan,salesorder.no_so,tgl_transaksi,status,ppn,nama_pelanggan,salesorder.kode_pelanggan,salesorder.total,salesorder.keterangan');
    $this->db->from('salesorder');
    $this->db->join('pelanggan', 'salesorder.kode_pelanggan = pelanggan.kode_pelanggan');
    $this->db->join('karyawan', 'pelanggan.id_sales = karyawan.nik', 'left');
    $this->db->order_by('tgl_transaksi,no_so', 'DESC');

    if ($no_so != '') {
      $this->db->like('salesorder.no_so', $no_so);
    }

    if ($kode_pelanggan != '') {
      $this->db->like('salesorder.kode_pelanggan', $kode_pelanggan);
    }

    if ($dari != '') {
      $this->db->where('salesorder.tgl_transaksi BETWEEN "' . $dari . '" AND "' . $sampai . '"');
    }

    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function getRecordSalesOrderCount($no_so = "", $kode_pelanggan = "", $dari = "", $sampai = "")
  {

    $this->db->select('count(*) as allcount');
    $this->db->from('salesorder');
    $this->db->join('pelanggan', 'salesorder.kode_pelanggan = pelanggan.kode_pelanggan');
    $this->db->join('karyawan', 'pelanggan.id_sales = karyawan.nik', 'left');
    $this->db->order_by('tgl_transaksi,salesorder.no_so', 'DESC');

    if ($no_so != '') {
      $this->db->like('salesorder.no_so', $no_so);
    }

    if ($kode_pelanggan != '') {
      $this->db->like('salesorder.kode_pelanggan', $kode_pelanggan);
    }

    if ($dari != '') {
      $this->db->where('salesorder.tgl_transaksi BETWEEN "' . $dari . '" AND "' . $sampai . '"');
    }

    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  function detail_salesorder()
  {
    $no_so              = $this->input->post('no_so');

    $year         = date('Y');
    $month         = date('m');
    $date         = date('d') + 01;
    $tglnow       = $year . "-" . $month . "-" . $date;

    $query = "SELECT barang.satuan,salesorder_detail.kode_barang,db.stok,SUM(qty) AS qty,nama_barang,salesorder_detail.harga_jual,salesorder_detail.keterangan 
    FROM salesorder_detail 
    INNER JOIN barang ON salesorder_detail.kode_barang=barang.kode_barang 

    LEFT JOIN (SELECT SUM( IF( exp_date >= '$tglnow' , stok ,0 )) AS stok,
    kode_barang,exp_date FROM barang_detail 
    GROUP BY kode_barang
    ORDER BY exp_date ASC) db ON (salesorder_detail.kode_barang=db.kode_barang)

    WHERE salesorder_detail.no_so = '$no_so'
    GROUP BY salesorder_detail.kode_barang,salesorder_detail.no_so";
    return $this->db->query($query);
  }

  function view_salesorder_temp()
  {
    $year               = date('Y');
    $month              = date('m');
    $date               = date('d') + 01;
    $tglnow             = $year . "-" . $month . "-" . $date;
    $id_user            = $this->session->userdata('id_user');
    // $kode_pelanggan     = $this->input->post('kode_pelanggan');
    $query = "SELECT salesorder_temp.kode_barang,satuan,db.stok,salesorder_temp.keterangan,SUM(qty) AS qty,nama_barang,salesorder_temp.harga_jual
    FROM salesorder_temp 
    INNER JOIN barang ON salesorder_temp.kode_barang=barang.kode_barang 

    LEFT JOIN (SELECT SUM( IF( exp_date >= '$tglnow' , stok ,0 )) AS stok,
    kode_barang,exp_date FROM barang_detail 
    GROUP BY kode_barang
    ORDER BY exp_date ASC) db ON (salesorder_temp.kode_barang=db.kode_barang)

    WHERE salesorder_temp.id_user = '$id_user'
    GROUP BY salesorder_temp.kode_barang";
    return $this->db->query($query);
  }

  function insert_salesorder_temp()
  {

    $kode_barang    = $this->input->post('kode_barang');
    $barangke       = $this->input->post('barangke');
    $exp_date       = $this->input->post('exp_date');
    $harga_jual     = str_replace(",", "", $this->input->post('harga_jual'));
    $qty            = str_replace(",", "", $this->input->post('qty'));
    $keterangan     = $this->input->post('keterangan');
    $kode_pelanggan = $this->input->post('kode_pelanggan');
    $id_user        = $this->session->userdata('id_user');

    $data = array(
      'kode_barang'       => $kode_barang,
      'qty'               => $qty,
      'harga_jual'        => $harga_jual,
      'keterangan'        => $keterangan,
      'exp_date'          => $exp_date,
      'barangke'          => $barangke,
      'kode_pelanggan'    => $kode_pelanggan,
      'id_user'           => $id_user
    );
    $this->db->query("DELETE FROM salesorder_temp WHERE kode_barang = '$kode_barang' AND id_user = '$id_user' ");
    $this->db->insert('salesorder_temp', $data);
  }

  function insert_salesorder_detail()
  {

    $no_so          = $this->input->post('no_so');
    $kode_barang    = $this->input->post('kode_barang');
    $barangke       = $this->input->post('barangke');
    $exp_date       = $this->input->post('exp_date');
    $harga_jual     = str_replace(",", "", $this->input->post('harga_jual'));
    $qty            = str_replace(",", "", $this->input->post('qty'));
    $keterangan     = $this->input->post('keterangan');

    $data = array(
      'kode_barang'       => $kode_barang,
      'no_so'             => $no_so,
      'qty'               => $qty,
      'harga_jual'        => $harga_jual,
      'keterangan'        => $keterangan,
      'exp_date'          => $exp_date,
      'barangke'          => $barangke
    );
    $this->db->query("DELETE FROM salesorder_detail WHERE kode_barang = '$kode_barang' AND no_so = '$no_so' ");
    $this->db->query("DELETE FROM penjualan_temp WHERE kode_barang = '$kode_barang' AND no_so = '$no_so' ");
    $this->db->insert('salesorder_detail', $data);
    $this->db->insert('penjualan_temp', $data);
  }

  function insert_salesorder()
  {

    $tahun    = date('y');
    $bulan    = date('m');
    $this->db->select('right(salesorder.no_so,3) as kode ', false);
    $this->db->where('mid(no_so,4,2)', $bulan);
    $this->db->where('mid(no_so,6,2)', $tahun);
    $this->db->order_by('no_so', 'desc');
    $this->db->limit('13');
    $query    = $this->db->get('salesorder');
    if ($query->num_rows() <> 0) {
      $data   = $query->row();
      $kode   = intval($data->kode) + 1;
    } else {
      $kode   = 1;
    }
    $kodemax  = str_pad($kode, 3, "0", STR_PAD_LEFT);
    $no_so   = "SO-" . $bulan . "" . $tahun . "" . $kodemax;

    $id_user            = $this->session->userdata('id_user');
    $subtotal           = str_replace(",", "", $this->input->post('subtotal'));
    $tgl_transaksi      = $this->input->post('tgl_transaksi');
    $id_sales           = $this->input->post('id_sales');
    $kode_pelanggan     = $this->input->post('kode_pelanggan');
    $ppn                = $this->input->post('ppn');
    $keterangan         = $this->input->post('keterangan');

    $data = array(
      'no_so'           => $no_so,
      'kode_pelanggan'  => $kode_pelanggan,
      'id_sales'        => $id_sales,
      'total'           => $subtotal,
      'ppn'             => $ppn,
      'tgl_transaksi'   => $tgl_transaksi,
      'status'          => "0",
      'keterangan'      => $keterangan,
      'id_user'         => $id_user
    );
    $this->db->insert('salesorder', $data);

    $datapenj = $this->db->query("SELECT * FROM salesorder_temp");
    foreach ($datapenj->result() as $d) {

      $data = array(
        'no_so'           => $no_so,
        'kode_barang'     => $d->kode_barang,
        'qty'             => $d->qty,
        'harga_jual'      => $d->harga_jual,
        'keterangan'      => $d->keterangan
      );
      $this->db->insert('salesorder_detail', $data);

      $datapemb = array(
        'no_so'           => $no_so,
        'kode_barang'     => $d->kode_barang,
        'qty'             => $d->qty,
        'harga_jual'      => $d->harga_jual,
        'exp_date'        => $d->exp_date,
        'barangke'        => $d->barangke,
        'keterangan'      => $d->keterangan,
        'id_user'         => $id_user
      );
      $this->db->insert('penjualan_temp', $datapemb);
    }

    $datapenj = $this->db->query("DELETE FROM salesorder_temp WHERE id_user = '$id_user'");
  }

  function update_salesorder()
  {

    $id_user            = $this->session->userdata('id_user');
    $subtotal           = str_replace(",", "", $this->input->post('subtotal'));
    $no_so              = $this->input->post('no_so');
    $id_sales           = $this->input->post('id_sales');
    $tgl_transaksi      = $this->input->post('tgl_transaksi');
    $kode_pelanggan     = $this->input->post('kode_pelanggan');
    $ppn                = $this->input->post('ppn');
    $keterangan         = $this->input->post('keterangan');

    $data = array(
      'no_so'           => $no_so,
      'kode_pelanggan'  => $kode_pelanggan,
      'total'           => $subtotal,
      'ppn'             => $ppn,
      'id_sales'        => $id_sales,
      'tgl_transaksi'   => $tgl_transaksi,
      'keterangan'      => $keterangan
    );

    $this->db->where('no_so', $no_so);
    $this->db->update('salesorder', $data);
  }

  public function codeotomatis()
  {
    $tahun    = date('y');
    $bulan    = date('m');
    $this->db->select('right(salesorder.no_so,3) as kode ', false);
    $this->db->where('mid(no_so,4,2)', $bulan);
    $this->db->where('mid(no_so,6,2)', $tahun);
    $this->db->order_by('no_so', 'desc');
    $this->db->limit('13');
    $query    = $this->db->get('salesorder');
    if ($query->num_rows() <> 0) {
      $data   = $query->row();
      $kode   = intval($data->kode) + 1;
    } else {
      $kode   = 1;
    }
    $kodemax  = str_pad($kode, 3, "0", STR_PAD_LEFT);
    echo "SO-" . $bulan . "" . $tahun . "" . $kodemax;
  }

  function get_pelanggan()
  {
    $keyword      = $this->uri->segment(3);
    $data         = $this->db->from('pelanggan')
      ->join('karyawan', 'karyawan.nik=pelanggan.id_sales')
      ->like('nama_pelanggan', $keyword)
      ->get();
    foreach ($data->result() as $d) {

      $tanggal        = Date('Y-m-d');
      $jatuhtempo     = Date('Y-m-d', strtotime('+' . $d->jatuh_tempo . ' days', strtotime($tanggal)));

      $pelanggan['query'] = $keyword;
      $pelanggan['suggestions'][] = array(
        'value'                   =>    $d->nama_pelanggan,
        'id_sales'                =>    $d->id_sales,
        'nama_karyawan'           =>    $d->nama_karyawan,
        'jatuh_tempo'             =>    $jatuhtempo,
        'kode_pelanggan'          =>    $d->kode_pelanggan,
        'jenis_harga'             =>    $d->jenis_harga,
        'nama_pelanggan'          =>    $d->nama_pelanggan
      );
    }
    echo json_encode($pelanggan);
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
    
    WHERE barang.nama_barang LIKE '%$keyword%' AND barang.kode_barang NOT IN (SELECT kode_barang FROM salesorder_temp) ");
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
}
