<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class User extends BaseController
{
    use ResponseTrait;
    
    // /api/users
    public function index()
    {
        $users = model('UserModel');
        return $this->respond(
            [
                'users' => $users->findAll()
            ],
            ResponseInterface::HTTP_OK
        );
    }

    public function getuser(){
        
    }
}
