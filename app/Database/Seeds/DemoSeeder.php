<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run()
    {
        helper('text');

        // --- Users (login accounts) ---
        $this->db->table('users')->truncate();

        $adminPassword = password_hash('admin123', PASSWORD_DEFAULT);
        $userPassword  = password_hash('user123', PASSWORD_DEFAULT);

        $this->db->table('users')->insertBatch([
            [
                'name'          => 'Admin User',
                'email'         => 'admin@example.com',
                'password_hash' => $adminPassword,
                'role'          => 'admin',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'name'          => 'Field Officer',
                'email'         => 'field@example.com',
                'password_hash' => $userPassword,
                'role'          => 'user',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
        ]);

        // --- Projects ---
        $this->db->table('projects')->truncate();

        $this->db->table('projects')->insertBatch([
            [
                'code'        => 'PRJ-FOOD-001',
                'name'        => 'Emergency Food Assistance',
                'description' => 'Food baskets for vulnerable households.',
                'start_date'  => '2026-01-01',
                'end_date'    => '2026-12-31',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'code'        => 'PRJ-LIV-001',
                'name'        => 'Livelihoods & IGA Support',
                'description' => 'Small grants and trainings for micro businesses.',
                'start_date'  => '2026-02-01',
                'end_date'    => null,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
        ]);

        $projects = $this->db->table('projects')->get()->getResultArray();
        $projectMap = [];
        foreach ($projects as $p) {
            $projectMap[$p['code']] = $p['id'];
        }

        // --- Interventions (service catalog) ---
        $this->db->table('interventions')->truncate();
        $this->db->table('interventions')->insertBatch([
            [
                'project_id'  => $projectMap['PRJ-FOOD-001'] ?? null,
                'name'        => 'Monthly Food Basket',
                'service_type'=> 'Food aid',
                'description' => 'Standard family food kit.',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'project_id'  => $projectMap['PRJ-LIV-001'] ?? null,
                'name'        => 'IGA Startup Grant',
                'service_type'=> 'Income Generating Activities (IGA)',
                'description' => 'Small grant for micro-enterprise.',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'project_id'  => $projectMap['PRJ-LIV-001'] ?? null,
                'name'        => 'Business Skills Training',
                'service_type'=> 'Training',
                'description' => 'Basic business management training.',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
        ]);

        // --- Households ---
        $this->db->table('households')->truncate();

        $this->db->table('households')->insert([
            'household_code'       => 'HH-2026-000001',
            'address'              => 'Community A, District X',
            'family_size'          => 5,
            'vulnerability_status' => 'Female-headed, IDP',
            'income_level'         => 'Low income',
            'created_at'           => date('Y-m-d H:i:s'),
            'updated_at'           => date('Y-m-d H:i:s'),
        ]);
        $hh1 = $this->db->insertID();

        $this->db->table('households')->insert([
            'household_code'       => 'HH-2026-000002',
            'address'              => 'Community B, District Y',
            'family_size'          => 3,
            'vulnerability_status' => 'Disability',
            'income_level'         => 'Below poverty line',
            'created_at'           => date('Y-m-d H:i:s'),
            'updated_at'           => date('Y-m-d H:i:s'),
        ]);
        $hh2 = $this->db->insertID();

        // --- Beneficiaries ---
        $this->db->table('beneficiaries')->truncate();

        $this->db->table('beneficiaries')->insertBatch([
            [
                'beneficiary_uid'     => 'BEN-2026-000001',
                'household_id'        => $hh1,
                'full_name'           => 'Amina Yusuf',
                'age'                 => 32,
                'gender'              => 'Female',
                'address'             => 'Community A, District X',
                'identification_type' => 'National ID',
                'identification_number'=> 'ID-A-123456',
                'photo_path'          => null,
                'created_at'          => date('Y-m-d H:i:s'),
                'updated_at'          => date('Y-m-d H:i:s'),
            ],
            [
                'beneficiary_uid'     => 'BEN-2026-000002',
                'household_id'        => $hh1,
                'full_name'           => 'Khalid Yusuf',
                'age'                 => 10,
                'gender'              => 'Male',
                'address'             => 'Community A, District X',
                'identification_type' => 'Birth Certificate',
                'identification_number'=> 'BC-987654',
                'photo_path'          => null,
                'created_at'          => date('Y-m-d H:i:s'),
                'updated_at'          => date('Y-m-d H:i:s'),
            ],
            [
                'beneficiary_uid'     => 'BEN-2026-000003',
                'household_id'        => $hh2,
                'full_name'           => 'Joseph Kamau',
                'age'                 => 45,
                'gender'              => 'Male',
                'address'             => 'Community B, District Y',
                'identification_type' => 'National ID',
                'identification_number'=> 'ID-B-555222',
                'photo_path'          => null,
                'created_at'          => date('Y-m-d H:i:s'),
                'updated_at'          => date('Y-m-d H:i:s'),
            ],
        ]);

        $beneficiaries = $this->db->table('beneficiaries')->get()->getResultArray();
        $benMap = [];
        foreach ($beneficiaries as $b) {
            $benMap[$b['beneficiary_uid']] = $b['id'];
        }

        // --- Baselines ---
        $this->db->table('beneficiary_baselines')->truncate();
        $this->db->table('beneficiary_baselines')->insertBatch([
            [
                'beneficiary_id'   => $benMap['BEN-2026-000001'],
                'education_status' => 'Primary completed',
                'health_status'    => 'Chronic illness',
                'livelihood_status'=> 'Casual labour',
                'nutrition_status' => 'Borderline',
                'income_status'    => 'Below poverty line',
                'baseline_date'    => '2026-01-15',
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ],
            [
                'beneficiary_id'   => $benMap['BEN-2026-000003'],
                'education_status' => 'Secondary completed',
                'health_status'    => 'Disability',
                'livelihood_status'=> 'Informal trade',
                'nutrition_status' => 'Normal',
                'income_status'    => 'Low income',
                'baseline_date'    => '2026-01-20',
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ],
        ]);

        // --- Progress updates ---
        $this->db->table('beneficiary_progress_updates')->truncate();
        $this->db->table('beneficiary_progress_updates')->insertBatch([
            [
                'beneficiary_id' => $benMap['BEN-2026-000001'],
                'progress_date'  => '2026-03-01',
                'domain'         => 'livelihood',
                'status_summary' => 'Started small vegetable business.',
                'score'          => 3,
                'notes'          => 'Received IGA startup grant.',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'beneficiary_id' => $benMap['BEN-2026-000003'],
                'progress_date'  => '2026-03-05',
                'domain'         => 'health',
                'status_summary' => 'Referred for specialized checkup.',
                'score'          => 2,
                'notes'          => 'Follow-up required.',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
        ]);

        // --- Case notes ---
        $this->db->table('case_notes')->truncate();
        $this->db->table('case_notes')->insertBatch([
            [
                'beneficiary_id'      => $benMap['BEN-2026-000001'],
                'note_type'           => 'social_followup',
                'content'             => 'Home visit conducted; discussed business plan.',
                'created_by'          => 'Field Officer',
                'next_follow_up_date' => '2026-03-15',
                'status'              => 'open',
                'risk_level'          => 'medium',
                'created_at'          => date('Y-m-d H:i:s'),
                'updated_at'          => date('Y-m-d H:i:s'),
            ],
            [
                'beneficiary_id'      => $benMap['BEN-2026-000003'],
                'note_type'           => 'counseling',
                'content'             => 'Counseling session; signs of severe stress.',
                'created_by'          => 'Counselor',
                'next_follow_up_date' => '2026-03-10',
                'status'              => 'open',
                'risk_level'          => 'high',
                'created_at'          => date('Y-m-d H:i:s'),
                'updated_at'          => date('Y-m-d H:i:s'),
            ],
        ]);

        // --- Referrals ---
        $this->db->table('referrals')->truncate();
        $this->db->table('referrals')->insertBatch([
            [
                'beneficiary_id'      => $benMap['BEN-2026-000003'],
                'referral_type'       => 'health',
                'referred_to'         => 'District Hospital',
                'referral_date'       => '2026-03-02',
                'status'              => 'pending',
                'outcome'             => null,
                'high_risk'           => 1,
                'next_follow_up_date' => '2026-03-09',
                'created_by'          => 'Field Officer',
                'created_at'          => date('Y-m-d H:i:s'),
                'updated_at'          => date('Y-m-d H:i:s'),
            ],
            [
                'beneficiary_id'      => $benMap['BEN-2026-000001'],
                'referral_type'       => 'psychosocial',
                'referred_to'         => 'Community Support Group',
                'referral_date'       => '2026-02-20',
                'status'              => 'completed',
                'outcome'             => 'Attended two sessions.',
                'high_risk'           => 0,
                'next_follow_up_date' => null,
                'created_by'          => 'Counselor',
                'created_at'          => date('Y-m-d H:i:s'),
                'updated_at'          => date('Y-m-d H:i:s'),
            ],
        ]);

        // --- Events & attendance ---
        $this->db->table('events')->truncate();
        $this->db->table('beneficiary_attendance')->truncate();

        $this->db->table('events')->insert([
            'project_id'  => $projectMap['PRJ-LIV-001'] ?? null,
            'name'        => 'Business Skills Training - Cohort 1',
            'type'        => 'training',
            'event_date'  => '2026-03-01',
            'location'    => 'Training Center A',
            'description' => 'Introductory business skills session.',
            'created_at'  => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s'),
        ]);
        $event1 = $this->db->insertID();

        $this->db->table('beneficiary_attendance')->insertBatch([
            [
                'beneficiary_id' => $benMap['BEN-2026-000001'],
                'event_id'       => $event1,
                'status'         => 'attended',
                'notes'          => 'Participated actively.',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'beneficiary_id' => $benMap['BEN-2026-000003'],
                'event_id'       => $event1,
                'status'         => 'absent',
                'notes'          => 'Reported illness.',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
        ]);
    }
}
