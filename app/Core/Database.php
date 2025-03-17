<?php

namespace App\Core;

use PDO;
use PDOException;

class Database {
    
    private static $connection;

   
    private function __construct() {}

    
    public static function getConnection() {
       
        if (self::$connection === null) {
            try {
                
                $host = getenv('DB_HOST') ?: 'localhost';
                $user = getenv('DB_USER') ?: 'root';
                $password = getenv('DB_PASS') ?: '';
                $database = getenv('DB_NAME') ?: 'forum_db'; 

                
                $dsn = "mysql:host=$host;dbname=$database;charset=utf8mb4";
                self::$connection = new PDO($dsn, $user, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, 
                    PDO::ATTR_EMULATE_PREPARES => false, 
                ]);
            } catch (PDOException $e) {
               
                error_log("Database connection failed: " . $e->getMessage());
                die("Database connection error. Please try again later.");
            }
        }
        return self::$connection;
    }
}