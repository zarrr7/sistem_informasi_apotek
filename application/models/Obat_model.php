<?php
class Obat_model extends CI_Model
{
    public function get_all_obat()
    {
        $this->db->select('tb_obat.*, tb_kategori.kategori, tb_satuan.satuan');
        $this->db->from('tb_obat');
        $this->db->join('tb_kategori', 'tb_obat.id_kategori = tb_kategori.id_kategori');
        $this->db->join('tb_satuan', 'tb_obat.id_satuan = tb_satuan.id_satuan');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_data($table, $where = null) {
        if ($where) {
            return $this->db->get_where($table, $where);
        }
        return $this->db->get($table);
    }

    public function insert_data($data, $table)
    {
        $this->db->insert($table, $data);
        if ($this->db->affected_rows() == 0) {
            return false;
        }
        return true;
    }

    public function update_data($data, $where, $table)
    {
        $this->db->where($where);
        $this->db->update($table, $data);
    }

    public function delete_data($where, $table)
    {
        $this->db->where($where);
        $this->db->delete($table);
    }
}
