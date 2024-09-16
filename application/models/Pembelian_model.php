<?php
class Pembelian_model extends CI_Model {

    public function get_all_pembelian() {
        $this->db->select('tb_pembelian.*, tb_detail_pembelian.id_obat');
        $this->db->from('tb_pembelian');
        $this->db->join('tb_detail_pembelian', 'tb_pembelian.id_pembelian = tb_detail_pembelian.id_pembelian');
        $query = $this->db->get();
        return $query->result();
    }
   
    public function get_data($table, $where = null) {
        if ($where) {
            return $this->db->get_where($table, $where);
        }
        return $this->db->get($table);
    }

    public function insert_data($data, $table) {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function update_data($data, $where, $table) {
        $this->db->where($where);
        $this->db->update($table, $data);
    }

    public function delete_data($where, $table) {
        $this->db->where($where);
        $this->db->delete($table);
    }

}
