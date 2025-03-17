<?php
session_start();

chdir(__DIR__ . '/../..');

require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/Config/config.php';

use App\Core\Router;

try {
    $router = new Router();
    $router->route($_SERVER['REQUEST_URI']);
} catch (\Exception $e) {
    error_log("Error in index.php: " . $e->getMessage());
    http_response_code(500);
    $_SESSION['error_message'] = 'An unexpected error occurred. Please try again later.';
    header('Location: ' . BASE_PATH . '/');
    exit;
}