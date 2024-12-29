<?php

require_once 'AppControler.php';

class DefaultController extends AppController{
    
    public function index() {
        
        $this->render('login');
    }
    public function reserve() {
        
        $this->render('reserve');
    }

}