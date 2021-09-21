<?php
require_once __DIR__. '/vendor/autoload.php';

use app\db\Database;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$db = new Database();

$stmt = $db->pdo->prepare('SELECT * FROM mentors');
$stmt->execute();

var_dump($stmt->fetchAll(PDO::FETCH_OBJ));
