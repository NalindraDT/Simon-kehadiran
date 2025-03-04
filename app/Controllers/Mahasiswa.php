<?php

namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use App\Models\ModelMahasiswa;
use CodeIgniter\HTTP\ResponseInterface;

class Mahasiswa extends BaseController
{
    use ResponseTrait;

    function __construct()
    {
        $this->model = new ModelMahasiswa();
    }

    // Menampilkan semua mahasiswa dengan join tabel kelas
    public function index(): ResponseInterface
    {
        $data = $this->model->getMahasiswaWithClass();
        return $this->respond($data, 200);
    }

    // Menampilkan detail mahasiswa berdasarkan NPM dengan join tabel kelas
    public function show($npm = null)
    {
        $data = $this->model->getMahasiswaWithClass($npm);

        if ($data) {
            return $this->respond($data, 200);
        } else {
            return $this->failNotFound("Data tidak ditemukan untuk NPM $npm");
        }
    }

    // Menambahkan data mahasiswa baru
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
                'success' => 'Berhasil memasukkan data mahasiswa'
            ]
        ];
        return $this->respond($response);
    }

    // Mengupdate data mahasiswa berdasarkan NPM
    public function update($npm = null)
    {
        $data = $this->request->getRawInput();
        $data['npm'] = $npm;

        $isExists = $this->model->find($npm);

        if (!$isExists) {
            return $this->failNotFound("Data tidak ditemukan untuk NPM $npm");
        }

        if (!$this->model->save($data)) {
            return $this->fail($this->model->errors());
        }

        $response = [
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => "Data mahasiswa dengan NPM $npm berhasil diupdate"
            ]
        ];

        return $this->respond($response);
    }

    // Menghapus data mahasiswa berdasarkan NPM
    public function delete($npm = null)
    {
        $isExists = $this->model->find($npm);

        if (!$isExists) {
            return $this->failNotFound("Data tidak ditemukan untuk NPM $npm");
        }

        $this->model->delete($npm);

        $response = [
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => "Data mahasiswa dengan NPM $npm berhasil dihapus"
            ]
        ];
        return $this->respondDeleted($response);
    }
}
