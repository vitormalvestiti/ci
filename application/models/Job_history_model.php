<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Job_history_model extends CI_Model
{

    private $table = 'job_history';

    public function get_by_person($person_id)
    {
        $this->db->select('jh.*, jp.name as job_position_name');
        $this->db->from('job_history jh');
        $this->db->join('job_positions jp', 'jp.id = jh.job_position_id');
        $this->db->where('jh.person_id', $person_id);
        $this->db->order_by('jh.start_date', 'DESC');
        return $this->db->get()->result();
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

    public function get_active_by_person($person_id)
    {
        $this->db->select('jh.*, jp.name as job_position_name');
        $this->db->from('job_history jh');
        $this->db->join('job_positions jp', 'jp.id = jh.job_position_id');
        $this->db->where('jh.person_id', $person_id);
        $this->db->where('jh.end_date IS NULL');
        $this->db->order_by('jh.start_date', 'DESC');
        return $this->db->get()->row();
    }
}
