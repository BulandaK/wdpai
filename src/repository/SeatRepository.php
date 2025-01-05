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

    public function getReservedSeats(int $screeningId): array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT seat_id FROM reservations WHERE screening_id = :screeningId
        ');
        $stmt->bindParam(':screeningId', $screeningId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getSeatsByScreening(int $screeningId): array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM seats WHERE room_number = (
                SELECT room_number FROM screenings WHERE id = :screeningId
            )
        ');
        $stmt->bindParam(':screeningId', $screeningId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
