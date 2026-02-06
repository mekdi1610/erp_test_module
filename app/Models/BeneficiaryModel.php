<?php

namespace App\Models;

use CodeIgniter\Model;

class BeneficiaryModel extends Model
{
    protected $table            = 'beneficiaries';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'beneficiary_uid',
        'household_id',
        'full_name',
        'age',
        'gender',
        'address',
        'identification_type',
        'identification_number',
        'photo_path',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    protected $allowCallbacks = true;
    protected $beforeInsert   = ['generateBeneficiaryUid'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Automatically generate a unique Beneficiary ID if not provided.
     */
    protected function generateBeneficiaryUid(array $data): array
    {
        if (! isset($data['data']['beneficiary_uid']) || empty($data['data']['beneficiary_uid'])) {
            $data['data']['beneficiary_uid'] = $this->buildUniqueUid();
        }

        return $data;
    }

    protected function buildUniqueUid(): string
    {
        helper('text');

        do {
            $uid = 'BEN-' . date('Y') . '-' . random_string('numeric', 6);
        } while ($this->where('beneficiary_uid', $uid)->countAllResults() > 0);

        return $uid;
    }
}
