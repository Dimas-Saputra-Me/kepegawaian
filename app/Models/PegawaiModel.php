<?php

namespace App\Models;

use CodeIgniter\Model;

class PegawaiModel extends Model
{
    protected $table            = 'pegawai';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'name', 
        'gender', 
        'departemenid', 
        'address', 
        'keahlian', 
        'active'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    // Soft delete: instead of deleting the record, set active = 0
    public function softDelete($id)
    {
        return $this->update($id, ['active' => 0]);
    }

    // Get all active pegawai
    public function getActivePegawai()
    {
        return $this->where('active', 1)->findAll();
    }

    // Get pegawai by ID
    public function getById($id)
    {
        return $this->where('id', $id)->first();
    }

    // Get pegawai along with department name
    public function getWithDepartemen()
    {
        return $this->select('pegawai.*, departemen.name as departemen_name')
                    ->join('departemen', 'departemen.id = pegawai.departemenid', 'left')
                    ->where('pegawai.active', 1)
                    ->findAll();
    }

    // Get pegawai along with skills name
    public function getWithKeahlian($id)
    {
        $pegawai = $this->find($id);
        if (!$pegawai) return null;

        // Ambil keahlian names
        $keahlianIds = explode(',', $pegawai['keahlian']);
        if (!empty($keahlianIds)) {
            $db = db_connect();
            $keahlianNames = $db->table('keahlian')
                                ->whereIn('id', $keahlianIds)
                                ->select('name')
                                ->get()
                                ->getResultArray();

            $pegawai['keahlianNames'] = array_column($keahlianNames, 'name');
        } else {
            $pegawai['keahlianNames'] = [];
        }

        return $pegawai;
    }
}
