<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repository/UserRepository.php';
require_once __DIR__ . '/../repository/SeatRepository.php'; // Dodaj import

class SeatsController extends AppController
{
    public function reserveSeats()
    {
        header('Content-Type: application/json');

        if (!$this->isPost()) {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        session_start();
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Sign in first']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data) {
            echo json_encode(['success' => false, 'message' => 'No data received']);
            return;
        }

        $seats = $data['seats'];

        // Pobierz ID seansu z parametru GET
        $screeningId = isset($_GET['screeningId']) ? (int) $_GET['screeningId'] : null;
        if (!$screeningId) {
            echo json_encode(['success' => false, 'message' => 'Invalid screening ID']);
            return;
        }

        $userId = $_SESSION['user_id']; // ID zalogowanego użytkownika

        $seatRepository = new SeatRepository();

        // Pobierz numer pokoju dla danego ID seansu
        $roomNumber = $seatRepository->getRoomNumberByScreeningId($screeningId);
        if (!$roomNumber) {
            echo json_encode(['success' => false, 'message' => 'Invalid room number']);
            return;
        }

        foreach ($seats as $seat) {
            [$row, $number] = explode('-', $seat);

            $seatId = $seatRepository->getSeatId($roomNumber, $row, $number); // Pobierz ID miejsca
            $seatRepository->reserveSeat($userId, $screeningId, $seatId); // Zarezerwuj miejsce
        }

        echo json_encode(['success' => true]);
    }


}