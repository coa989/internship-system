<?php

use app\src\Response;

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$router = new Bramus\Router\Router();

$router->setNamespace('\app\controllers');

// Mentor Routes
$router->get('/api/mentors/(\d+)', 'MentorController@show');
$router->post('/api/mentors', 'MentorController@store');
$router->put('/api/mentors/(\d+)', 'MentorController@update');
$router->delete('/api/mentors/(\d+)', 'MentorController@destroy');

// Intern Routes
$router->get('/api/interns/(\d+)', 'InternController@show');
$router->post('/api/interns', 'InternController@store');
$router->put('/api/interns/(\d+)', 'InternController@update');
$router->delete('/api/interns/(\d+)', 'InternController@destroy');

// Group Routes
$router->get('/api/groups?[a-z0-9_-]+', 'GroupController@index');
$router->get('/api/groups/(\d+)', 'GroupController@show');
$router->post('/api/groups', 'GroupController@store');
$router->put('/api/groups/(\d+)', 'GroupController@update');
$router->delete('/api/groups/(\d+)', 'GroupController@destroy');

// Comment Routes
$router->post('/api/comments', 'CommentController@store');

// Not Found Route Handler
$router->set404(function () {
    return (new Response())->json(404, [
        'errors' => 'Requested URL is not valid'
    ]);
});

$router->run();
