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

    // Menampilkan semua kelas dengan join tabel lain (jika diperlukan)
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
        $data = $this->model->where('kode_kelas', $kode_kelas)->findAll();

        if ($data) {
            return $this->respond($data, 200);
        } else {
            return $this->failNotFound("Data tidak ditemukan untuk kode kelas $kode_kelas");
        }
    }

    // Menambahkan data kelas baru
    public function create() 
    {
        $data = $this->request->getPost();

        if (!$this->model->save($data)) {
            return $this->fail($this->model->errors());
        }

        $response = [
            'status' => 201,
            'error' => null,
            'messages' => [
                'success' => 'Berhasil memasukkan data Kelas'
            ]
        ];
        return $this->respondCreated($response);
    }

    // Mengupdate data kelas berdasarkan kode_kelas
    public function update($kode_kelas = null)
    {
        $data = $this->request->getRawInput();
        $data['kode_kelas'] = $kode_kelas;

        $isExists = $this->model->find($kode_kelas);

        if (!$isExists) {
            return $this->failNotFound("Data tidak ditemukan untuk kode kelas $kode_kelas");
        }

        if (!$this->model->update($kode_kelas, $data)) {
            return $this->fail($this->model->errors());
        }

        $response = [
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => "Data kelas dengan kode_kelas $kode_kelas berhasil diupdate"
            ]
        ];

        return $this->respond($response);
    }

    // Menghapus data kelas berdasarkan kode_kelas
    public function delete($kode_kelas = null)
    {
        $isExists = $this->model->find($kode_kelas);

        if (!$isExists) {
            return $this->failNotFound("Data tidak ditemukan untuk kode kelas $kode_kelas");
        }

        $this->model->delete($kode_kelas);

        $response = [
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => "Data kelas dengan kode_kelas $kode_kelas berhasil dihapus"
            ]
        ];
        return $this->respondDeleted($response);
    }
}
