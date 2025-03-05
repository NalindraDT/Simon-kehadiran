<?php

namespace App\Models;
use CodeIgniter\Model;

class ModelUser extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id_user';
    protected $allowedFields = ['username','password','level'];
    
    protected $useAutoIncrement = true;

    // Validation rules
    protected $validationRules = [
        'username' => 'required',
        'password' => 'required',
        'level' => 'required',
    ];

    // Validation messages
    protected $validationMessages = [
        'username' => [
            'required' => 'Kode kelas harus diisi',
            'is_unique' => 'username sudah ada dalam database'
        ],
        'password' => [
            'required' => 'Nama kelas harus diisi'
        ],
        'level' => [
            'required' => 'Nama kelas harus diisi'
            ]
    ];
}