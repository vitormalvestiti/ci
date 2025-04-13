<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property Job_history_model $Job_history_model
 * @property Person_model $Person_model
 * @property Job_position_model $Job_position_model
 * @property CI_Input $input
 * @property CI_Loader $load
 * @property CI_DB_query_builder $db
 * @property CI_Pagination $pagination
 * @property CI_Session $session
 * @property CI_URI $uri
 */

class Job_position extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Job_position_model');
        $this->load->helper(['url', 'form']);
        $this->load->library('pagination');
        $this->load->library('session');
    }

    public function index()
    {
        $search = $this->input->get('search');
        $limit = 10;
        $start = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $this->load->library('pagination');

        if ($search) {
            $this->db->from('job_positions');
            $this->db->where("name ILIKE '%" . $this->db->escape_like_str($search) . "%'", null, false);
            $total_rows = $this->db->count_all_results();

            $config['base_url'] = site_url('job_position/index');
            $config['total_rows'] = $total_rows;
            $config['per_page'] = $limit;
            $config['reuse_query_string'] = true;
            $this->pagination->initialize($config);

            $this->db->where("name ILIKE '%" . $this->db->escape_like_str($search) . "%'", null, false);
            $view_data['job_positions'] = $this->db
                ->limit($limit, $start)
                ->get('job_positions')
                ->result();
        } else {
            $config['base_url'] = site_url('job_position/index');
            $config['total_rows'] = $this->Job_position_model->count_all();
            $config['per_page'] = $limit;
            $this->pagination->initialize($config);

            $view_data['job_positions'] = $this->Job_position_model->get_all($limit, $start);
        }

        $view_data['search'] = $search;

        $data['title'] = 'Job Positions';
        $data['view'] = 'job_position/index';
        $data['view_data'] = $view_data;

        $this->load->view('layout', $data);
    }

    public function assign($job_position_id)
    {
        $this->load->model('Person_model');

        $data['job_position'] = $this->Job_position_model->get_by_id($job_position_id);
        $data['people'] = $this->Person_model->get_all();

        $this->load->view('layout', [
            'title' => 'Vincular Cargo',
            'view' => 'job_position/assign',
            'view_data' => $data
        ]);
    }

    public function assign_store()
    {
        $person_id = $this->input->post('person_id');
        $job_position_id = $this->input->post('job_position_id');
        $start_date = $this->input->post('start_date');

        $this->load->model('Job_history_model');

        $current = $this->Job_history_model->get_active_by_person($person_id);
        if ($current) {
            $this->Job_history_model->update($current->id, ['end_date' => $start_date]);
        }

        $this->Job_history_model->insert([
            'person_id' => $person_id,
            'job_position_id' => $job_position_id,
            'start_date' => $start_date
        ]);

        $this->load->model('Job_position_model');
        $job_position = $this->Job_position_model->get_by_id($job_position_id);

        $data['job_position'] = $job_position;
        $data['success'] = 'Funcionário vinculado ao cargo com sucesso!';

        $this->load->view('job_position/assign', $data);
    }

    public function create()
    {
        if ($_POST) {
            $name = $this->input->post('name');
            $this->Job_position_model->insert(['name' => $name]);
            redirect('job_position');
        }

        $data['title'] = 'Create Job Position';
        $data['view'] = 'job_position/create';
        $data['view_data'] = [];

        $this->load->view('layout', $data);
    }

    public function edit($id)
    {
        if ($_POST) {
            $name = $this->input->post('name');
            $this->Job_position_model->update($id, ['name' => $name]);

            $this->session->set_flashdata('success', 'Cargo atualizado com sucesso!');

            $view_data['job_position'] = $this->Job_position_model->get_by_id($id);
            $data['title'] = 'Edit Job Position';
            $data['view'] = 'job_position/edit';
            $data['view_data'] = $view_data;
            $this->load->view('layout', $data);

            return;
        }

        $view_data['job_position'] = $this->Job_position_model->get_by_id($id);
        $data['title'] = 'Edit Job Position';
        $data['view'] = 'job_position/edit';
        $data['view_data'] = $view_data;
        $this->load->view('layout', $data);
    }

    public function delete($id)
    {
        $this->Job_position_model->delete($id);
        redirect('job_position');
    }
}
