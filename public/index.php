<?php
session_start();

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
require __DIR__ . '/../vendor/autoload.php';
require_once '../app/bootstrap.php';
// echo "Debug: index.php loaded<br>";

use App\Core\Router;

$router = new Router();
$router->route($_SERVER['REQUEST_URI']);