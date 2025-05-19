<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\ModelKehadiran;
use App\Models\ModelKehadiran1;
use CodeIgniter\HTTP\ResponseInterface;

class Kehadiran1 extends BaseController
{
    use ResponseTrait;

    protected $modelKehadiran;
    protected $modelKehadiran1;

    public function __construct()
    {
        $this->modelKehadiran = new ModelKehadiran();  // Untuk insert, update, delete
        $this->modelKehadiran1 = new ModelKehadiran1(); // Untuk get (menggunakan VIEW)
    }

    // 🔹 GET: Menampilkan semua data kehadiran (menggunakan VIEW)
    public function index(): ResponseInterface
    {
        $data = $this->modelKehadiran1->findAll(); // Menggunakan VIEW

        return $this->respond($data, 200);
    }

    // 🔹 GET: Menampilkan detail mahasiswa berdasarkan ID Kehadiran
    public function show($id_kehadiran = null)
    {
        $data = $this->modelKehadiran1->where('id_kehadiran', $id_kehadiran)->first();
    
        if ($data) {
            return $this->respond($data, 200);
        } else {
            return $this->failNotFound("Data tidak ditemukan untuk ID Kehadiran $id_kehadiran");
        }
    }
    

    // 🔹 POST: Menambahkan data kehadiran baru (menggunakan tabel asli)
    public function create()
    {
        $data = $this->request->getPost();

        // Validasi manual
        $requiredFields = ['tanggal', 'pertemuan', 'status', 'npm', 'nidn', 'kode_matkul', 'kode_kelas'];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                return $this->fail("Field $field harus diisi");
            }
        }

        // Simpan data
        if (!$this->modelKehadiran->insert($data)) {
            return $this->fail($this->modelKehadiran->errors());
        }

        return $this->respondCreated([
            'status' => 201,
            'error' => null,
            'messages' => [
                'success' => 'Data kehadiran berhasil ditambahkan'
            ]
        ]);
    }

    // 🔹 PUT: Mengupdate data kehadiran berdasarkan ID Kehadiran
    public function update($id_kehadiran = null)
{
    $data = $this->request->getJSON(true) ?? $this->request->getRawInput() ?? $this->request->getVar();

    // Pastikan data dengan ID tersebut ada
    if (!$this->modelKehadiran->find($id_kehadiran)) {
        return $this->failNotFound("Data tidak ditemukan untuk ID Kehadiran $id_kehadiran");
    }

    // Update data
    if (!$this->modelKehadiran->update($id_kehadiran, $data)) {
        return $this->fail($this->modelKehadiran->errors());
    }

    return $this->respond([
        'status' => 200,
        'error' => null,
        'messages' => [
            'success' => 'Data kehadiran berhasil diperbarui'
        ]
    ]);
}


    // 🔹 DELETE: Menghapus data kehadiran berdasarkan ID Kehadiran
    public function delete($id_kehadiran = null)
    {
        if (!$this->modelKehadiran->find($id_kehadiran)) {
            return $this->failNotFound("Data tidak ditemukan untuk ID Kehadiran $id_kehadiran");
        }
    
        $this->modelKehadiran->delete($id_kehadiran);
    
        return $this->respondDeleted([
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => "Data kehadiran dengan ID $id_kehadiran berhasil dihapus"
            ]
        ]);
    }
    
}
