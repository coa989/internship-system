<?php

require_once __DIR__. '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$router = new Bramus\Router\Router();

$router->setNamespace('\app\src');

// Mentor Routes
$router->get('/api/mentors', 'Mentor@index');
$router->get('/api/mentors/(\d+)', 'Mentor@show');
$router->post('/api/mentors', 'Mentor@store');
$router->post('/api/mentors/(\d+)/update', 'Mentor@update');
$router->delete('/api/mentors/(\d+)/destroy', 'Mentor@destroy');

// Intern Routes
$router->get('/api/interns', 'Intern@index');
$router->get('/api/interns/(\d+)', 'Intern@show');
$router->post('/api/interns', 'Intern@store');
$router->post('/api/interns/(\d+)/update', 'Intern@update');
$router->delete('/api/interns/(\d+)/destroy', 'Intern@destroy');

$router->run();