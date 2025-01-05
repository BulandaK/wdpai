<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Routing::get('', 'DefaultController');
Routing::get('main', 'DefaultController');
Routing::get('reserve', 'DefaultController');
Routing::post('login', 'SecurityController');
Routing::post('signUp', 'SecurityController');
Routing::post('reserveSeats', 'SecurityController');
Routing::post('logout', 'SecurityController'); // Wylogowanie


Routing::run($path);