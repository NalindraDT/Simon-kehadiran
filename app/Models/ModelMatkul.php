<?php

namespace App\Models;
use CodeIgniter\Model;

class ModelMatkul extends Model
{
    protected $table = 'matkul';
    protected $primaryKey = 'kode_matkul';
    protected $useAutoIncrement = false;
    protected $allowedFields = ['kode_matkul', 'nama_matkul', 'npm', 'nidn', 'kode_kelas'];

    // Validation rules
    protected $validationRules = [
        'kode_matkul' => 'required',
        'nama_matkul' => 'required',
        'npm' => 'required|is_unique[matkul.nidn]',
        'nidn' => 'required|is_unique[matkul.id_user]',
        'kode_kelas' => 'required',
    ];

    // Validation messages
    protected $validationMessages = [
        'kode_matkul' => [
            'required' => 'kode matkul harus diisi'
        ],
        'nama_matkul' => [
            'required' => 'Nama harus diisi'
        ],
        'npm' => [
            'required' => 'Silahkan masukkan npm',
            'is_unique' => 'npm sudah ada'
        ],
        'nidn ' => [
            'required' => 'ID User harus diisi',
            'is_unique' => 'nidn sudah ada'
        ],
        'kode_kelas' => [
            'required' => 'Kode kelas harus diisi'
        ]
    ];

}