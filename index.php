<?php

use app\src\Mentor;

require_once __DIR__. '/vendor/autoload.php';


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$router = new Bramus\Router\Router();

$router->get('/api/mentors', function() {
    echo (new Mentor())->index();
});

$router->get('/api/mentors/(\d+)', function($id) {
    echo (new Mentor())->show($id);
});

$router->run();