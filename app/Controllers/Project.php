<?php

namespace App\Controllers;

use App\Models\ProjectModel;

class Project extends BaseController
{
    public function index()
    {
        $projectModel = new ProjectModel();

        $data = [
            'title'    => 'Projects',
            'projects' => $projectModel->orderBy('start_date', 'DESC')->findAll(),
        ];

        return view('projects/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Create Project',
        ];

        return view('projects/create', $data);
    }

    public function store()
    {
        $projectModel = new ProjectModel();

        $data = $this->request->getPost([
            'code',
            'name',
            'description',
            'start_date',
            'end_date',
        ]);

        $projectModel->insert($data);

        return redirect()->to(site_url('projects'))->with('message', 'Project created.');
    }

    public function edit($id)
    {
        $project = (new ProjectModel())->find($id);
        if (! $project) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('projects/edit', [
            'title'   => 'Edit Project',
            'project' => $project,
        ]);
    }

    public function update($id)
    {
        $projectModel = new ProjectModel();

        $data = $this->request->getPost([
            'code',
            'name',
            'description',
            'start_date',
            'end_date',
        ]);

        $projectModel->update($id, $data);

        return redirect()->to(site_url('projects'))->with('message', 'Project updated.');
    }

    public function delete($id)
    {
        $projectModel = new ProjectModel();
        $projectModel->delete($id);

        return redirect()->to(site_url('projects'))->with('message', 'Project deleted.');
    }
}
