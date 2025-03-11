<?php
spl_autoload_register(function ($class) {
    $root = dirname(__DIR__); // Root directory (AI_Forum_PHP_Project)
    $file = $root . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require $file;
    } else {
        // Optional debug
        // echo "Debug: Could not load $class at $file<br>";
    }
});

// Start session (if not started elsewhere)
// session_start(); // Uncomment if needed, but controllers already handle this