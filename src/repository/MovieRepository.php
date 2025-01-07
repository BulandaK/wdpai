<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Movie.php';

class MovieRepository extends Repository
{
    public function getMovieById(int $id): ?Movie
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM movies WHERE id = :id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $movie = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($movie == false) {
            return null;
        }

        return new Movie(
            $movie['id'],
            $movie['title'],
            $movie['description'],
            $movie['release_date'],
            $movie['file']
        );
    }

    public function addMovie(Movie $movie): void
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO movies (title, description, release_date, file)
            VALUES (:title, :description, :release_date, :file)
        ');


        $title = $movie->getTitle();
        $description = $movie->getDescription();
        $release_date = $movie->getReleaseDate();
        $file = $movie->getFile();


        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':release_date', $release_date, PDO::PARAM_STR);
        $stmt->bindParam(':file', $file, PDO::PARAM_STR);

        $stmt->execute();
    }
    public function getAllMovies(): array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM movies
        ');
        $stmt->execute();

        $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = [];

        foreach ($movies as $movie) {
            $result[] = new Movie(
                $movie['id'],
                $movie['title'],
                $movie['description'],
                $movie['release_date'],
                $movie['file'],

            );
        }

        return $result;
    }

}
