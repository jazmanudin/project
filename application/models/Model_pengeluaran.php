<?php

class Model_pengeluaran extends CI_Model
{

  function get_barang()
  {
    $keyword    = $this->uri->segment(3);

    $data = $this->db->query("SELECT 
    barang.kode_barang,
    barang.nama_barang,
    barang.satuan,
    barang.harga_modal,
    db.stok,
    db.exp_date,
    db.barangke

    FROM barang 
       
    LEFT JOIN (SELECT SUM(stok) AS stok,
    kode_barang,exp_date,barangke FROM barang_detail 
    WHERE stok != '0'
    GROUP BY kode_barang
    ORDER BY exp_date ASC) db ON (barang.kode_barang=db.kode_barang)
    
    WHERE barang.nama_barang LIKE '%$keyword%' AND barang.kode_barang NOT IN (SELECT kode_barang FROM pengeluaran_temp)");
    foreach ($data->result() as $d) {

      if ($d->stok > 0) {
        $supplier['query'] = $keyword;
        $supplier['suggestions'][] = array(
          'value'                   =>    $d->nama_barang,
          'kode_barang'             =>    $d->kode_barang,
          'nama_barang'             =>    $d->nama_barang,
          'exp_date'                =>    $d->exp_date,
          'barangke'                =>    $d->barangke,
          'stok'                    =>    $d->stok,
          'satuan'                  =>    $d->satuan,
          'harga_modal'             =>    $d->harga_modal
        );
      }
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

  function hapus_pengeluaran()
  {

    $no_pengeluaran    = $this->uri->segment(3);
    $datapenj = $this->db->query("SELECT * FROM pengeluaran_detail WHERE no_pengeluaran = '$no_pengeluaran'");
    foreach ($datapenj->result() as $d) {

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

    $this->db->query("DELETE FROM pengeluaran WHERE no_pengeluaran = '$no_pengeluaran' ");
    $this->db->query("DELETE FROM pengeluaran_detail WHERE no_pengeluaran = '$no_pengeluaran' ");

    redirect('pengeluaran/view_pengeluaran');
  }

  function hapus_pengeluaran_temp()
  {

    $kode_barang    = $this->input->post('kode_barang');
    $id_user        = $this->session->userdata('id_user');
    return $this->db->query("DELETE FROM pengeluaran_temp WHERE kode_barang = '$kode_barang' AND id_user = '$id_user' ");
  }

  function hapus_pengeluaran_detail()
  {

    $kode_barang    = $this->input->post('kode_barang');
    $no_pengeluaran    = $this->input->post('no_p$no_pengeluaran');
    return $this->db->query("DELETE FROM pengeluaran_detail WHERE kode_barang = '$kode_barang' AND no_pengeluaran = '$no_pengeluaran' ");
  }

  function detail_pengeluaran()
  {
    $no_pengeluaran        = $this->input->post('no_pengeluaran');

    $query = "SELECT pengeluaran_detail.exp_date,pengeluaran_detail.kode_barang,SUM(qty) AS qty,nama_barang,pengeluaran_detail.keterangan,satuan
    FROM pengeluaran_detail 
    INNER JOIN barang ON pengeluaran_detail.kode_barang=barang.kode_barang 
    WHERE pengeluaran_detail.no_pengeluaran = '$no_pengeluaran'
    GROUP BY pengeluaran_detail.kode_barang,pengeluaran_detail.no_pengeluaran";
    return $this->db->query($query);
  }

  function getpengeluaran()
  {
    $no_pengeluaran        = $this->uri->segment(3);

    $query = "SELECT * FROM pengeluaran WHERE pengeluaran.no_pengeluaran = '$no_pengeluaran' ";
    return $this->db->query($query);
  }

  public function getDatapengeluaran($rowno, $rowperpage, $no_pengeluaran = "", $jenis_pengeluaran = "", $dari = "", $sampai = "")
  {

    $this->db->select('*');
    $this->db->from('pengeluaran');
    $this->db->order_by('tgl_transaksi,no_pengeluaran', 'DESC');

    if ($no_pengeluaran != '') {
      $this->db->like('pengeluaran.no_pengeluaran', $no_pengeluaran);
    }

    if ($jenis_pengeluaran != '') {
      $this->db->like('pengeluaran.jenis_pengeluaran', $jenis_pengeluaran);
    }

    if ($dari != '') {
      $this->db->where('pengeluaran.tgl_transaksi BETWEEN "' . $dari . '" AND "' . $sampai . '"');
    }

    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function getRecordpengeluaranCount($no_pengeluaran = "", $jenis_pengeluaran = "", $dari = "", $sampai = "")
  {

    $this->db->select('count(*) as allcount');
    $this->db->from('pengeluaran');
    $this->db->order_by('tgl_transaksi,no_pengeluaran', 'DESC');

    if ($no_pengeluaran != '') {
      $this->db->like('pengeluaran.no_pengeluaran', $no_pengeluaran);
    }

    if ($jenis_pengeluaran != '') {
      $this->db->like('pengeluaran.jenis_pengeluaran', $jenis_pengeluaran);
    }

    if ($dari != '') {
      $this->db->where('pengeluaran.tgl_transaksi BETWEEN "' . $dari . '" AND "' . $sampai . '"');
    }

    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }


  function view_pengeluaran_temp()
  {
    $id_user            = $this->session->userdata('id_user');

    $query = "SELECT pengeluaran_temp.kode_barang,satuan,db.stok,pengeluaran_temp.keterangan,SUM(qty) AS qty,
    nama_barang,db.exp_date,pengeluaran_temp.barangke,barang.harga_modal
    FROM pengeluaran_temp 
    INNER JOIN barang ON pengeluaran_temp.kode_barang=barang.kode_barang 

    LEFT JOIN (SELECT SUM(stok) AS stok,
    kode_barang,exp_date FROM barang_detail 
    GROUP BY kode_barang
    ORDER BY exp_date ASC) db ON (pengeluaran_temp.kode_barang=db.kode_barang)

    WHERE pengeluaran_temp.id_user = '$id_user'
    GROUP BY pengeluaran_temp.kode_barang";
    return $this->db->query($query);
  }

  function view_pengeluaran_detail()
  {
    $no_pengeluaran    = $this->input->post('no_pengeluaran');

    $query = "SELECT pengeluaran_detail.kode_barang,satuan,db.stok,pengeluaran_detail.keterangan,SUM(qty) AS qty,
    nama_barang,db.exp_date,pengeluaran_detail.barangke,barang.harga_modal
    FROM pengeluaran_detail 
    INNER JOIN barang ON pengeluaran_detail.kode_barang=barang.kode_barang 

    LEFT JOIN (SELECT SUM(stok) AS stok,
    kode_barang,exp_date FROM barang_detail 
    GROUP BY kode_barang
    ORDER BY exp_date ASC) db ON (pengeluaran_detail.kode_barang=db.kode_barang)

    WHERE pengeluaran_detail.no_pengeluaran = '$no_pengeluaran'
    GROUP BY pengeluaran_detail.kode_barang";
    return $this->db->query($query);
  }

  function insert_pengeluaran_temp()
  {

    $kode_barang    = $this->input->post('kode_barang');
    $qty            = str_replace(",", "", $this->input->post('qty'));
    $keterangan     = $this->input->post('keterangan');
    $barangke     = $this->input->post('barangke');
    $exp_date     = $this->input->post('exp_date');
    $id_user        = $this->session->userdata('id_user');

    $data = array(
      'kode_barang'       => $kode_barang,
      'barangke'          => $barangke,
      'qty'               => $qty,
      'keterangan'        => $keterangan,
      'exp_date'          => $exp_date,
      'id_user'           => $id_user
    );
    $this->db->query("DELETE FROM pengeluaran_temp WHERE kode_barang = '$kode_barang' AND id_user = '$id_user' ");
    $this->db->insert('pengeluaran_temp', $data);
  }

  function insert_pengeluaran_detail()
  {

    $kode_barang    = $this->input->post('kode_barang');
    $no_pengeluaran    = $this->input->post('no_pengeluaran');
    $qty            = str_replace(",", "", $this->input->post('qty'));
    $keterangan     = $this->input->post('keterangan');
    $exp_date     = $this->input->post('exp_date');
    $barangke     = $this->input->post('barng$barangke');

    $data = array(
      'no_pengeluaran'    => $no_pengeluaran,
      'kode_barang'       => $kode_barang,
      'barangke'          => $barangke,
      'qty'               => $qty,
      'keterangan'        => $keterangan,
      'exp_date'          => $exp_date
    );
    $this->db->query("DELETE FROM pengeluaran_detail WHERE kode_barang = '$kode_barang' AND no_pengeluaran = '$no_pengeluaran' ");
    $this->db->insert('pengeluaran_detail', $data);
  }

  function insert_pengeluaran()
  {

    $tahun    = date('y');
    $bulan    = date('m');
    $this->db->select('right(pengeluaran.no_pengeluaran,3) as kode ', false);
    $this->db->where('mid(no_pengeluaran,5,2)', $bulan);
    $this->db->where('mid(no_pengeluaran,7,2)', $tahun);
    $this->db->order_by('no_pengeluaran', 'desc');
    $this->db->limit('13');
    $query    = $this->db->get('pengeluaran');
    if ($query->num_rows() <> 0) {
      $data   = $query->row();
      $kode   = intval($data->kode) + 1;
    } else {
      $kode   = 1;
    }
    $kodemax  = str_pad($kode, 3, "0", STR_PAD_LEFT);
    $no_pengeluaran   = "MSK-" . $bulan . "" . $tahun . "" . $kodemax;

    $id_user            = $this->session->userdata('id_user');
    $tgl_transaksi      = $this->input->post('tgl_transaksi');
    $jenis_pengeluaran      = $this->input->post('jenis_pengeluaran');
    $keterangan         = $this->input->post('keterangan');

    $data = array(
      'no_pengeluaran'    => $no_pengeluaran,
      'jenis_pengeluaran'     => $jenis_pengeluaran,
      'tgl_transaksi'   => $tgl_transaksi,
      'keterangan'      => $keterangan,
      'id_user'       => $id_user
    );
    $this->db->insert('pengeluaran', $data);

    $datapenj = $this->db->query("SELECT * FROM pengeluaran_temp 
    INNER JOIN barang ON barang.kode_barang=pengeluaran_temp.kode_barang
    WHERE pengeluaran_temp.id_user = '$id_user' ");
    foreach ($datapenj->result() as $d) {

      $data = array(
        'no_pengeluaran'    => $no_pengeluaran,
        'kode_barang'       => $d->kode_barang,
        'exp_date'          => $d->exp_date,
        'barangke'          => $d->barangke,
        'qty'               => $d->qty
      );
      $this->db->insert('pengeluaran_detail', $data);

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
    }

    $datapenj = $this->db->query("DELETE FROM pengeluaran_temp WHERE id_user = '$id_user'");
  }

  function update_pengeluaran()
  {

    $id_user            = $this->session->userdata('id_user');
    $no_pengeluaran       = $this->input->post('no_pengeluaran');
    $tgl_transaksi      = $this->input->post('tgl_transaksi');
    $jenis_pengeluaran      = $this->input->post('jenis_pengeluaran');
    $keterangan         = $this->input->post('keterangan');

    $data = array(
      'jenis_pengeluaran'     => $jenis_pengeluaran,
      'tgl_transaksi'       => $tgl_transaksi,
      'keterangan'          => $keterangan,
      'id_user'             => $id_user
    );
    $this->db->where('no_pengeluaran', $no_pengeluaran);
    $this->db->update('pengeluaran', $data);
  }

  public function codeotomatis()
  {
    $tahun    = date('y');
    $bulan    = date('m');
    $this->db->select('right(pengeluaran.no_pengeluaran,3) as kode ', false);
    $this->db->where('mid(no_pengeluaran,5,2)', $bulan);
    $this->db->where('mid(no_pengeluaran,7,2)', $tahun);
    $this->db->order_by('no_pengeluaran', 'desc');
    $this->db->limit('13');
    $query    = $this->db->get('pengeluaran');
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
