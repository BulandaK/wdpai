<?php

class Movie
{
    private $title;
    private $description;
    private $release_date;
    private $file;

    // Konstruktor
    public function __construct(
        string $title,
        string $description,
        string $release_date,
        string $file
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->release_date = $release_date;
        $this->file = $file;
    }

    // Gettery
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
