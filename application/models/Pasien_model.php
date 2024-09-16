<?php
class Pasien_model extends CI_Model
{
 
    public function get_all_pasien()
    {
        $this->db->select('tb_pasien.*, tb_obat.obat');
        $this->db->from('tb_pasien');
        $this->db->join('tb_obat', 'tb_pasien.id_obat = tb_obat.id_obat');
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
