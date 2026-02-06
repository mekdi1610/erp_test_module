<?php

namespace App\Controllers;

use App\Models\InterventionModel;
use App\Models\ProjectModel;

class Intervention extends BaseController
{
    public function index()
    {
        $interventionModel = new InterventionModel();

        $data = [
            'title'         => 'Interventions',
            'interventions' => $interventionModel
                ->select('interventions.*, projects.code as project_code')
                ->join('projects', 'projects.id = interventions.project_id', 'left')
                ->orderBy('interventions.created_at', 'DESC')
                ->findAll(),
        ];

        return view('interventions/index', $data);
    }

    public function create()
    {
        $projectModel = new ProjectModel();

        $data = [
            'title'    => 'Create Intervention',
            'projects' => $projectModel->orderBy('code', 'ASC')->findAll(),
        ];

        return view('interventions/create', $data);
    }

    public function store()
    {
        $interventionModel = new InterventionModel();

        $interventionModel->insert([
            'project_id'   => $this->request->getPost('project_id') ?: null,
            'name'         => $this->request->getPost('name'),
            'service_type' => $this->request->getPost('service_type'),
            'description'  => $this->request->getPost('description'),
        ]);

        return redirect()->to(site_url('interventions'))->with('message', 'Intervention created.');
    }

    public function edit($id)
    {
        $interventionModel = new InterventionModel();
        $projectModel      = new ProjectModel();

        $intervention = $interventionModel->find($id);
        if (! $intervention) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title'        => 'Edit Intervention',
            'intervention' => $intervention,
            'projects'     => $projectModel->orderBy('code', 'ASC')->findAll(),
        ];

        return view('interventions/edit', $data);
    }

    public function update($id)
    {
        $interventionModel = new InterventionModel();

        $interventionModel->update($id, [
            'project_id'   => $this->request->getPost('project_id') ?: null,
            'name'         => $this->request->getPost('name'),
            'service_type' => $this->request->getPost('service_type'),
            'description'  => $this->request->getPost('description'),
        ]);

        return redirect()->to(site_url('interventions'))->with('message', 'Intervention updated.');
    }

    public function delete($id)
    {
        $interventionModel = new InterventionModel();
        $interventionModel->delete($id);

        return redirect()->to(site_url('interventions'))->with('message', 'Intervention deleted.');
    }
}
