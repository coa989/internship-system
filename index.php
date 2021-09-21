<?php
require_once __DIR__. '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$router = new Bramus\Router\Router();

$router->get('/mentors', function() {
    echo 'All Mentors';
});

$router->get('/mentors/(\d+)', function($param) {
    echo 'Single Mentor ', htmlentities($param);
});

$router->run();