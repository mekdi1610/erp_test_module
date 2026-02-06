<?php

namespace App\Controllers;

use App\Models\BeneficiaryInterventionModel;
use App\Models\BeneficiaryModel;
use App\Models\BeneficiaryProgressUpdateModel;
use App\Models\CaseNoteModel;
use App\Models\InterventionModel;
use App\Models\ProjectModel;
use App\Models\ReferralModel;

class CaseManagement extends BaseController
{
    public function show($beneficiaryId)
    {
        $beneficiaryModel   = new BeneficiaryModel();
        $progressModel      = new BeneficiaryProgressUpdateModel();
        $caseNoteModel      = new CaseNoteModel();
        $referralModel      = new ReferralModel();
        $enrollmentModel    = new BeneficiaryInterventionModel();
        $projectModel       = new ProjectModel();
        $interventionModel  = new InterventionModel();

        $beneficiary = $beneficiaryModel->find($beneficiaryId);

        $enrollments = $enrollmentModel
            ->select('beneficiary_interventions.*, projects.code as project_code, projects.name as project_name, interventions.name as intervention_name')
            ->join('projects', 'projects.id = beneficiary_interventions.project_id', 'left')
            ->join('interventions', 'interventions.id = beneficiary_interventions.intervention_id', 'left')
            ->where('beneficiary_interventions.beneficiary_id', $beneficiaryId)
            ->orderBy('service_date', 'DESC')
            ->findAll();

        $data = [
            'title'        => 'Case Management',
            'beneficiary'  => $beneficiary,
            'progress'     => $progressModel
                ->where('beneficiary_id', $beneficiaryId)
                ->orderBy('progress_date', 'DESC')
                ->findAll(),
            'caseNotes'    => $caseNoteModel
                ->where('beneficiary_id', $beneficiaryId)
                ->orderBy('created_at', 'DESC')
                ->findAll(),
            'referrals'    => $referralModel
                ->where('beneficiary_id', $beneficiaryId)
                ->orderBy('referral_date', 'DESC')
                ->findAll(),
            'enrollments'  => $enrollments,
            'projects'     => $projectModel->orderBy('code', 'ASC')->findAll(),
            'interventions'=> $interventionModel->orderBy('name', 'ASC')->findAll(),
        ];

        return view('case_management/show', $data);
    }

    public function storeProgress($beneficiaryId)
    {
        $model = new BeneficiaryProgressUpdateModel();

        $model->insert([
            'beneficiary_id' => $beneficiaryId,
            'progress_date'  => $this->request->getPost('progress_date') ?: date('Y-m-d'),
            'domain'         => $this->request->getPost('domain'),
            'status_summary' => $this->request->getPost('status_summary'),
            'score'          => $this->request->getPost('score') ?: null,
            'notes'          => $this->request->getPost('notes'),
        ]);

        return redirect()->to(site_url("case-management/{$beneficiaryId}"))->with('message', 'Progress update added.');
    }

    public function storeCaseNote($beneficiaryId)
    {
        $model = new CaseNoteModel();

        $model->insert([
            'beneficiary_id'      => $beneficiaryId,
            'note_type'           => $this->request->getPost('note_type'),
            'content'             => $this->request->getPost('content'),
            'created_by'          => $this->request->getPost('created_by'),
            'next_follow_up_date' => $this->request->getPost('next_follow_up_date') ?: null,
            'status'              => $this->request->getPost('status') ?: 'open',
            'risk_level'          => $this->request->getPost('risk_level') ?: null,
        ]);

        return redirect()->to(site_url("case-management/{$beneficiaryId}"))->with('message', 'Case note added.');
    }

    public function storeReferral($beneficiaryId)
    {
        $model = new ReferralModel();

        $model->insert([
            'beneficiary_id'      => $beneficiaryId,
            'referral_type'       => $this->request->getPost('referral_type'),
            'referred_to'         => $this->request->getPost('referred_to'),
            'referral_date'       => $this->request->getPost('referral_date') ?: date('Y-m-d'),
            'status'              => $this->request->getPost('status') ?: 'pending',
            'outcome'             => $this->request->getPost('outcome'),
            'high_risk'           => $this->request->getPost('high_risk') ? 1 : 0,
            'next_follow_up_date' => $this->request->getPost('next_follow_up_date') ?: null,
            'created_by'          => $this->request->getPost('created_by'),
        ]);

        return redirect()->to(site_url("case-management/{$beneficiaryId}"))->with('message', 'Referral added.');
    }

    public function deleteProgress($id)
    {
        $model = new BeneficiaryProgressUpdateModel();
        $row   = $model->find($id);
        if ($row) {
            $beneficiaryId = $row['beneficiary_id'];
            $model->delete($id);
            return redirect()->to(site_url("case-management/{$beneficiaryId}"))->with('message', 'Progress entry deleted.');
        }
        return redirect()->back();
    }

    public function deleteCaseNote($id)
    {
        $model = new CaseNoteModel();
        $row   = $model->find($id);
        if ($row) {
            $beneficiaryId = $row['beneficiary_id'];
            $model->delete($id);
            return redirect()->to(site_url("case-management/{$beneficiaryId}"))->with('message', 'Case note deleted.');
        }
        return redirect()->back();
    }

    public function deleteReferral($id)
    {
        $model = new ReferralModel();
        $row   = $model->find($id);
        if ($row) {
            $beneficiaryId = $row['beneficiary_id'];
            $model->delete($id);
            return redirect()->to(site_url("case-management/{$beneficiaryId}"))->with('message', 'Referral deleted.');
        }
        return redirect()->back();
    }

    public function storeEnrollment($beneficiaryId)
    {
        $model = new BeneficiaryInterventionModel();

        $model->insert([
            'beneficiary_id' => $beneficiaryId,
            'project_id'     => $this->request->getPost('project_id') ?: null,
            'intervention_id'=> $this->request->getPost('intervention_id') ?: null,
            'service_type'   => $this->request->getPost('service_type'),
            'service_date'   => $this->request->getPost('service_date') ?: date('Y-m-d'),
            'notes'          => $this->request->getPost('notes'),
        ]);

        return redirect()->to(site_url("case-management/{$beneficiaryId}"))->with('message', 'Service enrollment recorded.');
    }

    public function deleteEnrollment($id)
    {
        $model = new BeneficiaryInterventionModel();
        $row   = $model->find($id);
        if ($row) {
            $beneficiaryId = $row['beneficiary_id'];
            $model->delete($id);
            return redirect()->to(site_url("case-management/{$beneficiaryId}"))->with('message', 'Enrollment removed.');
        }
        return redirect()->back();
    }
}
