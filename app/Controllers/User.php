<?php

namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use App\Models\ModelUser;
use CodeIgniter\HTTP\ResponseInterface;

class User extends BaseController
{
    use ResponseTrait;
    protected $model;
    function __construct()
    {
        $this->model = new ModelUser();
    }

    // Menampilkan semua kelas
    public function index(): ResponseInterface
    {
        $data = $this->model
            ->select('*')
            ->orderBy('username', 'asc')
            ->findAll();

        return $this->respond($data, 200);
    }

    // Menampilkan detail kelas berdasarkan kode_kelas
    public function show($id_user = null)
    {
        $data = $this->model->find($id_user);

        if ($data) {
            return $this->respond($data, 200);
        } else {
            return $this->failNotFound("Data tidak ditemukan untuk kode kelas $id_user");
        }
    }

    // Menambahkan data kelas baru
    public function create() 
    {
        $data = $this->request->getPost(['username', 'password', 'level']);
    
        // Hash password sebelum memasukkan ke database
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    
        if (!$this->model->insert($data)) {
            return $this->fail($this->model->errors());
        }
    
        return $this->respondCreated([
            'status' => 201,
            'messages' => ['success' => 'Berhasil memasukkan data user']
        ]);
    }
    
    // Mengupdate data kelas berdasarkan kode_kelas
    public function update($id_user = null)
    {
        if (!$id_user) {
            return $this->fail('ID user harus disertakan', 400);
        }
    
        $existingData = $this->model->find($id_user);
        if (!$existingData) {
            return $this->failNotFound("Data tidak ditemukan untuk id user $id_user");
        }
    
        $data = [
            'username' => $this->request->getRawInput()['username'] ?? $existingData['username'],
            'password' => isset($this->request->getRawInput()['password']) ? password_hash($this->request->getRawInput()['password'], PASSWORD_DEFAULT) : $existingData['password'],
            'level' => $this->request->getRawInput()['level'] ?? $existingData['level']
        ];
    
        if (!$this->model->update($id_user, $data)) {
            return $this->fail($this->model->errors());
        }
    
        return $this->respond([
            'status' => 200,
            'error' => null,
            'messages' => ["success" => "Data user dengan ID $id_user berhasil diupdate"]
        ]);
    }
    

    // Menghapus data kelas berdasarkan kode_kelas
    public function delete($id_user = null)
    {
        if (!$this->model->find($id_user)) {
            return $this->failNotFound("Data tidak ditemukan untuk id user $id_user");
        }

        $this->model->delete($id_user);

        return $this->respondDeleted([
            'status' => 200,
            'error' => null,
            'messages' => ["success" => "Data kelas dengan kode_kelas $id_user berhasil dihapus"]
        ]);
    }
}
