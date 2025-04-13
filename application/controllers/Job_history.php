<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property Job_history_model $Job_history_model
 * @property Person_model $Person_model
 * @property Job_position_model $Job_position_model
 * @property CI_Input $input
 * @property CI_Loader $load
 * @property CI_URI $uri
 */

class Job_history extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Job_history_model');
        $this->load->model('Person_model');
        $this->load->model('Job_position_model');
        $this->load->helper('url');
    }

    public function index($person_id)
    {
        $view_data['person'] = $this->Person_model->get_by_id($person_id);
        $view_data['job_history'] = $this->Job_history_model->get_by_person($person_id);

        $data['title'] = 'Job History of ' . $view_data['person']->name;
        $data['view'] = 'job_history/index';
        $data['view_data'] = $view_data;

        $this->load->view('layout', $data);
    }

    public function edit($id)
    {
        $job_history = $this->Job_history_model->get_by_id($id);
        $person = $this->Person_model->get_by_id($job_history->person_id);

        $view_data = [
            'history' => $job_history,
            'person' => $person,
            'job_positions' => $this->Job_position_model->get_all()
        ];

        $data = [
            'title' => 'Editar histórico do funcionário',
            'view' => 'job_history/edit',
            'view_data' => $view_data
        ];

        $this->load->view('layout', $data);
    }

    public function update($id)
    {
        $data = [
            'job_position_id' => $this->input->post('job_position_id'),
            'start_date' => $this->input->post('start_date'),
            'end_date' => $this->input->post('end_date')
        ];

        $this->Job_history_model->update($id, $data);
        $this->load->view('layout', $data);

        $updated_history = $this->Job_history_model->get_by_id($id);
        $person = $this->Person_model->get_by_id($updated_history->person_id);
        $job_positions = $this->Job_position_model->get_all();

        $view_data = [
            'history' => $updated_history,
            'person' => $person,
            'job_positions' => $job_positions,
            'success' => 'Histórico atualizado com sucesso!'
        ];

        $this->load->view('job_history/edit', $view_data);
    }

    public function delete($id)
    {
        $job = $this->Job_history_model->get_by_id($id);

        if (!$job) {
            show_404();
        }

        $this->Job_history_model->delete($id);
        redirect('job_history/index/' . $job->person_id);
    }
}
