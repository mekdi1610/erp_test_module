<?php

namespace App\Controllers;

use App\Models\BeneficiaryBaselineModel;
use App\Models\BeneficiaryModel;
use App\Models\HouseholdModel;

class Beneficiary extends BaseController
{
    public function index()
    {
        $beneficiaryModel = new BeneficiaryModel();
        $data = [
            'title'         => 'Beneficiaries',
            'beneficiaries' => $beneficiaryModel
                ->select('beneficiaries.*, households.household_code')
                ->join('households', 'households.id = beneficiaries.household_id', 'left')
                ->orderBy('beneficiaries.created_at', 'DESC')
                ->findAll(),
        ];

        return view('beneficiaries/index', $data);
    }

    public function create()
    {
        $householdModel = new HouseholdModel();

        $data = [
            'title'      => 'Register Beneficiary',
            'households' => $householdModel->orderBy('created_at', 'DESC')->findAll(),
            'validation' => service('validation'),
        ];

        return view('beneficiaries/create', $data);
    }

    public function store()
    {
        $beneficiaryModel = new BeneficiaryModel();
        $householdModel   = new HouseholdModel();
        $baselineModel    = new BeneficiaryBaselineModel();
        $validation       = service('validation');

        $rules = [
            'full_name'            => 'required|min_length[3]',
            'age'                  => 'permit_empty|integer',
            'gender'               => 'permit_empty|in_list[Male,Female,Other]',
            'household_family_size'=> 'permit_empty|integer',
            'photo'                => 'permit_empty|is_image[photo]|max_size[photo,2048]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $request = $this->request;
        helper('text');

        $householdId = null;
        $householdData = [
            'address'             => $request->getPost('household_address'),
            'family_size'         => $request->getPost('household_family_size'),
            'vulnerability_status'=> $request->getPost('household_vulnerability_status'),
            'income_level'        => $request->getPost('household_income_level'),
        ];

        if ($householdData['address'] || $householdData['family_size'] || $householdData['vulnerability_status'] || $householdData['income_level']) {
            do {
                $code = 'HH-' . date('Y') . '-' . random_string('numeric', 6);
            } while ($householdModel->where('household_code', $code)->countAllResults() > 0);

            $householdData['household_code'] = $code;
            $householdId = $householdModel->insert($householdData, true);
        }

        $photo     = $request->getFile('photo');
        $photoPath = null;

        if ($photo && $photo->isValid() && ! $photo->hasMoved()) {
            $uploadDir = FCPATH . 'uploads/beneficiaries';
            if (! is_dir($uploadDir)) {
                mkdir($uploadDir, 0775, true);
            }
            $newName = $photo->getRandomName();
            $photo->move($uploadDir, $newName);
            $photoPath = 'uploads/beneficiaries/' . $newName;
        }

        $beneficiaryId = $beneficiaryModel->insert([
            'household_id'          => $householdId,
            'full_name'             => $request->getPost('full_name'),
            'age'                   => $request->getPost('age') ?: null,
            'gender'                => $request->getPost('gender') ?: null,
            'address'               => $request->getPost('address'),
            'identification_type'   => $request->getPost('identification_type'),
            'identification_number' => $request->getPost('identification_number'),
            'photo_path'            => $photoPath,
        ]);

        $baselineModel->insert([
            'beneficiary_id'   => $beneficiaryId,
            'education_status' => $request->getPost('education_status'),
            'health_status'    => $request->getPost('health_status'),
            'livelihood_status'=> $request->getPost('livelihood_status'),
            'nutrition_status' => $request->getPost('nutrition_status'),
            'income_status'    => $request->getPost('income_status'),
            'baseline_date'    => $request->getPost('baseline_date') ?: date('Y-m-d'),
        ]);

        return redirect()->to(site_url('beneficiaries'))
            ->with('message', 'Beneficiary registered successfully.');
    }

    public function edit($id)
    {
        $beneficiaryModel = new BeneficiaryModel();
        $baselineModel    = new BeneficiaryBaselineModel();
        $householdModel   = new HouseholdModel();

        $beneficiary = $beneficiaryModel->find($id);
        if (! $beneficiary) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $baseline = $baselineModel->where('beneficiary_id', $id)->orderBy('id', 'DESC')->first();
        $household = $beneficiary['household_id']
            ? $householdModel->find($beneficiary['household_id'])
            : null;

        $data = [
            'title'       => 'Edit Beneficiary',
            'beneficiary' => $beneficiary,
            'baseline'    => $baseline,
            'household'   => $household,
        ];

        return view('beneficiaries/edit', $data);
    }

    public function update($id)
    {
        $beneficiaryModel = new BeneficiaryModel();
        $baselineModel    = new BeneficiaryBaselineModel();
        $householdModel   = new HouseholdModel();

        $beneficiary = $beneficiaryModel->find($id);
        if (! $beneficiary) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $request = $this->request;
        helper('text');

        $householdId = $beneficiary['household_id'];
        $householdData = [
            'address'              => $request->getPost('household_address'),
            'family_size'          => $request->getPost('household_family_size'),
            'vulnerability_status' => $request->getPost('household_vulnerability_status'),
            'income_level'         => $request->getPost('household_income_level'),
        ];

        if ($householdId) {
            $householdModel->update($householdId, $householdData);
        } elseif ($householdData['address'] || $householdData['family_size'] || $householdData['vulnerability_status'] || $householdData['income_level']) {
            do {
                $code = 'HH-' . date('Y') . '-' . random_string('numeric', 6);
            } while ($householdModel->where('household_code', $code)->countAllResults() > 0);

            $householdData['household_code'] = $code;
            $householdId = $householdModel->insert($householdData, true);
        }

        $photo     = $request->getFile('photo');
        $photoPath = $beneficiary['photo_path'];
        if ($photo && $photo->isValid() && ! $photo->hasMoved()) {
            $uploadDir = FCPATH . 'uploads/beneficiaries';
            if (! is_dir($uploadDir)) {
                mkdir($uploadDir, 0775, true);
            }
            $newName = $photo->getRandomName();
            $photo->move($uploadDir, $newName);
            $photoPath = 'uploads/beneficiaries/' . $newName;
        }

        $beneficiaryModel->update($id, [
            'household_id'          => $householdId,
            'full_name'             => $request->getPost('full_name'),
            'age'                   => $request->getPost('age') ?: null,
            'gender'                => $request->getPost('gender') ?: null,
            'address'               => $request->getPost('address'),
            'identification_type'   => $request->getPost('identification_type'),
            'identification_number' => $request->getPost('identification_number'),
            'photo_path'            => $photoPath,
        ]);

        $baseline = $baselineModel->where('beneficiary_id', $id)->orderBy('id', 'DESC')->first();
        $baselineData = [
            'education_status' => $request->getPost('education_status'),
            'health_status'    => $request->getPost('health_status'),
            'livelihood_status'=> $request->getPost('livelihood_status'),
            'nutrition_status' => $request->getPost('nutrition_status'),
            'income_status'    => $request->getPost('income_status'),
            'baseline_date'    => $request->getPost('baseline_date') ?: date('Y-m-d'),
        ];

        if ($baseline) {
            $baselineModel->update($baseline['id'], $baselineData);
        } else {
            $baselineData['beneficiary_id'] = $id;
            $baselineModel->insert($baselineData);
        }

        return redirect()->to(site_url('beneficiaries'))->with('message', 'Beneficiary updated.');
    }

    public function delete($id)
    {
        $beneficiaryModel = new BeneficiaryModel();
        $beneficiaryModel->delete($id);

        return redirect()->to(site_url('beneficiaries'))->with('message', 'Beneficiary deleted.');
    }
}
