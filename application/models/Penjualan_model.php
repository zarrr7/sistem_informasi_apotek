<?php
class Penjualan_model extends CI_Model {

    public function get_all_penjualan() {
        $this->db->select('tb_penjualan.*, tb_detail_penjualan.id_obat');
        $this->db->from('tb_penjualan');
        $this->db->join('tb_detail_penjualan', 'tb_penjualan.id_penjualan = tb_detail_penjualan.id_penjualan');
        $query = $this->db->get();
        return $query->result();
    }
   
    public function get_data($table, $where = null) {
        if ($where) {
            return $this->db->get_where($table, $where);
        }
        return $this->db->get($table);
    }
    /**
     * Insert data to the database
     *
     * @param array $data the data to be inserted
     * @param string $table the table to insert the data to
     *
     * @return void
     */
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
