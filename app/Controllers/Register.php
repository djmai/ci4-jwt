<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use App\Controllers\BaseController;
use App\Models\UserModel;

class Register extends BaseController
{
    use ResponseTrait;

    public function register()
    {
        $rules = [
            'email' => [
                'label' => 'email',
                'rules' => 'required|min_length[4]|max_length[255]|valid_email|is_unique[users.email]',
                'errors' => [
                    'is_unique' => 'El campo de {field} debe ser único'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[8]|max_length[255]'
            ],
            'confirm_password' => [
                'label' => 'Confirmación de Contraseña',
                'rules' => 'matches[password]'
            ]
        ];

        if(!$this->validate($rules)){
            return $this->fail(
                [
                    'message' => 'Datos invalidos',
                    'errors' => $this->validator->getErrors(),
                ],
                ResponseInterface::HTTP_CONFLICT
            );
        }else{
            $userModel = new UserModel();
//            helper('tools');
            $data = [
                'email' => $this->request->getVar('email'),
                // 'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
                'password' => hashPass($this->request->getVar('password'))
            ];
            $user = $userModel->save($data);
            return $this->respond(
                [
                    'message' => 'Regristro completado correctamente',
                    'user' => $user
                ],
                ResponseInterface::HTTP_OK // 200
            );
        }
    }
}
