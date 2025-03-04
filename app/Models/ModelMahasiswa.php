<?php

namespace App\Models;
use CodeIgniter\Model;

class ModelMahasiswa extends Model
{
    protected $table = 'mahasiswa';
    protected $primaryKey = 'npm';
    protected $allowedFields = ['nama_mahasiswa', 'email', 'id_user', 'kode_kelas'];

    // Validation rules
    protected $validationRules = [
        'nama_mahasiswa' => 'required',
        'email' => 'required|valid_email',
        'id_user' => 'required',
        'kode_kelas' => 'required',
    ];

    // Validation messages
    protected $validationMessages = [
        'nama_mahasiswa' => [
            'required' => 'Nama harus diisi'
        ],
        'email' => [
            'required' => 'Silahkan masukkan email',
            'valid_email' => 'Email yang dimasukkan tidak valid'
        ],
    ];

    // Method untuk mengambil data mahasiswa dengan join tabel kelas
    public function getMahasiswaWithClass($npm = null)
    {
        $query = $this->select('mahasiswa.npm, mahasiswa.nama_mahasiswa, mahasiswa.email, mahasiswa.id_user, kelas.nama_kelas')
                      ->join('kelas', 'kelas.kode_kelas = mahasiswa.kode_kelas', 'left');

        if ($npm !== null) {
            $data = $query->where('mahasiswa.npm', $npm)->first();
            return $data ?: null; // Return null jika tidak ditemukan
        }

        return $query->orderBy('mahasiswa.nama_mahasiswa', 'asc')->findAll();
    }
}
