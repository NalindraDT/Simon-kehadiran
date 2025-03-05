<?php

namespace App\Models;
use CodeIgniter\Model;

class ModelKelas extends Model
{
    protected $table = 'kelas';
    protected $primaryKey = 'kode_kelas';
    protected $allowedFields = ['kode_kelas','nama_kelas'];
    
    // Set useAutoIncrement ke false karena kode_kelas adalah string/manual
    protected $useAutoIncrement = false;

    // Validation rules
    protected $validationRules = [
        'kode_kelas' => 'required|is_unique[kelas.kode_kelas]',
        'nama_kelas' => 'required'
    ];

    // Validation messages
    protected $validationMessages = [
        'kode_kelas' => [
            'required' => 'Kode kelas harus diisi',
            'is_unique' => 'Kode kelas sudah ada dalam database'
        ],
        'nama_kelas' => [
            'required' => 'Nama kelas harus diisi'
        ]
    ];
}