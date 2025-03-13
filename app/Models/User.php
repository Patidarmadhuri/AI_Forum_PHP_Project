<?php
namespace App\Models;

use PDO;
use App\Core\Database;

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function register($username, $email, $password, $is_admin = 0) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password, is_admin) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$username, $email, $hashed_password, $is_admin]);
    }

    public function login($email, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$user) {
            return [
                'success' => false,
                'message' => 'User is not authorized'
            ];
        }
        
        if (password_verify($password, $user['password'])) {
            return [
                'success' => true,
                'user' => $user
            ];
        }
        
        return [
            'success' => false,
            'message' => 'Incorrect password'
        ];
    }

    public function getAllUsers() {
        $stmt = $this->db->query("SELECT id, username, email, is_admin FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById($userId) {
        $stmt = $this->db->prepare("SELECT id, username, email, is_admin FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($userId, $username, $email, $is_admin) {
        $stmt = $this->db->prepare("UPDATE users SET username = ?, email = ?, is_admin = ? WHERE id = ?");
        return $stmt->execute([$username, $email, $is_admin, $userId]);
    }

    public function deleteUser($id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }
}