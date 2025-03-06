<?php

namespace App\Models;
use CodeIgniter\Model;

class ModelKehadiran extends Model
{
    protected $table = 'kehadiran';
    protected $primaryKey = 'id_kehadiran';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['tanggal', 'pertemuan', 'status','npm','nidn','kode_matkul', 'kode_kelas'];

    // Validation rules
    protected $validationRules = [
        'tanggal' => 'required',
        'pertemuan' => 'required',
        'status' => 'required',
        'npm' => 'required|is_unique[kehadiran.npm,id_kehadiran,{id_kehadiran}]',
        'nidn' => 'required',
        'kode_matkul' => 'required',
        'kode_kelas' => 'required'
    ];
    
    // Validation messages
    protected $validationMessages = [
        'tanggal' => [
            'required' => 'Tanggal harus diisi'
        ],
        'pertemuan' => [
            'required' => 'Pertemuan harus diisi'
        ],
        'status' => [
            'required' => 'Status harus diisi'
        ],
        'npm' => [
            'required' => 'NPM harus diisi',
            'is_unique' => 'NPM sudah terdaftar'
        ],
        'nidn' => [
            'required' => 'NIDN harus diisi',
            'is_unique' => 'NIDN sudah terdaftar'
        ],
        'kode_matkul' => [
            'required' => 'Kode mata kuliah harus diisi',
            'is_unique' => 'Kode mata kuliah sudah terdaftar'
        ],
        'kode_kelas' => [
            'required' => 'Kode kelas harus diisi',
            'is_unique' => 'Kode kelas sudah terdaftar'
        ]
    ];
}

    // Method untuk mengambil data mahasiswa dengan join tabel kelas