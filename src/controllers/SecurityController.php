<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repository/UserRepository.php';
require_once __DIR__ . '/../repository/SeatRepository.php';

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

        if (!$user) {
            return $this->render('login', ['messages' => ['User does not exist!']]);
        }

        if ($user->getEmail() !== $email) {
            return $this->render('login', ['messages' => ['User with this email does not exist!']]);
        }

        if ($password !== $user->getPassword()) {
            return $this->render('login', ['messages' => ['Wrong password!']]);
        }
        session_start();
        if ($user->getIsAdmin()) {
            $_SESSION['is_admin'] = true;
        } else {
            $_SESSION['is_admin'] = false;
        }
        // Przechowywanie `userId` w sesji
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['user_name'] = $user->getName();

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

        $isRegister = $userRepository->createUser($email, $password, $name, $surname);


        if (!$isRegister) {
            return $this->render('signUp', ['messages' => ['error ']]);
        }


        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: ${url}/login");
    }

    public function deleteUser()
    {

        if (!$this->isPost()) {
            http_response_code(400);
            echo "Invalid request method";
            return;
        }

        $userId = $_POST['user_id'] ?? null;
        if (!$userId) {
            http_response_code(400);
            echo "Invalid user ID";
            return;
        }

        $userRepository = new UserRepository();
        $success = $userRepository->deleteUserById($userId);

        if ($success) {
            header('Location: /adminPage');
            exit();
        } else {
            http_response_code(500);
            echo "Failed to delete user";
        }
    }


    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }


        session_unset();
        session_destroy();

        $url = "http://$_SERVER[HTTP_HOST]/login";
        header("Location: ${url}");
        exit();
    }


}