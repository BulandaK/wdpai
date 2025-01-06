<?php

class Movie
{
    private ?int $id;
    private string $title;
    private string $description;
    private string $release_date;
    private string $file;

    public function __construct(
        ?int $id = null, // Ustawienie wartości domyślnej
        string $title,
        string $description,
        string $release_date,
        string $file
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->release_date = $release_date;
        $this->file = $file;
    }

    // Gettery
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getReleaseDate(): string
    {
        return $this->release_date;
    }

    public function getFile(): string
    {
        return $this->file;
    }

    // Settery
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setReleaseDate(string $release_date): void
    {
        $this->release_date = $release_date;
    }

    public function setFile(string $file): void
    {
        $this->file = $file;
    }
}
