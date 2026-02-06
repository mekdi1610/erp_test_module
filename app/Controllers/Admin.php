<?php

namespace App\Controllers;

use App\Models\BeneficiaryModel;
use App\Models\CaseNoteModel;
use App\Models\ReferralModel;

class Admin extends BaseController
{
    protected function ensureAdmin()
    {
        if (! session()->get('user_id') || session()->get('role') !== 'admin') {
            return redirect()->to('/');
        }

        return null;
    }

    public function dashboard()
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }

        $beneficiaryModel = new BeneficiaryModel();
        $caseNoteModel    = new CaseNoteModel();
        $referralModel    = new ReferralModel();

        $highRiskCount = $caseNoteModel->where('risk_level', 'high')->countAllResults()
            + $referralModel->where('high_risk', 1)->countAllResults();

        $data = [
            'title'           => 'Admin Dashboard',
            'beneficiaryCount'=> $beneficiaryModel->countAllResults(),
            'highRiskCount'   => $highRiskCount,
        ];

        return view('admin/dashboard', $data);
    }
}

