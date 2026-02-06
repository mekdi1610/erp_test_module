<?php

namespace App\Controllers;

use App\Models\BeneficiaryModel;
use App\Models\CaseNoteModel;
use App\Models\ReferralModel;

class Alerts extends BaseController
{
    public function index()
    {
        $caseNoteModel   = new CaseNoteModel();
        $referralModel   = new ReferralModel();
        $beneficiaryModel = new BeneficiaryModel();

        $today = date('Y-m-d');

        $overdueNotes = $caseNoteModel
            ->where('status', 'open')
            ->where('next_follow_up_date <', $today)
            ->findAll();

        $overdueReferrals = $referralModel
            ->where('status', 'pending')
            ->where('next_follow_up_date <', $today)
            ->findAll();

        $highRiskNotes = $caseNoteModel
            ->where('risk_level', 'high')
            ->findAll();

        $highRiskReferrals = $referralModel
            ->where('high_risk', 1)
            ->findAll();

        $beneficiaries = $beneficiaryModel
            ->select('id, full_name, beneficiary_uid')
            ->findAll();
        $beneficiariesById = [];
        foreach ($beneficiaries as $b) {
            $beneficiariesById[$b['id']] = $b;
        }

        $data = [
            'title'             => 'Alerts & High-Risk Cases',
            'overdueNotes'      => $overdueNotes,
            'overdueReferrals'  => $overdueReferrals,
            'highRiskNotes'     => $highRiskNotes,
            'highRiskReferrals' => $highRiskReferrals,
            'beneficiariesById' => $beneficiariesById,
        ];

        return view('alerts/index', $data);
    }
}
