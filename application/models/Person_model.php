<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Person_model extends CI_Model
{
    private $table = 'people';

    public function get_all($limit = null, $offset = 0)
    {
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get($this->table)->result();
    }

    public function get_all_with_last_job($limit = null, $offset = 0)
    {
        $this->db->select('p.*, j.name as job_position_name, h.start_date');
        $this->db->from('people p');
        $this->db->join('(SELECT DISTINCT ON (person_id) * FROM job_history ORDER BY person_id, start_date DESC) h', 'h.person_id = p.id', 'left');
        $this->db->join('job_positions j', 'j.id = h.job_position_id', 'left');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get()->result();
    }

    public function search_with_last_job($limit, $offset, $search)
    {
        $subquery = "
            SELECT id FROM job_history
            WHERE person_id = people.id AND end_date IS NULL
            ORDER BY start_date DESC
            LIMIT 1
        ";

        $this->db->select('people.*, jh.start_date, jp.name as job_position_name');
        $this->db->from('people');
        $this->db->where("people.name ILIKE", '%' . $search . '%');
        $this->db->join("job_history jh", "jh.id = ($subquery)", 'left', false);
        $this->db->join("job_positions jp", "jp.id = jh.job_position_id", 'left');
        $this->db->order_by('people.id', 'DESC');
        $this->db->limit($limit, $offset);

        return $this->db->get()->result();
    }

    public function search_by_name($term)
    {
        return $this->db
            ->select('id, name')
            ->where("name ILIKE", "%{$term}%")
            ->limit(20)
            ->get('people')
            ->result();
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
}
