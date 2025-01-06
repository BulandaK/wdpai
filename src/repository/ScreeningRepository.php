<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Screening.php';

class ScreeningRepository extends Repository
{
    public function addScreening(Screening $screening): void
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO screenings (movie_id, screening_time, room_number)
            VALUES (:movie_id, :screening_time, :room_number)
        ');

        $movieId = $screening->getMovieId();
        $screeningTime = $screening->getScreeningTime();
        $roomNumber = $screening->getRoomNumber();

        $stmt->bindParam(':movie_id', $movieId, PDO::PARAM_INT);
        $stmt->bindParam(':screening_time', $screeningTime, PDO::PARAM_STR);
        $stmt->bindParam(':room_number', $roomNumber, PDO::PARAM_INT);

        $stmt->execute();
    }

    public function getAllScreenings(): array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM screenings
        ');
        $stmt->execute();

        $screenings = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = [];

        foreach ($screenings as $screening) {
            $result[] = new Screening(
                $screening['id'],
                $screening['movie_id'],
                $screening['screening_time'],
                $screening['room_number']
            );
        }

        return $result;
    }
}
