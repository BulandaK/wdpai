<?php

require_once 'Repository.php';

class SeatRepository extends Repository
{
    public function getSeatId($row, $number)
    {
        $stmt = $this->database->connect()->prepare('
            SELECT id FROM seats WHERE seat_row = :row AND seat_number = :number
        ');
        $stmt->bindParam(':row', $row, PDO::PARAM_INT);
        $stmt->bindParam(':number', $number, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchColumn();
    }

    public function reserveSeat($userId, $screeningId, $seatId)
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO reservations (user_id, screening_id, seat_id)
            VALUES (:userId, :screeningId, :seatId)
        ');
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':screeningId', $screeningId, PDO::PARAM_INT);
        $stmt->bindParam(':seatId', $seatId, PDO::PARAM_INT);
        $stmt->execute();
    }
}
