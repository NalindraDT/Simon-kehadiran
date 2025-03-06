<?php

namespace App\Models;
use CodeIgniter\Model;

class ModelMatkul extends Model
{
    protected $table = 'matkul';
    protected $primaryKey = 'kode_matkul';
    protected $useAutoIncrement = false;
    protected $allowedFields = ['kode_matkul', 'nama_matkul', 'sks'];

    // Validation rules
    protected $validationRules = [
        'kode_matkul' => 'required|is_unique[matkul.kode_matkul]',
        'nama_matkul' => 'required',
        'sks' => 'required',
    ];

    // Validation messages
    protected $validationMessages = [
        'kode_matkul' => [
            'required' => 'kode matkul harus diisi',
            'is_unique' => 'kode matkul sudah ada'
        ],
        'nama_matkul' => [
            'required' => 'Nama harus diisi'
        ],
        'sks' => [
            'required' => 'Silahkan masukkan jumlah sks',
        ]
    ];

}