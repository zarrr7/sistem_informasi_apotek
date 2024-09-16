<?php
class Penjualan_detail_model extends CI_Model {

    public function getAll() {
        $this->db->select('tb_detail_penjualan.*, tb_obat.obat');
        $this->db->from('tb_detail_penjualan');
        $this->db->join('tb_obat', 'tb_detail_penjualan.id_obat = tb_obat.id_obat');
        $query = $this->db->get();
        return $query->result();
    }
   
    public function getData($table, $where = null) {
        if ($where) {
            return $this->db->get_where($table, $where);
        }
        return $this->db->get($table);
    }

    public function insertData($data, $table) {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function updateData($data, $where, $table) {
        $this->db->where($where);
        $this->db->update($table, $data);
    }

    public function deleteData($where, $table) {
        $this->db->where($where);
        $this->db->delete($table);
    }

}
