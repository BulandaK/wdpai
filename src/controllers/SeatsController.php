<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repository/UserRepository.php';
require_once __DIR__ . '/../repository/SeatRepository.php'; // Dodaj import

class SeatsController extends AppController
{
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

}