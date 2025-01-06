<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Routing::get('', 'DefaultController');
Routing::get('main', 'DefaultController');
Routing::get('adminPage', 'DefaultController');

Routing::post('signUp', 'SecurityController');
Routing::post('login', 'SecurityController');
Routing::post('logout', 'SecurityController'); // Wylogowanie

Routing::get('reserve', 'DefaultController');
Routing::post('reserveSeats', 'SeatsController');

Routing::post('addMovie', 'MovieController');
Routing::get('movies', 'MovieController');

Routing::post('addScreening', 'ScreeningController');



Routing::run($path);