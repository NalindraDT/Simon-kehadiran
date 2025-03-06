<?php

namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use App\Models\ModelDosen;
use CodeIgniter\HTTP\ResponseInterface;

class Dosen extends BaseController
{
    use ResponseTrait;

    function __construct()
    {
        $this->model = new ModelDosen();
    }

    // Menampilkan semua kelas
    public function index(): ResponseInterface
    {
        $data = $this->model->getDosen();
        return $this->respond($data, 200);
    }

    // Menampilkan detail kelas berdasarkan kode_kelas
    public function show($nidn = null)
    {
        $data = $this->model->getDosen($nidn);

        if ($data) {
            return $this->respond($data, 200);
        } else {
            return $this->failNotFound("Data tidak ditemukan untuk nidn $nidn");
        }
    }

    // Menambahkan data kelas baru
    public function create() 
{
    $data = $this->request->getPost();

    // Validasi manual untuk memastikan semua field yang diperlukan ada
    $requiredFields = ['nidn', 'nama_dosen', 'id_user'];
    foreach ($requiredFields as $field) {
        if (!isset($data[$field]) || empty($data[$field])) {
            return $this->fail("Field $field harus diisi");
        }
    }

    $db = \Config\Database::connect();

    // Periksa apakah NIDN sudah ada dalam tabel dosen
    $dosenModel = new \App\Models\ModelDosen();
    $existingDosen = $dosenModel->find($data['nidn']);
    
    if ($existingDosen) {
        return $this->fail("NIDN sudah terdaftar");
    }

    // Cek keberadaan id_user
    $userExists = $db->table('user')
        ->where('id_user', $data['id_user'])
        ->countAllResults() > 0;

    if (!$userExists) {
        return $this->fail("ID User tidak valid");
    }

    // Simpan data
    if (!$this->model->insert($data)) {
        return $this->fail($this->model->errors());
    }

    $response = [
        'status' => 201,
        'error' => null,
        'messages' => [
            'success' => 'Berhasil memasukkan data dosen',
            'NIDN' => $data['nidn']
        ]
    ];
    return $this->respond($response);
}


    // Mengupdate data kelas berdasarkan kode_kelas
    public function update($nidn = null)
{
    // Ambil data dari input
    $data = $this->request->getRawInput();

    // Validasi keberadaan data mahasiswa
    $isExists = $this->model->find($nidn);
    if (!$isExists) {
        return $this->failNotFound("Data tidak ditemukan untuk nidn $nidn");
    }


    // Simpan data dengan metode update
    if (!$this->model->update($nidn, $data)) {
        return $this->fail($this->model->errors());
    }

    $response = [
        'status' => 200,
        'error' => null,
        'messages' => [
            'success' => "Data dosen berhasil diupdate"
        ]
    ];

    return $this->respond($response);
}

    public function delete($nidn = null)
    {
        if (!$this->model->find($nidn)) {
            return $this->failNotFound("Data tidak ditemukan untuk nidn $nidn");
        }

        $this->model->delete($nidn);

        return $this->respondDeleted([
            'status' => 200,
            'error' => null,
            'messages' => ["success" => "Data dosen dengan nidn $nidn berhasil dihapus"]
        ]);
    }
}
