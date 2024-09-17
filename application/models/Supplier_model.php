<?php
class Supplier_model extends CI_Model {
    public function get_all_supplier() {
        $this->db->select('*');
        $this->db->from('tb_supplier');
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
