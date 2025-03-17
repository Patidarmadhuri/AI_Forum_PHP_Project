<?php
$autoloadPath = __DIR__ . '/../../vendor/autoload.php';
if (!file_exists($autoloadPath)) {
    die("Error: Could not find autoload.php at $autoloadPath");
}
require_once $autoloadPath;

use Dotenv\Dotenv;

try {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
    $dotenv->load();
} catch (\Exception $e) {
    error_log("Error loading .env file: " . $e->getMessage());
    die("Error: Failed to load environment variables.");
}

function ensureEnvVariable($key) {
    if (!isset($_ENV[$key])) {
        die("Error: $key is not defined in the .env file.");
    }
}

ensureEnvVariable('BASE_URL');
define('BASE_URL', $_ENV['BASE_URL']);
define('BASE_PATH', rtrim($_ENV['BASE_URL'], '/'));

define('DEBUG_MODE', $_ENV['DEBUG_MODE'] ?? false);