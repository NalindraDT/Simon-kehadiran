<?php

namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use App\Models\ModelKelas;
use CodeIgniter\HTTP\ResponseInterface;

class Kelas extends BaseController
{
    use ResponseTrait;

    function __construct()
    {
        $this->model = new ModelKelas();
    }

    // Menampilkan semua kelas
    public function index(): ResponseInterface
    {
        $data = $this->model
            ->select('kelas.kode_kelas, kelas.nama_kelas')
            ->orderBy('kelas.nama_kelas', 'asc')
            ->findAll();

        return $this->respond($data, 200);
    }

    // Menampilkan detail kelas berdasarkan kode_kelas
    public function show($kode_kelas = null)
    {
        $data = $this->model->find($kode_kelas);

        if ($data) {
            return $this->respond($data, 200);
        } else {
            return $this->failNotFound("Data tidak ditemukan untuk kode kelas $kode_kelas");
        }
    }

    // Menambahkan data kelas baru
    public function create() 
{
    $data = $this->request->getPost(['kode_kelas', 'nama_kelas']);

    if ($this->model->find($data['kode_kelas'])) {
        return $this->fail("Kode kelas sudah ada.");
    }

    if (!$this->model->insert($data)) {
        return $this->fail($this->model->errors());
    }

    return $this->respondCreated([
        'status' => 201,
        'messages' => ['success' => 'Berhasil memasukkan data kelas']
    ]);
}

    // Mengupdate data kelas berdasarkan kode_kelas
    public function update($kode_kelas = null)
    {
        if (!$this->model->find($kode_kelas)) {
            return $this->failNotFound("Data tidak ditemukan untuk kode kelas $kode_kelas");
        }

        $data = [
            'nama_kelas' => $this->request->getRawInput()['nama_kelas'] ?? null
        ];

        if (!$this->model->update($kode_kelas, $data)) {
            return $this->fail($this->model->errors());
        }

        return $this->respond([
            'status' => 200,
            'error' => null,
            'messages' => ["success" => "Data kelas dengan kode_kelas $kode_kelas berhasil diupdate"]
        ]);
    }

    // Menghapus data kelas berdasarkan kode_kelas
    public function delete($kode_kelas = null)
    {
        if (!$this->model->find($kode_kelas)) {
            return $this->failNotFound("Data tidak ditemukan untuk kode kelas $kode_kelas");
        }

        $this->model->delete($kode_kelas);

        return $this->respondDeleted([
            'status' => 200,
            'error' => null,
            'messages' => ["success" => "Data kelas dengan kode_kelas $kode_kelas berhasil dihapus"]
        ]);
    }
}
