<?php

require_once __DIR__. '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$router = new Bramus\Router\Router();

$router->setNamespace('\app\src');

// Mentor Routes
$router->get('/api/mentors', 'Mentor@index');
$router->get('/api/mentors/(\d+)', 'Mentor@show');
$router->delete('/api/mentors/(\d+)/destroy', 'Mentor@destroy');
$router->post('/api/mentors', 'Mentor@store');
$router->post('/api/mentors/(\d+)/update', 'Mentor@update');

$router->run();