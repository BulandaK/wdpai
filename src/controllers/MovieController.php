<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/Movie.php';
require_once __DIR__ . '/../repository/MovieRepository.php';


class MovieController extends AppController
{
    const MAX_FILE_SIZE = 1024 * 1024;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/../public/uploads/';

    private $message = [];
    private $movieRepository;

    public function __construct()
    {
        parent::__construct();
        $this->movieRepository = new MovieRepository();
    }

    public function movies()
    {
        $movies = $this->movieRepository->getAllMovies();
        return $this->render('movies', ['movies' => $movies]);
    }


    public function addMovie()
    {
        if ($this->isPost() && is_uploaded_file($_FILES['file']['tmp_name']) && $this->validate($_FILES['file'])) {
            move_uploaded_file(
                $_FILES['file']['tmp_name'],
                dirname(__DIR__) . self::UPLOAD_DIRECTORY . $_FILES['file']['name']
            );


            $movie = new Movie(
                null,
                $_POST['title'],
                $_POST['description'],
                $_POST['release_date'],
                $_FILES['file']['name']
            );
            $this->movieRepository->addMovie($movie);

            $this->message[] = 'Movie added successfully!';
            return $this->render('movies', [
                'messages' => $this->message,
                'movies' => $this->movieRepository->getAllMovies()
            ]);
        }

        return $this->render('add-movie', ['messages' => $this->message]);
    }

    private function validate(array $file): bool
    {
        if ($file['size'] > self::MAX_FILE_SIZE) {
            $this->message[] = 'File is too large for destination file system.';
            return false;
        }

        if (!isset($file['type']) || !in_array($file['type'], self::SUPPORTED_TYPES)) {
            $this->message[] = 'File type is not supported.';
            return false;
        }
        return true;
    }
}
