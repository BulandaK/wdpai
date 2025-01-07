<?php

require_once 'Repository.php';

class SeatRepository extends Repository
{
    public function getSeatId($roomNumber, $row, $number)
    {
        $stmt = $this->database->connect()->prepare('
            SELECT id 
            FROM seats 
            WHERE room_number = :roomNumber 
              AND seat_row = :row 
              AND seat_number = :number
        ');
        $stmt->bindParam(':roomNumber', $roomNumber, PDO::PARAM_INT);
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
    public function reserveSeatsWithTransaction(int $userId, int $screeningId, array $seats): bool
    {
        try {
            // Rozpocznij transakcję
            $this->database->connect()->beginTransaction();

            foreach ($seats as $seat) {
                [$row, $number] = explode('-', $seat);

                // Pobierz numer pokoju na podstawie ID seansu
                $stmt = $this->database->connect()->prepare('
                SELECT room_number 
                FROM screenings 
                WHERE id = :screeningId
            ');
                $stmt->bindParam(':screeningId', $screeningId, PDO::PARAM_INT);
                $stmt->execute();
                $roomNumber = $stmt->fetchColumn();

                if (!$roomNumber) {
                    throw new Exception('Invalid room number');
                }

                // Pobierz ID miejsca
                $seatId = $this->getSeatId($roomNumber, $row, $number);
                if (!$seatId) {
                    throw new Exception('Invalid seat ID');
                }

                // Wstaw rezerwację
                $stmt = $this->database->connect()->prepare('
                INSERT INTO reservations (user_id, screening_id, seat_id)
                VALUES (:userId, :screeningId, :seatId)
            ');
                $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
                $stmt->bindParam(':screeningId', $screeningId, PDO::PARAM_INT);
                $stmt->bindParam(':seatId', $seatId, PDO::PARAM_INT);
                $stmt->execute();
            }

            // Zatwierdź transakcję
            $this->database->connect()->commit();

            return true;
        } catch (Exception $e) {
            // Wycofaj transakcję w przypadku błędu
            $this->database->connect()->rollBack();
            error_log("Transaction failed: " . $e->getMessage());
            return false;
        }
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
    public function getRoomNumberByScreeningId($screeningId): ?int
    {
        $stmt = $this->database->connect()->prepare('
        SELECT room_number 
        FROM screenings 
        WHERE id = :screeningId
    ');
        $stmt->bindParam(':screeningId', $screeningId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchColumn();
    }
    public function getUserReservedSeats($userId, $screeningId): array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT seat_id
            FROM reservations
            WHERE user_id = :userId
              AND screening_id = :screeningId
        ');
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':screeningId', $screeningId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

}
