<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property Job_history_model $Job_history_model
 * @property Person_model $Person_model
 * @property Job_position_model $Job_position_model
 * @property CI_Input $input
 * @property CI_Loader $load
 * @property CI_URI $uri
 * @property CI_DB_mysqli_driver $db
 * @property CI_Pagination $pagination
 * @property CI_Session $session
 */

class Person extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Person_model');
        $this->load->model('Job_position_model');
        $this->load->model('Job_history_model');
        $this->load->library('session');
    }

    public function index($page = 0)
    {
        $limit = 10;
        $search = $this->input->get('search');
        $this->load->library('pagination');

        if ($search) {
            $this->db->like('name', $search);
            $this->db->from('people');
            $total_rows = $this->db->count_all_results();

            $config['base_url'] = site_url('person/index');
            $config['total_rows'] = $total_rows;
            $config['per_page'] = $limit;
            $config['reuse_query_string'] = true;
            $this->pagination->initialize($config);

            $view_data['people'] = $this->Person_model->search_with_last_job($limit, $page, $search);
        } else {
            $config['base_url'] = site_url('person/index');
            $config['total_rows'] = $this->db->count_all('people');
            $config['per_page'] = $limit;
            $this->pagination->initialize($config);

            $view_data['people'] = $this->Person_model->get_all_with_last_job($limit, $page);
        }

        $view_data['search'] = $search;

        $data['title'] = 'People';
        $data['view'] = 'person/index';
        $data['view_data'] = $view_data;

        $this->load->view('layout', $data);
    }

    public function create()
    {
        $view_data['job_positions'] = $this->Job_position_model->get_all();

        $data['title'] = 'Create Person';
        $data['view'] = 'person/create';
        $data['view_data'] = $view_data;

        $this->load->view('layout', $data);
    }

    public function store()
    {
        $name = $this->input->post('name');
        $job_position_id = $this->input->post('job_position_id');
        $start_date = $this->input->post('start_date');

        $this->db->trans_start();

        $this->Person_model->insert(['name' => $name]);

        $person_id = $this->db->insert_id();

        $this->Job_history_model->insert([
            'person_id' => $person_id,
            'job_position_id' => $job_position_id,
            'start_date' => $start_date
        ]);

        $this->db->trans_complete();

        redirect('person');
    }

    public function edit($id)
    {
        $view_data['person'] = $this->Person_model->get_by_id($id);
        $view_data['job_positions'] = $this->Job_position_model->get_all();

        $data['title'] = 'Edit Person';
        $data['view'] = 'person/edit';
        $data['view_data'] = $view_data;

        $this->load->view('layout', $data);
    }

    public function update($id)
    {
        $this->Person_model->update($id, [
            'name' => $this->input->post('name')
        ]);

        $this->session->set_flashdata('success', 'Nome atualizado com sucesso!');
        redirect('person/edit/' . $id);
    }

    public function assign_job($person_id)
    {
        $new_position_id = $this->input->post('job_position_id');
        $start_date = $this->input->post('start_date');
        $histories = $this->Job_history_model->get_by_person($person_id);

        foreach ($histories as $history) {
            $history_start = $history->start_date;
            $history_end = $history->end_date ?? date('Y-m-d');

            if ($start_date >= $history_start && $start_date <= $history_end) {
                $this->session->set_flashdata('conflict', 'Já existe um cargo registrado neste intervalo de data.');
                redirect('person/edit/' . $person_id);
                return;
            }
        }

        $this->db->trans_start();

        $current_job = $this->Job_history_model->get_active_by_person($person_id);
        if ($current_job) {
            $this->Job_history_model->update($current_job->id, [
                'end_date' => $start_date
            ]);
        }

        $this->Job_history_model->insert([
            'person_id' => $person_id,
            'job_position_id' => $new_position_id,
            'start_date' => $start_date
        ]);

        $this->db->trans_complete();

        $this->session->set_flashdata('success', 'Cargo adicionado com sucesso!');
        redirect('person/edit/' . $person_id);
    }

    public function dismiss($person_id)
    {
        $dismiss_date = $this->input->post('dismiss_date');
        $dismissed_position = $this->Job_position_model->get_by_name('Desligado');

        if (!$dismissed_position) {
            show_error('Cargo "Desligado" não encontrado. Cadastre esse cargo primeiro.');
            return;
        }

        $this->db->trans_start();
        $current_job = $this->Job_history_model->get_active_by_person($person_id);
        if ($current_job) {
            $this->Job_history_model->update($current_job->id, [
                'end_date' => $dismiss_date
            ]);
        }

        $this->Job_history_model->insert([
            'person_id' => $person_id,
            'job_position_id' => $dismissed_position->id,
            'start_date' => $dismiss_date
        ]);

        $this->db->trans_complete();
        $this->session->set_flashdata('success', 'Desligado com sucesso!');
        redirect('person/edit/' . $person_id);
    }

    public function search_ajax()
    {
        $term = $this->input->get('term');
        $results = [];

        if (strlen($term) >= 2) {
            $people = $this->Person_model->search_by_name($term);

            foreach ($people as $person) {
                $results[] = [
                    'id' => $person->id,
                    'text' => $person->name
                ];
            }
        }
        echo json_encode($results);
    }

    public function delete($id)
    {
        $this->Person_model->delete($id);
        redirect('person');
    }
}
