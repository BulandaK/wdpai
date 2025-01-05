<?php

require_once 'AppController.php';

class DefaultController extends AppController
{

    public function index()
    {

        $this->render('main');
    }
    public function main()
    {

        $this->render('main');
    }
    public function reserve()
    {

        $this->render('reserve');
    }

    public function adminPage()
    {
        session_start();

        // Sprawdzenie, czy użytkownik jest zalogowany jako admin
        if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) {
            $this->render('adminPage'); // Renderuj stronę administratora
        } else {
            header('Location: /main'); // Przekierowanie na stronę główną, jeśli nie jest adminem
            exit();
        }
    }



}