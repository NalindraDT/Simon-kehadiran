<?php

namespace App\Models;
use CodeIgniter\Model;

class ModelKelas extends Model
{
    protected $table = 'kelas';
    protected $primaryKey = 'kode_kelas';
    protected $allowedFields = ['nama_kelas'];

    // Validation rules
    protected $validationRules = [
        'nama_kelas' => 'required'
    ];

    // Validation messages
    protected $validationMessages = [
        'nama_kelas' => [
            'required' => 'Nama harus diisi'
        ]
    ];
}
