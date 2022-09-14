<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;

class Login extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        //$userModel = model('UserModel');
        $userModel = new UserModel();
        
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $user = $userModel->where('email', $email)->first();

        if(is_null($user)){
            return $this->respond(
                [
                    'error' => 'Correo electrónico invalido',
                ],
                ResponseInterface::HTTP_UNAUTHORIZED // 401
            );
        }

        // $pass_verify = password_verify($password, $user['password']);
        // Helper Tools
        $pass_verify = veriPass($password, $user['password']);
        if(!$pass_verify){
            return $this->respond(
                [
                'error' => 'Contraseña invalida'
                ],
                ResponseInterface::HTTP_UNAUTHORIZED
            );
        }

        // Generación de token con JWT
        $key = getenv('JWT_SECRET');
        $iat = time();
        $exp = $iat + 3600;

        $payload = [
            // 'iss' => '',
            // 'aud' => '',
            'iat' => $iat,
            'exp' => $exp,
            'email' => $user['email']
        ];

        $token = JWT::encode($payload, $key, 'HS256');
        
        $response = [
            'message' => 'Credenciales correctas',
            'iat' => $iat,
            'exp' => $exp,
            'token' => $token,
        ];

        return $this->respond($response, ResponseInterface::HTTP_OK);

    }
}
