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

    // Validasi manual sebelum insertion
    if (empty($data['kode_kelas']) || empty($data['nama_kelas'])) {
        return $this->fail("Kode kelas dan nama kelas harus diisi.");
    }

    // Cek keberadaan kode kelas menggunakan query builder
    $existingKelas = $this->model->where('kode_kelas', $data['kode_kelas'])->first();
    
    if ($existingKelas) {
        return $this->fail("Kode kelas sudah ada.");
    }

    // Validasi dan simpan data
    if ($this->model->save($data) === false) {
        // Tangani kesalahan validasi
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
    $existingData = $this->model->find($kode_kelas);
    if (!$existingData) {
        return $this->failNotFound("Data tidak ditemukan untuk kode kelas $kode_kelas");
    }

    $newKodeKelas = $this->request->getRawInput()['kode_kelas'] ?? $kode_kelas;
    $namaKelas = $this->request->getRawInput()['nama_kelas'] ?? $existingData['nama_kelas'];

    $data = [
        'kode_kelas' => $newKodeKelas,
        'nama_kelas' => $namaKelas
    ];

    if (!$this->model->update($kode_kelas, $data)) {
        return $this->fail($this->model->errors());
    }

    // Jika kode_kelas berubah, hapus entri lama dan tambahkan entri baru
    if ($newKodeKelas !== $kode_kelas) {
        $this->model->delete($kode_kelas);
        $this->model->insert($data);
    }

    return $this->respond([
        'status' => 200,
        'error' => null,
        'messages' => ["success" => "Data kelas berhasil diupdate menjadi kode_kelas $newKodeKelas"]
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
