<?php

namespace App\Controllers;

use App\Models\BeneficiaryModel;
use App\Models\CaseNoteModel;
use App\Models\ReferralModel;

class Dashboard extends BaseController
{
    protected function ensureUser()
    {
        if (! session()->get('user_id')) {
            return redirect()->to('/');
        }

        return null;
    }

    public function index()
    {
        if ($redirect = $this->ensureUser()) {
            return $redirect;
        }

        $beneficiaryModel = new BeneficiaryModel();
        $caseNoteModel    = new CaseNoteModel();
        $referralModel    = new ReferralModel();
        $userId           = session()->get('user_id');

        $data = [
            'title'            => 'My Dashboard',
            'beneficiaryCount' => $beneficiaryModel->countAllResults(),
            'myNotes'          => $caseNoteModel->orderBy('created_at', 'DESC')->findAll(5),
            'myReferrals'      => $referralModel->orderBy('referral_date', 'DESC')->findAll(5),
        ];

        return view('dashboard/index', $data);
    }
}

