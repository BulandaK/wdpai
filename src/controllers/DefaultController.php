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


        if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) {
            $this->render('adminPage');
        } else {
            header('Location: /main');
            exit();
        }
    }



}