<?php

class Model_pemasukan extends CI_Model
{

  function get_barang()
  {
    $keyword    = $this->uri->segment(3);

    $data = $this->db->query("SELECT 
    barang.kode_barang,
    barang.nama_barang,
    barang.satuan,
    barang.harga_modal

    FROM barang 
    
    WHERE barang.nama_barang LIKE '%$keyword%' AND barang.kode_barang NOT IN (SELECT kode_barang FROM pemasukan_temp)");
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

  function get_barangbarcode()
  {

    $kode_barang     = $this->input->post('kode_barang');
    $barang = $this->db->query("SELECT  * FROM barang WHERE barang.kode_barang = '$kode_barang'
    ");

    if ($barang->num_rows() > 0) {

      $barang = $barang->row_array();
      echo $barang['nama_barang'] . "|" . $barang['satuan'] . "|" . $barang['harga_modal'];
    }
  }

  function hapus_pemasukan()
  {

    $no_pemasukan    = $this->uri->segment(3);
    $this->db->query("DELETE FROM pemasukan WHERE no_pemasukan = '$no_pemasukan' ");
    $this->db->query("DELETE FROM pemasukan_detail WHERE no_pemasukan = '$no_pemasukan' ");
    $this->db->query("DELETE FROM barang_detail WHERE no_ref = '$no_pemasukan' ");
    redirect('pemasukan/view_pemasukan');
  }

  function hapus_pemasukan_temp()
  {

    $kode_barang    = $this->input->post('kode_barang');
    $id_user        = $this->session->userdata('id_user');
    return $this->db->query("DELETE FROM pemasukan_temp WHERE kode_barang = '$kode_barang' AND id_user = '$id_user' ");
  }

  function hapus_pemasukan_detail()
  {

    $kode_barang    = $this->input->post('kode_barang');
    $no_pemasukan        = $this->input->post('no_pemasukan');
    return $this->db->query("DELETE FROM pemasukan_detail WHERE kode_barang = '$kode_barang' AND no_pemasukan = '$no_pemasukan' ");
  }

  function detail_pemasukan()
  {
    $no_pemasukan        = $this->input->post('no_pemasukan');

    $query = "SELECT pemasukan_detail.exp_date,pemasukan_detail.kode_barang,SUM(qty) AS qty,nama_barang,pemasukan_detail.keterangan,satuan
    FROM pemasukan_detail 
    INNER JOIN barang ON pemasukan_detail.kode_barang=barang.kode_barang 
    WHERE pemasukan_detail.no_pemasukan = '$no_pemasukan'
    GROUP BY pemasukan_detail.kode_barang,pemasukan_detail.no_pemasukan";
    return $this->db->query($query);
  }

  function getPemasukan()
  {
    $no_pemasukan        = $this->uri->segment(3);

    $query = "SELECT * FROM pemasukan WHERE pemasukan.no_pemasukan = '$no_pemasukan' ";
    return $this->db->query($query);
  }

  public function getDataPemasukan($rowno, $rowperpage, $no_pemasukan = "", $jenis_pemasukan = "", $dari = "", $sampai = "")
  {

    $this->db->select('*');
    $this->db->from('pemasukan');
    $this->db->order_by('tgl_transaksi,no_pemasukan', 'DESC');

    if ($no_pemasukan != '') {
      $this->db->like('pemasukan.no_pemasukan', $no_pemasukan);
    }

    if ($jenis_pemasukan != '') {
      $this->db->like('pemasukan.jenis_pemasukan', $jenis_pemasukan);
    }

    if ($dari != '') {
      $this->db->where('pemasukan.tgl_transaksi BETWEEN "' . $dari . '" AND "' . $sampai . '"');
    }

    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function getRecordPemasukanCount($no_pemasukan = "", $jenis_pemasukan = "", $dari = "", $sampai = "")
  {

    $this->db->select('count(*) as allcount');
    $this->db->from('pemasukan');
    $this->db->order_by('tgl_transaksi,no_pemasukan', 'DESC');

    if ($no_pemasukan != '') {
      $this->db->like('pemasukan.no_pemasukan', $no_pemasukan);
    }

    if ($jenis_pemasukan != '') {
      $this->db->like('pemasukan.jenis_pemasukan', $jenis_pemasukan);
    }

    if ($dari != '') {
      $this->db->where('pemasukan.tgl_transaksi BETWEEN "' . $dari . '" AND "' . $sampai . '"');
    }

    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  function view_pemasukan_temp()
  {
    $id_user        = $this->session->userdata('id_user');
    $query = "SELECT pemasukan_temp.kode_barang,exp_date,satuan,pemasukan_temp.keterangan,SUM(qty) AS qty,nama_barang
    FROM pemasukan_temp 
    INNER JOIN barang ON pemasukan_temp.kode_barang=barang.kode_barang
    WHERE pemasukan_temp.id_user = '$id_user' 
    GROUP BY pemasukan_temp.kode_barang";
    return $this->db->query($query);
  }

  function view_pemasukan_detail()
  {
    $no_pemasukan    = $this->input->post('no_pemasukan');
    $query = "SELECT pemasukan_detail.kode_barang,satuan,exp_date,pemasukan_detail.keterangan,SUM(qty) AS qty,nama_barang
    FROM pemasukan_detail 
    INNER JOIN barang ON pemasukan_detail.kode_barang=barang.kode_barang
    WHERE pemasukan_detail.no_pemasukan = '$no_pemasukan' 
    GROUP BY pemasukan_detail.kode_barang";
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
    $exp_date     = $this->input->post('exp_date');
    $id_user        = $this->session->userdata('id_user');

    $data = array(
      'kode_barang'       => $kode_barang,
      'qty'               => $qty,
      'keterangan'        => $keterangan,
      'exp_date'          => $exp_date,
      'id_user'           => $id_user
    );
    $this->db->query("DELETE FROM pemasukan_temp WHERE kode_barang = '$kode_barang' AND id_user = '$id_user' ");
    $this->db->insert('pemasukan_temp', $data);
  }

  function insert_pemasukan_detail()
  {

    $kode_barang        = $this->input->post('kode_barang');
    $no_pemasukan       = $this->input->post('no_pemasukan');
    $qty                = str_replace(",", "", $this->input->post('qty'));
    $keterangan         = $this->input->post('keterangan');
    $exp_date           = $this->input->post('exp_date');
    $id_user            = $this->session->userdata('id_user');


    $this->db->query("DELETE FROM pemasukan_detail WHERE kode_barang = '$kode_barang' AND no_pemasukan = '$no_pemasukan' ");
    $this->db->query("DELETE FROM barang_detail WHERE kode_barang = '$kode_barang' AND exp_date = '$exp_date' AND no_ref = '$no_pemasukan'");

    $data = array(
      'no_pemasukan'      => $no_pemasukan,
      'kode_barang'       => $kode_barang,
      'qty'               => $qty,
      'keterangan'        => $keterangan,
      'exp_date'          => $exp_date
    );
    $this->db->insert('pemasukan_detail', $data);

    $barangke = $this->db->query("SELECT barangke FROM barang WHERE kode_barang = '$kode_barang' ")->row_array();

    $databarang = array(
      'kode_barang'     => $kode_barang,
      'stok'            => $qty,
      'exp_date'        => $exp_date,
      'id_user'         => $id_user,
      'barangke'        => $barangke['barangke'],
      'asal_barang'     => "Pemasukan",
      'no_ref'          => $no_pemasukan
    );
    $this->db->insert('barang_detail', $databarang);
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

    $id_user            = $this->session->userdata('id_user');
    $tgl_transaksi      = $this->input->post('tgl_transaksi');
    $jenis_pemasukan      = $this->input->post('jenis_pemasukan');
    $keterangan         = $this->input->post('keterangan');

    $data = array(
      'no_pemasukan'    => $no_pemasukan,
      'jenis_pemasukan'     => $jenis_pemasukan,
      'tgl_transaksi'   => $tgl_transaksi,
      'keterangan'      => $keterangan,
      'id_user'       => $id_user
    );
    $this->db->insert('pemasukan', $data);

    $datapenj = $this->db->query("SELECT * FROM pemasukan_temp 
    INNER JOIN barang ON barang.kode_barang=pemasukan_temp.kode_barang
    WHERE pemasukan_temp.id_user = '$id_user'");
    foreach ($datapenj->result() as $d) {

      $data = array(
        'no_pemasukan'    => $no_pemasukan,
        'kode_barang'     => $d->kode_barang,
        'exp_date'        => $d->exp_date,
        'qty'             => $d->qty
      );
      $this->db->insert('pemasukan_detail', $data);

      $databarang = array(
        'kode_barang'     => $d->kode_barang,
        'stok'            => $d->qty,
        'exp_date'        => $d->exp_date,
        'id_user'         => $id_user,
        'barangke'        => $d->barangke + 1,
        'no_ref'          => $no_pemasukan,
        'asal_barang'     => "Pemasukan"
      );
      $this->db->insert('barang_detail', $databarang);

      $this->db->query("UPDATE barang SET barangke = barangke+1 WHERE kode_barang = '$d->kode_barang'");
      $datapenj = $this->db->query("DELETE FROM pemasukan_temp WHERE id_user = '$id_user' AND kode_barang = '$d->kode_barang'");
    }
  }

  function update_pemasukan()
  {

    $id_user            = $this->session->userdata('id_user');
    $no_pemasukan       = $this->input->post('no_pemasukan');
    $tgl_transaksi      = $this->input->post('tgl_transaksi');
    $jenis_pemasukan      = $this->input->post('jenis_pemasukan');
    $keterangan         = $this->input->post('keterangan');

    $data = array(
      'jenis_pemasukan'     => $jenis_pemasukan,
      'tgl_transaksi'       => $tgl_transaksi,
      'keterangan'          => $keterangan,
      'id_user'             => $id_user
    );
    $this->db->where('no_pemasukan', $no_pemasukan);
    $this->db->update('pemasukan', $data);
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
