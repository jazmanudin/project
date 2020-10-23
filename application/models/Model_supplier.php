<?php
class Model_supplier extends CI_Model
{

    function view_supplier()
    {
        $id_member = $this->session->userdata('id_member');
        return $this->db->query("SELECT * FROM supplier 
        WHERE supplier.id_member = '$id_member'
        ORDER BY nama_supplier
        ");
    }

    function get_supplier()
    {

        $id_member = $this->session->userdata('id_member');
        return $this->db->get_where('supplier', array('id_member' => $id_member));
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
        $keterangan     = $this->input->post('keterangan');
        $id_member      = $this->session->userdata('id_member');
        $id_user        = $this->session->userdata('id_user');

        if ($kodesupplier != "") {
            $data             = array(
                'nama_supplier'                     => $nama_supplier,
                'alamat'                            => $alamat,
                'no_hp'                             => $no_hp,
                'keterangan'                        => $keterangan,
                'id_member'                         => $id_member,
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
                'keterangan'                        => $keterangan,
                'id_member'                         => $id_member,
                'id_user'                           => $id_user,
            );

            $this->db->insert('supplier', $data);
        }
    }
}
