<?php

namespace App\Models;
use CodeIgniter\Model;

class ModelMahasiswa extends Model
{
    protected $table = 'mahasiswa';
    protected $primaryKey = 'npm';
    protected $useAutoIncrement = false;
    protected $allowedFields = ['npm', 'nama_mahasiswa', 'email', 'id_user', 'kode_kelas'];

    // Validation rules
    protected $validationRules = [
        'npm' => 'required',
        'nama_mahasiswa' => 'required',
        'email' => 'required|valid_email',
        'id_user' => 'required|is_unique[mahasiswa.id_user]',
        'kode_kelas' => 'required',
    ];

    // Validation messages
    protected $validationMessages = [
        'npm' => [
            'required' => 'NPM harus diisi'
        ],
        'nama_mahasiswa' => [
            'required' => 'Nama harus diisi'
        ],
        'email' => [
            'required' => 'Silahkan masukkan email',
            'valid_email' => 'Email yang dimasukan tidak valid'
        ],
        'id_user' => [
            'required' => 'ID User harus diisi',
            'is_unique' => 'Id sudah ada'
        ],
        'kode_kelas' => [
            'required' => 'Kode kelas harus diisi'
        ]
    ];

    // Method untuk mengambil data mahasiswa dengan join tabel kelas
    public function getMahasiswaWithClass($npm = null)
    {
        $query = $this->select('mahasiswa.npm, mahasiswa.nama_mahasiswa, mahasiswa.email, mahasiswa.id_user, kelas.nama_kelas, user.username, user.password')
            ->join('kelas', 'kelas.kode_kelas = mahasiswa.kode_kelas', 'left')
            ->join('user', 'user.id_user = mahasiswa.id_user', 'left');

        if ($npm !== null) {
            $data = $query->where('mahasiswa.npm', $npm)->first();
            return $data ?: null;
        }

        return $query->orderBy('mahasiswa.npm', 'asc')->findAll();
    }
}