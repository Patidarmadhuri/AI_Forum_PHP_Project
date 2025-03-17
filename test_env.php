<?php
$envPath = "C:/xampp/htdocs/AI_Forum_PHP_Project/.env";
if (file_exists($envPath)) {
    echo "File exists.\n";
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        echo $line . "\n";
    }
} else {
    echo "File does not exist.";
}