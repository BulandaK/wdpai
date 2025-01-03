<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';

class SecurityController extends AppController
{
    public function login()
    {
        $userRepository = new UserRepository();

        

        if (!$this->isPost()) {
            return $this->render('login');
        }

        $email = $_POST["email"];
        $password = $_POST["password"];
        
        $user = $userRepository->getUser($email);

        if(!$user){
            return $this->render('login', ['messages' => ['User not exist!']]);
        }

        if ($user->getEmail() !== $email) {
            return $this->render('login', ['messages' => ['User with this email not exist!']]);
        }

        if (!password_verify($password, $user->getPassword())) {
            return $this->render('login', ['messages' => ['Wrong password!']]);
        }
        

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: ${url}/reserve");
    }

    public function signUp()
    {
        $userRepository = new UserRepository();

        

        if (!$this->isPost()) {
            return $this->render('signUp');
        }

        
        $name = $_POST["name"];
        $surname = $_POST["surname"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        
        error_log("Name: $name, Surname: $surname, Email: $email, Password: $password");

        $isRegister = $userRepository->createUser($email,$password,$name,$surname);
        // $user = $userRepository->getUser($email);

        if(!$isRegister){
            return $this->render('signUp', ['messages' => ['error ']]);
        }

        // if ($user->getEmail() !== $email) {
        //     return $this->render('login', ['messages' => ['User with this email not exist!']]);
        // }

        // if ($user->getPassword() !== $password) {
        //     return $this->render('login', ['messages' => ['Wrong password!']]);
        // }
        

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: ${url}/login");
    }
}