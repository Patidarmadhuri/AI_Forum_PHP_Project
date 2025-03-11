<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    // Database connection instance
    private static $connection;

    // Private constructor to prevent multiple instances of the class
    private function __construct() {}

    // Get the database connection (Singleton pattern)
    public static function getConnection()
    {
        if (self::$connection === null) {
            try {
                // Load environment variables
                $host = getenv('DB_HOST') ?: 'localhost';
                $user = getenv('DB_USER') ?: 'root';
                $password = getenv('DB_PASS') ?: '';
                $database = getenv('DB_NAME') ?: 'forum_db'; // Your DB name

                // Create a new PDO connection
                $dsn = "mysql:host=$host;dbname=$database;charset=utf8mb4";
                self::$connection = new PDO($dsn, $user, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
            } catch (PDOException $e) {
                // Handle connection failure
                error_log("Database connection failed: " . $e->getMessage());
                die("Database connection error. Please try again later.");
            }
        }
        return self::$connection;
    }
}
