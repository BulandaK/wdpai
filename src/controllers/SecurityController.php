<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repository/UserRepository.php';
require_once __DIR__ . '/../repository/SeatRepository.php'; // Dodaj import

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

    public function reserveSeats()
    {

        // Ustaw nagłówek JSON
        header('Content-Type: application/json');
        if (!$this->isPost()) {
            return $this->render('reserve');
        }

        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data) {
            echo json_encode(['success' => false, 'message' => 'No data received']);
            return;
        }


        $seats = $data['seats'];

        $screeningId = 1; // Na podstawie wybranego seansu
        $userId = 1; // Zakładamy, że użytkownik jest zalogowany

        $seatRepository = new SeatRepository(); // Tworzenie obiektu wewnątrz bloku try

        foreach ($seats as $seat) {
            [$row, $number] = explode('-', $seat);

            $seatId = $seatRepository->getSeatId($row, $number); // Użycie repozytorium
            $seatRepository->reserveSeat($userId, $screeningId, $seatId); // Użycie repozytorium
        }

        echo json_encode(['success' => true]);
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Usuń wszystkie dane z sesji
        session_unset();
        session_destroy();

        $url = "http://$_SERVER[HTTP_HOST]/login";
        header("Location: ${url}");
        exit();
    }


}