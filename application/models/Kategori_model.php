<?php
class Kategori_model extends CI_Model {

    public function get_all_kategori()
    {
        return $this->db->get('tb_kategori')->result();
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
