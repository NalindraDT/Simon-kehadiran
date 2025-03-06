<?php

namespace App\Models;
use CodeIgniter\Model;

class ModelKehadiran extends Model
{
    protected $table = 'kehadiran';
    protected $primaryKey = 'npm';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['id_kehadiran', 'tanggal', 'pertemuan', 'status','npm','kode_matkul', 'kode_kelas'];

    // Validation rules
    protected $validationRules = [
        'tanggal' => 'required',
        'pertemuan' => 'required',
        'status' => 'required',
        'npm' => 'required|is_unique[kehadiran.npm]',
        'kode_matkul' => 'required|is_unique[kode_matkul]',
        'kode_kelas' => 'required|is_unique[kehadiran.kode_kelas]',
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
        'kode_matkul' => [
            'required' => 'Kode mata kuliah harus diisi',
            'is_unique' => 'Kode mata kuliah sudah terdaftar'
        ],
        'kode_kelas' => [
            'required' => 'Kode kelas harus diisi',
            'is_unique' => 'Kode kelas sudah terdaftar'
        ]
    ];

    // Method untuk mengambil data mahasiswa dengan join tabel kelas
    public function getKehadiran($npm = null)
{
    $query = $this->db->table('kehadiran kh')
        ->select(
            "ROW_NUMBER() OVER (ORDER BY m.npm) AS No, 
            m.npm, m.nama_mahasiswa, kh.tanggal, kh.pertemuan, kh.status, 
            mk.nama_matkul, d.nama_dosen"
        )
        ->join('mahasiswa m', 'kh.npm = m.npm')
        ->join('matkul mk', 'kh.kode_matkul = mk.kode_matkul')
        ->join('dosen d', 'mk.nidn = d.nidn');

    if ($npm !== null) {
        $query->where('m.npm', $npm);
        return $query->get()->getRowArray() ?: null;
    }

    return $query->orderBy('kh.id_kehadiran', 'asc')->get()->getResultArray();
}

}