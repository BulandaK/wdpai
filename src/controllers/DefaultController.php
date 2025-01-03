<?php

require_once 'AppController.php';

class DefaultController extends AppController{
    
    public function index() {
        
        $this->render('main');
    }
    public function main() {
        
        $this->render('main');
    }
    public function reserve() {
        
        $this->render('reserve');
    }
    

}