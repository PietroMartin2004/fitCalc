<?php

namespace Controller;

use Model\User;

use Exception;

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    //REGISTRAR USUÁRIO
    public function registerUser($user_fullname, $email, $password)
    {
        if (empty($user_fullname) or empty($email) or empty($password)) {
            return false;
        }
        
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        return $this->userModel->post($user_fullname, $email, $hashed_password);
    }

    // FAZER LOGIN
    public function loginUser($email, $password)
    {
        $user = $this->userModel->getUserByEmail($email);
      
        if ($user) {
            if (crypt($password, $user['password'])) {
                $_SESSION['id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['user_fullname'] = $user['user_fullname'];

                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    // VERIFICAR SE USUÁRIO ESTÁ LOGADO

    public function isLoggedIn()
    {
        return isset($_SESSION['id']);
    }

    // OBTER INFORMAÇÕES DO USUÁRIOS

    public function getUser($user_id, $user_fullname, $email)
    {
        $user_id = $_SESSION['id'];

        return $this->userModel->getUserInfo($user_id, $user_fullname, $email);
    }
}

?>