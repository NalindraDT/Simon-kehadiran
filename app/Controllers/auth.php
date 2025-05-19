<?php
namespace App\Controllers;

use App\Models\UserModel;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Auth extends BaseController
{
    public function login()
    {
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $userModel = new UserModel();
        $user = $userModel->where('username', $username)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return $this->response->setJSON(['error' => 'Login gagal'])->setStatusCode(401);
        }

        $key = getenv('JWT_SECRET');
        $iat = time(); // current time
        $exp = $iat + 3600; // token valid 1 jam

        $payload = [
            'iss' => 'localhost',
            'aud' => 'localhost',
            'iat' => $iat,
            'exp' => $exp,
            'data' => [
                'id' => $user['id'],
                'username' => $user['username'],
            ]
        ];

        $token = JWT::encode($payload, $key, 'HS256');

        return $this->response->setJSON(['token' => $token]);

        
    }
}
