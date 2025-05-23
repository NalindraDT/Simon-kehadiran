<?php

namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use App\Models\ModelKelas;
use CodeIgniter\HTTP\ResponseInterface;

class Kelas extends BaseController
{
    use ResponseTrait;
protected $model;
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

public function update($kode_kelas = null)
{
    // Ambil data dari input
    $data = $this->request->getJSON(true) ?? $this->request->getRawInput();


    // Validasi keberadaan data mahasiswa
    $isExists = $this->model->find($kode_kelas);
    if (!$isExists) {
        return $this->failNotFound("Data tidak ditemukan untuk kode matkul $kode_kelas");
    }

    // Simpan data dengan metode update
    if (!$this->model->update($kode_kelas, $data)) {
        return $this->fail($this->model->errors());
    }

    $response = [
        'status' => 200,
        'error' => null,
        'messages' => [
            'success' => "Data kelas berhasil diupdate"
        ]
        ];
    return $this->respond($response);
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
