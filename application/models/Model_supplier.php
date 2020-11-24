<?php
class Model_supplier extends CI_Model
{

    public function getDatasupplier($rowno, $rowperpage, $kode_supplier = "", $nama_supplier = "")
    {

        $this->db->select('*');
        $this->db->from('supplier');
        $this->db->order_by('nama_supplier', 'DESC');

        if ($kode_supplier != '') {
            $this->db->like('supplier.kode_supplier', $kode_supplier);
        }

        if ($nama_supplier != '') {
            $this->db->like('supplier.nama_supplier', $nama_supplier);
        }

        $this->db->limit($rowperpage, $rowno);
        $query = $this->db->get();
        return $query->result();
    }

    public function getRecordsupplierCount($kode_supplier = "", $nama_supplier = "")
    {

        $this->db->select('count(*) as allcount');
        $this->db->from('supplier');
        $this->db->order_by('supplier.nama_supplier', 'DESC');

        if ($kode_supplier != '') {
            $this->db->like('supplier.kode_supplier', $kode_supplier);
        }

        if ($nama_supplier != '') {
            $this->db->like('supplier.nama_supplier', $nama_supplier);
        }

        $query  = $this->db->get();
        $result = $query->result_array();
        return $result[0]['allcount'];
    }

    function get_supplier()
    {

        return $this->db->get('supplier');
    }

    function insert_supplier()
    {
        $this->db->select('right(supplier.kode_supplier,4) as kode ', false);
        $this->db->order_by('kode_supplier', 'desc');
        $this->db->limit('6');
        $query    = $this->db->get('supplier');
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->kode) + 1;
        } else {
            $kode = 1;
        }
        $kodemax          = str_pad($kode, 4, "0", STR_PAD_LEFT);
        $kode_supplier    = "K" . $kodemax;

        $kodesupplier   = $this->input->post('kode_supplier');
        $nama_supplier  = $this->input->post('nama_supplier');
        $alamat         = $this->input->post('alamat');
        $no_hp          = $this->input->post('no_hp');
        $jatuh_tempo    = $this->input->post('jatuh_tempo');
        $keterangan     = $this->input->post('keterangan');
        $id_user        = $this->session->userdata('id_user');

        if ($kodesupplier != "") {
            $data             = array(
                'nama_supplier'                     => $nama_supplier,
                'alamat'                            => $alamat,
                'no_hp'                             => $no_hp,
                'jatuh_tempo'                       => $jatuh_tempo,
                'keterangan'                        => $keterangan,
                'id_user'                           => $id_user,
            );

            $this->db->where('kode_supplier', $kodesupplier);
            $this->db->update('supplier', $data);
        } else {

            $data             = array(
                'kode_supplier'                     => $kode_supplier,
                'nama_supplier'                     => $nama_supplier,
                'alamat'                            => $alamat,
                'no_hp'                             => $no_hp,
                'jatuh_tempo'                       => $jatuh_tempo,
                'keterangan'                        => $keterangan,
                'id_user'                           => $id_user,
            );

            $this->db->insert('supplier', $data);
        }
    }
}
