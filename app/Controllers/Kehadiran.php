<?php

namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use App\Models\ModelKehadiran;
use CodeIgniter\HTTP\ResponseInterface;

class Kehadiran extends BaseController
{
    use ResponseTrait;

    function __construct()
    {
        $this->model = new ModelKehadiran();
    }

    // Menampilkan semua mahasiswa dengan join tabel kelas
    public function index(): ResponseInterface
    {
        $data = $this->model->getKehadiran();
        return $this->respond($data, 200);
    }

    // Menampilkan detail mahasiswa berdasarkan NPM dengan join tabel kelas
    public function show($id_kehadiran = null)
    {
        $data = $this->model->getMahasiswaWithClass($id_kehadiran);

        if ($data) {
            return $this->respond($data, 200);
        } else {
            return $this->failNotFound("Data tidak ditemukan untuk id kehadiran $id_kehadiran");
        }
    }

    // Menambahkan data mahasiswa baru
    public function create() 
{
    $data = $this->request->getPost();

    // Validasi manual untuk memastikan semua field yang diperlukan ada
    $requiredFields = ['nama_mahasiswa', 'email', 'id_user', 'kode_kelas'];
    foreach ($requiredFields as $field) {
        if (!isset($data[$field]) || empty($data[$field])) {
            return $this->fail("Field $field harus diisi");
        }
    }

    // Misalnya, cek apakah id_user dan kode_kelas valid
    $db = \Config\Database::connect();

    // Cek keberadaan kode kelas
    $kelasExists = $db->table('kelas')
        ->where('kode_kelas', $data['kode_kelas'])
        ->countAllResults() > 0;

    if (!$kelasExists) {
        return $this->fail("Kode kelas tidak valid");
    }

    // Cek keberadaan id_user
    $userExists = $db->table('user')
        ->where('id_user', $data['id_user'])
        ->countAllResults() > 0;

    if (!$userExists) {
        return $this->fail("ID User tidak valid");
    }

    // Simpan data
    $result = $this->model->save($data);

    // Periksa apakah penyimpanan berhasil
    if ($result === false) {
        // Jika gagal, ambil error dari model
        return $this->fail($this->model->errors());
    }

    $response = [
        'status' => 201,
        'error' => null,
        'messages' => [
            'success' => 'Berhasil memasukkan data mahasiswa',
            'npm' => $data['npm']
        ]
    ];
    return $this->respond($response);
}

    // Mengupdate data mahasiswa berdasarkan NPM
    public function update($npm = null)
{
    // Ambil data dari input
    $data = $this->request->getRawInput();

    // Validasi keberadaan data mahasiswa
    $isExists = $this->model->find($npm);
    if (!$isExists) {
        return $this->failNotFound("Data tidak ditemukan untuk NPM $npm");
    }

    // Pastikan NPM tidak berubah jika tidak sengaja

    // Simpan data dengan metode update
    if (!$this->model->update($npm, $data)) {
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
