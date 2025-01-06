<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/Screening.php';
require_once __DIR__ . '/../repository/ScreeningRepository.php';

class ScreeningController extends AppController
{
    private $screeningRepository;

    public function __construct()
    {
        parent::__construct();
        $this->screeningRepository = new ScreeningRepository();
    }
    public function screeningsList()
    {
        $screeningRepository = new ScreeningRepository();
        $screenings = $screeningRepository->getAllScreeningsWithMovies();

        $this->render('screeningsList', ['screenings' => $screenings]);
    }
    public function addScreening()
    {
        if (!$this->isPost()) {
            return $this->render('adminPage', ['messages' => ['Invalid request']]);
        }

        if (empty($_POST['movie_id']) || empty($_POST['screening_time']) || empty($_POST['room_number'])) {
            return $this->render('adminPage', ['messages' => ['All fields are required']]);
        }

        $screening = new Screening(
            null,
            (int) $_POST['movie_id'],
            $_POST['screening_time'],
            (int) $_POST['room_number']
        );

        $this->screeningRepository->addScreening($screening);
        return $this->render('adminPage', ['messages' => ['Screening added successfully!']]);
    }
}
