<?php

class Screening
{
    private ?int $id;
    private int $movieId;
    private string $screeningTime;
    private int $roomNumber;

    public function __construct(?int $id, int $movieId, string $screeningTime, int $roomNumber)
    {
        $this->id = $id;
        $this->movieId = $movieId;
        $this->screeningTime = $screeningTime;
        $this->roomNumber = $roomNumber;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMovieId(): int
    {
        return $this->movieId;
    }

    public function getScreeningTime(): string
    {
        return $this->screeningTime;
    }

    public function getRoomNumber(): int
    {
        return $this->roomNumber;
    }

    public function setMovieId(int $movieId): void
    {
        $this->movieId = $movieId;
    }

    public function setScreeningTime(string $screeningTime): void
    {
        $this->screeningTime = $screeningTime;
    }

    public function setRoomNumber(int $roomNumber): void
    {
        $this->roomNumber = $roomNumber;
    }
}
