<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Job_position_model extends CI_Model
{

    private $table = 'job_positions';

    public function get_all($limit = null, $offset = 0)
    {
        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get($this->table)->result();
    }

    public function count_all()
    {
        return $this->db->count_all($this->table);
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        return $this->db->update($this->table, $data, ['id' => $id]);
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }

    public function get_by_name($name)
    {
        return $this->db
            ->where('name', $name)
            ->get('job_positions')
            ->row();
    }
}
