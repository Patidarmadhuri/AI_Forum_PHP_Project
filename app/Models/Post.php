<?php
namespace App\Models;

use PDO;
use App\Core\Database;

class Post {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAllPosts() {
        $stmt = $this->db->prepare("SELECT * FROM posts ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createPost($user_id, $title, $content) {
        $stmt = $this->db->prepare("INSERT INTO posts (user_id, title, content, created_at) VALUES (?, ?, ?, NOW())");
        return $stmt->execute([$user_id, $title, $content]);
    }

    public function getPostById($postId) { // Changed to instance method
        $stmt = $this->db->prepare("SELECT * FROM posts WHERE id = ?");
        $stmt->execute([$postId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function searchPosts($searchTerm) {
        $searchTerm = trim($searchTerm);
        
        if (empty($searchTerm)) {
            $sql = "SELECT * FROM posts ORDER BY created_at DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    
        $sql = "SELECT * FROM posts 
                WHERE title LIKE :search_term 
                   OR content LIKE :search_content
                ORDER BY created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $searchParam = '%' . $searchTerm . '%';
        
        $stmt->execute([
            ':search_term' => $searchParam,
            ':search_content' => $searchParam
        ]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function updatePost($postId, $title, $content) { // Changed to instance method
        $stmt = $this->db->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
        return $stmt->execute([$title, $content, $postId]);
    }
    
    public function deletePost($postId) { // Changed to instance method
        $stmt = $this->db->prepare("DELETE FROM posts WHERE id = ?");
        return $stmt->execute([$postId]);
    }
}