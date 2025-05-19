<?php

namespace App\Models;
use CodeIgniter\Model;

class ModelDosen extends Model
{
    protected $table = 'dosen';
    protected $primaryKey = 'nidn';
    protected $allowedFields = ['nidn','nama_dosen','id_user'];
    
    // Set useAutoIncrement ke false karena kode_kelas adalah string/manual
    protected $useAutoIncrement = false;

    // Validation rules
    protected $validationRules = [
        'nidn' => 'required',
        'nama_dosen' => 'required',
        'id_user' => 'required',

    ];

    // Validation messages
    protected $validationMessages = [
        'nidn' => [
            'required' => 'nidn harus di isi',
            'is_unique' => 'NIDN sudah ada'
        ],
        'nama_dosen' => [
            'required' => 'Nama kelas harus diisi'
        ],
        'id_user' => [
            'required' => 'id user harus di isi',
            'is_unique' => 'id user sudah ada'
        ]
    ];

    public function getDosen($nidn = null)
    {
        $query = $this->select('dosen.nidn, dosen.nama_dosen, user.username')
            ->join('user', 'user.id_user = dosen.id_user', 'left');

        if ($nidn !== null) {
            $data = $query->where('dosen.nidn', $nidn)->first();
            return $data ?: null;
        }

        return $query->orderBy('dosen.nidn', 'asc')->findAll();
    }
}