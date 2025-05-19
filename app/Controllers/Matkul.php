<?php

namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use App\Models\ModelMatkul;
use CodeIgniter\HTTP\ResponseInterface;

class Matkul extends BaseController
{
    use ResponseTrait;

    function __construct()
    {
        $this->model = new ModelMatkul();
    }

    // Menampilkan semua mahasiswa dengan join tabel kelas
    public function index(): ResponseInterface
    {
        $data = $this->model
            ->select('matkul.kode_matkul, matkul.nama_matkul, matkul.sks')
            ->orderBy('matkul.kode_matkul', 'asc')
            ->findAll();

        return $this->respond($data, 200);
    }

    // Menampilkan detail mahasiswa berdasarkan NPM dengan join tabel kelas
    public function show($kode_matkul = null)
    {
        $data = $this->model->find($kode_matkul);

        if ($data) {
            return $this->respond($data, 200);
        } else {
            return $this->failNotFound("Data tidak ditemukan untuk kode matkul $kode_matkul");
        }
    }

    // Menambahkan data mahasiswa baru
    public function create() 
{
    $data = $this->request->getPost(['kode_matkul', 'nama_matkul','sks']);

    // Validasi manual sebelum insertion
    if (empty($data['kode_matkul']) || empty($data['nama_matkul']) || empty($data['sks'])) {
        return $this->fail("yang kurrang mohon di isi.");
    }

    // Cek keberadaan kode kelas menggunakan query builder
    $existingmatkul = $this->model->where('kode_matkul', $data['kode_matkul'])->first();
    
    if ($existingmatkul) {
        return $this->fail("Kode matkul sudah ada.");
    }

    // Validasi dan simpan data
    if ($this->model->save($data) === false) {
        // Tangani kesalahan validasi
        return $this->fail($this->model->errors());
    }

    return $this->respondCreated([
        'status' => 201,
        'messages' => ['success' => 'Berhasil memasukkan data matkul']
    ]);
}

    // Mengupdate data mahasiswa berdasarkan NPM
    public function update($kode_matkul = null)
{
    // Ambil data dari input
    $data = $this->request->getJSON(true) ?? $this->request->getRawInput() ?? $this->request->getVar();

    // Validasi keberadaan data mahasiswa
    $isExists = $this->model->find($kode_matkul);
    if (!$isExists) {
        return $this->failNotFound("Data tidak ditemukan untuk kode matkul $kode_matkul");
    }

    // Simpan data dengan metode update
    if (!$this->model->update($kode_matkul, $data)) {
        return $this->fail($this->model->errors());
    }

    $response = [
        'status' => 200,
        'error' => null,
        'messages' => [
            'success' => "Data mahasiswa berhasil diupdate"
        ]
    ];

    return $this->respond($response);
}

    // Menghapus data mahasiswa berdasarkan NPM
    public function delete($kode_matkul = null)
    {
        $isExists = $this->model->find($kode_matkul);

        if (!$isExists) {
            return $this->failNotFound("Data tidak ditemukan untuk kode_matkul $kode_matkul");
        }

        $this->model->delete($kode_matkul);

        $response = [
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => "Data mahasiswa dengan kode matkul $kode_matkul berhasil dihapus"
            ]
        ];
        return $this->respondDeleted($response);
    }
}
