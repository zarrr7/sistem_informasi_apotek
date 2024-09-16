<?php
class Penjualan_model extends CI_Model {

    public function get_all_penjualan()
    {
        $this->db->select('tb_penjualan.*, tb_obat.obat');
        $this->db->from('tb_penjualan');
        $this->db->join('tb_obat', 'tb_penjualan.id_obat = tb_obat.id_obat');
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
        /**
         * Insert the data to the database
         *
         * @var $this->db the database object
         */
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
